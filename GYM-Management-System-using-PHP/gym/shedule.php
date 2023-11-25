<?php
// Assuming you have a database connection established
// $conn = new mysqli("localhost", "username", "password", "database");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the form submission
    if (isset($_POST['schedule'])) {
        $user_id = $_POST['user_id']; // Get user ID from the session or login information
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];

        // Check if the time slot is available and the user limit is not reached
        $availability_query = "SELECT * FROM time_slots 
                              WHERE ('$start_time' BETWEEN start_time AND end_time 
                                   OR '$end_time' BETWEEN start_time AND end_time)";
        $availability_result = $conn->query($availability_query);

        if ($availability_result->num_rows < 10) {
            // Time slot is available and the user limit is not reached, insert into the database
            $insert_query = "INSERT INTO time_slots (user_id, start_time, end_time) 
                             VALUES ($user_id, '$start_time', '$end_time')";
            $conn->query($insert_query);
            echo "Time slot scheduled successfully!";
        } else {
            echo "Time slot not available. The user limit for this time slot has been reached.";
        }
    }
}

// Display the form to schedule a time slot
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Time Slot</title>
</head>
<body>
    <h2>Schedule Time Slot</h2>
    <form method="post" action="">
        <label for="start_time">Start Time:</label>
        <input type="datetime-local" id="start_time" name="start_time" required><br>

        <label for="end_time">End Time:</label>
        <input type="datetime-local" id="end_time" name="end_time" required><br>

        <!-- You may need to adjust this if you have a user authentication system -->
        <input type="hidden" name="user_id" value="1">

        <button type="submit" name="schedule">Schedule</button>
    </form>
</body>
</html>
