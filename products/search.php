<?php
require_once 'connection.php';

$search = $_GET["search"];

$sql = "SELECT * FROM products WHERE product_name LIKE '%$search%'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo '<table>';
  echo '<tr>
          <th>Product Name</th>
          <th>Price</th>
          <th>Discount</th>
          <th>Description</th>
          <th>Quantity</th>
          <th>Category</th>
          <th>Actions</th>
        </tr>';

  while ($row = $result->fetch_assoc()) {
    $product_id = $row['product_id'];
    $product_name = $row['product_name'];
    $price = $row['price'];
    $discount = $row['discount'];
    $description = $row['description'];
    $quantity = $row['quantity'];
    $category = $row['category'];

    echo '<tr>
            <td>' . $product_name . '</td>
            <td>' . $price . '</td>
            <td>' . $discount . '</td>
            <td>' . $description . '</td>
            <td>' . $quantity . '</td>
            <td>' . $category . '</td>
            <td>
              <a href="edit.php?product_id=' . $product_id . '">Edit</a>
              <a href="upload.php?delete=' . $product_id . '" onclick="return confirm(\'Are you sure you want to delete this product?\')">Delete</a>
            </td>
          </tr>';
  }

  echo '</table>';
} else {
  echo '<p>No products found.</p>';
}

$conn->close();
?>
