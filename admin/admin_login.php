<?php

include '../components/connect.php';

session_start();

if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $name = filter_var($name,FILTER_SANITIZE_STRING); 
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass,FILTER_SANITIZE_STRING);   
    
    $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ? AND password = ?");
    $select_admin ->execute([$name, $pass]);

    if($select_admin->rowCount() > 0) {
        $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
        $_SESSION['admin_id'] = $fetch_admin_id['id'];
        header('location: dashboard.php');
        $message[] = 'login working!';
    }else {
        $message[] = 'incorrect username or password!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php 
if(isset($message)) {
    foreach($message as $message) {
        echo '
        <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
        ';
    }
}
?>

<!-- admin login form section starts -->
<section class="form-container">
    <form action="" method="post">
        <h3>Login now</h3>
        <p>default username = <span>Elvis</span> & password = <span>1234</span></p>
        <input type="text" placeholder="enter your username" name="name" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="password" placeholder="enter your password" name="pass" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="submit" value="login now" name="submit" class="btn">
    </form>
</section>
<!-- admin login form section ends -->
    
</body>
</html>