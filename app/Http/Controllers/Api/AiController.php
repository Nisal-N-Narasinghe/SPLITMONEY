<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Services\GeminiService;
use Illuminate\Http\Request;

class AiController extends Controller
{
    private GeminiService $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    /**
     * POST /api/ai/trip-plan
     * Generate a full day-by-day trip itinerary with expense breakdown.
     */
    public function tripPlan(Request $request)
    {
        $request->validate([
            'destination'       => 'required|string|max:255',
            'start_date'        => 'required|date',
            'end_date'          => 'required|date|after_or_equal:start_date',
            'people_count'      => 'required|integer|min:1|max:50',
            'budget_per_person' => 'nullable|numeric|min:0',
            'currency'          => 'nullable|string|max:10',
            'preferences'       => 'nullable|string|max:500',
            'group_id'          => 'nullable|exists:groups,id',
        ]);

        $start    = $request->start_date;
        $end      = $request->end_date;
        $days     = (int) ((strtotime($end) - strtotime($start)) / 86400) + 1;
        $people   = $request->people_count;
        $currency = $request->currency ?? 'USD';
        $prefs    = $request->preferences ?? 'No specific preferences';
        $budget   = $request->budget_per_person ? "Budget per person: {$currency} {$request->budget_per_person}" : 'No specific budget constraint';

        $groupContext = '';
        if ($request->group_id) {
            $group = Group::with('members.user')->find($request->group_id);
            if ($group) {
                $names = $group->members->map(fn($m) => $m->user->name)->implode(', ');
                $groupContext = "Group name: {$group->name}. Members: {$names}.";
            }
        }

        $prompt = <<<PROMPT
You are an expert travel planner. Create a detailed {$days}-day trip plan for {$people} people traveling to {$request->destination} from {$start} to {$end}.

{$budget}
Currency: {$currency}
Preferences: {$prefs}
{$groupContext}

Respond with a JSON object in this exact structure:
{
  "trip_title": "string",
  "destination": "string",
  "start_date": "YYYY-MM-DD",
  "end_date": "YYYY-MM-DD",
  "duration_days": number,
  "people_count": number,
  "currency": "string",
  "summary": "2-3 sentence overview of the trip",
  "estimated_total_cost": number,
  "estimated_cost_per_person": number,
  "itinerary": [
    {
      "day": number,
      "date": "YYYY-MM-DD",
      "title": "Day theme",
      "activities": [
        {
          "time": "Morning/Afternoon/Evening",
          "activity": "Activity name",
          "description": "Short description",
          "estimated_cost_per_person": number,
          "category": "food/transport/accommodation/attraction/shopping/other"
        }
      ],
      "day_total_per_person": number
    }
  ],
  "expense_breakdown": {
    "accommodation": number,
    "food": number,
    "transport": number,
    "attractions": number,
    "shopping": number,
    "other": number
  },
  "packing_tips": ["tip1", "tip2", "tip3"],
  "travel_tips": ["tip1", "tip2", "tip3"]
}
PROMPT;

        try {
            $plan = $this->gemini->generateJson($prompt);

            return response()->json([
                'success' => true,
                'data'    => $plan,
            ]);
        } catch (\RuntimeException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate trip plan. Please try again.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * POST /api/ai/budget-estimate
     * Estimate the budget for a trip by destination, duration, and travel style.
     */
    public function budgetEstimate(Request $request)
    {
        $request->validate([
            'destination'   => 'required|string|max:255',
            'duration_days' => 'required|integer|min:1|max:365',
            'people_count'  => 'required|integer|min:1|max:50',
            'travel_style'  => 'required|in:budget,moderate,luxury',
            'currency'      => 'nullable|string|max:10',
        ]);

        $currency = $request->currency ?? 'USD';
        $style    = $request->travel_style;
        $days     = $request->duration_days;
        $people   = $request->people_count;

        $prompt = <<<PROMPT
You are a travel budget expert. Provide a realistic budget estimate for a {$style} style trip to {$request->destination} for {$people} people over {$days} days. Use {$currency} as currency.

Respond with a JSON object in this exact structure:
{
  "destination": "string",
  "duration_days": number,
  "people_count": number,
  "travel_style": "{$style}",
  "currency": "{$currency}",
  "per_person_per_day": {
    "accommodation": number,
    "food": number,
    "local_transport": number,
    "attractions": number,
    "miscellaneous": number,
    "total": number
  },
  "total_per_person": number,
  "total_for_group": number,
  "breakdown_by_category": {
    "accommodation": number,
    "food": number,
    "local_transport": number,
    "international_flights_estimate": number,
    "attractions": number,
    "shopping": number,
    "miscellaneous": number
  },
  "money_saving_tips": ["tip1", "tip2", "tip3"],
  "best_time_to_visit": "string",
  "notes": "any important notes about costs"
}
PROMPT;

        try {
            $estimate = $this->gemini->generateJson($prompt);

            return response()->json([
                'success' => true,
                'data'    => $estimate,
            ]);
        } catch (\RuntimeException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate budget estimate. Please try again.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * POST /api/ai/expense-split-suggestions
     * Suggest how to split expenses fairly for a group trip.
     */
    public function expenseSplitSuggestions(Request $request)
    {
        $request->validate([
            'destination'   => 'required|string|max:255',
            'duration_days' => 'required|integer|min:1',
            'total_budget'  => 'required|numeric|min:1',
            'currency'      => 'nullable|string|max:10',
            'group_id'      => 'nullable|exists:groups,id',
            'members'       => 'nullable|array',
            'members.*'     => 'string|max:100',
        ]);

        $currency = $request->currency ?? 'USD';
        $members  = [];

        if ($request->group_id) {
            $group   = Group::with('members.user')->find($request->group_id);
            if ($group) {
                $members = $group->members
                    ->filter(fn($m) => !$m->user->is_admin)
                    ->map(fn($m) => $m->user->name)
                    ->values()
                    ->toArray();
            }
        } elseif ($request->members) {
            $members = $request->members;
        }

        $memberCount   = count($members) ?: 2;
        $memberList    = count($members) ? implode(', ', $members) : "{$memberCount} people";
        $perPersonBudget = round($request->total_budget / $memberCount, 2);

        $prompt = <<<PROMPT
You are a travel expense planning expert. Suggest a smart expense splitting plan for a group trip.

Destination: {$request->destination}
Duration: {$request->duration_days} days
Total budget: {$currency} {$request->total_budget}
Per person budget: {$currency} {$perPersonBudget}
Group members: {$memberList}

Provide practical suggestions for how the group should split and manage expenses fairly. Include which expenses to split equally, which might vary, and assignment suggestions.

Respond with a JSON object in this exact structure:
{
  "destination": "string",
  "duration_days": number,
  "total_budget": number,
  "currency": "string",
  "per_person_budget": number,
  "member_count": number,
  "expense_categories": [
    {
      "category": "string",
      "suggested_amount": number,
      "per_person": number,
      "split_type": "equal/by_usage/one_pays_and_collects",
      "description": "How to handle this expense",
      "suggested_payer": "string or null"
    }
  ],
  "shared_expense_tips": ["tip1", "tip2"],
  "payment_schedule": [
    {
      "when": "Before trip/Day 1/During trip/etc",
      "expense": "string",
      "amount": number,
      "who_pays": "string"
    }
  ],
  "recommended_apps": ["SplitMoney"],
  "summary": "Brief summary of the split strategy"
}
PROMPT;

        try {
            $suggestions = $this->gemini->generateJson($prompt);

            return response()->json([
                'success' => true,
                'data'    => $suggestions,
            ]);
        } catch (\RuntimeException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate expense split suggestions. Please try again.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * POST /api/ai/activity-suggestions
     * Suggest activities and attractions for a destination.
     */
    public function activitySuggestions(Request $request)
    {
        $request->validate([
            'destination'   => 'required|string|max:255',
            'duration_days' => 'required|integer|min:1|max:365',
            'interests'     => 'nullable|array',
            'interests.*'   => 'string|max:100',
            'people_count'  => 'nullable|integer|min:1',
            'currency'      => 'nullable|string|max:10',
        ]);

        $currency  = $request->currency ?? 'USD';
        $interests = $request->interests ? implode(', ', $request->interests) : 'general sightseeing, food, culture';
        $people    = $request->people_count ?? 2;

        $prompt = <<<PROMPT
You are a local travel expert. Suggest the best activities and attractions for a group visiting {$request->destination} for {$request->duration_days} days.

People count: {$people}
Interests: {$interests}
Currency: {$currency}

Respond with a JSON object in this exact structure:
{
  "destination": "string",
  "duration_days": number,
  "currency": "string",
  "must_see": [
    {
      "name": "string",
      "type": "attraction/restaurant/experience/tour",
      "description": "2-3 sentences",
      "estimated_cost_per_person": number,
      "duration_hours": number,
      "best_time": "Morning/Afternoon/Evening/Any",
      "booking_required": true/false,
      "group_friendly": true/false
    }
  ],
  "hidden_gems": [
    {
      "name": "string",
      "type": "string",
      "description": "string",
      "estimated_cost_per_person": number,
      "why_special": "string"
    }
  ],
  "food_recommendations": [
    {
      "name": "string",
      "cuisine": "string",
      "price_range": "cheap/moderate/expensive",
      "must_try_dish": "string",
      "estimated_cost_per_person": number
    }
  ],
  "day_trip_options": [
    {
      "destination": "string",
      "distance_km": number,
      "description": "string",
      "estimated_cost_per_person": number
    }
  ],
  "practical_tips": ["tip1", "tip2", "tip3"],
  "avoid": ["thing to avoid 1", "thing to avoid 2"]
}
PROMPT;

        try {
            $suggestions = $this->gemini->generateJson($prompt);

            return response()->json([
                'success' => true,
                'data'    => $suggestions,
            ]);
        } catch (\RuntimeException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate activity suggestions. Please try again.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
