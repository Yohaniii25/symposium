<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/classes/database.php';
require_once __DIR__ . '/classes/auth.php';

$auth = new Auth();
if (!$auth->isParticipant()) {
    header("Location: login.php");
    exit();
}

$user = $auth->user();

// Set amount
$fees = ['Presenting Author' => 1000, 'Co-Author' => 1500, 'Other Participants' => 5000];
$amount = $fees[$user['type']];

// Generate order ID
$order_id = "GJRTI-" . $user['id'] . "-" . time();

// ------------------- IPG FUNCTION -------------------
function ipg_start($order_id, $amount, $user_id)
{
    $success_url = "https://sltdigital.site/gem/symposium/payment-success.php?orderId=" . $order_id;

    $payload = [
        "apiOperation" => "INITIATE_CHECKOUT",
        "interaction" => [
            "operation" => "PURCHASE",
            "merchant" => [
                "name" => "GJRTI Symposium",
                "url"  => "https://sltdigital.site"
            ],
            "returnUrl" => $success_url
        ],
        "order" => [
            "id"          => $order_id,
            "currency"    => "LKR",
            "amount"      => number_format($amount, 2, '.', ''),  // ← CRITICAL: correct format
            "description" => "GJRTI Symposium Registration"
        ]
    ];

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => 'https://test-bankofceylon.mtf.gateway.mastercard.com/api/rest/version/100/merchant/TEST700182200500/session',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => json_encode($payload),
        CURLOPT_HTTPHEADER     => [
            'Content-Type: application/json',
            'Authorization: Basic bWVyY2hhbnQuVEVTVDcwMDE4MjIwMDUwMDpiMWUzZTE1NjU3MWNlNGFhZTRmNzMzZTVmMWY1MGYyMw=='
        ],
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT        => 30
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error    = curl_error($ch);
    curl_close($ch);

    // DEBUG: Remove this in production
    if ($httpCode !== 200 || $error) {
        die("Gateway connection failed (HTTP $httpCode):<br><pre>" . htmlspecialchars($response ?: $error) . "</pre>");
    }

    $data = json_decode($response, true);

    if (!isset($data['session']['id'])) {
        die("Gateway failed. Response:<br><pre>" . htmlspecialchars(print_r($data, true)) . "</pre>");
    }

    // Save for success page
    $_SESSION['success_indicator'] = $data['successIndicator'];
    $_SESSION['order_id'] = $order_id;
    $_SESSION['amount_paid'] = $amount;
    $_SESSION['user_id_paid'] = $user_id;

    // OUTPUT THE CHECKOUT PAGE
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Processing Payment...</title>
        <script src="https://test-bankofceylon.mtf.gateway.mastercard.com/static/checkout/checkout.min.js"
                data-error="onError" data-cancel="onCancel"></script>
        <script>
            function onError(error) {
                alert("Payment Failed: " + error);
                location.href = "https://sltdigital.site/gem/symposium/proceed-to-pay.php";
            }
            function onCancel() {
                location.href = "https://sltdigital.site/gem/symposium/proceed-to-pay.php";
            }
            Checkout.configure({ session: { id: "' . $data['session']['id'] . '" } });
        </script>
    </head>
    <body style="margin:0; padding:50px; text-align:center; font-family:Arial;">
        <h2>Please wait while we redirect you to the secure payment gateway...</h2>
        <p>If nothing happens, <a href="javascript:Checkout.showPaymentPage()">click here</a>.</p>
        <script>Checkout.showPaymentPage();</script>
    </body>
    </html>';
    exit;
}

// START PAYMENT
ipg_start($order_id, $amount, $user['id']);
?>