<?php
session_start();

// Function to fetch products by category
function fetchProductsByCategory($category)
{
    global $conn;
    $sql = "SELECT * FROM products WHERE category = '$category' limit 5";
    return $conn->query($sql);
}

// Function to get the cart count from the session
function getCartCount()
{
    if (isset($_SESSION['cart'])) {
        return count($_SESSION['cart']);
    }
    return 0;
}

// Add a product to the cart
function addToCart($productId)
{
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    array_push($_SESSION['cart'], $productId);
}

// Check if the cart is already set in the session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Check if a product is added to the cart
if (isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    addToCart($productId);
}

require_once 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<!-- Rest of your HTML code -->

<body>
    <?php
    require_once 'header.php'; 
   
    require_once 'footer.php';
    ?>
    
    <!-- Your product display code -->

    <!-- Your footer code -->

    <script>
        // Get the "Add to cart" buttons
        const addToCartButtons = document.querySelectorAll('.add');

        // Add event listeners to the "Add to cart" buttons
        addToCartButtons.forEach((button) => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-id');
                addToCart(productId);
                updateCart();
            });
        });

        // Function to update the cart count in the UI
        function updateCart() {
            const cartCount = document.getElementById('cart-count');
            const count = <?php echo getCartCount(); ?>;
            cartCount.innerText = count;
        }

        // Update the cart count when the page loads
        updateCart();
    </script>
</body>

</html>
