<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
    header('location: home.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cart</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
<?php 
include 'components/user_header.php';
?>

<!--about section starts -->

<section class="about">
    <div class="row">
        <div class="image">
            <img src="images/about.svg" alt="">
        </div>

        <div class="content">
            <h3>why choose us?</h3>
            <p>Here at Aquas Catering we offer quality home made food. Customers are able to add extra additions or remove certain recipes from a dish!
                We offer service for customers who live in Cape Town Western Cape. A customer only receives free delivery if their order is above 200 rand else the customer may receive their
                their order at restaurant.
            </p>
            <a href="contact.php" class="btn">contact us</a>
        </div>
    </div>
</section>
<!--about section ends -->

<?php 
include 'components/footer.php';
?>

<!-- custom js file link -->
<script src="js/script.js"></script>

</body>
</html>