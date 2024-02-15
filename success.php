<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Donation</title>
    <link rel="stylesheet" href="success.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
</head>

<body>
    <div id="main">
        <div id="page">
            <h1>Certificate of Donation</h1>
            <?php
            // Retrieve name and amount from URL query string
            $name = isset($_GET['name']) ? $_GET['name'] : '';
            $amount = isset($_GET['amount']) ? $_GET['amount'] : '';
            ?>
            <h4>This certifies that <span><?php echo htmlspecialchars($name); ?></span> has generously donated <span>₹<?php echo htmlspecialchars($amount); ?></span> to Prospect Education and Social Welfare Society,
                an NGO in Bhopal. Your kindness empowers us to provide essential resources, nurturing a brighter future.
                Thank you for your invaluable contribution, inspiring hope and compassion in our community.
            </h4>
            <h3>        
                Authorized Signature: 
                <br>
                Prospect Welfare Society
            </h3>
        </div>
        <button class="print" onclick="printCertificate()">Print</button>
        <a href="index.php"><button class="home">Go to Home</button></a>
    </div>

    <script>
        function printCertificate() {
            window.print();
        }
    </script>
</body>

</html>
