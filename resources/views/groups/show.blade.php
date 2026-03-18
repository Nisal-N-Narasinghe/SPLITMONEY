@extends('layouts.app')

@section('content')

<style>
    .page-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.8rem;
        flex-wrap: wrap;
    }

    .back-btn {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: white;
        border: 1px solid #e2e8f0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        text-decoration: none;
        transition: background 0.15s;
        flex-shrink: 0;
    }

    .back-btn:hover { background: #f1f5f9; color: #0f172a; }

    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
        flex: 1;
    }

    .action-btns {
        display: flex;
        gap: 0.6rem;
        flex-wrap: wrap;
        align-items: center;
    }

    .btn-action {
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: opacity 0.2s, transform 0.1s;
    }

    .btn-action:hover { opacity: 0.88; transform: translateY(-1px); }

    .btn-expense {
        background: linear-gradient(135deg, #0ea5e9, #2563eb);
        color: white;
        box-shadow: 0 3px 10px rgba(14,165,233,0.3);
    }

    .btn-settlement {
        background: linear-gradient(135deg, #f59e0b, #ef4444);
        color: white;
        box-shadow: 0 3px 10px rgba(245,158,11,0.3);
    }

    .btn-delete-group {
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        background: white;
        color: #dc2626;
        border: 1.5px solid #fca5a5;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
        transition: background 0.15s, border-color 0.15s;
    }

    .btn-delete-group:hover {
        background: #fee2e2;
        border-color: #dc2626;
    }

    .section-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        border: 1px solid #f1f5f9;
        margin-bottom: 1.4rem;
    }

    .section-title {
        font-size: 1rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .section-title i {
        color: #0ea5e9;
        font-size: 1.1rem;
    }

    .member-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        color: #0369a1;
        border-radius: 20px;
        padding: 0.3rem 0.75rem;
        font-size: 0.82rem;
        font-weight: 600;
        margin: 0.2rem;
    }

    .balance-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.7rem 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .balance-row:last-child { border-bottom: none; }

    .balance-name {
        font-size: 0.9rem;
        font-weight: 600;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .balance-name i { color: #94a3b8; }

    .badge-gets {
        background: #dcfce7;
        color: #166534;
        border-radius: 8px;
        padding: 0.25rem 0.7rem;
        font-size: 0.82rem;
        font-weight: 700;
    }

    .badge-owes {
        background: #fee2e2;
        color: #991b1b;
        border-radius: 8px;
        padding: 0.25rem 0.7rem;
        font-size: 0.82rem;
        font-weight: 700;
    }

    .badge-settled {
        background: #f1f5f9;
        color: #64748b;
        border-radius: 8px;
        padding: 0.25rem 0.7rem;
        font-size: 0.82rem;
        font-weight: 600;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
    }

    .data-table thead th {
        background: #f8fafc;
        color: #64748b;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 0.65rem 0.9rem;
        border-bottom: 2px solid #f1f5f9;
    }

    .data-table tbody td {
        padding: 0.75rem 0.9rem;
        border-bottom: 1px solid #f8fafc;
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
