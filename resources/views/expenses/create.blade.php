@extends('layouts.app')

@section('content')

<h2>Add Expense</h2>

<form method="POST" action="/expenses">

@csrf

<input type="hidden"
name="group_id"
value="{{ $group->id }}">

<div class="mb-3">

<label>Description</label>

<input type="text"
name="description"
class="form-control">

</div>

<div class="mb-3">

<label>Amount</label>

<input type="number"
step="0.01"
name="amount"
class="form-control">

</div>

<div class="mb-3">

<label>Paid By</label>

<select name="paid_by" class="form-control">

@foreach($group->members as $member)

<option value="{{ $member->user->id }}">

{{ $member->user->name }}

</option>

@endforeach

</select>

</div>

<div class="mb-3">

<label>Expense Date</label>

<input type="date"
name="expense_date"
class="form-control">

</div>

<div class="mb-3">

<label>Split With</label>

@foreach($group->members as $member)

<div class="form-check">

<input type="checkbox"
name="members[]"
value="{{ $member->user->id }}"
class="form-check-input">

<label class="form-check-label">

{{ $member->user->name }}

</label>

</div>

@endforeach

</div>

<button class="btn btn-success">

Save Expense

</button>

</form>

@endsection
