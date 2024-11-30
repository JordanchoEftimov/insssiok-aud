<h1>Create Reservation</h1>

<form action="{{ route('reservations.store') }}" method="POST">
    @csrf

    <label for="guest_name">Guest Name:</label><br>
    <input type="text" id="guest_name" name="guest_name" required><br><br>

    <label for="num_guests">Number of Guests:</label><br>
    <input type="number" id="num_guests" name="num_guests" min="1" required><br><br>

    <label for="num_room">Room Number:</label><br>
    <input type="number" id="num_room" name="num_room" min="1" required><br><br>

    <label for="check_in_date">Check-In Date:</label><br>
    <input type="date" id="check_in_date" name="check_in_date" required><br><br>

    <label for="check_out_date">Check-Out Date:</label><br>
    <input type="date" id="check_out_date" name="check_out_date" required><br><br>

    <button type="submit">Create Reservation</button>
</form>
