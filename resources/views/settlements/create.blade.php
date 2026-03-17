@extends('layouts.app')

@section('content')

<style>
    .page-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.8rem;
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
    }

    .page-subtitle {
        font-size: 0.85rem;
        color: #94a3b8;
        font-weight: 500;
    }

    .form-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        border: 1px solid #f1f5f9;
        max-width: 560px;
    }

    .form-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: 0.4rem;
        display: block;
    }

    .form-control, .form-select {
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        font-size: 0.9rem;
        padding: 0.55rem 0.85rem;
        color: #0f172a;
        width: 100%;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .form-control:focus, .form-select:focus {
        border-color: #38bdf8;
        box-shadow: 0 0 0 3px rgba(56,189,248,0.15);
        outline: none;
    }

    .input-prefix {
        position: relative;
    }

    .input-prefix .prefix-symbol {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .input-prefix .form-control {
        padding-left: 2rem;
    }

    .transfer-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .transfer-row .form-group {
        flex: 1;
    }

    .transfer-arrow {
        margin-top: 1.4rem;
        color: #94a3b8;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .btn-submit {
        background: linear-gradient(135deg, #f59e0b, #ef4444);
        color: white;
        border: none;
        padding: 0.65rem 1.6rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: opacity 0.2s, transform 0.1s;
        box-shadow: 0 3px 10px rgba(245,158,11,0.3);
        cursor: pointer;
    }

    .btn-submit:hover { opacity: 0.9; transform: translateY(-1px); }
</style>

<div class="page-header">
    <a href="/groups/{{ $group->id }}" class="back-btn"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h1 class="page-title">Settle Up</h1>
        <div class="page-subtitle">{{ $group->name }}</div>
    </div>
</div>

<div class="form-card">
    <form method="POST" action="/settlements">
        @csrf
        <input type="hidden" name="group_id" value="{{ $group->id }}">

        <div class="mb-3">
            <div class="transfer-row">
                <div class="form-group">
                    <label class="form-label">Paid From</label>
                    <select name="paid_from" class="form-control">
                        @foreach($group->members as $member)
                        <option value="{{ $member->user->id }}">{{ $member->user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="transfer-arrow"><i class="bi bi-arrow-right"></i></div>
                <div class="form-group">
                    <label class="form-label">Paid To</label>
                    <select name="paid_to" class="form-control">
                        @foreach($group->members as $member)
                        <option value="{{ $member->user->id }}">{{ $member->user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Amount</label>
            <div class="input-prefix">
                <span class="prefix-symbol">$</span>
                <input type="number" step="0.01" name="amount" class="form-control" placeholder="0.00">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="settled_at" class="form-control">
        </div>

        <div class="mb-4">
            <label class="form-label">Note <span style="color:#94a3b8;font-weight:400;">(optional)</span></label>
            <input type="text" name="note" class="form-control" placeholder="e.g. Paid via bank transfer">
        </div>

        <button type="submit" class="btn-submit">
            <i class="bi bi-arrow-left-right"></i> Save Settlement
        </button>
    </form>
</div>

@endsection
