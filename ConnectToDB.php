<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if all required fields are not empty
    if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['text'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $text = $_POST['text'];

        // Debugging output
        echo "Received firstname: " . htmlspecialchars($firstname) . "<br>";
        echo "Received lastname: " . htmlspecialchars($lastname) . "<br>";
        echo "Received text: " . htmlspecialchars($text) . "<br>";

        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'bps');
        if ($conn->connect_error) {
            die('Connection Failed: ' . $conn->connect_error);
        }

        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO Bps_form (firstname, lastname, text) VALUES (?, ?, ?)");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }

        //execute
        $stmt->bind_param("sss", $firstname, $lastname, $text);
        if (!$stmt->execute()) {
            die('Execute failed: ' . htmlspecialchars($stmt->error));
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();

        // Redirect to a new page after successful registration
        header("Location: Submitted.php");
        exit();
    } else {
        // Redirect to an error page if required fields are missing
        header("Location: error.php");
        exit();
    }
} else {
    // Redirect to an error page if the request method is not POST
    header("Location: error.php");
    exit();
}
?>