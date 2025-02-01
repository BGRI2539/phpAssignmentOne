<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Subscriber Portal</title>
  <!-- Bootstrap CSS (optional) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <!-- Header with Navigation and Logo -->
  <header class="bg-primary text-white p-3">
    <div class="container d-flex justify-content-between align-items-center">
      <div class="logo">
        <h1>Subscriber Portal</h1>
      </div>
      <nav>
        <ul class="nav">
          <li class="nav-item"><a class="nav-link text-white" href="#">Home</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="#">About</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="#">Contact</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- Main -->
  <main class="container my-5">
    <h2>Add Subscriber</h2>
    <form action="processForm.php" method="post" novalidate>
      <div class="mb-3">
        <label for="firstName" class="form-label">First Name:</label>
        <input type="text" class="form-control" id="firstName" name="first_name" required>
      </div>
      <div class="mb-3">
        <label for="lastName" class="form-label">Last Name:</label>
        <input type="text" class="form-control" id="lastName" name="last_name" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email Address:</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="mb-3">
        <label for="interest" class="form-label">Interests:</label>
        <textarea class="form-control" id="interest" name="interests" rows="3" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </main>

  <!-- Footer -->
  <footer class="bg-dark text-white text-center p-3">
    <div class="container">
      <p>&copy; 2025 Subscriber Portal.</p>
    </div>
  </footer>
</body>
</html>

