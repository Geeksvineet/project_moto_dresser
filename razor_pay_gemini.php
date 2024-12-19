<?php
// Razorpay keys (ideally, store these in an environment variable or configuration file)
$key_id = "rzp_test_DfhbmLCnKJDWxO";
$key_secret = "YFZxjAWfyFyJidZXbXLu2UN0";

// Function to create an order
function createOrder($amount) {
    global $key_id, $key_secret;

    // Set up the request to Razorpay's API
    $url = 'https://api.razorpay.com/v1/orders';
    $fields = json_encode([
        "amount" => $amount * 100, // Amount in paise (smallest currency unit)
        "currency" => "INR",
        "receipt" => "order_rcptid_11"
    ]);

    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_USERPWD, "$key_id:$key_secret");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

    // Execute the request and get the response
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        // Handle error
        echo 'Request Error:' . curl_error($ch);
    }

    // Close cURL session
    curl_close($ch);

    // Decode the response and return
    return json_decode($response, true);
}

// Fetch the amount from the POST request
$amount = 300;

if ($amount) {
    // Create the order
    $order = createOrder($amount);

    // Return the response as JSON
    header('Content-Type: application/json');
    echo json_encode([
        "success" => true,
        "amount" => $amount,
        "order" => $order
    ]);
} else {
    // Handle missing amount
    echo json_encode([
        "success" => false,
        "message" => "Amount not provided"
    ]);
}
?>
