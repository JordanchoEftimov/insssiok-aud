<h1>Create New Client</h1>


<form action="{{ route('clients.store') }}" method="POST">
    @csrf
    <div>
        <label for="full_name">Name</label>
        <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}">
        @error('full_name')
            <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}">
        @error('email')
            <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" value="{{ old('phone') }}">
        @error('phone')
            <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label for="address">Address</label>
        <input type="text" id="address" name="address" value="{{ old('address') }}">
        @error('address')
            <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <button type="submit">Create Client</button>
    </div>
</form>

<a href="{{ route('clients.index') }}">Back to Clients</a>
