<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();
if (isset($_SESSION['SESSION_EMAIL'])) {
    header("Location: welcome.php");
    die();
}

require 'vendor/autoload.php';

include 'config.php';
$msg = ""; 

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['Full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['Email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm_password']));
    $code = mysqli_real_escape_string($conn, md5(rand()));

    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE Email='{$email}'")) > 0) {
        $msg = "<div class='alert alert-danger'>{$email} - This email address already exists.</div>";
    } else {
        if ($password === $confirm_password) {
            $sql = "INSERT INTO users (name, email, password, code) VALUES ('{$name}', '{$email}', '{$password}', '{$code}')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'your_smtp_mail';
                    $mail->Password   = 'smtp_password';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port       = 465;

                    $mail->setFrom('your_smtp_mail');
                    $mail->addAddress($email);

                    $verificationLink = "http://localhost/digiProducts/login/login.php?verification=" . urlencode($code);

                    $mail->isHTML(true);
                    $mail->Subject = 'PatronVirtu Verification';
                    $mail->Body    = 'Dear '.$name.', <br><br>
                    
                    I am writing to inform you that your account has been successfully created on our website, PatronVirtu. To complete the registration process,
                    we require you to verify your email address. <br><br>
                    
                    To verify your email, please follow the link provided below: <b><a href="'.$verificationLink.'">'.$verificationLink.'</a></b>
                        <br>
                    Please note that this verification link is valid for 24 hours. If you do not verify your email within this time frame, 
                    you will need to request a new verification link. <br><br>
                    
                    Thank you for choosing PatronVirtu. <br> <br>
                    
                    Best regards,<br>
                    PatronVirtu Team';

                    $mail->send();
                    $msg = "<div class='alert alert-info'>We've sent a verification link to your email address.</div>";
                } catch (Exception $e) {
                    $msg = "<div class='alert alert-danger'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
                }
            } else {
                $msg = "<div class='alert alert-danger'>Something went wrong.</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Register Page Ep. 3</title>
    <!-- Load bootstrap stylesheet -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Load login stylesheet -->
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
                            <h2>Register</h2>
                            <?php echo $msg; ?>
                            <p class="lead">Before you get started, you must register if you don't already have an account.</p>
                            <form autocomplete="off" action="#" method="post">
                                <div class="form-group">
                                    <label for="Full_name">
                                        Full name 
                                    </label>
                                    <input type="text" name="Full_name" class="form-control" id="Full_name" tabindex="1">
                                </div>

                                <div class="form-group">
                                    <label for="Email">
                                        Email
                                    </label>
                                    <input type="email" name="Email" class="form-control" id="Email" tabindex="1">
                                </div>


                                <div class="form-group">
                                    <label class="d-block" for="password">
                                        Password
                                    </label>
                                    <input type="password" name="password" class="form-control" id="password" tabindex="2"><br>


                                    <label class="d-block" for="confirm_password">
                                        Confirm Password
                                    </label>
                                    <input type="password" name="confirm_password" class="form-control" id="confirm_password" tabindex="2">


                                </div>
                                <div class="form-group text-right">
                                    <div class="mt-0">
                                        <p class="text-left" >
                                            <label >By registering, you agree with our terms and conditions.</label> 
                                        </p>
                                        <div class="align-items-center d-flex">
                                            <input type="submit" class="btn btn-primary ms-auto" name="submit" value="Register">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="card-footer py-md-2 border-0">
                                <div class="text-left">
                                    Already have an account? <a href="Login.php" class="text-dark">Login</a>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-5 text-muted">
                            &copy; 2023 PatronVirtu
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
</body>
</html>
