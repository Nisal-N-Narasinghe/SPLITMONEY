<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class TripPlannerAiService
{
    public function generatePlan(array $input): array
    {
        $apiKey = (string) config('services.gemini.api_key');
        $model = (string) config('services.gemini.model', 'gemini-2.5-flash');
        $timeout = (int) config('services.gemini.timeout', 30);

        if ($apiKey === '') {
            throw new RuntimeException('Gemini API key is not configured.');
        }

        $systemPrompt = $this->buildSystemPrompt();
        $userPrompt = $this->buildUserPrompt($input);

        $url = 'https://generativelanguage.googleapis.com/v1beta/models/' . $model . ':generateContent';

        $response = Http::timeout($timeout)
            ->withQueryParameters(['key' => $apiKey])
            ->acceptJson()
            ->post($url, [
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [
                            ['text' => $systemPrompt . "\n\n" . $userPrompt],
                        ],
                    ],
                ],
                'generationConfig' => [
                    'temperature' => 0.5,
                    'responseMimeType' => 'application/json',
                ],
            ]);

        if (!$response->ok()) {
            $providerMessage = (string) data_get($response->json(), 'error.message', 'Unknown provider error');
            throw new RuntimeException('AI provider error ' . $response->status() . ': ' . $providerMessage);
        }

        $text = data_get($response->json(), 'candidates.0.content.parts.0.text');
        if (!is_string($text) || trim($text) === '') {
            throw new RuntimeException('AI provider returned an empty response.');
        }

        $decoded = $this->decodeJsonResponse($text);

        return $this->normalizePlan($decoded, $input);
    }

    private function buildSystemPrompt(): string
    {
        return 'You are a travel budget planner assistant. Always return valid JSON only. No markdown. '
            . 'Respond with keys: summary, destination, days, travelers, daily_plan, budget, tips. '
            . 'daily_plan must be an array with each day item {day, title, activities}. '
            . 'budget must be an object with keys {total, by_day, categories}. '
            . 'categories must include accommodation, food, transport, activities, misc as numbers.';
    }

    private function buildUserPrompt(array $input): string
    {
        $destination = (string) ($input['destination'] ?? 'Unknown');
        $days = (int) ($input['days'] ?? 1);
        $travelers = (int) ($input['travelers'] ?? 1);
        $budgetMode = (string) ($input['budget_mode'] ?? 'both');
        $totalBudget = isset($input['total_budget']) ? (float) $input['total_budget'] : null;
        $notes = trim((string) ($input['notes'] ?? ''));

        return "Plan a trip with these details:\n"
            . "Destination: {$destination}\n"
            . "Days: {$days}\n"
            . "Travelers: {$travelers}\n"
            . "Budget mode: {$budgetMode}\n"
            . 'Total budget: ' . ($totalBudget !== null ? number_format($totalBudget, 2, '.', '') : 'Not specified') . "\n"
            . 'Special notes: ' . ($notes !== '' ? $notes : 'None') . "\n"
            . 'Budget numbers should be realistic and in same currency units as provided budget.';
    }

    private function decodeJsonResponse(string $text): array
    {
        $decoded = json_decode($text, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        $trimmed = trim($text);
        $trimmed = preg_replace('/^```json\s*/i', '', $trimmed);
        $trimmed = preg_replace('/```$/', '', (string) $trimmed);

        $decoded = json_decode((string) $trimmed, true);
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
            throw new RuntimeException('AI response could not be parsed as JSON.');
        }

        return $decoded;
    }

    private function normalizePlan(array $plan, array $input): array
    {
        $days = max(1, (int) ($input['days'] ?? data_get($plan, 'days', 1)));
        $travelers = max(1, (int) ($input['travelers'] ?? data_get($plan, 'travelers', 1)));
        $destination = (string) ($input['destination'] ?? data_get($plan, 'destination', 'Unknown'));

        $dailyPlan = data_get($plan, 'daily_plan', []);
        if (!is_array($dailyPlan)) {
            $dailyPlan = [];
        }

        $normalizedDays = [];
        for ($i = 1; $i <= $days; $i++) {
            $item = $dailyPlan[$i - 1] ?? [];
            $normalizedDays[] = [
                'day' => $i,
                'title' => (string) data_get($item, 'title', 'Day ' . $i),
                'activities' => array_values(array_filter((array) data_get($item, 'activities', []), fn($v) => is_string($v) && trim($v) !== '')),
            ];
        }

        $budget = (array) data_get($plan, 'budget', []);
        $categories = (array) data_get($budget, 'categories', []);

        $normalizedCategories = [
            'accommodation' => (float) ($categories['accommodation'] ?? 0),
            'food' => (float) ($categories['food'] ?? 0),
            'transport' => (float) ($categories['transport'] ?? 0),
            'activities' => (float) ($categories['activities'] ?? 0),
            'misc' => (float) ($categories['misc'] ?? 0),
        ];

        $byDay = (array) data_get($budget, 'by_day', []);
        if (count($byDay) !== $days) {
            $totalFromCategories = array_sum($normalizedCategories);
            $daily = $days > 0 ? round($totalFromCategories / $days, 2) : 0;
            $byDay = array_fill(0, $days, $daily);
        }

        return [
            'summary' => (string) data_get($plan, 'summary', 'Trip plan generated successfully.'),
            'destination' => $destination,
            'days' => $days,
            'travelers' => $travelers,
            'budget_mode' => (string) ($input['budget_mode'] ?? 'both'),
            'daily_plan' => $normalizedDays,
            'budget' => [
                'total' => (float) data_get($budget, 'total', array_sum($normalizedCategories)),
                'by_day' => array_map(fn($v) => (float) $v, array_values($byDay)),
                'categories' => $normalizedCategories,
            ],
            'tips' => array_values(array_filter((array) data_get($plan, 'tips', []), fn($v) => is_string($v) && trim($v) !== '')),
        ];
    }
}
