<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Form</title>
    <link rel="stylesheet" href="style.css">
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
    <!-- Include Razorpay Checkout -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
        /* Blur effect */
        #main.blur {
            filter: blur(5px);
        }
        /* Style for radio div */
        .radio-div {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div id="main">
        <div id="page">
            <img src="https://prospectwelfare.in/wp-content/uploads/2021/07/logo.png" alt="Prospect Welfare Logo">
            <div id="contact">
                <form id="paymentForm" action="connect.php">
                    <div class="radio-group">
                        <div class="radio-div" onclick="selectAmount(100)">
                            <label for="radio-100">
                                <input type="radio" name="amount" value="100">
                                <span>₹100</span>
                                <p>Thank you for paying ₹100</p>
                            </label>
                        </div>
                        <div class="radio-div" onclick="selectAmount(200)">
                            <label for="radio-200">
                                <input type="radio" name="amount" value="200">
                                <span>₹200</span>
                                <p>Thank you for paying ₹200</p>
                            </label>
                        </div>
                        <div class="radio-div" onclick="selectAmount(300)">
                            <label for="radio-300">
                                <input type="radio" name="amount" value="300">
                                <span>₹300</span>
                                <p>Thank you for paying ₹300</p>
                            </label>
                        </div>
                        <div class="radio-div" onclick="selectCustomAmount()">
                            <label for="radio-other">
                                <input type="radio" name="amount" value="other">
                                <span>₹</span><input type="number" name="customAmount" id="customAmount" class="radio-num" placeholder="">
                                <p>Thank you for your payment</p>
                            </label>
                        </div>
                    </div>
                    <div id="main-form">
                        <div class="name">
                            <input type="text" id="fname" placeholder="First name" name="fname" class="name-con">
                            <input type="text" placeholder="Last Name" name="lname" id="lname" class="name-con">
                        </div>
                        <div class="name">
                            <input type="email" id="email" placeholder="Email" name="email" class="name-con">
                            <input type="number" placeholder="Mobile" name="mobile" id="mobile" class="name-con">
                        </div>
                        <textarea name="address" placeholder="Address" class="address" cols="100" rows="2"></textarea>
                        <div class="name">
                            <input type="text" placeholder="City" name="city" class="code">
                            <input type="text" placeholder="State" name="state" class="code">
                            <input type="number" placeholder="Postal Code" name="pincode" class="code">
                        </div>
                        <div class="name">
                            <input type="text" placeholder="Country" name="country" class="name-con">
                            <input type="text" placeholder="PAN" name="pan" class="name-con">
                        </div>
                    </div>
                    <button type="submit" id="proceedToPayment">PROCEED TO PAYMENT</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Loader HTML -->
    <div id="loader" style="display:none;">
        Please wait for some time ....
    </div>
    <script>
        var options = {
            key: "razorpay Key ",
            currency: "INR",
            prefill: {
                name: "",
                email: "",
                contact: ""
            },
            theme: {
                color: "#54b6f3"
            },
            handler: function(response) {
                console.log(response);
                // Show loader when payment processing starts
                $("#loader").show();
                // Add blur effect to main div
                $("#main").addClass("blur");
                // Send form data to connect.php upon successful payment
                $.ajax({
                    type: 'POST',
                    url: 'connect.php',
                    data: $('#paymentForm').serialize(), // Serialize form data
                    success: function(data) {
                        console.log(data);
                        // Send email verification after successful payment
                        $.ajax({
                            type: 'POST',
                            url: 'mailverification.php',
                            data: $('#paymentForm').serialize(), // Serialize form data
                            success: function(data) {
                                console.log(data);
                                // Remove blur effect
                                $("#main").removeClass("blur");
                                // Hide loader
                                $("#loader").hide();
                                // Redirect or show a success message after storing data and sending email
                                alert("Payment successful. Your data has been stored and email verification sent.");
                                console.log(data);
                                // Redirect to success page
                                var fname = $("#fname").val(); // Corrected this line
                                var lname = $("#lname").val(); // Added this line
                                var amount;
                                if ($('input[name=amount]:checked').val() == 'other') {
                                    amount = $("#customAmount").val();
                                } else {
                                    amount = $('input[name=amount]:checked').val();
                                }
                                window.location.href = "success.php?name=" + encodeURIComponent(fname + " " + lname) + "&amount=" + encodeURIComponent(amount);
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                                // Handle errors, show an error message if needed
                                alert("Payment successful but there was an error sending email verification.");
                                // Remove blur effect
                                $("#main").removeClass("blur");
                                // Hide loader
                                $("#loader").hide();
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        // Handle errors, show an error message if needed
                        alert("Payment successful but there was an error storing your data.");
                        // Remove blur effect
                        $("#main").removeClass("blur");
                        // Hide loader
                        $("#loader").hide();
                    }
                });
            }
        };

        function updateAmount(amount) {
            options.amount = amount * 100;
        }

        function updateCustomAmount() {
            var customAmount = document.querySelector('.radio-num').value;
            options.amount = customAmount * 100;
        }

        function selectAmount(amount) {
            $('input[name=amount][value="' + amount + '"]').prop('checked', true).change();
            updateAmount(amount); // Update the amount before opening Razorpay
        }

        function selectCustomAmount() {
            $('input[name=amount][value="other"]').prop('checked', true).change();
            updateCustomAmount(); // Update the custom amount before opening Razorpay
        }

        $(document).ready(function() {
            $("#paymentForm").submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                var selectedAmount = $('input[name=amount]:checked').val();

                if (selectedAmount == 'other') {
                    var customAmount = parseFloat($("#customAmount").val());
                    if (isNaN(customAmount) || customAmount < 1) {
                        alert("Please enter a valid amount (minimum ₹1).");
                        return;
                    } else {
                        updateCustomAmount(); // Update the custom amount before opening Razorpay
                    }
                }

                options.prefill.name = $("#fname").val() + " " + $("#lname").val();
                options.prefill.email = $("#email").val();
                options.prefill.contact = $("#mobile").val();

                var rzp = new Razorpay(options);
                rzp.open();
            });
        });
    </script>

</body>

</html>
