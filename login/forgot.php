<!DOCTYPE html>
<html>
<head>
  <title>Forgot Password</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
  <style>
    .form-gap {
      padding-top: 140px;
    }
    .btn-block {
      background-color: #0069d9;
    }
   .alert-info {
      background-color: #0069d9;
      color: white;
    }
    .alert-danger {
      background-color: #dc3545;
      color: white;
    }
  </style>
</head>
<body>
<div class="form-gap"></div>
<div class="container">
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="text-center">
            <h3><i class="fa fa-lock fa-4x"></i></h3>
            <h2 class="text-center">Forgot Password?</h2>
            <p>You can reset your password here.</p>
          </div>
          <div class="panel-body">
            <?php
            require_once 'config.php';
            require 'vendor/autoload.php';
            use PHPMailer\PHPMailer\PHPMailer;
            use PHPMailer\PHPMailer\SMTP;
            use PHPMailer\PHPMailer\Exception;

            // Check if the form is submitted
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
              // Get the email from the form
              $email = $_POST['email'];
              $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
              if (mysqli_num_rows($query) > 0) {
                $result = mysqli_fetch_assoc($query);

                // Create a new PHPMailer instance
                if ($result) {
                  $code = uniqid();

                  // Store the verification code in the database
                  $updateQuery = mysqli_query($conn, "UPDATE users SET code='$code' WHERE email='$email'");
                  if (!$updateQuery) {
                    $msg = "<div class='alert alert-danger'>Failed to generate the verification code. Please try again.</div>";
                  } else {
                    $mail = new PHPMailer(true);

                    try {
                      $mail->isSMTP();
                      $mail->Host       = 'smtp.gmail.com';
                      $mail->SMTPAuth   = true;
                      $mail->Username   = 'your_smtp_mail';
                      $mail->Password   = 'smtp_password';
                      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                      $mail->Port       = 465;

                      $mail->setFrom('your_smtp_mail'); // Replace with your Gmail address
                      $mail->addAddress($email);

                      $verificationLink = "http://localhost/digiProducts/login/resetpassword.php?verification=" . urlencode($code);

                      $mail->isHTML(true);
                      $mail->Subject = 'PatronVirtu Password Reset';
                      $mail->Body = 'Dear '.$result['name'].', <br><br>
                        You have requested to reset your password. Please follow the link below to reset your password: <br><br>
                        <b><a href="'.$verificationLink.'">'.$verificationLink.'</a></b> <br><br>
                        If you did not request a password reset, please ignore this email.<br><br>
                        Best regards,<br>
                        PatronVirtu Team';

                      $mail->send();
                      $msg = "<div class='alert alert-info'>We've sent a password reset link to your email address.</div>";
                    } catch (Exception $e) {
                      $msg = "<div class='alert alert-danger'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
                    }
                  }
                }
              } else {
                $msg = "<div class='alert alert-danger'>The provided email does not exist. Please try again.</div>";
              }
            }
            ?>
            <?php if (isset($msg)) echo $msg; ?>
            <form id="recover-form" role="form" autocomplete="off" class="form" method="post">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                  <input id="email" name="email" placeholder="Email Address" class="form-control" type="email" required>
                </div>
              </div>
              <div class="form-group">
                <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
</body>
</html>
