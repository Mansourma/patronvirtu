<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="footer.css">
   
</head>
<body>
    <footer class="footer">
        <div class="container">
            <div class="footer-body">
                <div class="grid-3">
                    <div class="footer-item">
                        <h3>Terms & Policies</h3>
                        <ul class="footer-list">
                            <li><a href="/policy-pages/conditions.html">Conditions Terms</a></li>
                            <li><a href="/policy-pages/refund.html">Refund Policy</a></li>
                            <li><a href="/policy-pages/privacy.html">Privacy Policy</a></li>
                        </ul>
                    </div>
                    <div class="footer-item">
                        <h3>About Store</h3>
                        <ul class="footer-list">
                            <li><a href="/policy-pages/payments.html">Payments methods</a></li>
                            <li><a href="/policy-pages/shipping.html">Shipping & Delivery</a></li>
                            <li><a href="/policy-pages/about-store.html">About Store</a></li>
                        </ul>
                    </div>
                    <div class="footer-item">
                        <h3>Contact Us</h3>
                        <ul class="footer-list">
                            <li><a href="/policy-pages/faq.html">Frequently Asked Questions</a></li>
                            <li><a href="/policy-pages/contact.html">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="newsletter">
                <h3>Subscribe to our Newsletter</h3>
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="email" class="form-control" name="email" id="newsletterEmail" aria-describedby="emailHelp" placeholder="Enter your email" required>
                            <div class="input-group-append">
                                <button type="submit" name="subscribe" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subscribe'])) {
                            $email = $_POST['email'];
                            require_once 'connection.php';

                            $stmt = $conn->prepare("SELECT COUNT(*) FROM subscribers WHERE email = ?");
                            $stmt->bind_param("s", $email);
                            $stmt->execute();
                            $stmt->bind_result($count);
                            $stmt->fetch();
                            $stmt->close();

                            if ($count > 0) {
                                echo '<span class="error-message">Email already subscribed!</span>';
                            } else {
                                $stmt = $conn->prepare("INSERT INTO subscribers (email) VALUES (?)");
                                $stmt->bind_param("s", $email);
                                $stmt->execute();
                                $stmt->close();

                                echo '<script>window.location.href = "newslettersuccess.php";</script>';
                                exit;
                            }

                            $conn->close();
                        }
                        ?>
                    </div>
                </form>
                <p class="detail-para">You can unsubscribe anytime. For more details, review our <a href="policy-pages/privacy.html">Privacy Policy</a>.</p>
            </div>
        </div>
    </footer>
</body>
</html>
