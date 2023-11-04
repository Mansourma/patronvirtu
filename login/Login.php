<?php
session_start();
if (isset($_SESSION['user_logged_in'])) {
    header("Location: ../products/newhome.php");
    die();
}

include 'config.php';
$msg = "";

if (isset($_GET['verification'])) {
    $verificationCode = mysqli_real_escape_string($conn, $_GET['verification']);
    $query = mysqli_query($conn, "SELECT * FROM users WHERE code='{$verificationCode}' AND code != ''");
    if (mysqli_num_rows($query) > 0) {
        $updateQuery = mysqli_query($conn, "UPDATE users SET code='' WHERE code='{$verificationCode}'");
        if ($updateQuery) {
            $msg = "<div class='alert alert-success'>Account verification has been successfully completed.</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Failed to update account verification status.</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Invalid or expired verification code.</div>";
    }
}

if (isset($_POST['submit'])) {
    // Validate reCAPTCHA response
    $recaptchaResponse = $_POST['g-recaptcha-response'];
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret' => 'your_captcha_secret_key',
        'response' => $recaptchaResponse
    ];

    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context = stream_context_create($options);
    $recaptchaResult = file_get_contents($url, false, $context);
    $recaptchaResult = json_decode($recaptchaResult);

    if (!$recaptchaResult->success) {
        $msg = "<div class='alert alert-danger'>reCAPTCHA verification failed. Please try again.</div>";
    } else {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));

        $sql = "SELECT * FROM users WHERE email='{$email}' AND password='{$password}'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            if (empty($row['code'])) {
                $_SESSION['user_logged_in'] = $email;
                $_SESSION['name'] = $row['name'];
                $_SESSION['email'] = $row['email'];

                if (isset($_POST['remember_me'])) {
                    $token = bin2hex(random_bytes(32));
                    $userId = $row['id'];
                    $updateTokenQuery = mysqli_query($conn, "UPDATE users SET remember_token='{$token}' WHERE id='{$userId}'");

                    if ($updateTokenQuery) {
                        setcookie('remember_token', $token, time() + 86400 * 30, '/');
                    }
                }

                header("Location: ../products/newhome.php");
                exit();
            } else {
                $msg = "<div class='alert alert-info'>First verify your account and try again.</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Email or password do not match.</div>";
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login Page Ep. 3</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="container-fluid">
        <div class="card card-login">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-12">
                        <div class="padding bg-primary text-center align-items-center d-flex">
                            <div id="particles-js"></div>
                            <div class="w-100">
                                <div class="logo mb-4">
                                    <img src="img/kodinger.jpg" alt="kodinger logo" class="img-fluid">
                                </div>
                                <h4 class="text-light mb-2">Don't waste your time</h4>
                                <p class="lead text-light">Login quickly like replying to your girlfriend's message.</p>
                                <button class="btn btn-block btn-icon btn-icon-google mb-3">
                                    Login With Google
                                </button>
                            </div>

                            <div class="help-links">
                                <ul>
                                    <li><a href="#">Terms of Service</a></li>
                                    <li><a href="#">Privacy Policy</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="padding">
                            <h2>Login</h2>
                            <p class="lead">Before you get started, you must login or register if you don't already have an account.</p>
                            <?php echo $msg; ?>
                            <form autocomplete="on" action="#" method="post">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" class="form-control" id="email" tabindex="1" autocomplete="email">
                                </div>
                                <div class="form-group">
                                    <label class="d-block" for="password">
                                        Password
                                        <div class="float-right">
                                            <a href="forgot.php">Forgot Password?</a>
                                        </div>
                                    </label>
                                    <input type="password" name="password" class="form-control" id="password" tabindex="2" autocomplete="current-password">
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me" <?php echo isset($_COOKIE['remember_token']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="remember_me">Remember Me</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="g-recaptcha" data-sitekey="captcha_key"></div>
                                </div>
                                <div class="form-group text-right">
                                    <div class="float-left mt-2">
                                        <a href="register.php">Create an account?</a>
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-primary" tabindex="3">
                                        Login
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/particles.js"></script>
    <script>
        particlesJS.load('particles-js', 'particlesjs-config.json', function() {
          console.log('callback - particles.js config loaded');
        });
    </script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const emailField = document.getElementById('email');
            const rememberMeCheckbox = document.getElementById('remember_me');

            // Function to populate login information
            function populateLoginInfo() {
                if (localStorage.getItem('loginEmail')) {
                    emailField.value = localStorage.getItem('loginEmail');
                    rememberMeCheckbox.checked = true;
                }
            }

            // Function to save login information
            function saveLoginInfo() {
                if (rememberMeCheckbox.checked) {
                    localStorage.setItem('loginEmail', emailField.value);
                } else {
                    localStorage.removeItem('loginEmail');
                }
            }

            // Populate login information on page load
            populateLoginInfo();

            // Save login information on form submission
            document.querySelector('form').addEventListener('submit', saveLoginInfo);
        });
    </script>

</body>
</html>
