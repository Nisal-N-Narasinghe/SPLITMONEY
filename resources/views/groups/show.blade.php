@extends('layouts.app')

@section('content')

<h2>{{ $group->name }}</h2>

<div class="mb-3">

    <a href="/expenses/create/{{ $group->id }}" class="btn btn-primary">
        Add Expense
    </a>

    <a href="/settlements/create/{{ $group->id }}" class="btn btn-warning">
        Add Settlement
    </a>

</div>

<h4>Members</h4>

<ul class="list-group mb-4">

    @foreach($group->members as $member)

    <li class="list-group-item">

        {{ $member->user->name }}

    </li>

    @endforeach

</ul>

<h4>Balances</h4>

<table class="table table-bordered">

    <thead>
        <tr>
            <th>User</th>
            <th>Balance</th>
        </tr>
    </thead>

    <tbody>

        @foreach($balances as $balance)

        <tr>

            <td>{{ $balance['name'] }}</td>

            <td>

                @if($balance['balance'] > 0)

                <span class="text-success">

                    Gets {{ number_format($balance['balance'],2) }}

                </span>

                @elseif($balance['balance'] < 0) <span class="text-danger">

                    Owes {{ number_format(abs($balance['balance']),2) }}

                    </span>

                    @else

                    Settled

                    @endif

            </td>

        </tr>

        @endforeach

    </tbody>

</table>

<h4>Expenses</h4>

<table class="table table-bordered">

    <thead>

        <tr>

            <th>Description</th>
            <th>Amount</th>
            <th>Paid By</th>
            <th>Date</th>

        </tr>

    </thead>

    <tbody>

        @foreach($group->expenses as $expense)

        <tr>

            <td>{{ $expense->description }}</td>
            <td>{{ $expense->amount }}</td>
            <td>{{ $expense->payer->name }}</td>
            <td>{{ $expense->expense_date }}</td>

        </tr>

        @endforeach

    </tbody>

</table>

<h4>Settlements</h4>
<table class="table table-bordered">

    <thead>

        <tr>

            <th>Paid From</th>
            <th>Paid To</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Note</th>

        </tr>

    </thead>

    <tbody>

        @foreach($settlements as $settlement)

        <tr>

            <td>{{ $settlement->fromUser->name }}</td>
            <td>{{ $settlement->toUser->name }}</td>
            <td>{{ $settlement->amount }}</td>
            <td>{{ $settlement->settled_at->format('Y-m-d') }}</td>
            <td>{{ $settlement->note }}</td>

        </tr>

        @endforeach

    </tbody>

</table>

@endsection