<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    private string $apiKey;
    private string $model;
    private int $timeout;
    private string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models';

    public function __construct()
    {
        $this->apiKey  = env('GEMINI_API_KEY');
        $this->model   = env('GEMINI_MODEL', 'gemini-2.5-flash');
        $this->timeout = (int) env('GEMINI_TIMEOUT', 30);
    }

    public function generate(string $prompt): string
    {
        $url = "{$this->baseUrl}/{$this->model}:generateContent?key={$this->apiKey}";

        $response = Http::timeout($this->timeout)
            ->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt],
                        ],
                    ],
                ],
                'generationConfig' => [
                    'temperature'     => 0.7,
                    'maxOutputTokens' => 8192,
                ],
            ]);

        if ($response->failed()) {
            Log::error('Gemini API error', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            throw new \RuntimeException('Gemini API request failed: ' . $response->body());
        }

        $data = $response->json();

        return $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
    }

    public function generateJson(string $prompt): array
    {
        $fullPrompt = $prompt . "\n\nIMPORTANT: Respond ONLY with valid JSON. No markdown, no code blocks, no extra text.";

        $raw = $this->generate($fullPrompt);

        $cleaned = preg_replace('/^```json\s*/i', '', trim($raw));
        $cleaned = preg_replace('/^```\s*/i', '', $cleaned);
        $cleaned = preg_replace('/\s*```$/', '', $cleaned);
        $cleaned = trim($cleaned);

        $decoded = json_decode($cleaned, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('Gemini JSON parse error', ['raw' => $raw]);
            throw new \RuntimeException('Failed to parse Gemini response as JSON.');
        }

        return $decoded;
    }
}
