<!DOCTYPE html>
<html lang="en">
<head>
  <style>
    html,body { height: 100%; }

    body{
      display: -ms-flexbox;
      display: -webkit-box;
      display: flex;
      -ms-flex-align: center;
      -ms-flex-pack: center;
      -webkit-box-align: center;
      align-items: center;
      -webkit-box-pack: center;
      justify-content: center;
      background-color: #f5f5f5;
    }

    form{
      padding-top: 10px;
      font-size: 15px;
      margin-top: 30px;
    }

    .card-title{ font-weight:300; }

    .btn{
      font-size: 13px;
    }

    .login-form{ 
      width:320px;
      margin:20px;
    }

    .sign-up{
      text-align:center;
      padding:20px 0 0;
    }

    span{
      font-size:20px;
    }

    .submit-btn{
      margin-top:20px;
    }
  </style>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <title>Change Password</title>
</head>
<body>
  <div class="card login-form">
    <div class="card-body">
      <h3 class="card-title text-center">Change password</h3>
      
      <!--Password must contain one lowercase letter, one number, and be at least 7 characters long.-->
      
      <div class="card-text">
      <?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $newPassword = $_POST['new_password'];
  $repeatPassword = $_POST['repeat_password'];

  $verificationCode = $_GET['verification'];

  $query = mysqli_query($conn, "SELECT * FROM users WHERE code='$verificationCode'");
  if (mysqli_num_rows($query) > 0) {
    $user = mysqli_fetch_assoc($query);


    if ($newPassword === $repeatPassword) {
      $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
      $updateQuery = mysqli_query($conn, "UPDATE users SET password='$hashedPassword' WHERE id=" . $user['id']);

      if ($updateQuery) {
        echo '<div class="alert alert-success">Password updated successfully.</div>';
      } else {
        echo '<div class="alert alert-danger">Failed to update password. Please try again.</div>';
      }
    } else {
      echo '<div class="alert alert-danger">New password and repeat password do not match.</div>';
    }
  } else {
    echo '<div class="alert alert-danger">Invalid verification code.</div>';
  }
}
?>

<!-- Your HTML form code -->

        

        <form method="POST">
          <div class="form-group">
            <label for="new_password">Your new password</label>
            <input type="password" class="form-control form-control-sm" name="new_password" required>
          </div>
          <div class="form-group">
            <label for="repeat_password">Repeat password</label>
            <input type="password" class="form-control form-control-sm" name="repeat_password" required>
          </div>
          <button type="submit" class="btn btn-primary btn-block submit-btn">Confirm</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
