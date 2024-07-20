<?php
include 'config.php';
if(isset($_POST['submit'])){
    $error = array();
    $product_Name = isset($_POST['name'])? $_POST['name']:'';
    $product_Price = isset($_POST['price'])? $_POST['price']:'';
    if(empty($product_Name)){
        $error[] = 'Please enter product name';
    }
    if(empty($product_Price)){
        $error[] = 'Please enter product price';
    }
    if(!is_dir(UPLOAD_DIR)){
        mkdir(UPLOAD_DIR,0777,true);
    }
    $file_name = $_FILES['file']['name'];
    $file_tmp=$_FILES['file']['tmp_name'];
    $tmp = explode(".",$file_name);
    $file_ext = end($tmp);
    if(empty($error)){
        $insert_product = mysqli_query($conn,"INSERT INTO products(name,price,image) VALUES('$product_Name','$product_Price','$file_name')");
        if($insert_product==1){
            move_uploaded_file($file_tmp,UPLOAD_DIR.$file_name);
            $message[] = 'Product added successfully';
        }else{
            $message[] = 'Error adding product';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
    <meta charset="UTF-8" />
    <title>Save product details</title>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #0277bd;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .form-container {
            background-color: #fff;
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            margin-top: 0;
        }
        .form-container label {
            display: block;
            margin: 10px 0 5px;
        }
        .form-container input[type="text"],
        .form-container input[type="number"],
        .form-container input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
        }
        .form-container button {
            background-color: #0277bd;
            color: #fff;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #025f9a;
        }
        .message {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #e0f7fa;
            color: #00796b;
        }
        .error {
            color: #d32f2f;
        }
        .link-to-product-details {
            text-align: center;
            margin-top: 20px;
        }
        @media (max-width: 768px) {
            .form-container {
                width: 80%;
            }
        }
        @media (max-width: 480px) {
            .form-container {
                width: 95%;
            }
        }
    </style>
</head>
<body>
    <?php
    if(isset($message)){
        echo '<div class="message">';
        foreach ($message as $msg) {
            echo '<span>' . $msg . '</span>';
        }
        echo '</div>';
    }
    if(!empty($error)){
        echo '<div class="message error">';
        foreach ($error as $err) {
            echo '<span>' . $err . '</span>';
        }
        echo '</div>';
    }
    ?>
    <div class="header">TASTE OF NEPAL</div>
    <div class="form-container">
        <h2>Add a product</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php echo isset($product_Name) ? $product_Name : ''; ?>">
            <label for="price">Price</label>
            <input type="number" id="price" name="price" min="0" value="<?php echo isset($product_Price) ? $product_Price : ''; ?>">
            <label for="file">Image</label>
            <input type="file" id="file" name="file">
            <button type="submit" id="submit" name="submit">Submit</button>
        </form>
        <div class="link-to-product-details">
            <a href="http://localhost/ecommerce/display.php" style="color: #0277bd; text-decoration: none;">View Product</a>
        </div>
    </div>
</body>
</html>
