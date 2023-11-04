<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once 'connection.php';
require_once 'header.php';

// Function to fetch product details by product ID
function fetchProductDetails($productId)
{
    global $conn;
    $productId = mysqli_real_escape_string($conn, $productId); 
    $sql = "SELECT * FROM products WHERE product_id = '$productId'"; 
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return null;
}

function calculateTotalPrice()
{
    $totalPrice = 0;
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $productId) {
            $product = fetchProductDetails($productId);
            $totalPrice += $product['price'];
        }
    }
    return $totalPrice;
}

if (isset($_GET['remove']) && $_GET['remove'] != '') {
    $productIdToRemove = $_GET['remove'];
    $index = array_search($productIdToRemove, $_SESSION['cart']);
    if ($index !== false) {
        unset($_SESSION['cart'][$index]);
    }
    header("Location: cart.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    header("Location: checkout.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .remove-button {
            background-color: #f44336;
            border: none;
            color: white;
            padding: 6px 12px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 2px 2px;
            cursor: pointer;
        }
        .place-order-button {
            background-color: #007bff;
            border: none;
            color: white;
            padding: 6px 12px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin-top: 10px;
            cursor: pointer;
        }
        .empty{
            text-align: center;
            margin-top: 40px;
            font-size:2.4rem;
            margin-bottom: 50px;
            font-weight: bold;
        }
        h1{
            margin-left: 20px;
            font-size:2.4rem;
            margin-left: 10px; 
            font-weight: bold;
      }
        .back-home-button {
            background-color: #007bff;
            border: none;
            color: white;
            padding: 6px 12px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin-top: 10px;
            cursor: pointer;
        }
        .button-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
    margin-bottom: 30px;
    margin-left: 20px;
    margin-right: 20px;
}
.shop{
    display: flex;
    align-items: center;
    margin-left: 10px;
    margin-bottom: 15px;
}
.shopping{
    width: 50px;
    height: 50px;
}

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 300px;
            text-align: center;
        }
        .modal-content p {
        font-size: 1.4rem;        }
        .modal-buttons {
            margin-top: 20px;
        }
        .modal-buttons button {
            background-color: #f44336;
            color: white;
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            margin-right: 10px;
        }
        .modal-buttons button.cancel-button {
            background-color: #999999;
        }
    </style>
</head>
<body>
<div class="shop">
  <img src="cart.png" class="shopping">
  <h1>Your Cart</h1>
</div>
    <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) : ?>
        <table>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            <?php foreach ($_SESSION['cart'] as $productId) : ?>
                <?php $product = fetchProductDetails($productId); ?>
                <?php if ($product !== null) : ?>
                    <tr>
                        <td><?php echo $product['product_id']; ?></td>
                        <td><?php echo $product['product_name']; ?></td>
                        <td>$<?php echo $product['price']; ?></td>
                        <td><a class="remove-button" href="javascript:void(0);" onclick="openModal('<?php echo $product['product_id']; ?>');">Remove</a></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>

            <tr>
                <td colspan="2"><strong>Total:</strong></td>
                <td colspan="2">$<?php echo calculateTotalPrice(); ?></td>
            </tr>
        </table>
        <div class="button-container">
    <a class="back-home-button" href="newhome.php">Back to Home</a>
    <form method="POST" action="" class="order-form">
        <input type="submit" name="place_order" value="Place Order" class="place-order-button">
    </form>
</div>
    <?php else : ?>
        <h1 class="empty">Your cart is empty.</h1>
    <?php endif; ?>

    <!-- Modal Dialog -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <p>Are you sure you would like to remove this item from the shopping cart?</p>
            <div class="modal-buttons">
                <button onclick="removeItem();">Remove</button>
                <button class="cancel-button" onclick="closeModal();">Cancel</button>
            </div>
        </div>
    </div>

    <script>
        function openModal(productId) {
            var modal = document.getElementById('modal');
            modal.style.display = 'block';
            // Store the productId to be used in the removeItem() function
            modal.dataset.productId = productId;
        }

        function closeModal() {
            var modal = document.getElementById('modal');
            modal.style.display = 'none';
        }

        function removeItem() {
            var modal = document.getElementById('modal');
            var productId = modal.dataset.productId;
            window.location.href = 'cart.php?remove=' + productId;
        }
    </script>
    <?php require_once 'footer.php'; ?>
</body>
</html>
