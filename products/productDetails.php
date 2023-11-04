<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce Website</title>
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
    <link rel="stylesheet" href="newhome.css">

    <style>
        .container {
            display: flex;
            flex-direction: row;
            margin: 0 ;
            justify-content: space-between;
        }
        
        .product-details {
            margin: 0 ;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #e2e2e2;
            display: flex;
        }

        .product-details .image {
            flex: 0 0 50%;
        }

        .product-details .image img {
            width: 300px;
            border-radius: 10px;
            display: block;
            margin: 0 ;
        }

        .product-details .caption {
            flex: 0 0 50%;
            padding-left: 20px;
        }

        .product-details .caption h1 {
            font-size: 2.5rem;
            margin-left: 0px;
            font-weight: bolder;
            margin-bottom: 10px;
        }

        .product-details .description {
            font-size: 1.4rem;
            line-height: 2rem;
            color: #555;
            margin-bottom: 20px;
        }

        .product-details .quantity-container {
            width: 80%;
            height: 180px;
            margin-bottom: 20px;
            border: 1.5px solid #e2e2e2;
            border-radius: 10px;
            padding: 10px;
            display: inline-block;
            background-color: #e2e2e2;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center

        }
       

        .product-details .quantity-container .quantity-label {
            font-size: 1.4rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .product-details .quantity-container .quantity-buttons {
            display: flex;
            align-items: center;
        }

        .product-details .quantity-container .quantity-buttons button {
            background-color: transparent;
            border: none;
            cursor: pointer;
            font-size: 1.6rem;
            margin: 0 5px;
            padding: 0;
        }

        .product-details .quantity-container .quantity-value {
            font-size: 1.4rem;
            font-weight: bold;
            margin: 0 10px;
        }

        .product-details .price {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .product-details .total-price {
            font-size: 1.6rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .product-details .buy-now-button {
            display: block;
            padding: 1em 2em;
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            border: none;
            border-radius: 3px;
            transition: background-color 0.3s ease;
        }

        .product-details .buy-now-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<?php 
            include 'header.php';
         
        ?>
 
    <div class="product-details">
        <?php
        require_once 'connection.php';
      
        if (isset($_GET['id'])) {

            $product_id = $_GET['id'];
            $sql = "SELECT * FROM products WHERE product_id = '$product_id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                ?>
                <div class="container">
                    <div class="image">
                        <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['product_name']; ?>">
                    </div>
                    <div class="caption">
                        <h1><?php echo $row['product_name']; ?></h1>
                        <div class="description"><?php echo $row['description']; ?></div>
                        <div class="quantity-container">
                            <div class="quantity-label">Available Quantity:</div>
                            <div class="quantity-buttons">
                                <button class="decrement" data-id="<?php echo $row['product_id']; ?>">-</button>
                                <div class="quantity-value"><?php echo $row['quantity']; ?></div>
                                <button class="increment" data-id="<?php echo $row['product_id']; ?>">+</button>
                        
                            </div>
                            <div class="price">$<?php echo $row['price']; ?></div>
                        <div class="total-price">Total: $<span class="total-price-value"><?php echo $row['price']; ?></span></div>
                        </div>
                        <button class="buy-now-button" data-id="<?php echo $row['product_id']; ?>">Buy Now</button>
                    </div>
                </div>
                <?php
            } else {
                echo "<p class='text-center'>Product not found.</p>";
            }
        } else {
            echo "<p class='text-center'>Invalid product ID.</p>";
        }
        ?>
    </div>
    <?php    include 'footer.php'; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        // Quantity buttons click event
        $(document).ready(function() {
            $('.quantity-container').on('click', '.decrement', function() {
                var quantityValue = $(this).siblings('.quantity-value');
                var quantity = parseInt(quantityValue.text());
                if (quantity > 0) {
                    quantity--;
                    quantityValue.text(quantity);
                    updateTotalPrice(quantity);
                }
            });

            $('.quantity-container').on('click', '.increment', function() {
                var quantityValue = $(this).siblings('.quantity-value');
                var quantity = parseInt(quantityValue.text());
                quantity++;
                quantityValue.text(quantity);
                updateTotalPrice(quantity);
            });

            $('.buy-now-button').click(function() {
                var productId = $(this).data('id');
                var quantity = parseInt($(this).siblings('.quantity-container').find('.quantity-value').text());
           
            });

            function updateTotalPrice(quantity) {
                var price = parseFloat($('.price').text().replace('$', ''));
                var totalPrice = price * quantity;
                $('.total-price-value').text(totalPrice.toFixed(2));
            }
        });
    </script>
    <script src="home.js"></script>
</body>
</html>
