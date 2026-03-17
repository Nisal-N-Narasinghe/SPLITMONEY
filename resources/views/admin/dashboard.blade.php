@extends('admin.layout')

@section('content')

<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1.2rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 1.4rem;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        border: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
    }

    .stat-icon.blue   { background: #e0f2fe; color: #0284c7; }
    .stat-icon.green  { background: #dcfce7; color: #16a34a; }
    .stat-icon.orange { background: #fef3c7; color: #d97706; }
    .stat-icon.purple { background: #ede9fe; color: #7c3aed; }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.8rem;
        color: #94a3b8;
        font-weight: 500;
        margin-top: 2px;
    }

    .section-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        border: 1px solid #f1f5f9;
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

    .section-title i { color: #0ea5e9; }

    .user-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.7rem 0;
        border-bottom: 1px solid #f8fafc;
    }

    .user-row:last-child { border-bottom: none; }

    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #e0f2fe, #bfdbfe);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0284c7;
        font-weight: 700;
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    .user-info { display: flex; align-items: center; gap: 0.75rem; }
    .user-name { font-weight: 600; font-size: 0.9rem; color: #0f172a; }
    .user-email { font-size: 0.78rem; color: #94a3b8; }
    .user-date { font-size: 0.78rem; color: #94a3b8; }
</style>

<h1 style="font-size:1.4rem;font-weight:700;color:#0f172a;margin-bottom:1.5rem;">
    Admin Overview
</h1>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue"><i class="bi bi-people-fill"></i></div>
        <div>
            <div class="stat-value">{{ $stats['users'] }}</div>
            <div class="stat-label">Registered Users</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="bi bi-collection-fill"></i></div>
        <div>
            <div class="stat-value">{{ $stats['groups'] }}</div>
            <div class="stat-label">Total Groups</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="bi bi-receipt"></i></div>
        <div>
            <div class="stat-value">{{ $stats['expenses'] }}</div>
            <div class="stat-label">Total Expenses</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple"><i class="bi bi-arrow-left-right"></i></div>
        <div>
            <div class="stat-value">{{ $stats['settlements'] }}</div>
            <div class="stat-label">Settlements</div>
        </div>
    </div>
</div>

<div class="section-card">
    <div class="section-title"><i class="bi bi-person-plus-fill"></i> Recent Users</div>
    @forelse($recentUsers as $user)
    <div class="user-row">
        <div class="user-info">
            <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
            <div>
                <div class="user-name">{{ $user->name }}</div>
                <div class="user-email">{{ $user->email }}</div>
            </div>
        </div>
        <div class="user-date">{{ $user->created_at->format('d M Y') }}</div>
    </div>
    @empty
    <p style="color:#94a3b8;font-size:0.85rem;">No users yet.</p>
    @endforelse
</div>

@endsection
