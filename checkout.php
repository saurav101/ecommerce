<?php
session_start();
@include 'config.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $method = $_POST['method'];
    $house_no = $_POST['house_no'];
    $city = $_POST['city'];
    $street = $_POST['street'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $pin_code = $_POST['pin_code'];
    $grand_total = isset($_SESSION['grand_total']) ? $_SESSION['grand_total'] : 0;

    $stmt = $conn->prepare("INSERT INTO orders (name, number, email, method, house_no, city, street, state, country, pin_code, grand_total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssd", $name, $number, $email, $method, $house_no, $city, $street, $state, $country, $pin_code, $grand_total);

    if ($stmt->execute()) {
        if ($method === 'esewa') {
            header("Location: esewa.php?total=" . urlencode($grand_total));
        } else {
            header("Location: completion.php");
        }
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }
        .checkout-form {
            text-align: center;
        }
        .heading {
            text-align: center;
            font-size: 2rem;
            text-transform: uppercase;
            color: var(--black);
            margin-bottom: 2rem;
        }
        .flex {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: space-between;
        }
        .inputBox {
            flex: 1 1 45%;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .inputBox span {
            font-size: 14px;
            color: #666;
        }
        .inputBox input, .inputBox select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        .inputBox input:focus, .inputBox select:focus {
            border-color: #0277bd;
        }
        .btn {
            background-color: #0277bd;
            color: #fff;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 4px;
            margin-top: 20px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #025f9a;
        }
        @media (max-width: 768px) {
            .inputBox {
                flex: 1 1 100%;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <section class="checkout-form">
        <h1 class="heading">Complete Your Order</h1>
        <form action="" method="post">
            <div class="flex">
                <div class="inputBox">
                    <span>Your Name</span>
                    <input type="text" placeholder="Name" name="name" required>
                </div>
                <div class="inputBox">
                    <span>Your Number</span>
                    <input type="number" placeholder="Phone Number" name="number" required>
                </div>
                <div class="inputBox">
                    <span>Your Email</span>
                    <input type="email" placeholder="Email" name="email" required>
                </div>
                <div class="inputBox">
                    <span>Payment Method</span>
                    <select name="method">
                        <option value="delivery">Cash on delivery</option>
                        <option value="esewa">Esewa</option>
                    </select>
                </div>
                <div class="inputBox">
                    <span>House Number</span>
                    <input type="text" placeholder="House Number" name="house_no" required>
                </div>
                <div class="inputBox">
                    <span>City</span>
                    <input type="text" placeholder="City" name="city" required>
                </div>
                <div class="inputBox">
                    <span>Street</span>
                    <input type="text" placeholder="Street" name="street" required>
                </div>
                <div class="inputBox">
                    <span>State</span>
                    <input type="text" placeholder="State" name="state" required>
                </div>
                <div class="inputBox">
                    <span>Country</span>
                    <input type="text" placeholder="Country" name="country" required>
                </div>
                <div class="inputBox">
                    <span>Pin Code</span>
                    <input type="text" placeholder="Pin Code" name="pin_code" required>
                </div>
            </div>
            <input type="submit" value="Order Now" name="order_btn" class="btn">
        </form>
    </section>
</div>
</body>
</html>
