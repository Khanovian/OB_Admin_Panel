<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Products</title>
  <style>
    /* Add some basic styling */
    body {
      font-family: Arial, sans-serif;
    }
    .container {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
    }
    .product {
      border: 1px solid #ccc;
      padding: 10px;
      margin-bottom: 10px;
    }
    .product img {
      max-width: 200px;
      max-height: 150px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>View Products</h1>
    <?php
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

      // Retrieve data from the database
      $sql = "SELECT * FROM items";
      $result = $conn->query($sql);

      // Check if there are any records in the database
      if ($result->num_rows > 0) {
        // Loop through the records and display them
        while ($row = $result->fetch_assoc()) {
          echo '<div class="product">';
          echo '<h2>' . $row["productName"] . '</h2>';
          echo '<p>Price: $' . $row["productPrice"] . '</p>';
          echo '<p>Description: ' . $row["productDescription"] . '</p>';
          echo '<img src="' . $row["productPicture"] . '" alt="' . $row["productName"] . '">';
          echo '</div>';
        }
      } else {
        echo "No products found.";
      }

      // Close the database connection
      $conn->close();
    ?>
  </div>
</body>
</html>
