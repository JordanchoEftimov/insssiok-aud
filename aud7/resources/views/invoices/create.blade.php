<h1>Create New Invoice</h1>

<form method="POST" action="{{ route('invoices.store') }}">
    @csrf

    <div>
        <label for="invoice_number">Invoice Number:</label>
        <input type="text" name="invoice_number" id="invoice_number" value="{{ old('invoice_number') }}">
        @error('invoice_number')
            <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="client_id">Client:</label>
        <select name="client_id" id="client_id">
            <option value="">Select Client</option>
            @foreach ($clients as $client)
                <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                    {{ $client->full_name }}
                </option>
            @endforeach
        </select>
        @error('client_id')
            <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="due_date">Due Date:</label>
        <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}">
        @error('due_date')
            <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="status">Status:</label>
        <select name="status" id="status">
            @foreach(\App\Enums\InvoiceStatusEnum::cases() as $status)
                <option value="{{ $status->value }}" {{ old('status') == $status->value ? 'selected' : '' }}>
                    {{ ucfirst($status->value) }}
                </option>
            @endforeach
        </select>
        @error('status')
            <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="amount">Amount:</label>
        <input type="number" name="amount" id="amount" value="{{ old('amount') }}" step="0.01">
        @error('amount')
            <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit">Create Invoice</button>
</form>

<a href="{{ route('invoices.index') }}">Back to Invoices</a>
