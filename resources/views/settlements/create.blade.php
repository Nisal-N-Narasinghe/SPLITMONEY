@extends('layouts.app')

@section('content')

<h2>Add Settlement</h2>

<form method="POST" action="/settlements">

    @csrf

    <input type="hidden" name="group_id" value="{{ $group->id }}">

    <div class="mb-3">

        <label>Paid From</label>

        <select name="paid_from" class="form-control">

            @foreach($group->members as $member)

            <option value="{{ $member->user->id }}">

                {{ $member->user->name }}

            </option>

            @endforeach

        </select>

    </div>

    <div class="mb-3">

        <label>Paid To</label>

        <select name="paid_to" class="form-control">

            @foreach($group->members as $member)

            <option value="{{ $member->user->id }}">

                {{ $member->user->name }}

            </option>

            @endforeach

        </select>

    </div>

    <div class="mb-3">

        <label>Amount</label>

        <input type="number" step="0.01" name="amount" class="form-control">

    </div>

    <div class="mb-3">

        <label>Date</label>

        <input type="date" name="settled_at" class="form-control">

    </div>

    <div class="mb-3">

        <label>Note</label>

        <input type="text" name="note" class="form-control">

    </div>

    <button class="btn btn-success">

        Save Settlement

    </button>

</form>

@endsection