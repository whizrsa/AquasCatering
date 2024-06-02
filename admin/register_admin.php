<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)) {
    header('location: admin_login.php');
};

if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $name = filter_var($name,FILTER_SANITIZE_STRING); 
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass,FILTER_SANITIZE_STRING);  
    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass,FILTER_SANITIZE_STRING); 
    
    $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ?");
    $select_admin ->execute([$name]);

    if($select_admin->rowCount() > 0) {
        $message[] = 'Admin already exists!';
    }else {
        if($pass !== $cpass) {
            $message[] = 'Password does not match';
        }else {
            $insert_admin = $conn->prepare("INSERT INTO `admins`(name, password) VALUES(?,?)");
            $insert_admin->execute([$name,$cpass]);
            $message[] = 'New admin Registered!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>
    <!-- admin login form section starts -->
    <section class="form-container">
        <form action="" method="post">
            <h3>Register new</h3>
            <input type="text" placeholder="enter your username" name="name" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" placeholder="Enter your password" name="pass" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" placeholder="Confirm your password" name="cpass" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="register now" name="submit" class="btn">
        </form>
    </section>
<!-- admin login form section ends -->

 <script src="../js/admin_script.js"></script>  
</body>
</html>