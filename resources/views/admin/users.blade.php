@extends('admin.layout')

@section('content')

<style>
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }

    .page-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .users-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        border: 1px solid #f1f5f9;
        overflow: hidden;
    }

    .users-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
    }

    .users-table thead th {
        background: #f8fafc;
        color: #64748b;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 0.75rem 1.2rem;
        border-bottom: 2px solid #f1f5f9;
        text-align: left;
    }

    .users-table tbody td {
        padding: 0.9rem 1.2rem;
        border-bottom: 1px solid #f8fafc;
        color: #334155;
        vertical-align: middle;
    }

    .users-table tbody tr:last-child td { border-bottom: none; }
    .users-table tbody tr:hover td { background: #fafcff; }

    .user-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: linear-gradient(135deg, #e0f2fe, #bfdbfe);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #0284c7;
        font-weight: 700;
        font-size: 0.8rem;
        margin-right: 0.6rem;
    }

    .user-name-cell {
        display: flex;
        align-items: center;
        font-weight: 600;
        color: #0f172a;
    }

    .badge-date {
        font-size: 0.78rem;
        color: #94a3b8;
    }

    .btn-del {
        background: #fee2e2;
        color: #dc2626;
        border: none;
        border-radius: 8px;
        padding: 0.3rem 0.7rem;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: background 0.15s;
        font-family: 'Inter', sans-serif;
    }

    .btn-del:hover { background: #fca5a5; }

    .count-badge {
        background: #f1f5f9;
        color: #64748b;
        border-radius: 6px;
        padding: 0.15rem 0.5rem;
        font-size: 0.78rem;
        font-weight: 600;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #94a3b8;
        font-size: 0.9rem;
    }
</style>

<div class="page-header">
    <h1 class="page-title">Users <span style="color:#94a3b8;font-size:1rem;font-weight:500;">({{ $users->count() }})</span></h1>
</div>

@if(session('success'))
<div style="background:#dcfce7;color:#166534;border-radius:10px;padding:0.7rem 1rem;margin-bottom:1rem;font-size:0.85rem;display:flex;align-items:center;gap:6px;">
    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
</div>
@endif

@if(session('error'))
<div style="background:#fee2e2;color:#991b1b;border-radius:10px;padding:0.7rem 1rem;margin-bottom:1rem;font-size:0.85rem;">
    {{ session('error') }}
</div>
@endif

<div class="users-card">
    @if($users->isEmpty())
    <div class="empty-state"><i class="bi bi-people" style="font-size:2rem;display:block;margin-bottom:0.5rem;"></i>No users registered yet.</div>
    @else
    <table class="users-table">
        <thead>
            <tr>
                <th>User</th>
                <th>Email</th>
                <th>Groups</th>
                <th>Joined</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>
                    <div class="user-name-cell">
                        <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                        {{ $user->name }}
                    </div>
                </td>
                <td style="color:#64748b;">{{ $user->email }}</td>
                <td>
                    <span class="count-badge">{{ $user->groupMembers()->count() }}</span>
                </td>
                <td><span class="badge-date">{{ $user->created_at->format('d M Y') }}</span></td>
                <td>
                    <form method="POST" action="/admin/users/{{ $user->id }}"
                        data-confirm="This cannot be undone."
                        data-title="Delete {{ $user->name }}?">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-del">
                            <i class="bi bi-trash3"></i> Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

@endsection
