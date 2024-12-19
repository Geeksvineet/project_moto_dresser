<?php
// Assume database connection in $con and session management
session_start();
require 'includes/db.php';
$customer_login_id = $_SESSION['user_id'];

// Redirect if user is not logged in
if (!isset($customer_login_id)) {
    header('Location: Login-page');
    exit();
}

// Fetch profile status and redirect if not complete
$profileQuery = "SELECT profile_status FROM customer_login WHERE id = ?";
$stmt = $con->prepare($profileQuery);
$stmt->bind_param('i', $customer_login_id);
$stmt->execute();
$profileResult = $stmt->get_result();

if ($profileResult && $profileResult->num_rows > 0) {
    $profile = $profileResult->fetch_assoc();
    if ($profile['profile_status'] == 0) {
        header('Location: add_profile');
        exit();
    }
} else {
    header('Location: Login-page');
    exit();
}

// Fetch customer details and cart items...
// Fetch the customer details
$customerQuery = "SELECT * FROM customers WHERE customer_login_id = $customer_login_id";
$customerResult = $con->query($customerQuery);
$customer = $customerResult->fetch_assoc();

$addressOptions = "<option value='{$customer['customer_address']}'>{$customer['customer_address']}, {$customer['customer_city']}, {$customer['customer_country']} - {$customer['customer_pincode']}</option>";


// Fetch cart items
$cartQuery = "
    SELECT c.qty, c.p_id, c.p_price, p.product_title, p.product_img1 
    FROM cart AS c
    JOIN products AS p ON c.p_id = p.product_id
    WHERE c.customer_login_id = $customer_login_id";
$cartResult = $con->query($cartQuery);

