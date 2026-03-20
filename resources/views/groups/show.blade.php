@extends('layouts.app')

@section('content')

<style>
    .page-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid rgba(124, 58, 237, 0.1);
    }

    .back-btn {
        width: 40px;
        height: 40px;
        border-radius: 11px;
        background: linear-gradient(135deg, rgba(124,58,237,0.08), rgba(79,70,229,0.08));
        border: 2px solid rgba(124, 58, 237, 0.2);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #7c3aed;
        text-decoration: none;
        transition: all 0.2s ease;
        flex-shrink: 0;
        font-size: 1.1rem;
    }

    .back-btn:hover {
        background: linear-gradient(135deg, rgba(124,58,237,0.15), rgba(79,70,229,0.15));
        border-color: #7c3aed;
        transform: translateX(-2px);
    }

    .page-title {
        font-size: 1.8rem;
        font-weight: 800;
        background: linear-gradient(90deg, #1e293b, #7c3aed);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0;
        flex: 1;
        letter-spacing: -0.5px;
    }

    .action-btns {
        display: flex;
        gap: 0.6rem;
        flex-wrap: wrap;
        align-items: center;
    }

    .btn-action {
        padding: 0.65rem 1.2rem;
        border-radius: 11px;
        font-weight: 700;
        font-size: 0.9rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s cubic-bezier(.4,0,.2,1);
        font-family: 'Inter', sans-serif;
        letter-spacing: 0.2px;
    }

    .btn-action:hover {
        transform: translateY(-3px);
    }

    .btn-expense {
        background: linear-gradient(135deg, #7c3aed 0%, #4f46e5 50%, #0ea5e9 100%);
        background-size: 200% 200%;
        color: white;
        box-shadow: 0 8px 24px rgba(124,58,237,0.3), 0 4px 12px rgba(0,0,0,0.1);
    }

    .btn-expense:hover {
        box-shadow: 0 12px 40px rgba(124,58,237,0.45), 0 6px 16px rgba(0,0,0,0.15);
        background-position: 100% 50%;
    }

    .btn-settlement {
        background: linear-gradient(135deg, #f59e0b 0%, #ef4444 50%, #f97316 100%);
        background-size: 200% 200%;
        color: white;
        box-shadow: 0 8px 24px rgba(245,158,11,0.3), 0 4px 12px rgba(0,0,0,0.1);
    }

    .btn-settlement:hover {
        box-shadow: 0 12px 40px rgba(245,158,11,0.4), 0 6px 16px rgba(0,0,0,0.15);
        background-position: 100% 50%;
    }

    .btn-delete-group {
        padding: 0.65rem 1.2rem;
        border-radius: 11px;
        font-weight: 700;
        font-size: 0.9rem;
        background: linear-gradient(135deg, rgba(239,68,68,0.1), rgba(239,68,68,0.08));
        color: #dc2626;
        border: 2px solid rgba(239, 68, 68, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Inter', sans-serif;
    }

    .btn-delete-group:hover {
        background: #fee2e2;
        border-color: #dc2626;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(220,38,38,0.2);
    }

    .section-card {
        background: linear-gradient(135deg, rgba(255,255,255,0.95), rgba(255,255,255,0.7));
        border-radius: 18px;
        padding: 1.8rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08), inset 0 1px 2px rgba(255,255,255,0.8);
        border: 1px solid rgba(124, 58, 237, 0.1);
        margin-bottom: 1.6rem;
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }

    .section-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #7c3aed, #06b6d4, #4f46e5);
        border-radius: 18px 18px 0 0;
        background-size: 200% 100%;
        animation: gradientShift 3s ease infinite;
    }

    @keyframes gradientShift {
        0% { background-position: 0%; }
        50% { background-position: 100%; }
        100% { background-position: 0%; }
    }

    .section-card {
        position: relative;
    }

    .section-card:hover {
        box-shadow: 0 8px 24px rgba(124,58,237,0.12), inset 0 1px 2px rgba(255,255,255,0.8);
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 1.2rem;
        display: flex;
        align-items: center;
        gap: 8px;
        letter-spacing: -0.3px;
    }

    .section-title i {
        background: linear-gradient(135deg, #7c3aed, #06b6d4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 1.3rem;
    }

    .member-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, rgba(124,58,237,0.1), rgba(79,70,229,0.1));
        border: 1px solid rgba(124, 58, 237, 0.3);
        color: #7c3aed;
        border-radius: 22px;
        padding: 0.4rem 0.85rem;
        font-size: 0.85rem;
        font-weight: 700;
        margin: 0.3rem;
        transition: all 0.2s ease;
    }

    .member-pill:hover {
        background: linear-gradient(135deg, rgba(124,58,237,0.2), rgba(79,70,229,0.2));
        border-color: #7c3aed;
    }

    .balance-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.9rem 0;
        border-bottom: 1px solid rgba(124, 58, 237, 0.08);
        transition: background 0.2s ease;
    }

    .balance-row:hover { background: rgba(124,58,237,0.03); }

    .balance-row:last-child { border-bottom: none; }

    .balance-name {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 8px;
        letter-spacing: -0.2px;
    }

    .balance-name i { color: #a78bfa; }

    .badge-gets {
        background: linear-gradient(135deg, rgba(74,222,128,0.15), rgba(34,197,94,0.15));
        color: #166534;
        border-radius: 8px;
        padding: 0.3rem 0.8rem;
        font-size: 0.85rem;
        font-weight: 800;
        border: 1px solid rgba(74, 222, 128, 0.3);
    }

    .badge-owes {
        background: linear-gradient(135deg, rgba(239,68,68,0.15), rgba(220,38,38,0.15));
        color: #991b1b;
        border-radius: 8px;
        padding: 0.3rem 0.8rem;
        font-size: 0.85rem;
        font-weight: 800;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .badge-settled {
        background: rgba(124,58,237,0.1);
        color: #7c3aed;
        border-radius: 8px;
        padding: 0.3rem 0.8rem;
        font-size: 0.85rem;
        font-weight: 800;
        border: 1px solid rgba(124, 58, 237, 0.3);
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
    }

    .data-table thead th {
        background: linear-gradient(90deg, rgba(124,58,237,0.05), rgba(79,70,229,0.05));
        color: #64748b;
        font-size: 0.8rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        padding: 0.8rem 1rem;
        border-bottom: 2px solid rgba(124, 58, 237, 0.15);
    }

    .data-table tbody td {
        padding: 0.85rem 1rem;
        border-bottom: 1px solid rgba(124, 58, 237, 0.08);
        color: #334155;
        vertical-align: middle;
    }

    .data-table tbody tr:last-child td { border-bottom: none; }

    .data-table tbody tr:hover td { background: #fafcff; }

    .amount-cell {
        font-weight: 700;
        color: #0f172a;
    }

    .empty-row td {
        text-align: center;
        color: #94a3b8;
        padding: 2rem;
        font-size: 0.85rem;
    }

    .budget-alert {
        border-radius: 14px;
        padding: 0.9rem 1rem;
        margin-bottom: 1.2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.8rem;
        font-weight: 700;
        border: 1px solid transparent;
    }

    .budget-alert-warning {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.14), rgba(249, 115, 22, 0.12));
        border-color: rgba(245, 158, 11, 0.35);
        color: #9a3412;
    }

    .budget-alert-danger {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.15), rgba(220, 38, 38, 0.14));
        border-color: rgba(239, 68, 68, 0.35);
        color: #991b1b;
    }

    .budget-topline {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.6rem;
        margin-bottom: 1rem;
        color: #475569;
        font-weight: 600;
    }

    .budget-metrics {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 0.8rem;
        margin-bottom: 1rem;
    }

    .budget-metric {
        background: linear-gradient(145deg, rgba(124,58,237,0.06), rgba(79,70,229,0.05));
        border: 1px solid rgba(124, 58, 237, 0.2);
        border-radius: 12px;
        padding: 0.85rem;
    }

    .budget-metric-label {
        color: #64748b;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.3rem;
    }

    .budget-metric-value {
        color: #0f172a;
        font-size: 1.05rem;
        font-weight: 800;
    }

    .budget-progress-wrap {
        margin-bottom: 1rem;
    }

    .budget-progress-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.45rem;
        font-size: 0.84rem;
        color: #475569;
        font-weight: 700;
    }

    .budget-progress {
        height: 10px;
        background: rgba(148, 163, 184, 0.2);
        border-radius: 999px;
        overflow: hidden;
    }

    .budget-progress-bar {
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, #10b981, #06b6d4);
        transition: width 0.4s ease;
    }

    .budget-progress-bar.warn {
        background: linear-gradient(90deg, #f59e0b, #f97316);
    }

    .budget-progress-bar.danger {
        background: linear-gradient(90deg, #ef4444, #dc2626);
    }

    .category-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 0.65rem;
    }

    .category-item {
        background: rgba(124, 58, 237, 0.05);
        border: 1px solid rgba(124, 58, 237, 0.18);
        border-radius: 10px;
        padding: 0.6rem 0.7rem;
    }

    .category-name {
        color: #64748b;
        font-size: 0.75rem;
        font-weight: 700;
        margin-bottom: 0.2rem;
    }

    .category-value {
        color: #1e293b;
        font-size: 0.9rem;
        font-weight: 800;
    }

    @media (max-width: 768px) {
        .budget-alert {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>

<div class="page-header">
    <a href="/" class="back-btn"><i class="bi bi-arrow-left"></i></a>
    <h1 class="page-title">{{ $group->name }}</h1>
    <div class="action-btns">
        <a href="/expenses/create/{{ $group->id }}" class="btn-action btn-expense">
            <i class="bi bi-plus-circle"></i> Add Expense
        </a>
        <a href="/settlements/create/{{ $group->id }}" class="btn-action btn-settlement">
            <i class="bi bi-arrow-left-right"></i> Settle Up
        </a>
        <form method="POST" action="/groups/{{ $group->id }}"
            data-confirm="This will also remove all expenses and settlements."
            data-title="Delete '{{ $group->name }}'?">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-delete-group">
                <i class="bi bi-trash3"></i> Delete
            </button>
        </form>
    </div>
</div>

@if($trip)
    @if($warningExceeded)
        <div class="budget-alert budget-alert-danger">
            <span><i class="bi bi-exclamation-triangle-fill"></i> Budget exceeded by ${{ number_format($remainingOrOverAmount, 2) }}. Total spent is ${{ number_format($totalExpenses, 2) }} against ${{ number_format($totalBudget, 2) }} budget.</span>
            <strong>{{ number_format($budgetUsagePercent, 2) }}% used</strong>
        </div>
    @elseif($warning80)
        <div class="budget-alert budget-alert-warning">
            <span><i class="bi bi-exclamation-circle-fill"></i> You are close to your trip budget. Spent ${{ number_format($totalExpenses, 2) }} of ${{ number_format($totalBudget, 2) }}.</span>
            <strong>{{ number_format($budgetUsagePercent, 2) }}% used</strong>
        </div>
    @endif

    <div class="section-card">
        <div class="section-title"><i class="bi bi-wallet2"></i> Trip Budget Overview</div>
        <div class="budget-topline">
            <span>{{ $trip->destination }} · {{ $trip->days }} day{{ $trip->days > 1 ? 's' : '' }} · {{ $trip->travelers }} traveler{{ $trip->travelers > 1 ? 's' : '' }}</span>
            <span>Mode: {{ \Illuminate\Support\Str::headline($trip->budget_mode) }}</span>
        </div>

        <div class="budget-metrics">
            <div class="budget-metric">
                <div class="budget-metric-label">Total Budget</div>
                <div class="budget-metric-value">${{ number_format($totalBudget, 2) }}</div>
            </div>
            <div class="budget-metric">
                <div class="budget-metric-label">Total Spent</div>
                <div class="budget-metric-value">${{ number_format($totalExpenses, 2) }}</div>
            </div>
            <div class="budget-metric">
                <div class="budget-metric-label">{{ $warningExceeded ? 'Exceeded' : 'Remaining' }}</div>
                <div class="budget-metric-value">${{ number_format($remainingOrOverAmount, 2) }}</div>
            </div>
        </div>

        <div class="budget-progress-wrap">
            <div class="budget-progress-header">
                <span>Budget Usage</span>
                <span>{{ number_format($budgetUsagePercent, 2) }}%</span>
            </div>
            <div class="budget-progress">
                <div
                    class="budget-progress-bar {{ $warningExceeded ? 'danger' : ($warning80 ? 'warn' : '') }}"
                    style="width: {{ min($budgetUsagePercent, 100) }}%;"
                ></div>
            </div>
        </div>

        @if(!empty($trip->category_budgets))
            <div class="section-title" style="font-size:0.95rem;margin-top:0.1rem;margin-bottom:0.8rem;">
                <i class="bi bi-pie-chart-fill"></i> Budget Distribution
            </div>
            <div class="category-grid">
                @foreach($trip->category_budgets as $category => $amount)
                    <div class="category-item">
                        <div class="category-name">{{ \Illuminate\Support\Str::headline($category) }}</div>
                        <div class="category-value">${{ number_format((float) $amount, 2) }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endif

{{-- Members --}}
<div class="section-card">
    <div class="section-title"><i class="bi bi-people-fill"></i> Members</div>
    <div>
        @foreach($group->members as $member)
        <span class="member-pill">
            <i class="bi bi-person-fill"></i> {{ $member->user->name }}
        </span>
        @endforeach
    </div>
</div>

{{-- Balances --}}
<div class="section-card">
    <div class="section-title"><i class="bi bi-bar-chart-fill"></i> Balances</div>
    @foreach($balances as $balance)
    <div class="balance-row">
        <div class="balance-name">
            <i class="bi bi-person-circle"></i>
            {{ $balance['name'] }}
        </div>
        @if($balance['balance'] > 0)
            <span class="badge-gets">Gets ${{ number_format($balance['balance'], 2) }}</span>
        @elseif($balance['balance'] < 0)
            <span class="badge-owes">Owes ${{ number_format(abs($balance['balance']), 2) }}</span>
        @else
            <span class="badge-settled"><i class="bi bi-check2"></i> Settled</span>
        @endif
    </div>
    @endforeach
</div>

{{-- Expenses --}}
<div class="section-card">
    <div class="section-title"><i class="bi bi-receipt"></i> Expenses</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Description</th>
                <th>Paid By</th>
                <th>Date</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @forelse($group->expenses as $expense)
            <tr>
                <td>{{ $expense->description }}</td>
                <td>
                    <span class="member-pill" style="font-size:0.78rem;padding:0.2rem 0.6rem;">
                        <i class="bi bi-person-fill"></i> {{ $expense->payer->name }}
                    </span>
                </td>
                <td>{{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}</td>
                <td class="amount-cell">${{ number_format($expense->amount, 2) }}</td>
            </tr>
            @empty
            <tr class="empty-row"><td colspan="4">No expenses yet</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Settlements --}}
<div class="section-card">
    <div class="section-title"><i class="bi bi-arrow-left-right"></i> Settlements</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>From</th>
                <th>To</th>
                <th>Date</th>
                <th>Note</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @forelse($settlements as $settlement)
            <tr>
                <td>{{ $settlement->fromUser->name }}</td>
                <td>{{ $settlement->toUser->name }}</td>
                <td>{{ $settlement->settled_at->format('d M Y') }}</td>
                <td style="color:#64748b;">{{ $settlement->note ?? '—' }}</td>
                <td class="amount-cell">${{ number_format($settlement->amount, 2) }}</td>
            </tr>
            @empty
            <tr class="empty-row"><td colspan="5">No settlements yet</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
