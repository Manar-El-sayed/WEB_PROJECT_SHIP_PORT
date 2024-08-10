<?php
@include 'connect.php';
session_start();
if(isset($_POST['submit'])){
   $email = $_POST['email'];
   $password = $_POST['password'];

   $select = "SELECT * FROM registration WHERE email = '$email' AND password = '$password'";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result)>0){

      $row = mysqli_fetch_array($result);

      if($row['userType'] == 'admin'){

         $_SESSION['admin_name'] = $row['firstName'];
         header('location:admin_page.php');

      }elseif($row['userType'] == 'user'){

         $_SESSION['user_name'] = $row['firstName'];
         header('location:user_page.php');

      }
   }else{
      $_SESSION['error'] = 'Incorrect email or password!';
   }
}
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login Page</title>
   <link rel="stylesheet" href="login.css">
</head>
<body class="reg">
   <section class="login">
      <div class="container">
         <div class="title">Login</div>
         <form action="" method="post">
         <?php
            if(isset($_SESSION['error'])){
               echo '<span class="error-msg">'.$_SESSION['error'].'</span>';
               unset($_SESSION['error']);
            };
         ?>
            <div class="user-details">
               <div class="input-box">
                 <label for="email">Email</label>
                 <input type="text" id="email" name="email" placeholder="Enter your email" required>
               </div>
               <div class="input-box">
                 <label for="password">Password</label>
                 <input type="password" id="password" name="password" placeholder="Enter your password" required>
               </div>
            </div>
            <div class="button">
               <input type="submit" name="submit" value="Login" >
            </div>
               <p>Don't have an account ? <a href="register.php"> Sign Up Now</a></p>
         </form>
      </div>
   </section>
</body>
</html>

