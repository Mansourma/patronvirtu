<?php
require_once 'connection.php';

if (isset($_POST["submit"])) {
    $product_name = $_POST["product_name"];
    $price = $_POST["price"];
    $discount = $_POST["discount"];
    $description = $_POST["description"];
    $quantity = $_POST["quantity"];
    $category = $_POST["category"];

    // For uploads photos
    $upload_dir = "uploads/"; // This is where the uploaded photo is stored
    $image = $upload_dir . $_FILES["imageUpload"]["name"];
    $upload_file = $upload_dir . basename($_FILES["imageUpload"]["name"]);
    $imageType = strtolower(pathinfo($upload_file, PATHINFO_EXTENSION)); // Used to detect the image format
    $check = $_FILES["imageUpload"]["size"]; // To detect the size of the image
    $upload_ok = 0;

    if (file_exists($upload_file)) {
        echo "<script>alert('The file already exists')</script>";
        $upload_ok = 0;
    } else {
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
    }

    if ($upload_ok == 0) {
        echo '<script>alert("Sorry, your file can\'t be uploaded. Please try again")</script>';
    } else {
        if ($product_name != "" && $price != "") {
            move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $upload_file);

            // Check if discount is empty and set it to NULL or provide a default value
            if (empty($discount)) {
                $discount = "NULL"; // or set a default value like 0
            }

            // Check if quantity is empty and set it to NULL or provide a default value
            if (empty($quantity)) {
                $quantity = "NULL"; // or set a default value like 0
            }

            $stmt = $conn->prepare("INSERT INTO products (product_name, price, discount, description, quantity, category, image) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sddsiss", $product_name, $price, $discount, $description, $quantity, $category, $image);


           
if ($stmt->execute()) {
    echo "<script>alert('Your product uploaded successfully')</script>";
} else {
    echo "Error: " . $stmt->error;
}
        }
    }
}


if (isset($_GET["delete"])) {
    $product_id = $_GET["delete"];

    // Delete the product from the database
    $stmt = $conn->prepare("DELETE FROM products WHERE product_id=?");
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        echo "<script>alert('Product deleted successfully')</script>";
    } else {
        echo "Error deleting product: " . $stmt->error;
    }
}


// Pagination variables
$limit = 15; // Number of products per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number
$start = ($page - 1) * $limit; // Starting index for the products
// Retrieve total number of products
$sql = "SELECT COUNT(*) AS total FROM products";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$totalProducts = $row['total'];

// Calculate total number of pages
$totalPages = ceil($totalProducts / $limit);

// Retrieve products for the current page
$sql = "SELECT * FROM products LIMIT $start, $limit";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="upload.css">
</head>
<body>
    <h1 id="titre">Create Products</h1>
    <section id="upload_container">
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="product_name" id="product_name" placeholder="Product Name" required>
            <input type="number" name="price" id="price" placeholder="Product Price" required>
            <input type="number" name="discount" id="discount" placeholder="Product Discount">
            <textarea name="description" id="description" placeholder="Product Description"></textarea>
            <input type="number" name="quantity" id="quantity" placeholder="Quantity">
            <select name="category" id="category">
                <option value="steam">Steam</option>
                <option value="xbox">Xbox</option>
                <option value="security">Security</option>
                <option value="entertainment">Entertainment</option>
                <option value="game">Game</option>
                <option value="playstation">PlayStation</option>
            </select>
            <input type="file" name="imageUpload" id="imageUpload" required hidden>
            <button id="choose" onclick="upload();">Choose Image</button>
            <input type="submit" value="Upload" name="submit">
        </form>
    </section>

    <script>
        var product_name = document.getElementById("product_name");
        var price = document.getElementById("price");
        var discount = document.getElementById("discount");
        var description = document.getElementById("description");
        var quantity = document.getElementById("quantity");
        var category = document.getElementById("category");
        var choose = document.getElementById("choose");
        var uploadImage = document.getElementById("imageUpload");

        function upload(){
            uploadImage.click();
        }

        uploadImage.addEventListener("change",function(){
            var file = this.files[0];
            if(product_name.value == ""){
                product_name.value = file.name;
            }
            choose.innerHTML = "You can change("+file.name+") picture";
        })
    </script>

    <input type="text" id="searchInput" placeholder="Search products" style="width: 85%; margin-top: 15px;">
    <button class="search" onclick="searchProducts()">Search</button>
    <div id="searchResults"></div>
    <div id="productsContainer">
        <table>
            <tr>
                <th>Image</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Discount</th>
                <th style="width: 40%;">Description</th>
                <th>Quantity</th>
                <th>Category</th>
                <th style="width: 8%;">Actions</th>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
                $product_id = $row['product_id'];
                $product_name = $row['product_name'];
                $price = $row['price'];
                $discount = $row['discount'];
                $description = $row['description'];
                $quantity = $row['quantity'];
                $category = $row['category'];
                ?>
                <tr>
                    <td><img src="<?php echo $row['image']; ?>" alt="Product Image" class="product-image"></td>
                    <td><?php echo $product_name; ?></td>
                    <td><?php echo $price; ?></td>
                    <td><?php echo $discount; ?></td>
                    <td><?php echo $description; ?></td>
                    <td><?php echo $quantity; ?></td>
                    <td><?php echo $category; ?></td>
                    <td>
                    <a href="edit.php?product_id=<?php echo $product_id; ?>" class="btn btn-success btn-sm"><i class="bi bi-pencil-fill"></i></a>
                    <a href="upload.php?delete=<?php echo $product_id; ?>" onclick="return confirm('Are you sure you want to delete this product?')" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
    
    <!-- Pagination -->
    <div id="pagination" >
        <?php if ($totalPages > 1): ?>
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo ($page - 1); ?>">Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <?php if ($i == $page): ?>
                    <span><?php echo $i; ?></span>
                <?php else: ?>
                    <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo ($page + 1); ?>">Next</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>


    <script>
        function searchProducts() {
            var searchInput = document.getElementById("searchInput").value;
            var productsContainer = document.getElementById("productsContainer");
            var searchResultsContainer = document.getElementById("searchResults");

            // Create an XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            // Set up the request
            xhr.open("GET", "search.php?search=" + searchInput, true);

            // Set up a callback function to handle the response
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Display the search results
                    searchResultsContainer.innerHTML = xhr.responseText;

                    // Hide the original products table
                    productsContainer.style.display = "none";
                }
            };

            // Send the request
            xhr.send();
        }
    </script>
</body>
</html>
