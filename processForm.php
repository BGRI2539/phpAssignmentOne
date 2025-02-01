<?php

// Initialize variables to hold user data and errors
$userData = [];
$error    = "";

// Process the form only if it's a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Retrieve and sanitize form data
    $firstName = trim(filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING));
    $lastName  = trim(filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING));
    $email     = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $interests = trim(filter_input(INPUT_POST, 'interests', FILTER_SANITIZE_STRING));

    // Basic server-side validation
    if (empty($firstName) || empty($lastName) || empty($email) || empty($interests)) {
        $error = "All fields are required. Please go back and fill out the form completely.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format. Please go back and correct your email.";
    } else {
        // Include the database connection file
        require_once('database.php');

        // Prepare SQL statement to insert data
        $stmt = $conn->prepare("INSERT INTO subscribers (first_name, last_name, email, interests) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            $error = "Prepare failed: " . $conn->error;
        } else {
            // Bind parameters and execute
            $stmt->bind_param("ssss", $firstName, $lastName, $email, $interests);
            if ($stmt->execute()) {
                // Get the last inserted id
                $last_id = $conn->insert_id;
                
                // Prepare a new statement to retrieve the inserted record
                $stmt2 = $conn->prepare("SELECT first_name, last_name, email, interests FROM subscribers WHERE id = ?");
                if ($stmt2) {
                    $stmt2->bind_param("i", $last_id);
                    $stmt2->execute();
                    $stmt2->bind_result($dbFirstName, $dbLastName, $dbEmail, $dbInterests);
                    if ($stmt2->fetch()) {
                        // Save the retrieved data into an array
                        $userData = [
                            'first_name' => $dbFirstName,
                            'last_name'  => $dbLastName,
                            'email'      => $dbEmail,
                            'interests'  => $dbInterests
                        ];
                    } else {
                        $error = "Failed to retrieve the inserted record.";
                    }
                    $stmt2->close();
                } else {
                    $error = "Prepare failed (retrieval): " . $conn->error;
                }
            } else {
                $error = "Error inserting data: " . $stmt->error;
            }
            $stmt->close();
        }
        // Close the database connection
        $conn->close();
    }
} else {
    // If not a POST request, redirect to the form page
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Submission Status</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS for additional styling -->
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <!-- Header -->
  <header class="bg-primary text-white p-3">
    <div class="container d-flex justify-content-between align-items-center">
      <div class="logo">
        <h1>Subscriber Portal</h1>
      </div>
      <nav>
        <ul class="nav">
          <li class="nav-item"><a class="nav-link text-white" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="#">About</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="#">Contact</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- Confirmation Message Section -->
  <main class="container confirmation-container">
    <?php if (empty($error) && !empty($userData)): ?>
      <div class="alert alert-success" role="alert">
        <h2>Thank You!</h2>
        <p>Subscriber added successfully!</p>
      </div>
      <div class="user-details">
        <dl>
          <dt>First Name:</dt>
          <dd><?php echo htmlspecialchars($userData['first_name']); ?></dd>
          <dt>Last Name:</dt>
          <dd><?php echo htmlspecialchars($userData['last_name']); ?></dd>
          <dt>Email Address:</dt>
          <dd><?php echo htmlspecialchars($userData['email']); ?></dd>
          <dt>Interests:</dt>
          <dd><?php echo nl2br(htmlspecialchars($userData['interests'])); ?></dd>
        </dl>
      </div>
    <?php else: ?>
      <div class="alert alert-danger" role="alert">
        <h2>Submission Failed</h2>
        <p><?php echo htmlspecialchars($error); ?></p>
      </div>
    <?php endif; ?>
    <a href="index.php" class="btn btn-primary">Back to Form</a>
  </main>

  <!-- Footer -->
  <footer class="bg-dark text-white text-center p-3 mt-5">
    <div class="container">
      <p>&copy; 2025 Subscriber Portal.</p>
    </div>
  </footer>

</body>
</html>
