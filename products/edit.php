
<?php
require_once 'connection.php';

$image = ""; // Initialize $image with an empty string

// Check if product_id parameter is set
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Retrieve product information from the database
    $sql = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $product_name = $row['product_name'];
        $price = $row['price'];
        $discount = $row['discount'];
        $description = $row['description'];
        $quantity = $row['quantity'];
        $category = $row['category'];
    } else {
        echo "Product not found.";
        exit;
    }
} else {
    echo "Product ID not provided.";
    exit;
}

if (isset($_POST["update"])) {
    $product_name = $_POST["product_name"];
    $price = $_POST["price"];
    $discount = $_POST["discount"];
    $description = $_POST["description"];
    $quantity = $_POST["quantity"];
    $category = $_POST["category"];

    // For updating image
    if ($_FILES["imageUpload"]["size"] > 0) {
        $upload_dir = "uploads/";
        $image = $upload_dir . $_FILES["imageUpload"]["name"];
        $upload_file = $upload_dir . basename($_FILES["imageUpload"]["name"]);
        $imageType = strtolower(pathinfo($upload_file, PATHINFO_EXTENSION));
        $check = $_FILES["imageUpload"]["size"];
        $upload_ok = 0;

        if ($check > 0) {
            if ($imageType == 'jpg' || $imageType == 'png' || $imageType == 'jpeg' || $imageType == 'gif') {
                $upload_ok = 1;
            } else {
                echo '<script>alert("Please change the image format")</script>';
            }
        } else {
            echo '<script>alert("The photo size is 0. Please change the photo")</script>';
            $upload_ok = 0;
        }

        if ($upload_ok == 1) {
            move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $upload_file);
        }
    }

    // Check if discount is empty and set it to NULL or provide a default value
    if (empty($discount)) {
        $discount = NULL; // or set a default value like 0
    }

    // Check if quantity is empty and set it to NULL or provide a default value
    if (empty($quantity)) {
        $quantity = NULL; // or set a default value like 0
    }

    $product_name = mysqli_real_escape_string($conn, $product_name);
    $description = mysqli_real_escape_string($conn, $description);
    
    $sql = "UPDATE products SET product_name = ?, price = ?, discount = ?, image = ?, description = ?, quantity = ?, category = ? WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sddssisi", $product_name, $price, $discount, $image, $description, $quantity, $category, $product_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Product updated successfully')</script>";
    } else {
        echo "Error updating product: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
      .update_img {
  display: none;
}

.file-label {
  display: inline-block;
  padding: 10px 20px;
  background-color: #337ab7;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
#update{
    display: inline-block;
  padding: 10px 20px;
  background-color: #337ab7;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
.back-button-container {
text-align: center;
 margin-top: 15px;
}

.back-button {
 display: inline-block;
padding: 10px 20px;
background-color: #ff4d4d;
color: #fff;
border: none;
border-radius: 5px;
cursor: pointer;
text-decoration: none;
}
    </style>
    <link rel="stylesheet" href="upload.css">
</head>
<body>
    <h1 id="titre">Edit Product</h1>
    <section id="upload_container">
        <form action="edit.php?product_id=<?php echo $product_id; ?>" method="POST" enctype="multipart/form-data">
            <input type="text" name="product_name" id="product_name" placeholder="Product Name" value="<?php echo $product_name; ?>" required>
            <input type="number" name="price" id="price" placeholder="Product Price" value="<?php echo $price; ?>" required>
            <input type="number" name="discount" id="discount" placeholder="Product Discount" value="<?php echo $discount; ?>">
            <textarea name="description" id="description" placeholder="Product Description"><?php echo $description; ?></textarea>
            <input type="number" name="quantity" id="quantity" placeholder="Quantity" value="<?php echo $quantity; ?>">
            <select name="category" id="category">
                <option value="steam" <?php if ($category == 'steam') echo 'selected'; ?>>Steam</option>
                <option value="xbox" <?php if ($category == 'xbox') echo 'selected'; ?>>Xbox</option>
                <option value="security" <?php if ($category == 'security') echo 'selected'; ?>>Security</option>
                <option value="entertainment" <?php if ($category == 'entertainment') echo 'selected'; ?>>Entertainment</option>
                <option value="game" <?php if ($category == 'game') echo 'selected'; ?>>Game</option>
                <option value="playstation" <?php if ($category == 'playstation') echo 'selected'; ?>>PlayStation</option>
            </select>
            <input type="file" name="imageUpload" id="imageUpload" class="update_img">
            <label for="imageUpload" id="fileLabel" class="file-label">Choose Image</label>

            <button type="submit" name="update" id="update">Update</button>
         </form>
              <div class="back-button-container">
            <a href="upload.php" class="back-button">Back to Upload Page</a>
              </div>   
     </section>
    <script>
var fileInput = document.getElementById("imageUpload");
var fileLabel = document.getElementById("fileLabel");

fileInput.addEventListener("change", function() {
      fileLabel.textContent = this.files[0].name;
});

    </script>
</body>
</html>
