/aurora-beats
    /assets
        /css
        /images
        /js
    /includes
        db.php
        header.php
        footer.php
        functions.php
    /music
        track1.mp3
        track2.mp3
    /videos
        video1.mp4
        video2.mp4
    contact.php
    index.php
    login.php
    logout.php
    register.php
    stream.php
    music.php
    download.php
    <?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'aurora_beats_db';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<?php
include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo "New user created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<form method="post">
    Username: <input type="text" name="username" required><br>
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit">Register</button>
</form>
<?php
session_start();
include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            echo "Login successful!";
            header("Location: index.php");
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that email.";
    }
}
?>
<form method="post">
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit">Login</button>
</form>
<?php
session_start();
session_unset();
session_destroy();
header("Location: login.php");
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $to = "admin@aurorabeats.com";
    $subject = "New Feedback/Message";
    $body = "Name: $name\nEmail: $email\nMessage: $message";

    if (mail($to, $subject, $body)) {
        echo "Message sent successfully!";
    } else {
        echo "Failed to send message.";
    }
}
?>
<form method="post">
    Name: <input type="text" name="name" required><br>
    Email: <input type="email" name="email" required><br>
    Message: <textarea name="message" required></textarea><br>
    <button type="submit">Send Message</button>
</form>
<?php
$files = scandir('music'); // directory containing the music files
foreach ($files as $file) {
    if ($file != '.' && $file != '..') {
        echo "<a href='music/$file' download>Download $file</a><br>";
    }
}
?>
<video width="320" height="240" controls>
  <source src="videos/video1.mp4" type="video/mp4">
  Your browser does not support the video tag.
</video>
<audio controls>
  <source src="music/track1.mp3" type="audio/mp3">
  Your browser does not support the audio element.
</audio>
body {
    background-color: #ff0000; /* Red background */
    color: #ffffff; /* White text */
    font-family: Arial, sans-serif;
}

header, footer {
    background-color: #ffffff;
    color: #ff0000;
    text-align: center;
    padding: 10px;
}

button {
    background-color: #ff0000;
    color: #ffffff;
    padding: 10px;
    border: none;
    cursor: pointer;
}

button:hover {
    background-color: #cc0000;
}
