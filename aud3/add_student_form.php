<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Student</title>
</head>
<body>
<form action="add_student.php" method="POST">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" required>
    <br />
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>
    <br />
    <label for="age">Age:</label>
    <input type="number" name="age" id="age" required>
    <br />
    <button type="submit">Add Student</button>
</form>
</body>
