<?php
session_start();
include('database/db.php');
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

// Check if the 'user' session variable is set
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
} else {
    // If the user session variable is not set, redirect to the login page
    header('Location: index.php');
    exit;
}

// Fetch products from the database using PDO
$query = "SELECT * FROM product_tbl";
$stmt = $conn->query($query);
 
// Fetch all products at once into an array
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Page</title>
  <link rel="stylesheet" href="css/productpage.css">
</head>
<body>

<div class="navbar">
    <div class="nav-left">
      <a href="#">Dashboard</a>
      <a href="#">Users</a>
      <a href="#">Settings</a>
      <a href="Admin_page.php" style="color:#e53935">Home</a>
    </div>
    <div class="nav-right">
      <a href="php/logout.php" class="btn">Logout</a>
    </div>
  </div>

  <!-- Sidebar -->
  <div class="sidebar">
    <a href="#">Home</a>
    <a href="#">Profile</a>
    <a href="#">Manage User</a>
    <a href="products_page.php">Products</a>
    <a href="#">Analytics</a>
  </div>

  <!-- Main Content -->
  <div class="main-content">
   
  <h1 style="color:green">Add New Product</h1>

  <div class="form-container">

    <form action="product/create_product.php" method="POST" enctype="multipart/form-data">

      <label for="name">Product Name</label>
      <input type="text" id="name" name="product_name" required>
      
      <label for="name">Product Type</label>
      <input type="text" id="name" name="product_type" required>

      <label for="name">Product Price</label>
      <input type="number" id="name" name="product_price" required>

      <label for="name">Product Image</label>
      <input type="file" id="name" name="image" accept="image/*" required>

      <button type="submit" name="submit">Submit</button>

    </form>

  </div>

    <!-- Product Table -->
    <h2 style="margin-top: 30px;">Added Products</h2>
    <table class="product-table">
      <thead>
        <tr>
          <th>Product Name</th>
          <th>Product Type</th>
          <th>Price</th>
          <th>Image</th>
        </tr>
      </thead>
      <tbody>
      
      <?php foreach($products as $row): ?>
          <tr>
            <td><?php echo ($row ['pt_name'])?></td>
            <td><?php echo ($row ['pt_type'])?></td>
            <td><?php echo ($row ['pt_price'])?></td>
            <td><img style= "height:30px" src="product/product_img/<?php echo ($row ['pt_img'])?>" alt=""></td>
          </tr>
          <?php endforeach?>

      </tbody>
    </table>
  </div>

</body>
</html>


