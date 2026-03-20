@extends('layouts.app')

@section('content')
<style>
    .planner-shell {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    .planner-card {
        background: linear-gradient(135deg, rgba(255,255,255,0.95), rgba(255,255,255,0.7));
        border: 1px solid rgba(124, 58, 237, 0.15);
        border-radius: 20px;
        box-shadow: 0 12px 40px rgba(124,58,237,0.15), 0 4px 16px rgba(0,0,0,0.08), inset 0 1px 2px rgba(255,255,255,0.8);
        padding: 2rem;
        backdrop-filter: blur(10px);
        animation: cardFadeIn 0.6s ease;
    }

    @keyframes cardFadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .planner-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #7c3aed, #06b6d4, #4f46e5);
        border-radius: 20px 20px 0 0;
        background-size: 200% 100%;
        animation: gradientFlow 4s ease infinite;
    }

    @keyframes gradientFlow {
        0% { background-position: 0%; }
        50% { background-position: 100%; }
        100% { background-position: 0%; }
    }

    .planner-card {
        position: relative;
    }

    .planner-title {
        margin: 0 0 0.4rem;
        font-size: 1.6rem;
        font-weight: 800;
        background: linear-gradient(90deg, #1e293b, #7c3aed);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.5px;
    }

    .planner-subtitle {
        margin: 0 0 1.5rem;
        color: #64748b;
        font-size: 0.95rem;
        font-weight: 500;
        line-height: 1.4;
    }

    .planner-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.2rem;
    }

    .planner-input,
    .planner-select,
    .planner-textarea {
        width: 100%;
        border: 2px solid rgba(124, 58, 237, 0.15);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        font-family: 'Inter', sans-serif;
        background: rgba(255,255,255,0.7);
        color: #1e293b;
        transition: all 0.3s ease;
    }

    .planner-input:focus,
    .planner-select:focus,
    .planner-textarea:focus {
        outline: none;
        border-color: #7c3aed;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1), 0 4px 12px rgba(124, 58, 237, 0.15);
    }

    .planner-textarea {
        min-height: 110px;
        resize: vertical;
    }

    .planner-label {
        display: block;
        font-size: 0.85rem;
        color: #475569;
        margin-bottom: 0.5rem;
        font-weight: 700;
        letter-spacing: 0.2px;
        text-transform: uppercase;
    }

    .planner-btn {
        background: linear-gradient(135deg, #7c3aed 0%, #4f46e5 50%, #0ea5e9 100%);
        background-size: 200% 200%;
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 0.75rem 1.4rem;
        font-weight: 700;
        font-size: 0.95rem;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(.4,0,.2,1);
        box-shadow: 0 8px 24px rgba(124,58,237,0.35), 0 4px 12px rgba(0,0,0,0.1);
        letter-spacing: 0.3px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .planner-btn:hover:not(:disabled) {
        transform: translateY(-3px);
        box-shadow: 0 12px 40px rgba(124,58,237,0.45), 0 6px 16px rgba(0,0,0,0.15);
        background-position: 100% 50%;
    }

    .planner-btn:active:not(:disabled) {
        transform: translateY(-1px);
    }

    .planner-btn:disabled {
        opacity: 0.65;
        cursor: not-allowed;
    }

    .planner-btn.loading::after {
        content: '';
        display: inline-block;
        width: 14px;
        height: 14px;
        border: 2px solid rgba(255,255,255,0.3);
        border-top-color: #fff;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .budget-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 1rem;
        margin: 1.5rem 0;
    }

    .budget-box {
        background: linear-gradient(135deg, rgba(124,58,237,0.08), rgba(79,70,229,0.08));
        border: 2px solid rgba(124, 58, 237, 0.2);
        border-radius: 14px;
        padding: 1.2rem;
        transition: all 0.3s ease;
        animation: budgetEnter 0.5s ease forwards;
    }

    @keyframes budgetEnter {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .budget-box:hover {
        border-color: #7c3aed;
        box-shadow: 0 8px 24px rgba(124,58,237,0.2);
        transform: translateY(-2px);
    }

    .budget-label {
        color: #64748b;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        font-weight: 700;
        margin-bottom: 0.6rem;
    }

    .budget-value {
        color: #7c3aed;
        font-weight: 800;
        font-size: 1.4rem;
        letter-spacing: -0.3px;
    }

    .itinerary-day {
        border: 2px solid rgba(124, 58, 237, 0.15);
        border-radius: 14px;
        padding: 1.2rem;
        margin-bottom: 0.8rem;
        background: linear-gradient(135deg, rgba(124,58,237,0.04), rgba(79,70,229,0.04));
        transition: all 0.3s ease;
        animation: itenaryEnter 0.5s ease forwards;
    }

    @keyframes itenaryEnter {
        from { opacity: 0; transform: translateX(-10px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .itinerary-day:hover {
        border-color: #7c3aed;
        box-shadow: 0 8px 20px rgba(124,58,237,0.15);
        background: linear-gradient(135deg, rgba(124,58,237,0.08), rgba(79,70,229,0.08));
    }

    .itinerary-day h4 {
        margin: 0 0 0.5rem;
        font-size: 0.95rem;
        font-weight: 700;
        color: #1e293b;
        letter-spacing: -0.2px;
    }

    .itinerary-day ul {
        margin: 0;
        padding-left: 1.4rem;
        color: #334155;
        font-size: 0.9rem;
    }

    .itinerary-day li {
        margin-bottom: 0.4rem;
        line-height: 1.4;
    }

    .muted-note {
        color: #94a3b8;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .members-checkbox-list {
        max-height: 220px;
        overflow-y: auto;
        border: 2px solid rgba(124, 58, 237, 0.15);
        border-radius: 12px;
        padding: 0.8rem;
        background: rgba(255,255,255,0.7);
    }

    .members-checkbox-list::-webkit-scrollbar {
        width: 6px;
    }

    .members-checkbox-list::-webkit-scrollbar-track {
        background: rgba(124,58,237,0.05);
        border-radius: 10px;
    }

    .members-checkbox-list::-webkit-scrollbar-thumb {
        background: rgba(124,58,237,0.3);
        border-radius: 10px;
    }

    .members-checkbox-list::-webkit-scrollbar-thumb:hover {
        background: rgba(124,58,237,0.5);
    }

    .member-option {
        display: flex;
        align-items: flex-start;
        gap: 0.7rem;
        border: 2px solid rgba(124, 58, 237, 0.1);
        border-radius: 10px;
        padding: 0.6rem 0.8rem;
        margin-bottom: 0.6rem;
        cursor: pointer;
        transition: all 0.2s ease;
        background: rgba(255,255,255,0.5);
    }

    .member-option:last-child {
        margin-bottom: 0;
    }

    .member-option:hover {
        border-color: #7c3aed;
        background: rgba(124,58,237,0.05);
        transform: translateX(2px);
    }

    .member-option input[type="checkbox"] {
        margin-top: 0.25rem;
        cursor: pointer;
        accent-color: #7c3aed;
        width: 18px;
        height: 18px;
        border-radius: 4px;
    }

    .member-name {
        display: block;
        font-size: 0.9rem;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.2;
    }

    .member-email {
        display: block;
        font-size: 0.8rem;
        color: #64748b;
        line-height: 1.2;
        margin-top: 0.2rem;
        font-weight: 500;
    }

    .ai-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: linear-gradient(90deg, rgba(124,58,237,0.15), rgba(79,70,229,0.15));
        color: #7c3aed;
        padding: 0.3rem 0.7rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        margin-bottom: 0.8rem;
        border: 1px solid rgba(124,58,237,0.3);
    }

    .ai-badge i {
        animation: badgePulse 2s ease-in-out infinite;
    }

    @keyframes badgePulse {
        0%, 100% { opacity: 0.8; }
        50% { opacity: 1; filter: drop-shadow(0 0 4px rgba(124,58,237,0.6)); }
    }

    @media (max-width: 768px) {
        .planner-card {
            padding: 1.5rem;
        }

        .planner-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .planner-title {
            font-size: 1.4rem;
        }

        .budget-grid {
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        }

        .budget-value {
            font-size: 1.2rem;
        }

        .planner-btn {
            padding: 0.65rem 1.2rem;
            font-size: 0.9rem;
        }

        .planner-input,
        .planner-select,
        .planner-textarea {
            padding: 0.65rem 0.9rem;
        }
    }
</style>

<div class="planner-shell">
    <div class="planner-card">
        <span class="ai-badge">
            <i class="bi bi-stars"></i> AI-POWERED PLANNING
        </span>
        <h1 class="planner-title">Trip Planner</h1>
        <p class="planner-subtitle">Let AI analyze your destination and generate a complete day-by-day itinerary with category-wise budget break-down. Then instantly create a group from the plan.</p>

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
                <button type="submit" class="planner-btn" id="generateBtn">
                    <i class="bi bi-lightbulb-fill"></i> Generate Plan
                </button>
                <span class="muted-note" id="plannerStatus">Ready to generate.</span>
            </div>
        </form>
    </div>

    <div class="planner-card" id="resultCard" style="display:none;">
        <span class="ai-badge">
            <i class="bi bi-check-circle-fill"></i> PLAN GENERATED
        </span>
        <h2 class="planner-title" style="font-size:1.4rem;margin-bottom:0.5rem;">Your Trip Plan</h2>
        <p class="planner-subtitle" id="planSummary"></p>

        <div style="margin-top:1.5rem;">
            <h3 class="planner-label" style="margin-bottom:0.8rem;">Budget Breakdown</h3>
            <div class="budget-grid" id="budgetCategories"></div>
        </div>

        <div style="margin-top:2rem;">
            <h3 class="planner-label" style="margin-bottom:0.8rem;">Daily Itinerary</h3>
            <div id="itineraryWrap"></div>
        </div>

        <div style="margin-top:2rem;border-top:2px solid rgba(124,58,237,0.1);padding-top:2rem;">
            <h3 class="planner-label" style="margin-bottom:1rem;">Create Group From This Plan</h3>
            <form method="POST" action="/trip-planner/create-group">
            @csrf
            <input type="hidden" name="plan_json" id="planJsonInput">

            <div class="planner-grid">
                <div>
                    <label class="planner-label" for="group_name">Group Name</label>
                    <input id="group_name" name="group_name" class="planner-input" required>
                </div>
                <div>
                    <label class="planner-label" for="member_ids">Friends (optional)</label>
                    <div id="member_ids" class="members-checkbox-list">
                        @forelse($users as $user)
                        <label class="member-option">
                            <input type="checkbox" name="member_ids[]" value="{{ $user->id }}">
                            <span>
                                <span class="member-name">{{ $user->name }}</span>
                                <span class="member-email">{{ $user->email }}</span>
                            </span>
                        </label>
                        @empty
                        <p class="muted-note" style="margin:0;">You have no friends yet. Add friends from your <a href="{{ route('profile.edit') }}">profile</a> first.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div style="margin-top: 0.8rem;">
                <button type="submit" class="planner-btn">
                    <i class="bi bi-people-fill"></i> Create Group
                </button>
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
        generateBtn.classList.add('loading');
        plannerStatus.textContent = '✨ Generating with AI...';

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
            planSummary.textContent = plan.summary || 'Your personalized trip plan has been generated!';
            groupName.value = (plan.destination || 'Trip') + ' Trip';

            budgetCategories.innerHTML = '';
            const categories = plan.budget?.categories || {};
            const total = Number(plan.budget?.total || 0).toFixed(2);

            const totalBox = document.createElement('div');
            totalBox.className = 'budget-box';
            totalBox.innerHTML = '<div class="budget-label">Total Budget</div><div class="budget-value">$' + total + '</div>';
            budgetCategories.appendChild(totalBox);

            Object.keys(categories).forEach((key) => {
                const value = Number(categories[key] || 0).toFixed(2);
                const card = document.createElement('div');
                card.className = 'budget-box';
                card.innerHTML = '<div class="budget-label">' + key.toUpperCase() + '</div><div class="budget-value">$' + value + '</div>';
                budgetCategories.appendChild(card);
            });

            itineraryWrap.innerHTML = '';
            (plan.daily_plan || []).forEach((dayItem, index) => {
                const card = document.createElement('div');
                card.className = 'itinerary-day';
                card.style.animationDelay = (index * 0.1) + 's';
                const activities = (dayItem.activities || []).map((act) => '<li>' + act + '</li>').join('');
                card.innerHTML = '<h4><i class="bi bi-calendar-event"></i> Day ' + dayItem.day + ': ' + (dayItem.title || '') + '</h4><ul>' + activities + '</ul>';
                itineraryWrap.appendChild(card);
            });

            planJsonInput.value = JSON.stringify(plan);
            resultCard.style.display = 'block';
            plannerStatus.textContent = '✓ Plan ready! Review and create your group below.';
            resultCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
        } catch (error) {
            plannerStatus.textContent = '✗ ' + error.message;
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: error.message,
                confirmButtonText: 'OK'
            });
        } finally {
            generateBtn.disabled = false;
            generateBtn.classList.remove('loading');
        }
    });
</script>
@endsection
