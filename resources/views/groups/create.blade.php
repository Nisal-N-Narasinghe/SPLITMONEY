@extends('layouts.app')

@section('content')

<h2>Create Group</h2>

<form method="POST" action="/groups">

@csrf

<div class="mb-3">

<label class="form-label">Group Name</label>

<input type="text" name="name" class="form-control">

</div>

<div class="mb-3">

<label class="form-label">Created By</label>

<select name="created_by" class="form-control">

@foreach($users as $user)

<option value="{{ $user->id }}">
{{ $user->name }}
</option>

@endforeach

</select>

</div>

<div class="mb-3">

<label class="form-label">Select Members</label>

@foreach($users as $user)

<div class="form-check">

<input type="checkbox"
name="members[]"
value="{{ $user->id }}"
class="form-check-input">

<label class="form-check-label">

{{ $user->name }}

</label>

</div>

@endforeach

</div>

<button class="btn btn-success">
Create Group
</button>

</form>

@endsection
