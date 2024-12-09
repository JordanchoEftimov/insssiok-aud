@extends('layout')

@section('content')
    <h1>{{ $client->full_name }}'s Details</h1>

    <table border="1">
        <tr>
            <th>Name</th>
            <td>{{ $client->full_name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $client->email }}</td>
        </tr>
        <tr>
            <th>Phone</th>
            <td>{{ $client->phone }}</td>
        </tr>
        <tr>
            <th>Address</th>
            <td>{{ $client->address }}</td>
        </tr>
    </table>

    <h2>Invoices</h2>
    <table border="1">
        <thead>
        <tr>
            <th>Invoice Number</th>
            <th>Date</th>
            <th>Due Date</th>
            <th>Status</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($client->invoices as $invoice)
            <tr>
                <td>
                    <a href="{{ route('invoices.show', $invoice->id) }}">
                        {{ $invoice->invoice_number }}
                    </a>
                </td>
                <td>{{ $invoice->created_at }}</td>
                <td>{{ $invoice->due_date }}</td>
                <td>{{ ucfirst($invoice->status) }}</td>
                <td>{{ $invoice->amount }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <a href="{{ route('clients.index') }}">Back to Clients</a>
@endsection
