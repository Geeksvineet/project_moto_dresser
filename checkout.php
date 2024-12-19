<?php
// Assume database connection in $con and session management
session_start();
require 'includes/db.php';

$customer_login_id = $_SESSION['user_id']; // Logged-in customer ID

// Fetch the profile status to check if the user needs to complete their profile
$profileQuery = "SELECT profile_status FROM customer_login WHERE id = ?";
$stmt = $con->prepare($profileQuery);
$stmt->bind_param("i", $customer_login_id);
$stmt->execute();
$profileResult = $stmt->get_result();

if ($profileResult && $profileResult->num_rows > 0) {
    $profile = $profileResult->fetch_assoc();

    // Check if profile_status is 0 (incomplete)
    if ($profile['profile_status'] == 0) {
        header('Location: add_profile');
        exit();
    }
} else {
    // If the query fails or no user is found, redirect to login or error page
    header('Location: Login-page');
    exit();
}

// Fetch the customer details
$customerQuery = "SELECT * FROM customers WHERE customer_login_id = ?";
$stmt = $con->prepare($customerQuery);
$stmt->bind_param("i", $customer_login_id);
$stmt->execute();
$customerResult = $stmt->get_result();
$customer = $customerResult->fetch_assoc();

$addressOptions = "<option value='{$customer['customer_address']}'>{$customer['customer_address']}, {$customer['customer_city']}, {$customer['customer_country']} - {$customer['customer_pincode']}</option>";

// Fetch cart items and calculate subtotal
$cartQuery = "
    SELECT 
        c.qty, 
        c.p_id, 
        c.p_price, 
        p.product_title, 
        MIN(pi.image) AS image,
        c.color,
        c.size,
        p.shipping_charges
    FROM cart AS c
    JOIN products AS p ON c.p_id = p.product_id
    JOIN product_images AS pi ON pi.product_id = c.p_id AND pi.color = c.color
    WHERE c.customer_login_id = ?
    GROUP BY c.p_id, c.qty, c.p_price, p.product_title, c.color, c.size";

$stmt = $con->prepare($cartQuery);
$stmt->bind_param("i", $customer_login_id);
$stmt->execute();
$cartResult = $stmt->get_result();

$subtotal = 0;
$totalShipping = 0; // Initialize total shipping charges
$cartItemsHTML = '';
while ($cartItem = $cartResult->fetch_assoc()) {
    $itemTotal = $cartItem['qty'] * $cartItem['p_price'];
    $subtotal += $itemTotal;

    // Add the shipping charges for this product
    $totalShipping += $cartItem['shipping_charges'];

    $cartItemsHTML .= "
        <div class='cart-item' data-product-id='{$cartItem['p_id']}'>
            <img src='admin_area/product_images/{$cartItem['image']}' alt='{$cartItem['product_title']}'>
            <div class='item-details'>
                <p>{$cartItem['product_title']}</p>
                <p>Color: {$cartItem['color']}</p>
                <p>Size: {$cartItem['size']}</p>
                <p><span class='quantity_vs'>{$cartItem['qty']}</span>x ₹{$cartItem['p_price']} = ₹{$itemTotal}</p>
            </div>
        </div>";
}

// Calculate final total
$total = $subtotal + $totalShipping;

// Prepare data for JavaScript
$shippingCharges = [
    'subtotal' => $subtotal,
    'shipping' => $totalShipping,
    'total' => $total
];