$subtotal = 0;
$cartItemsHTML = '';
while ($cartItem = $cartResult->fetch_assoc()) {
    $itemTotal = $cartItem['qty'] * $cartItem['p_price'];
    $subtotal += $itemTotal;

    $cartItemsHTML .= "
        <div class='cart-item' data-product-id='{$cartItem['p_id']}'>
            <img src='admin_area/product_images/{$cartItem['product_img1']}' alt='{$cartItem['product_title']}'>
            <div class='item-details'>
                <p>{$cartItem['product_title']}</p>
                <p><span class='quantity_vs'>{$cartItem['qty']}</span>x \${$cartItem['p_price']} = \${$itemTotal}</p>
            </div>
        </div>";
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no" />
    <title>Checkout – Moto Dresser</title>
    <?php include 'includes/head-links.php'; ?>
    <style>
        .checkout-container {
            display: flex;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            gap: 20px;
        }

        .checkout-form,
        .cart-summary {
            flex: 1;
            padding: 20px;
            min-width: 300px;
        }

        h1,
        h2 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #333;
        }

        h2 {
            font-size: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .address-selection {
            margin-bottom: 20px;
        }

        .address-selection select {
            width: 100%;
        }

        .add-new-address {
            margin-top: 10px;
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }

        .cart-summary h2 {
            text-align: right;
        }

        .cart-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .cart-item img {
            width: 60px;
            height: 60px;
            margin-right: 15px;
        }

        .item-details p {
            margin: 0;
            color: #666;
        }

        .discount {
            margin: 20px 0;
            text-align: right;
        }

        .discount input {
            width: calc(70% - 10px);
            margin-right: 10px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .discount .apply-btn {
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .totals p {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .total {
            font-weight: bold;
        }

        .pay-now-btn {
            width: 100%;
            padding: 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            font-size: 18px;
        }

        .pay-now-btn:hover {
            background-color: #0056b3;
        }

        .payment-methods {
            margin: 20px 0;
        }

        .payment-methods label {
            display: block;
            margin-bottom: 5px;
            cursor: pointer;
        }

        .payment-methods input {
            margin-right: 10px;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .checkout-container {
                flex-direction: column;
                padding: 10px;
            }

            .checkout-form,
            .cart-summary {
                padding: 10px;
            }

            .cart-summary h2,
            .discount,
            .totals {
                text-align: left;
            }
        }
    </style>
</head>

<body>
    <?php include 'includes/top-bar.php'; ?>
    <div class="page_wrapper">
        <?php include 'includes/header.php'; ?>
        <main class="page_content" style="margin: 140px 0 40px;">
            <section>
                <div class="checkout-container">
                    <div class="checkout-form">
                        <h1>Checkout</h1>
                        <h2>Your Address</h2>
                        <div class="address-selection">
                            <label for="saved-address">Choose a saved address:</label>
                            <select id="saved-address">
                                <?= $addressOptions ?>
                            </select>
                            <div class="add-new-address" onclick="showAddressForm()">+ Add New Address</div>
                        </div>

                        <form id="new-address-form" style="display:none;">
                            <!-- Form for new address -->
                        </form>

                        <h2>Payment Method</h2>
                        <div class="payment-methods">
                            <label>
                                <input type="radio" name="payment-method" value="cod" checked onchange="togglePaymentButton()"> Cash on Delivery (COD)
                            </label>
                            <label>
                                <input type="radio" name="payment-method" value="online" onchange="togglePaymentButton()"> Pay Online (Razorpay)
                            </label>
                        </div>
                    </div>

                    <div class="cart-summary">
                        <h2>Review Your Cart</h2>
                        <?= $cartItemsHTML ?>

                        <!-- Discount Code -->
                        <div class="discount">
                            <input type="text" id="discount-code" placeholder="Enter discount code">
                            <button class="apply-btn" onclick="applyDiscount()">Apply</button>
                        </div>

                        <!-- Subtotal and other totals will be updated dynamically -->
                        <div class="totals" style="margin-top: 40px;">
                            <p>Subtotal: <span id="subtotal">$<?= number_format($subtotal, 2) ?></span></p>
                            <p>Shipping: <span id="shipping">$5.00</span></p>
                            <p>Discount: <span id="discount">-$0.00</span></p>
                            <p class="total">Total: <span id="total">$<?= number_format($subtotal + 5, 2) ?></span></p>
                        </div>
                        <button id="place-order-btn" class="pay-now-btn" onclick="placeOrder()">Place Order</button>
                    </div>

                    <!-- <div class="cart-summary">
                        <h2>Review Your Cart</h2>
                        <?= $cartItemsHTML ?>
                        <p>Total: <span id="total">$<?= number_format($totalAmount, 2) ?></span></p>

                        <button id="place-order-btn" class="pay-now-btn" onclick="placeOrder()">Place Order</button>
                    </div> -->
                </div>
            </section>
        </main>
        <?php include 'includes/footer.php'; ?>
    </div>
    <?php include 'includes/script-links.php'; ?>

    <script>
        function togglePaymentButton() {
            const paymentMethod = document.querySelector('input[name="payment-method"]:checked').value;
            const placeOrderButton = document.getElementById('place-order-btn');

            if (paymentMethod === 'online') {
                placeOrderButton.textContent = 'Pay Now';
                placeOrderButton.setAttribute('onclick', 'payNow()');
            } else {
                placeOrderButton.textContent = 'Place Order';
                placeOrderButton.setAttribute('onclick', 'placeOrder()');
            }
        }

        async function placeOrder() {
            const selectedAddress = document.getElementById('saved-address').value;
            if (!selectedAddress) {
                Swal.fire('Error', 'Please select an address.', 'error');
                return;
            }

            // Place order logic for COD
            console.log('Placing order with COD...');
            const orderDetails = {
                address_id: selectedAddress,
                payment_method: 'COD',
                total_amount: <?= $totalAmount ?>,
                customer_id: <?= $customer_login_id ?>
            };

            try {
                const response = await fetch('confirm_order.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(orderDetails)
                });
                const data = await response.json();

                if (data.success) {
                    Swal.fire('Order Placed', 'Your order has been placed successfully.', 'success')
                        .then(() => {
                            window.location.href = 'my_orders.php';
                        });
                } else {
                    Swal.fire('Order Error', 'Failed to place the order. Please contact support.', 'error');
                }
            } catch (error) {
                console.error('Error confirming order:', error);
                Swal.fire('Order Error', 'There was an error confirming your order.', 'error');
            }
        }

        async function payNow() {
            console.log('Starting online payment...');
            const selectedAddress = document.getElementById('saved-address').value;
            if (!selectedAddress) {
                Swal.fire('Error', 'Please select an address.', 'error');
                return;
            }

            // Gather necessary payment details
            const paymentDetails = {
                total_amount: <?= $totalAmount ?>,
                invoice_no: 'INV' + new Date().getTime(),
                customer_id: <?= $customer_login_id ?>
            };

            try {
                const response = await fetch('initiate_payment.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(paymentDetails)
                });
                const data = await response.json();

                if (data.success) {
                    const options = {
                        key: 'your_razorpay_key_id', // Replace with your Razorpay Key ID
                        amount: paymentDetails.total_amount * 100,
                        currency: 'INR',
                        name: 'Moto Dresser',
                        description: 'Payment for order ' + paymentDetails.invoice_no,
                        order_id: data.order_id,
                        handler: function(response) {
                            confirmPayment(response.razorpay_payment_id);
                        },
                        prefill: {
                            name: 'Your Name', // Prefill user details
                            email: 'your-email@example.com',
                            contact: '9999999999'
                        },
                        theme: {
                            color: '#007bff'
                        }
                    };

                    const rzp = new Razorpay(options);
                    rzp.open();
                } else {
                    Swal.fire('Payment Failed', 'Please try again.', 'error');
                }
            } catch (error) {
                console.error('Error during payment:', error);
                Swal.fire('Payment Error', 'An error occurred while processing your payment.', 'error');
            }
        }
    </script>
</body>

</html>