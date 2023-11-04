<?php
require_once 'add_to_cart.php';
  require_once 'connection.php';
?>
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="newhome.css"></head>
<header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="newhome.php"><span id="logo">Patron</span><span id="logo1" >Virtu</span></a>
                <form class="d-flex" id="search-form">
    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" id="search-input">
    <button class="btn btn-primary submit" type="submit">Search</button>
    
</form>



                <div class="d-flex">
                <a class="nav-link" href="cart.php">
    <button class="btn btn-primary">
        <i class="bi bi-cart-fill" style="color: #f8f9fa;"></i>
        <span id="cart-count"><?php echo count($_SESSION['cart'] ?? []); ?></span>
    </button>
</a>

<?php
require_once 'add_to_cart.php';
require_once 'connection.php';
    if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']) {
        // User is logged in, display dropdown menu
        ?>
        <div class="dropdown">
            <button class="dropbtn">Profile</button>
            <div class="dropdown-content">
            <a href="#"><?php echo $_SESSION['name']; ?></a>
                <a href="#"><?php echo $_SESSION['email']; ?></a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
        <?php
    } else {
        // User is not logged in, display regular login button
        ?>
 <a class="nav-link" href="../login/Login.php">
                        <button class="btn btn-success">Login</button>
                    </a>        <?php
    }
    ?>
                </div>
            </div>
        </nav>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="steam.php">Steam</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="xbox.php">Xbox</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="playstation.php">Playstation</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="entertainment.php">Entertainment</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="security.php">Security</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="games.php">Games</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <div id="search-results"></div>
  