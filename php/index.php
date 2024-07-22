<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $from_currency = $_POST['from_currency'];
        $to_currency = $_POST['to_currency'];
        $amount = $_POST['amount'];

        // Fetching JSON from the exchange rate API
        $req_url = "https://v6.exchangerate-api.com/v6/5e1dc264f4d2a6d98d4aaa83/latest/$from_currency";
        $response_json = file_get_contents($req_url);

        // Continuing if we got a result
        if (false !== $response_json) {
            // Try/catch for json_decode operation
            try {
                // Decoding
                $response = json_decode($response_json);

                // Check for success
                if ('success' === $response->result) {
                    // Calculate the converted amount
                    $converted_amount = round(($amount * $response->conversion_rates->$to_currency), 2);
                    echo "<h1>Converted Amount: $converted_amount $to_currency</h1>";
                } else {
                    echo "<h1>Failed to fetch conversion rate. Please try again later.</h1>";
                }
            } catch (Exception $e) {
                echo "<h1>Failed to parse response. Please try again later.</h1>";
            }
        } else {
            echo "<h1>Failed to fetch conversion rate. Please try again later.</h1>";
        }
    } else {
        echo "<h1>Invalid request method.</h1>";
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currency Converter</title>
</head>
<body>
<h1>Currency Converter</h1>
<form action="index.php" method="post">
    <label for="from_currency">From Currency:</label>
    <select id="from_currency" name="from_currency" required>
        <option value="USD">USD</option>
        <option value="EUR">EUR</option>
        <option value="GBP">GBP</option>
        <!-- Add more currency options as needed -->
    </select>
    <br>
    <label for="to_currency">To Currency:</label>
    <select id="to_currency" name="to_currency" required>
        <option value="USD">USD</option>
        <option value="EUR">EUR</option>
        <option value="GBP">GBP</option>
        <!-- Add more currency options as needed -->
    </select>
    <br>
    <label for="amount">Amount:</label>
    <input type="number" id="amount" name="amount" step="0.01" required>
    <br>
    <button type="submit">Convert</button>
</form>
</body>
</html>

