<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Security Lesson</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-info">
            <h4 class="alert-heading">Nice Try! 😄</h4>
            <p>You've just attempted a SQL injection attack using: <code>' OR 1=1 --</code></p>
            <p>While this might work on vulnerable systems, this application is protected using:</p>
            <ul>
                <li>Prepared Statements</li>
                <li>Input Validation</li>
                <li>Password Hashing</li>
            </ul>
            <hr>
            <p class="mb-0">Security is important! Always protect your applications against SQL injection attacks.</p>
            <a href="login.php" class="btn btn-primary mt-3">Back to Login</a>
        </div>
    </div>
</body>
</html>