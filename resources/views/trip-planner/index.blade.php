@extends('layouts.app')

@section('content')
<style>
    .planner-shell {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .planner-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.06);
        padding: 1.2rem;
    }

    .planner-title {
        margin: 0 0 0.25rem;
        font-size: 1.15rem;
        font-weight: 700;
        color: #0f172a;
    }

    .planner-subtitle {
        margin: 0 0 1rem;
        color: #64748b;
        font-size: 0.9rem;
    }

    .planner-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 0.8rem;
    }

    .planner-input,
    .planner-select,
    .planner-textarea {
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 0.55rem 0.7rem;
        font-size: 0.9rem;
    }

    .planner-textarea {
        min-height: 95px;
        resize: vertical;
    }

    .planner-label {
        display: block;
        font-size: 0.8rem;
        color: #475569;
        margin-bottom: 0.32rem;
        font-weight: 600;
    }

    .planner-btn {
        background: linear-gradient(135deg, #0284c7, #1d4ed8);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 0.58rem 1.05rem;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .planner-btn:disabled {
        opacity: 0.7;
        cursor: wait;
    }

    .budget-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 0.7rem;
    }

    .budget-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.7rem;
    }

    .budget-label {
        color: #64748b;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .budget-value {
        color: #0f172a;
        font-weight: 700;
        font-size: 1rem;
    }

    .itinerary-day {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.75rem;
        margin-bottom: 0.65rem;
        background: #fcfdff;
    }

    .itinerary-day h4 {
        margin: 0 0 0.35rem;
        font-size: 0.93rem;
        color: #0f172a;
    }

    .itinerary-day ul {
        margin: 0;
        padding-left: 1rem;
        color: #334155;
        font-size: 0.88rem;
    }

    .muted-note {
        color: #94a3b8;
        font-size: 0.82rem;
    }

    .members-checkbox-list {
        max-height: 180px;
        overflow-y: auto;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 0.5rem;
        background: #ffffff;
    }

    .member-option {
        display: flex;
        align-items: flex-start;
        gap: 0.55rem;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.45rem 0.55rem;
        margin-bottom: 0.45rem;
        cursor: pointer;
        transition: border-color 0.15s, background-color 0.15s;
    }

    .member-option:last-child {
        margin-bottom: 0;
    }

    .member-option:hover {
        border-color: #93c5fd;
        background: #f8fbff;
    }

    .member-option input[type="checkbox"] {
        margin-top: 0.18rem;
    }

    .member-name {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: #0f172a;
        line-height: 1.2;
    }

    .member-email {
        display: block;
        font-size: 0.76rem;
        color: #64748b;
        line-height: 1.2;
        margin-top: 0.15rem;
    }
</style>

