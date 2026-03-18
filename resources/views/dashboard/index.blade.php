@extends('layouts.app')

@section('content')

<style>
.page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 2rem;
}

.page-title {
    font-size: 1.6rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
}

.page-title span {
    color: #38bdf8;
}

.btn-create {
    background: linear-gradient(135deg, #0ea5e9, #2563eb);
    color: white;
    border: none;
    padding: 0.55rem 1.2rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: opacity 0.2s, transform 0.1s;
    box-shadow: 0 3px 10px rgba(14, 165, 233, 0.35);
}

.btn-create:hover {
    opacity: 0.9;
    transform: translateY(-1px);
    color: white;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 16px;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06);
}

.empty-state i {
    font-size: 3rem;
    color: #cbd5e1;
    margin-bottom: 1rem;
    display: block;
}

.empty-state p {
    color: #94a3b8;
    font-size: 1rem;
    margin: 0;
}

.groups-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 1.2rem;
}

.group-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06);
    text-decoration: none;
    color: inherit;
    display: block;
    transition: transform 0.15s, box-shadow 0.15s;
    border: 1px solid #f1f5f9;
}

.group-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    color: inherit;
}

.group-card-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: linear-gradient(135deg, #e0f2fe, #bfdbfe);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
}

.group-card-icon i {
    font-size: 1.4rem;
    color: #0284c7;
}

.group-card-name {
    font-size: 1.05rem;
    font-weight: 600;
    color: #0f172a;
    margin-bottom: 0.3rem;
}

.group-card-meta {
    font-size: 0.8rem;
    color: #94a3b8;
    display: flex;
    align-items: center;
    gap: 4px;
}

.group-card-arrow {
    position: absolute;
    top: 1.4rem;
    right: 1.4rem;
    color: #cbd5e1;
    font-size: 1rem;
    transition: color 0.15s;
}

.group-card:hover .group-card-arrow {
    color: #0ea5e9;
}

.btn-delete-card {
    position: absolute;
    bottom: 1.1rem;
    right: 1.1rem;
    width: 30px;
    height: 30px;
    border-radius: 8px;
    background: transparent;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #cbd5e1;
    font-size: 0.9rem;
    cursor: pointer;
    opacity: 0;
    transition: opacity 0.15s, background 0.15s, color 0.15s;
    z-index: 10;
}

.group-card-wrapper:hover .btn-delete-card {
    opacity: 1;
}

.btn-delete-card:hover {
    background: #fee2e2;
    color: #dc2626;
}
</style>

<div class="page-header">
    <h1 class="page-title"><span>Groups</span></h1>
    <a href="/groups/create" class="btn-create">
        <i class="bi bi-plus-lg"></i> New Group
    </a>
</div>

@if($groups->isEmpty())
<div class="empty-state">
    <i class="bi bi-people"></i>
    <p>No groups yet. Create one to start splitting expenses!</p>
</div>
@else
<div class="groups-grid">
    @foreach($groups as $group)
    <div class="group-card-wrapper" style="position:relative;">
        <a href="/groups/{{ $group->id }}" class="group-card" style="position:relative;">
            <div class="group-card-icon">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="group-card-name">{{ $group->name }}</div>
            <div class="group-card-meta">
                <i class="bi bi-hash"></i> Group {{ $group->id }}
            </div>
            <i class="bi bi-chevron-right group-card-arrow"></i>
        </a>
        <form method="POST" action="/groups/{{ $group->id }}"
            data-confirm="This will also remove all expenses and settlements."
            data-title="Delete '{{ $group->name }}'?">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-delete-card" title="Delete group">
                <i class="bi bi-trash3"></i>
            </button>
        </form>
    </div>
    @endforeach
</div>
@endif

@endsection