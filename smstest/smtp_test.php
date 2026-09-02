<?php

$tests = [
    [
        'name' => 'SMTP 587 STARTTLS',
        'host' => 'smtp.gmail.com',
        'port' => 587,
        'prefix' => '',
    ],
    [
        'name' => 'SMTP 465 SSL',
        'host' => 'smtp.gmail.com',
        'port' => 465,
        'prefix' => 'ssl://',
    ],
    [
        'name' => 'SMTP 25',
        'host' => 'localhost',
        'port' => 25,
        'prefix' => '',
    ],
    [
        'name' => 'SMTP 465',
        'host' => 'smtpout.secureserver.net',
        'port' => 465,
        'prefix' => '',
    ],
];

foreach ($tests as $test) {

    echo "<hr>";
    echo "<h3>{$test['name']}</h3>";

    $start = microtime(true);

    $connection = @fsockopen(
        $test['prefix'] . $test['host'],
        $test['port'],
        $errno,
        $errstr,
        20
    );

    $time = round(microtime(true) - $start, 2);

    if ($connection) {

        echo "Status: ✅ CONNECTED<br>";
        echo "Host: {$test['host']}<br>";
        echo "Port: {$test['port']}<br>";
        echo "Time: {$time} seconds<br>";

        $response = fgets($connection, 512);

        echo "Server response: <br>";
        echo "<pre>" .
            htmlspecialchars($response) .
            "</pre>";

        fclose($connection);

    } else {

        echo "Status: ❌ FAILED<br>";
        echo "Host: {$test['host']}<br>";
        echo "Port: {$test['port']}<br>";
        echo "Error: {$errno} - " .
            htmlspecialchars($errstr);
    }
}