// Pass shipping charges and total to the frontend
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
                    <!-- Address Section -->
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
                            <input type="text" id="new-address" placeholder="Address">
                            <input type="text" id="new-city" placeholder="City">
                            <input type="text" id="new-country" placeholder="Country">
                            <input type="text" id="new-pincode" placeholder="Pincode">
                            <button type="button" onclick="saveNewAddress()" style="color: black; background-color: gray; padding: 10px;">Save Address</button>
                        </form>

                        <!-- Payment Method -->
                        <h2>Payment Method</h2>
                        <div class="payment-methods">
                            <label>
                                <input type="radio" name="payment-method" value="cod" checked> Cash on Delivery (COD)
                            </label>
                            <label>
                                <input type="radio" name="payment-method" value="online"> Pay Online (Razorpay)
                            </label>
                        </div>
                    </div>

                    <!-- Cart Summary Section -->
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
                            <p>Subtotal: <span id="subtotal">₹<?= number_format($subtotal, 2) ?></span></p>
                            <p>Shipping: <span id="shipping-charge">₹<?= number_format($totalShipping, 2) ?></span></p>
                            <p>Discount: <span id="discount">-₹0.00</span></p>
                            <p class="total">Total: <span id="total">₹<?= number_format($total, 2) ?></span></p>
                        </div>
                        <button class="pay-now-btn" onclick="placeOrder()">Place Order</button>
                    </div>
                </div>
            </section>
        </main>
        <?php include 'includes/footer.php'; ?>
    </div>
    <?php include 'includes/script-links.php'; ?>

    <script>
        // Example of dynamically updating totals
        const subtotal = <?= json_encode($shippingCharges['subtotal']) ?>;
        const shipping = <?= json_encode($shippingCharges['shipping']) ?>;
        const total = <?= json_encode($shippingCharges['total']) ?>;

        document.getElementById("subtotal").innerText = "₹" + subtotal.toFixed(2);
        document.getElementById("shipping-charge").innerText = "₹" + shipping.toFixed(2);
        document.getElementById("total").innerText = "₹" + total.toFixed(2);
    </script>

    <script>
        function showAddressForm() {
            document.getElementById('new-address-form').style.display = 'block';
        }

        function saveNewAddress() {
            const address = document.getElementById('new-address').value;
            const city = document.getElementById('new-city').value;
            const country = document.getElementById('new-country').value;
            const pincode = document.getElementById('new-pincode').value;

            // Use AJAX to save the address in the database
            fetch('save_address', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        address,
                        city,
                        country,
                        pincode
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Address changed', 'Address changed Successfully.', 'success')
                            .then(() => {
                                location.reload();
                            });
                        // Reload the page or update the address dropdown dynamically
                    } else {
                        alert('Error saving address');
                    }
                });
        }
    </script>

    <script>
        function applyDiscount() {
            const discountCode = document.getElementById('discount-code').value.trim();
            const subtotal = <?= json_encode($shippingCharges['subtotal']) ?>; // Pass subtotal from PHP to JS
            const total = <?= json_encode($shippingCharges['total']) ?>; // Pass total from PHP to JS

            fetch('validate_coupon.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        code: discountCode,
                        subtotal: subtotal
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let discount = data.amount;

                        // Check if the discount is a percentage (e.g., '10%')
                        if (typeof discount === 'string' && discount.includes('%')) {
                            const percentage = parseFloat(discount.replace('%', '')); // Extract percentage
                            if (!isNaN(percentage) && percentage > 0) {
                                discount = (subtotal * percentage) / 100; // Calculate percentage discount
                            } else {
                                Swal.fire('Error!', 'Invalid discount percentage.', 'error');
                                return;
                            }
                        }

                        // Ensure discount is not greater than the total
                        if (discount > total) {
                            Swal.fire('Error!', 'Discount cannot be greater than the total price.', 'error');
                            return;
                        }

                        // Update the discount display and total
                        document.getElementById('discount').innerText = `-₹${discount.toFixed(2)}`;
                        updateTotal(discount);

                        // Show success alert
                        Swal.fire('Success!', 'Discount applied successfully!', 'success');
                    } else {
                        Swal.fire('Error!', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error applying discount:', error);
                    Swal.fire('Error!', 'Could not apply the discount. Please try again.', 'error');
                });
        }

        // Function to update total after discount
        function updateTotal(discount) {
            const subtotal = <?= json_encode($shippingCharges['subtotal']) ?>;
            const totalShipping = <?= json_encode($shippingCharges['shipping']) ?>;

            const newTotal = subtotal + totalShipping - discount;
            document.getElementById('total').innerText = `₹${newTotal.toFixed(2)}`;
        }
    </script>

    <script>
        async function placeOrder() {
            const paymentMethod = document.querySelector('input[name="payment-method"]:checked').value;
            const address = document.getElementById('saved-address').value;
            const customerId = <?php echo json_encode($_SESSION['user_id']); ?>; // Use the correct session variable

            // Prepare the products ordered array
            const productsOrdered = [];
            const cartItems = document.querySelectorAll('.cart-item');

            // Loop through cart items to gather product IDs, quantities, colors, and sizes
            cartItems.forEach(item => {
                const productId = item.dataset.productId; // Ensure this attribute is correctly set
                const quantityInput = item.querySelector('.quantity_vs');
                const quantity = quantityInput ? parseInt(quantityInput.innerText) : 1; // Default to 1 if quantity is not found

                // Get color and size from the item details
                const color = item.querySelector('p:nth-child(2)').innerText.replace('Color: ', ''); // Assuming color is the second <p>
                const size = item.querySelector('p:nth-child(3)').innerText.replace('Size: ', ''); // Assuming size is the third <p>

                // Push the productId, quantity, color, and size into the productsOrdered array
                productsOrdered.push({
                    productId,
                    quantity,
                    color,
                    size
                });
            });

            // Calculate total amount
            const totalAmount = parseFloat(document.getElementById('total').innerText.replace('₹', '').replace(',', '')); // Remove ₹ and commas

            // Generate a unique invoice number
            const invoiceNo = 'INV-' + Date.now(); // Unique invoice number using timestamp

            // Create the order details object
            const orderDetails = {
                customer_id: customerId,
                total_amount: totalAmount,
                invoice_no: invoiceNo,
                qty: productsOrdered.reduce((sum, item) => sum + item.quantity, 0), // Sum of quantities
                payment_method: paymentMethod,
                products_ordered: JSON.stringify(productsOrdered) // Store as JSON string
            };

            try {
                const response = await fetch('place_order.php', { // Ensure this points to your correct PHP file
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(orderDetails)
                });

                const data = await response.json();

                if (data.success) {
                    // Show success alert
                    Swal.fire('Order placed!', 'Your order has been successfully placed. Invoice No: ' + data.invoice_no, 'success')
                        .then(() => {
                            window.location.href = 'my_orders.php'; // Redirect to the orders page
                        });
                } else {
                    // Show error alert
                    Swal.fire('Error!', data.message || 'There was an error placing your order.', 'error');
                }
            } catch (error) {
                console.error('Error placing order:', error);
                Swal.fire('Error!', 'There was an error placing your order.', 'error');
            }
        }
    </script>

</body>

</html>