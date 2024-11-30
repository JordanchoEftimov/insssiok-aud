<h1>Edit Reservation</h1>

<form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="guest_name">Guest Name:</label><br>
    <input type="text" id="guest_name" name="guest_name" value="{{ $reservation->guest_name }}" required><br><br>

    <label for="num_guests">Number of Guests:</label><br>
    <input type="number" id="num_guests" name="num_guests" value="{{ $reservation->num_guests }}" min="1"
           required><br><br>

    <label for="num_room">Room Number:</label><br>
    <input type="number" id="num_room" name="num_room" value="{{ $reservation->num_room }}" min="1" required><br><br>

    <label for="check_in_date">Check-In Date:</label><br>
    <input type="date" id="check_in_date" name="check_in_date" value="{{ $reservation->check_in_date }}"
           required><br><br>

    <label for="check_out_date">Check-Out Date:</label><br>
    <input type="date" id="check_out_date" name="check_out_date" value="{{ $reservation->check_out_date }}"
           required><br><br>

    <button type="submit">Update Reservation</button>
</form>
