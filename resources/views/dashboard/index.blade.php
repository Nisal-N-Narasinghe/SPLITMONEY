@extends('layouts.app')

@section('content')

<h2>Dashboard</h2>

<a href="/groups/create" class="btn btn-primary mb-3">
    Create Group
</a>

<table class="table table-bordered">

<thead>
<tr>
<th>ID</th>
<th>Group Name</th>
<th>Action</th>
</tr>
</thead>

<tbody>

@foreach($groups as $group)

<tr>
<td>{{ $group->id }}</td>
<td>{{ $group->name }}</td>

<td>
<a href="/groups/{{ $group->id }}" class="btn btn-sm btn-success">
View
</a>
</td>

</tr>

@endforeach

</tbody>

</table>

@endsection