<div class="planner-shell">
    <div class="planner-card">
        <h1 class="planner-title">AI Trip Planner</h1>
        <p class="planner-subtitle">Generate day-by-day itinerary and budget plan, then create a group directly from the result.</p>

        <form id="plannerForm" class="planner-grid">
            @csrf
            <div>
                <label class="planner-label" for="destination">Destination</label>
                <input id="destination" name="destination" class="planner-input" placeholder="Bali, Tokyo, Ella..." required>
            </div>
            <div>
                <label class="planner-label" for="days">Days</label>
                <input id="days" name="days" type="number" min="1" max="30" value="3" class="planner-input" required>
            </div>
            <div>
                <label class="planner-label" for="travelers">Travelers</label>
                <input id="travelers" name="travelers" type="number" min="1" max="30" value="2" class="planner-input" required>
            </div>
            <div>
                <label class="planner-label" for="budget_mode">Budget Mode</label>
                <select id="budget_mode" name="budget_mode" class="planner-select">
                    <option value="both" selected>Both (day + category)</option>
                    <option value="total">Total budget focus</option>
                    <option value="category">Category budget focus</option>
                </select>
            </div>
            <div>
                <label class="planner-label" for="total_budget">Total Budget (optional)</label>
                <input id="total_budget" name="total_budget" type="number" min="1" step="0.01" class="planner-input" placeholder="1500">
            </div>
            <div style="grid-column: 1 / -1;">
                <label class="planner-label" for="notes">Extra Notes</label>
                <textarea id="notes" name="notes" class="planner-textarea" placeholder="Family trip, avoid expensive places, prefer beaches, include local food..."></textarea>
            </div>
            <div style="grid-column: 1 / -1; display: flex; align-items: center; gap: 0.7rem;">
                <button type="submit" class="planner-btn" id="generateBtn">Generate Plan</button>
                <span class="muted-note" id="plannerStatus">Ready to generate.</span>
            </div>
        </form>
    </div>

    <div class="planner-card" id="resultCard" style="display:none;">
        <h2 class="planner-title" style="font-size:1.05rem;">Plan Result</h2>
        <p class="planner-subtitle" id="planSummary"></p>

        <div class="budget-grid" id="budgetCategories"></div>

        <h3 class="planner-title" style="font-size:1rem;margin-top:1rem;">Daily Itinerary</h3>
        <div id="itineraryWrap"></div>

        <h3 class="planner-title" style="font-size:1rem;margin-top:1rem;">Create Group From This Plan</h3>
        <form method="POST" action="/trip-planner/create-group">
            @csrf
            <input type="hidden" name="plan_json" id="planJsonInput">

            <div class="planner-grid">
                <div>
                    <label class="planner-label" for="group_name">Group Name</label>
                    <input id="group_name" name="group_name" class="planner-input" required>
                </div>
                <div>
                    <label class="planner-label" for="member_ids">Members (optional)</label>
                    <div id="member_ids" class="members-checkbox-list">
                        @foreach($users as $user)
                        <label class="member-option">
                            <input type="checkbox" name="member_ids[]" value="{{ $user->id }}">
                            <span>
                                <span class="member-name">{{ $user->name }}</span>
                                <span class="member-email">{{ $user->email }}</span>
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div style="margin-top: 0.8rem;">
                <button type="submit" class="planner-btn">Create Group</button>
            </div>
        </form>
    </div>
</div>

<script>
    const plannerForm = document.getElementById('plannerForm');
    const generateBtn = document.getElementById('generateBtn');
    const plannerStatus = document.getElementById('plannerStatus');
    const resultCard = document.getElementById('resultCard');
    const planSummary = document.getElementById('planSummary');
    const budgetCategories = document.getElementById('budgetCategories');
    const itineraryWrap = document.getElementById('itineraryWrap');
    const planJsonInput = document.getElementById('planJsonInput');
    const groupName = document.getElementById('group_name');

    plannerForm.addEventListener('submit', async function (event) {
        event.preventDefault();

        generateBtn.disabled = true;
        plannerStatus.textContent = 'Generating with AI...';

        const formData = new FormData(plannerForm);

        try {
            const response = await fetch('/trip-planner/plan', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': formData.get('_token'),
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const payload = await response.json();
            if (!response.ok) {
                throw new Error(payload.message || 'Failed to generate plan.');
            }

            const plan = payload.plan;
            planSummary.textContent = plan.summary || 'Trip plan generated.';
            groupName.value = (plan.destination || 'Trip') + ' Trip';

            budgetCategories.innerHTML = '';
            const categories = plan.budget?.categories || {};
            const total = Number(plan.budget?.total || 0).toFixed(2);

            const totalBox = document.createElement('div');
            totalBox.className = 'budget-box';
            totalBox.innerHTML = '<div class="budget-label">Total</div><div class="budget-value">' + total + '</div>';
            budgetCategories.appendChild(totalBox);

            Object.keys(categories).forEach((key) => {
                const value = Number(categories[key] || 0).toFixed(2);
                const card = document.createElement('div');
                card.className = 'budget-box';
                card.innerHTML = '<div class="budget-label">' + key + '</div><div class="budget-value">' + value + '</div>';
                budgetCategories.appendChild(card);
            });

            itineraryWrap.innerHTML = '';
            (plan.daily_plan || []).forEach((dayItem) => {
                const card = document.createElement('div');
                card.className = 'itinerary-day';
                const activities = (dayItem.activities || []).map((act) => '<li>' + act + '</li>').join('');
                card.innerHTML = '<h4>Day ' + dayItem.day + ': ' + (dayItem.title || '') + '</h4><ul>' + activities + '</ul>';
                itineraryWrap.appendChild(card);
            });

            planJsonInput.value = JSON.stringify(plan);
            resultCard.style.display = 'block';
            plannerStatus.textContent = 'Plan generated. Review and create your group.';
        } catch (error) {
            plannerStatus.textContent = error.message;
        } finally {
            generateBtn.disabled = false;
        }
    });
</script>
@endsection
