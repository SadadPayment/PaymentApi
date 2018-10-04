@extends('layouts.dashboard',["active"=> "transaction"])

@section('content')
    <h2>Transactions</h2>
    <table class="table table-hover" id="dataTable">
        <thead class="success">
            <td>Transaction Type</td>
            <td>Time</td>
            <td>User</td>
            <td>Status</td>
        </thead>
        <tbody>
            @forelse($transactions as $transaction)
                @if ($transaction->status == "Done")
                <tr class="success">

                @else
                <tr class="danger">
                @endif
                    <td>{{$transaction->transactionType->name}}</td>
                    <td>{{\Carbon\Carbon::parse($transaction->created_at)}}</td>
                    <td>{{$transaction->user->fullName}}</td>
                    <td>{{$transaction->status}}</td>
                </tr>
            @empty
            @endforelse
        </tbody>
    </table>
    {{--{{$transactions->links()}}--}}
@endsection