<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>🚩 CTF Hint</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            background: #1a1a1a;
            color: #00ff00;
            font-family: monospace;
            padding: 20px;
        }
        .terminal {
            background: #000;
            padding: 20px;
            border-radius: 5px;
            border: 1px solid #00ff00;
        }
        .blink {
            animation: blink 1s infinite;
        }
        @keyframes blink {
            50% { opacity: 0; }
        }
        .comment {
            color: #666;
        }
    </style>
</head>
<body>
    <div class="terminal">
        <pre>
CTF_DB>
[!] HINT RETRIEVED:
----------------------------------------
Check out /create_product.php...
Something seems off about how it handles input.
Maybe try looking at ...?
----------------------------------------

<!-- Dev Note: Need to patch that parameter validation... -->
<!-- TODO: Remove GET method from product creation -->

[<span class="blink">█</span>] Good luck, hacker...
        </pre>
    </div>
</body>
</html>