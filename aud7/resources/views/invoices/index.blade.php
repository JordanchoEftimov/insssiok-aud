@extends('layout')

@section('content')
    <h1>Invoices</h1>

    <form method="GET" action="{{ route('invoices.index') }}">
        <label for="status">Filter by Status:</label>
        <select name="status" id="status">
            <option value="{{null}}">All</option>
            @foreach(\App\Enums\InvoiceStatusEnum::cases() as $status)
                <option value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>
                    {{ ucfirst($status->value) }}
                </option>
            @endforeach
        </select>
        <button type="submit">Filter</button>
    </form>

    <a href="{{ route('invoices.create') }}">
        <button>Create Invoice</button>
    </a>

    <table border="1">
        <thead>
        <tr>
            <th>Invoice Number</th>
            <th>Client</th>
            <th>Date</th>
            <th>Due Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($invoices as $invoice)
            <tr>
                <td>{{ $invoice->invoice_number }}</td>
                <td>
                    <a href="{{ route('clients.show', $invoice->client->id) }}">
                        {{ $invoice->client->full_name }}
                    </a>
                </td>
                <td>{{ $invoice->created_at }}</td>
                <td>{{ $invoice->due_date }}</td>
                <td>{{ ucfirst($invoice->status) }}</td>
                <td>
                    <a href="{{ route('invoices.show', $invoice->id) }}">View</a>
                    <a href="{{ route('invoices.edit', $invoice->id) }}">Edit</a>

                    <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this invoice?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $invoices->appends(request()->query())->links() }}
@endsection
