@extends('layouts.app')

@section('content')

<style>
.page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 2.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid rgba(124, 58, 237, 0.1);
}

.page-title {
    font-size: 2rem;
    font-weight: 800;
    background: linear-gradient(135deg, #1e293b, #7c3aed);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 0;
    letter-spacing: -0.5px;
}

.page-title span {
    background: linear-gradient(90deg, #7c3aed, #06b6d4);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.btn-create {
    background: linear-gradient(135deg, #7c3aed 0%, #4f46e5 50%, #0ea5e9 100%);
    background-size: 200% 200%;
    color: white;
    border: none;
    padding: 0.65rem 1.4rem;
    border-radius: 12px;
    font-weight: 700;
    font-size: 0.9rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s cubic-bezier(.4,0,.2,1);
    box-shadow: 0 8px 24px rgba(124, 58, 237, 0.3), 0 4px 12px rgba(0,0,0,0.1);
    letter-spacing: 0.3px;
    font-family: 'Inter', sans-serif;
}

.btn-create:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 40px rgba(124, 58, 237, 0.45), 0 6px 16px rgba(0,0,0,0.15);
    background-position: 100% 50%;
    color: white;
}

.btn-create:active {
    transform: translateY(-1px);
}

.empty-state {
    text-align: center;
    padding: 5rem 2rem;
    background: linear-gradient(135deg, rgba(255,255,255,0.7), rgba(224,231,255,0.5));
    border-radius: 20px;
    box-shadow: 0 4px 16px rgba(124,58,237,0.12), inset 0 1px 2px rgba(255,255,255,0.8);
    border: 1px solid rgba(124, 58, 237, 0.15);
    backdrop-filter: blur(10px);
}

.empty-state i {
    font-size: 4rem;
    background: linear-gradient(135deg, #7c3aed, #06b6d4);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 1.2rem;
    display: block;
    animation: float-icon 3s ease-in-out infinite;
}

@keyframes float-icon {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.empty-state p {
    color: #64748b;
    font-size: 1.05rem;
    margin: 0;
    font-weight: 500;
}

.groups-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
}

.group-card-wrapper {
    position: relative;
    animation: cardEnter 0.4s ease forwards;
}

@keyframes cardEnter {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.group-card {
    background: linear-gradient(135deg, rgba(255,255,255,0.95), rgba(255,255,255,0.7));
    border-radius: 16px;
    padding: 1.8rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08), inset 0 1px 2px rgba(255,255,255,0.8);
    text-decoration: none;
    color: inherit;
    display: block;
    transition: all 0.3s cubic-bezier(.4,0,.2,1);
    border: 1px solid rgba(124, 58, 237, 0.1);
    position: relative;
    overflow: hidden;
    backdrop-filter: blur(10px);
}

.group-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #7c3aed, #06b6d4, #4f46e5);
    background-size: 200% 100%;
    animation: gradientShift 3s ease infinite;
}

@keyframes gradientShift {
    0% { background-position: 0%; }
    50% { background-position: 100%; }
    100% { background-position: 0%; }
}

.group-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 40px rgba(124,58,237,0.25), 0 8px 20px rgba(0,0,0,0.1), inset 0 1px 2px rgba(255,255,255,0.9);
    color: inherit;
}

.group-card-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    background: linear-gradient(135deg, #7c3aed 0%, #4f46e5 50%, rgba(124,58,237,0.1) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.2rem;
    box-shadow: 0 4px 12px rgba(124,58,237,0.25);
    transition: transform 0.3s ease;
}

.group-card:hover .group-card-icon {
    transform: scale(1.1) rotate(5deg);
}

.group-card-icon i {
    font-size: 1.6rem;
    color: white;
}

.group-card-name {
    font-size: 1.15rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 0.4rem;
    letter-spacing: -0.3px;
}

.group-card-meta {
    font-size: 0.82rem;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 4px;
    font-weight: 500;
}

.group-card-arrow {
    position: absolute;
    top: 1.8rem;
    right: 1.8rem;
    color: rgba(124,58,237,0.3);
    font-size: 1.2rem;
    transition: all 0.3s ease;
    animation: float-arrow 2s ease-in-out infinite;
}

@keyframes float-arrow {
    0%, 100% { transform: translateX(0); }
    50% { transform: translateX(4px); }
}

.group-card:hover .group-card-arrow {
    color: #7c3aed;
    transform: translateX(4px) translateY(0);
}

.btn-delete-card {
    position: absolute;
    bottom: 1.3rem;
    right: 1.3rem;
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: rgba(239,68,68,0.1);
    border: 1px solid rgba(239,68,68,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ef4444;
    font-size: 0.95rem;
    cursor: pointer;
    opacity: 0;
    transition: all 0.2s ease;
    z-index: 10;
    font-family: 'Inter', sans-serif;
}

.group-card-wrapper:hover .btn-delete-card {
    opacity: 1;
}

.btn-delete-card:hover {
    background: #fee2e2;
    border-color: #fca5a5;
    color: #dc2626;
    transform: scale(1.08);
}

.btn-delete-card:active {
    transform: scale(0.95);
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .page-title {
        font-size: 1.75rem;
    }

    .groups-grid {
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 1rem;
    }

    .group-card {
        padding: 1.4rem;
    }

    .empty-state {
        padding: 3rem 1.5rem;
    }

    .btn-create {
        width: 100%;
        justify-content: center;
    }
}
</style>

<div class="page-header">
    <h1 class="page-title"><span>Groups</span></h1>
    <div class="d-flex gap-2">
        <a href="/groups/create" class="btn-create">
            <i class="bi bi-plus-lg"></i> New Group
        </a>
    </div>
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
