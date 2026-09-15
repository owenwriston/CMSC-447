<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture the input
    $email = $_POST['email'] ?? '';
    $password = $_POST['pwd'] ?? '';

    // Format the data line
    $data = "Email: " . $email . " | Password: " . $password . "\n";

    // Append data to the text file (creates it if it doesn't exist)
    file_put_contents("login_data.txt", $data, FILE_APPEND);

    // Redirect back to the main.php with a project dashboard screen parameter
    header("Location: main.html?screen=projdashboard");
	
	
	// GOAL HERE: 
	// (1) save login data to login_data.txt
	// (2) check if $data is in user_data.txt
	// (2a) if so, go to project dashboard screen
	// (2b) if not, say "No account with this email" and redirect user to create-account screen
	
	
    exit();
}
?>