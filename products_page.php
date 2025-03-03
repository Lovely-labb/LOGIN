<?php
session_start();
include('database/db.php');

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
} else {
    header('Location: index.php');
    exit;
}

$query = "SELECT * FROM products_tbl";
$stmt = $conn->query($query);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Page</title>
  <link rel="stylesheet" href="css/productpage.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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

<div class="sidebar">
  <a href="#">Home</a>
  <a href="#">Profile</a>
  <a href="#">Manage User</a>
  <a href="products_page.php">Products</a>
  <a href="#">Analytics</a>
</div>

<div class="main-content">
  <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addproduct">ADD NEW PRODUCTS</button>

  <div class="modal fade" id="addproduct" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5">ADD PRODUCT</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form action="product/create_product.php" method="POST" enctype="multipart/form-data">
            <label for="name">Product Name:</label>
            <input class="form-control" type="text" name="product_name" required>

            <label for="type">Product Type:</label>
            <input class="form-control" type="text" name="product_type" required>

            <label for="price">Product Price:</label>
            <input class="form-control" type="number" name="product_price" required>

            <label for="image">Product Image:</label>
            <input class="form-control" type="file" name="image" accept="image/*" required>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-info" name="submit">ADD PRODUCT</button>
        </div>
          </form>
      </div>
    </div>
  </div>

  <h2 style="margin-top: 30px;">PRODUCTS LIST</h2>
  <table class="product-table">
    <thead>
      <tr>
        <th>Product Name</th>
        <th>Product Type</th>
        <th>Price</th>
        <th>Image</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $row): ?>
      <tr>
        <td><?php echo $row['pt_name']; ?></td>
        <td><?php echo $row['pt_type']; ?></td>
        <td><?php echo $row['pt_price']; ?></td>
        <td><img style="height:30px" src="product/product_img/<?php echo $row['pt_img']; ?>" alt=""></td>
        <td>
          <div style="display: flex; gap: 5px;">
            <button type="button" class="btn btn-warning edit-btn" 
              data-bs-toggle="modal" 
              data-bs-target="#editProductModal"
              data-id="<?php echo $row['product_id']; ?>"
              data-name="<?php echo $row['pt_name']; ?>"
              data-type="<?php echo $row['pt_type']; ?>"
              data-price="<?php echo $row['pt_price']; ?>">
               EDIT
            </button>

            <form action="product/delete_product.php" method="POST">
              <input type="hidden" name="delete_id" value="<?php echo $row['product_id']; ?>">
              <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?');">DELETE</button>
            </form>
          </div>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<div class="modal fade" id="editProductModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">EDIT DETAILS</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="product/edit_product.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="product_id" id="edit_product_id">

          <label for="edit_name">Product Name:</label>
          <input class="form-control" type="text" name="product_name" id="edit_name" required>

          <label for="edit_type">Product Type:</label>
          <input class="form-control" type="text" name="product_type" id="edit_type" required>

          <label for="edit_price">Product Price:</label>
          <input class="form-control" type="number" name="product_price" id="edit_price" required>

          <label for="edit_image">Product Image:</label>
          <input class="form-control" type="file" name="image" accept="image/*">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success" name="update">CONFIRM</button>
      </div>
        </form>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const editButtons = document.querySelectorAll(".edit-btn");
    editButtons.forEach(button => {
      button.addEventListener("click", function () {
        const id = this.getAttribute("data-id");
        const name = this.getAttribute("data-name");
        const type = this.getAttribute("data-type");
        const price = this.getAttribute("data-price");

        document.getElementById("edit_product_id").value = id;
        document.getElementById("edit_name").value = name;
        document.getElementById("edit_type").value = type;
        document.getElementById("edit_price").value = price;
      });
    });
  });
</script>

</body>
</html>

