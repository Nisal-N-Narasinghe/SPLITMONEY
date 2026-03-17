@extends('admin.layout')

@section('content')

<style>
    .page-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 1.5rem;
    }

    .groups-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        border: 1px solid #f1f5f9;
        overflow: hidden;
    }

    .groups-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
    }

    .groups-table thead th {
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

    .groups-table tbody td {
        padding: 0.9rem 1.2rem;
        border-bottom: 1px solid #f8fafc;
        color: #334155;
        vertical-align: middle;
    }

    .groups-table tbody tr:last-child td { border-bottom: none; }
    .groups-table tbody tr:hover td { background: #fafcff; }

    .group-name {
        font-weight: 600;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .group-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: linear-gradient(135deg, #e0f2fe, #bfdbfe);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #0284c7;
        font-size: 0.85rem;
    }

    .count-badge {
        background: #f1f5f9;
        color: #64748b;
        border-radius: 6px;
        padding: 0.15rem 0.5rem;
        font-size: 0.78rem;
        font-weight: 600;
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

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #94a3b8;
        font-size: 0.9rem;
    }
</style>

<h1 class="page-title">All Groups <span style="color:#94a3b8;font-size:1rem;font-weight:500;">({{ $groups->count() }})</span></h1>

@if(session('success'))
<div style="background:#dcfce7;color:#166534;border-radius:10px;padding:0.7rem 1rem;margin-bottom:1rem;font-size:0.85rem;display:flex;align-items:center;gap:6px;">
    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
</div>
@endif

<div class="groups-card">
    @if($groups->isEmpty())
    <div class="empty-state"><i class="bi bi-collection" style="font-size:2rem;display:block;margin-bottom:0.5rem;"></i>No groups yet.</div>
    @else
    <table class="groups-table">
        <thead>
            <tr>
                <th>Group</th>
                <th>Created By</th>
                <th>Members</th>
                <th>Expenses</th>
                <th>Created</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($groups as $group)
            <tr>
                <td>
                    <div class="group-name">
                        <div class="group-icon"><i class="bi bi-people-fill"></i></div>
                        {{ $group->name }}
                    </div>
                </td>
                <td style="color:#64748b;">{{ $group->creator?->name ?? '—' }}</td>
                <td><span class="count-badge">{{ $group->members()->count() }}</span></td>
                <td><span class="count-badge">{{ $group->expenses()->count() }}</span></td>
                <td style="color:#94a3b8;font-size:0.78rem;">{{ $group->created_at->format('d M Y') }}</td>
                <td>
                    <form method="POST" action="/admin/groups/{{ $group->id }}"
                        onsubmit="return confirm('Delete {{ $group->name }}?')">
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
