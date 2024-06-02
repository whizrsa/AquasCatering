<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
}

if(isset($_POST['send'])) {

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $msg = $_POST['msg'];
    $msg = filter_var($msg, FILTER_SANITIZE_STRING);


    $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? 
    AND email = ? AND number = ? AND message = ?");
    $select_message->execute([$name, $email, $number, $msg]);

    if($select_message->rowCount() > 0) {
        $message[] = 'message sent already';
    }else {
        $send_message = $conn->prepare("INSERT INTO `messages` (name, email, number, message) VALUES(?,?,?,?)");
        $send_message->execute([$name, $email, $number, $msg]);
        $message[] = 'message sent successfully';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>contact</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
<?php 
include 'components/user_header.php';
?>

<!-- contact section starts -->
<section class="form-container">

<h1 class="heading">CONTACT US</h1>

    <form action="" method="post" class="box">
        <h3>send us message!</h3>
        <input type="text" name="name" required placeholder="enter your name" maxlength="20" class="box">
        <input type="number" name="number" required placeholder="enter your number" min="0" max="9999999999"  class="box" onkeypress="if(this.value.length == 10) return false;">
        <input type="email" name="email" required placeholder="enter your email" maxlength="50" class="box">
        <textarea name="msg" placeholder="enter your message" required class="box" cols="30" rows="10"></textarea>
        <input type="submit" value="send message" class="btn" name="send">

    </form>
</section>

<!-- contact section ends -->


<!-- custom js file link -->
<script src="js/script.js"></script>

</body>
</html>