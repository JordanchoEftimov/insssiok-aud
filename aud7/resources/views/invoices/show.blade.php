<h1>Invoice Details</h1>

<div>
    <strong>Invoice Number:</strong> {{ $invoice->invoice_number }}
</div>

<div>
    <strong>Client:</strong>
    <a href="{{ route('clients.show', $invoice->client->id) }}">
        {{ $invoice->client->full_name }}
    </a>
</div>

<div>
    <strong>Date:</strong> {{ $invoice->created_at }}
</div>

<div>
    <strong>Due Date:</strong> {{ $invoice->due_date }}
</div>

<div>
    <strong>Status:</strong> {{ ucfirst($invoice->status) }}
</div>

<div>
    <strong>Amount:</strong> {{ $invoice->amount }} $
</div>

<a href="{{ route('invoices.index') }}">Back to Invoices</a>
