<?php
include('header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .contact-info {
            text-align: left;
            margin-bottom: 20px;
        }
        .contact-info h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .contact-info p {
            margin-bottom: 8px;
        }
        .contact-info .icon-link {
            display: block;
            text-decoration: none;
            color: #4CAF50;
            margin-bottom: 5px;
        }
        .contact-info .icon-link:hover {
            text-decoration: underline;
        }
        .icon {
            margin-right: 10px;
        }
        .map-container {
            margin-top: 20px;
            text-align: center;
        }
        .map-container iframe {
            width: 100%;
            height: 400px;
            border: none;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Contact Us</h2>
        
        <div class="contact-info">
            <h3>Address:</h3>
            <p>Librify SMK High, 88450 Kota Kinabalu, Sabah, Malaysia</p>
            <h3>Phone:</h3>
            <p>
                <a href="tel:+60178040316" class="icon-link">
                    <i class="fas fa-phone icon"></i> Head of Librarian
                </a>
            </p>
            <h3>Email:</h3>
            <p>
                <a href="mailto:librify3@gmail.com" class="icon-link">
                    <i class="fas fa-envelope icon"></i> librify3@gmail.com
                </a>
            </p>
            <h3>Instagram:</h3>
            <p>
                <a href="https://www.instagram.com/librify_smk_high?utm_source=qr&igsh=NTRpa2kzbjhzZmtm" target="_blank" class="icon-link">
                    <i class="fab fa-instagram icon"></i> librifyHigh
                </a>
            </p>
        </div>
        
        <p>Feel free to reach out to us via any of the above channels!</p>
    </div>
</body>
</html>
