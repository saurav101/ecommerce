<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esewa Payment</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/hmac-sha256.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/enc-base64.min.js"></script>
    <style>
        table {
            width: 50%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        .form-container {
            text-align: center;
            margin-top: 20px;
        }
        .submit-btn {
            background-color: green;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
   <?php
   @include 'config.php';
   @include 'setting.php';
   $select_cart = mysqli_query($conn, "SELECT * FROM cart");
   $grand_total = 0;
   if (mysqli_num_rows($select_cart) > 0) {
       while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
           $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
           $grand_total += $sub_total;
       }
   }
   $tax_amt = $grand_total * (13 / 100);
   $product_delivery_charge = 100;
   $total_amount = $grand_total + $tax_amt  + $product_delivery_charge;
   ?>
    <h1 style="text-align: center;">Esewa Payment</h1>
    <table>
        <tr>
            <th>Description</th>
            <th>Amount</th>
        </tr>
        <tr>
            <td>Amount</td>
            <td><?php echo $grand_total; ?></td>
        </tr>
        <tr>
            <td>Tax Amount</td>
            <td><?php echo $tax_amt; ?></td>
        </tr>
        <tr>
            <td>Product Delivery Charge</td>
            <td><?php echo $product_delivery_charge; ?></td>
        </tr>
        <tr>
            <th>Grand Total</th>
            <th><?php echo $total_amount; ?></th>
        </tr>
    </table>
    <div class="form-container">
        <form action="<?php echo $epay_url ?>" method="POST">
            <input type="hidden" id="amount" name="amount" value="<?php echo $grand_total ?>" required>
            <input type="hidden" id="tax_amount" name="tax_amount" value="<?php echo $tax_amt ?>" required>
            <input type="hidden" id="total_amount" name="total_amount" value="<?php echo $total_amount ?>" required>
            <input type="hidden" id="transaction_uuid" name="transaction_uuid" required>
            <input type="hidden" id="product_code" name="product_code" value="EPAYTEST" required>
            <input type="hidden" id="product_service_charge" name="product_service_charge" value="0" required>
            <input type="hidden" id="product_delivery_charge" name="product_delivery_charge" value="100" required>
            <input type="hidden" id="success_url" name="success_url" value="https://esewa.com.np" required>
            <input type="hidden" id="failure_url" name="failure_url" value="https://google.com" required>
            <input type="hidden" id="signed_field_names" name="signed_field_names" value="total_amount,transaction_uuid,product_code" required>
            <input type="hidden" id="signature" name="signature" required>
            <input value="Pay With Esewa" type="submit" class="submit-btn">
        </form>
    </div>
    <script>
        function generateSignature() {
            // Generate transaction UUID
            var currentTime = new Date();
            var formattedTime = currentTime.toISOString().slice(2, 10).replace(/-/g, '') + '-' + currentTime.getHours() + currentTime.getMinutes() + currentTime.getSeconds();
            document.getElementById("transaction_uuid").value = formattedTime;
            // Retrieve payment details
            var total_amount = document.getElementById("total_amount").value;
            var transaction_uuid = document.getElementById("transaction_uuid").value;
            var product_code = document.getElementById("product_code").value;
            var secret = "8gBm/:&EnhH.1/q";
             
            var hash = CryptoJS.HmacSHA256(`total_amount=${total_amount},transaction_uuid=${transaction_uuid},product_code=${product_code}`, secret);
            var hashInBase64 = CryptoJS.enc.Base64.stringify(hash);
            document.getElementById("signature").value = hashInBase64;
        }
    
        generateSignature();
    </script>
</body>
</html>
