@extends('layouts.app')

@section('content')

<style>
    .page-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 2rem;
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
        letter-spacing: -0.5px;
    }

    .page-subtitle {
        font-size: 0.9rem;
        color: #64748b;
        font-weight: 500;
    }

    .form-card {
        background: linear-gradient(135deg, rgba(255,255,255,0.95), rgba(255,255,255,0.7));
        border-radius: 20px;
        padding: 2.2rem;
        box-shadow: 0 12px 40px rgba(124,58,237,0.15), 0 4px 16px rgba(0,0,0,0.08), inset 0 1px 2px rgba(255,255,255,0.8);
        border: 1px solid rgba(124, 58, 237, 0.15);
        max-width: 580px;
        backdrop-filter: blur(10px);
    }

    .form-card::before {
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

    .form-card {
        position: relative;
    }

    .form-label {
        font-size: 0.85rem;
        font-weight: 700;
        color: #475569;
        margin-bottom: 0.5rem;
        display: block;
        letter-spacing: 0.2px;
        text-transform: uppercase;
    }

    .form-control, .form-select {
        border-radius: 12px;
        border: 2px solid rgba(124, 58, 237, 0.15);
        font-size: 0.95rem;
        padding: 0.75rem 1rem;
        color: #1e293b;
        width: 100%;
        background: rgba(255,255,255,0.7);
        transition: all 0.3s ease;
        font-family: 'Inter', sans-serif;
    }

    .form-control:focus, .form-select:focus {
        border-color: #7c3aed;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1), 0 4px 12px rgba(124, 58, 237, 0.15);
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
        color: #a78bfa;
        font-weight: 700;
        font-size: 1rem;
    }

    .input-prefix .form-control {
        padding-left: 2.2rem;
    }

    .member-check-item {
        display: flex;
        align-items: center;
        gap: 0.7rem;
        padding: 0.7rem 0.95rem;
        border-radius: 12px;
        border: 2px solid rgba(124, 58, 237, 0.15);
        margin-bottom: 0.6rem;
        cursor: pointer;
        transition: all 0.2s ease;
        background: rgba(255,255,255,0.5);
    }

    .member-check-item:hover {
        border-color: #7c3aed;
        background: rgba(124,58,237,0.05);
        transform: translateX(2px);
    }

    .member-check-item input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: #7c3aed;
        cursor: pointer;
        border-radius: 4px;
    }

    .member-check-item span {
        font-size: 0.92rem;
        color: #1e293b;
        font-weight: 700;
    }

    .section-label {
        font-size: 0.85rem;
        font-weight: 700;
        color: #475569;
        margin-bottom: 0.9rem;
        letter-spacing: 0.2px;
        text-transform: uppercase;
    }

    .btn-submit {
        background: linear-gradient(135deg, #7c3aed 0%, #4f46e5 50%, #0ea5e9 100%);
        background-size: 200% 200%;
        color: white;
        border: none;
        padding: 0.75rem 1.6rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.95rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s cubic-bezier(.4,0,.2,1);
        box-shadow: 0 8px 24px rgba(124,58,237,0.35), 0 4px 12px rgba(0,0,0,0.1);
        cursor: pointer;
        letter-spacing: 0.3px;
        font-family: 'Inter', sans-serif;
    }

    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 40px rgba(124,58,237,0.45), 0 6px 16px rgba(0,0,0,0.15);
        background-position: 100% 50%;
    }

    .btn-submit:active {
        transform: translateY(-1px);
    }
</style>

<div class="page-header">
    <a href="/groups/{{ $group->id }}" class="back-btn"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h1 class="page-title">Add Expense</h1>
        <div class="page-subtitle">{{ $group->name }}</div>
    </div>
</div>

<div class="form-card">
    <form method="POST" action="/expenses">
        @csrf
        <input type="hidden" name="group_id" value="{{ $group->id }}">

        <div class="mb-3">
            <label class="form-label">Description</label>
            <input type="text" name="description" class="form-control" placeholder="e.g. Dinner, Hotel...">
        </div>

        <div class="mb-3">
            <label class="form-label">Amount</label>
            <div class="input-prefix">
                <span class="prefix-symbol">$</span>
                <input type="number" step="0.01" name="amount" class="form-control" placeholder="0.00">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Paid By</label>
            <select name="paid_by" class="form-control">
                @foreach($group->members as $member)
                <option value="{{ $member->user->id }}">{{ $member->user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Expense Date</label>
            <input type="date" name="expense_date" class="form-control">
        </div>

        <div class="mb-4">
            <div class="section-label">Split With</div>
            @foreach($group->members as $member)
            <label class="member-check-item">
                <input type="checkbox" name="members[]" value="{{ $member->user->id }}">
                <span>{{ $member->user->name }}</span>
            </label>
            @endforeach
        </div>

        <button type="submit" class="btn-submit">
            <i class="bi bi-receipt"></i> Save Expense
        </button>
    </form>
</div>

@endsection
