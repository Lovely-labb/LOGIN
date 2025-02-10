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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
 
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
 
  <!-- Button trigger modal -->
<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addproduct">
  ADD NEW PRODUCT
</button>
 
<!-- Modal -->
<div class="modal fade" id="addproduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addproduct">ADD PRODUCT</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
 
      <form action="product/create_products.php" method="POST" enctype= "multipart/form-data">
 
        <label for="name">Product Name:</label>
        <input class = "form-control" type="text" id="name" name="product_name" required>
 
        <label for="name">Product Type:</label>
        <input class = "form-control" type="text" id="name" name="product_type" required>
 
        <label for="name">Product Price:</label>
        <input class = "form-control" type="number" id="name" name="product_price" required>
 
        <label for="name">Product Image:</label>
        <input class = "form-control" type="file" id="name" name="image" accpet="image/*" required>
 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="Submit" name = "name" class="btn btn-success">ADD PRODUCT</button>
      </form>
 
 
      </div>
    </div>
  </div>
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
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
       
      <?php foreach($products as $row ): ?>
 
          <tr>
            <td><?php echo ($row['pt_name']) ?></td>
            <td><?php echo ($row['pt_type']) ?></td>
            <td><?php echo ($row['pt_price']) ?></td>
            <td><img style="height:30px" src="product/product_img/<?php echo ($row['pt_img']) ?>" alt=""></td>
           
            <td>
                <button class = "btn btn-warning"> Edit</button>
                <button class = "btn btn-danger"> Delete</button>
            </td>
 
          </tr>
      <?php endforeach ?>
      </tbody>
 
    </table>
  </div>
 
 
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>