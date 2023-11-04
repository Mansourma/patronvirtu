<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce Website - playstation Category</title>
    <!-- Option 1: Include in HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="newhome.css">
    <link rel="stylesheet" href="pagination.css">
</head>
<body>
    <?php
    include 'header.php';
    require_once 'connection.php';

    // Function to fetch products by category
    function fetchProductsByCategory($category)
    {
        global $conn;
        $sql = "SELECT * FROM products WHERE category = '$category'";
        return $conn->query($sql);
    }

    // Fetch products for the Steam category
    $products = fetchProductsByCategory('game');
    // Pagination variables
$limit = 15; // Number of products per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number
$start = ($page - 1) * $limit; // Starting index for the products

// Retrieve total number of products
$sql = "SELECT COUNT(*) AS total FROM products WHERE category = 'game'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$totalProducts = $row['total'];

// Calculate total number of pages
$totalPages = ceil($totalProducts / $limit);

// Retrieve products for the current page
$sql = "SELECT * FROM products WHERE category = 'game' LIMIT $start, $limit";
$result = $conn->query($sql);
    ?>

    <h1>Games Category</h1>

    <main>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="card">
                <div class="image">
                    <a href="productdetails.php?id=<?php echo $row['product_id']; ?>">
                        <img src="<?php echo $row['image']; ?>" alt="">
                    </a>
                </div>
                <div class="caption">
                    <div class="product_name"><?php echo $row['product_name']; ?></div>
                    <div class="quantity">
                        <i class="fas fa-key"></i>
                        <?php echo $row['quantity']; ?>
                    </div>
                    <p class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </p>
                    <div class="price"><b>$<?php echo $row['price']; ?></b></div>
                    <?php if ($row['discount'] > 0) { ?>
                        <div class="discount"><b><del>$<?php echo $row['discount']; ?></del></b></div>
                    <?php } ?>
                </div>
                <button class="add" data-id="<?php echo $row['product_id']; ?>">Add to cart</button>
            </div>
        <?php } ?>
    </main>
<!-- Pagination -->
<div id="pagination">
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
    <?php include 'footer.php'; ?>
<script src="home.js"></script>
</body>
</html>
