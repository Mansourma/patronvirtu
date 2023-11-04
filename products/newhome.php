<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PatronVirtu</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="newhome.css">
   
</head>
<body>
<?php
  require_once 'connection.php';
 include 'add_to_cart.php'; 
 require  'header.php';

?>

    <?php

    function fetchProductsByCategory($category)
    {
        global $conn;
        $sql = "SELECT * FROM products WHERE category = '$category' limit 5";
        return $conn->query($sql);
    }

    $categories = array(
        'playstation' => 'Playstation',
        'steam' => 'Steam',
        'xbox' => 'Xbox',
        'security' => 'Security'
    );

    foreach ($categories as $category => $title) {
        $products = fetchProductsByCategory($category);
    ?>
        <h2><?php echo '<h1 id="category">'.$title.'</h1> '; ?></h2>
        <main>
            <?php while ($row = mysqli_fetch_assoc($products)) { ?>
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
    <?php } ?>

    <?php
        include 'footer.php';
    ?>

 <script src="home.js">

 </script>

</body>
</html>
