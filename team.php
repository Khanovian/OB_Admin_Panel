<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Database credentials
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "add_items";

  // Create a database connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Get form data (add validation if needed)
  $chefName = $_POST["chefName"];
  $chefSalary = $_POST["chefSalary"];
  $chefDescription = $_POST["chefDescription"];

  // File upload handling
  if ($_FILES["chefPicture"]["error"] === UPLOAD_ERR_OK) {
    $targetDir = "C:/xampp/htdocs/obpanel/pictures/";
    $targetFile = $targetDir . basename($_FILES["chefPicture"]["name"]);

    // Move the uploaded file to the target directory
    // Check if the file was successfully uploaded to the server
if (move_uploaded_file($_FILES["chefPicture"]["tmp_name"], $targetFile)) {
  // If the file was moved successfully, set the $chefPicture variable to the target file path
  $chefPicture = $targetFile;
} else {
  // If there was an error moving the file, display an error message and exit the script
  echo "Error uploading file.";
  exit;
}


  // Prepare and execute the SQL query to insert data using prepared statement
  $stmt = $conn->prepare("INSERT INTO `team` (chefName, chefSalary, chefDescription, chefPicture) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $chefName, $chefSalary, $chefDescription, $chefPicture);
  
  if ($stmt->execute()) {
    echo "Product added successfully!";
  } else {
    echo "Error: " . $conn->error;
  }

  // Close the database connection
  $stmt->close();
  $conn->close();
  header("location:team.php");
  }}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a href="#" class="navbar-brand">Admin Panel</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.html">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php">Items</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="team.php">Team</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div id="home" class="content">
    <!-- Home Page Content Goes Here -->
  </div>

  <div id="team" class="content">
    <div class="container">
      <h1>Add Team</h1>
      <form method="POST" enctype="multipart/form-data">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="chefName">Chef Name</label>
            <input type="text" class="form-control" id="chefName" name="chefName" required>
          </div>
          <div class="form-group col-md-6">
            <label for="chefSalary">Chef Salary</label>
            <input type="number" class="form-control" id="chefSalary" name="chefSalary" required>
          </div>
        </div>
        <div class="form-group">
          <label for="chefDescription">Chef Description</label>
          <textarea class="form-control" id="chefDescription" name="chefDescription" required></textarea>
        </div>
        <div class="form-group">
          <label for="chefPicture">Chef Picture</label>
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="chefPicture" name="chefPicture" required>
            <label class="custom-file-label" for="chefPicture">Choose file</label>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>

    
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
