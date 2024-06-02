<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)) {
    header('location: admin_login.php');
    exit();
}

if(isset($_POST['update'])) {
    
    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $details = $_POST['details'];
    $details = filter_var($details, FILTER_SANITIZE_STRING);

    $update_product = $conn->prepare("UPDATE `products` SET name = ?, price = ?, details = ? WHERE id = ?");
    $update_product->execute([$name, $price, $details, $pid]);

    $message[] = 'product successfully updated!';

    $old_image_01 = $_POST['old_image_01'];
    $image_01 = $_FILES['image_01']['name'];
    $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
    $image_size_01 = $_FILES['image_01']['size'];
    $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
    $image_folder_01 = '../uploaded_img/'.$image_01;

    if(!empty($image_01)){
        if($image_size_01 > 2000000){
            $message[] = 'image size is too large';
        }else{
            $update_image_01 = $conn->prepare("UPDATE `products` SET image_01 = ? WHERE id = ?");
            $update_image_01->execute([$image_01, $pid]);
            move_uploaded_file($image_tmp_name_01, $image_folder_01);
            unlink('../uploaded_img/' .$old_image_01);
            $message[] = 'image 01 updated!';
        }
    }

    $old_image_02 = $_POST['old_image_02'];
    $image_02 = $_FILES['image_02']['name'];
    $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
    $image_size_02 = $_FILES['image_02']['size'];
    $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
    $image_folder_02 = '../uploaded_img/'.$image_02;

    if(!empty($image_02)){
        if($image_size_02 > 2000000){
            $message[] = 'image size is too large';
        }else{
            $update_image_02 = $conn->prepare("UPDATE `products` SET image_02 = ? WHERE id = ?");
            $update_image_02->execute([$image_02, $pid]);
            move_uploaded_file($image_tmp_name_02, $image_folder_02);
            unlink('../uploaded_img/' .$old_image_02);
            $message[] = 'image 02 updated!';
        }
    }

    $old_image_03 = $_POST['old_image_03'];
    $image_03 = $_FILES['image_03']['name'];
    $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
    $image_size_03 = $_FILES['image_03']['size'];
    $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
    $image_folder_03 = '../uploaded_img/'.$image_03;

    if(!empty($image_03)){
        if($image_size_03 > 2000000){
            $message[] = 'image size is too large';
        }else{
            $update_image_03 = $conn->prepare("UPDATE `products` SET image_03 = ? WHERE id = ?");
            $update_image_03->execute([$image_03, $pid]);
            move_uploaded_file($image_tmp_name_03, $image_folder_03);
            unlink('../uploaded_img/' .$old_image_03);
            $message[] = 'image 03 updated!';
        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product update</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- update product section starts -->

<section class="update-product">

    <h1 class="heading">Update Product</h1>

    <?php
       $update_id = $_GET['update'];
       $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
       $select_products->execute([$update_id]);
       if($select_products->rowCount() > 0){
          while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
    ?>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
        <input type="hidden" name="old_image_01" value="<?= $fetch_products['image_01']; ?>">
        <input type="hidden" name="old_image_02" value="<?= $fetch_products['image_02']; ?>">
        <input type="hidden" name="old_image_03" value="<?= $fetch_products['image_03']; ?>">

          <div class="image-container">
            <div class="main-image">
                <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
            </div>

            <div class="sub-images">
                <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
                <img src="../uploaded_img/<?= $fetch_products['image_02']; ?>" alt="">
                <img src="../uploaded_img/<?= $fetch_products['image_03']; ?>" alt="">
            </div>
          </div>
          <span>update name</span>
          <input type="text" placeholder="enter product name" required class="box" name="name" maxlength="100" class="box" value="<?= $fetch_products['name']; ?>">
          <span>update price</span>
          <input type="number" min="0" max="9999999999" placeholder="enter product price" required class="box" name="price" 
          onkeypress="if(this.value.length == 10) return false;" class="box" value="<?= $fetch_products['price']; ?>">
          <span>update details</span>
          <textarea name="details" class="box" placeholder="enter product details" required maxlength="500" cols="30" rows="10" >
          <?= $fetch_products['details']; ?>
          </textarea>
          <span>update image 01</span>
          <input type="file" name="image_01" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" >
          <span>update image 02</span>
          <input type="file" name="image_02" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" >
          <span>update image 03</span>
          <input type="file" name="image_03" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" >
          <div class="flex-btn">
          <input type="submit" value="update" class="btn" name="update">
          <a href="products.php" class="option-btn">go back</a>
          </div>
    </form>

    <?php
            }
         } else {
            echo '<p class="empty">Product not found!</p>';
        }
    ?>

<!-- update product section ends -->
</section>

<!-- custom js file -->
<script src="../js/admin_script.js"></script>  
</body>
</html>
