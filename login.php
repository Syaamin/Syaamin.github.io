<?php include('header.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
            padding: 20px;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #4CAF50;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            display: block;
            text-align: left;
            margin-bottom: 5px;
        }
        input[type=text], input[type=password] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type=submit] {
            background-color: #4CAF50; /* Green color */
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type=submit]:hover {
            background-color: #45a049; /* Darker green color on hover */
        }
        .register-btn {
            display: block;
            margin-top: 10px;
            text-decoration: none;
            color: #333;
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            transition: background-color 0.3s ease;
        }
        .register-btn:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form id="loginForm" method="post" action="login_process.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Login">
        </form>
        
        <!-- Register button -->
        <a href="register.php" class="register-btn">Register</a>
    </div>

    <!-- Script for notification pop-up -->
    <script>
        // Function to show notification
        function showNotification(message) {
            alert(message); // You can replace this with a more sophisticated notification system
        }

        // Example usage: show a welcome message if redirected from registration
        let params = new URLSearchParams(window.location.search);
        if (params.has('registered')) {
            showNotification('Registration successful! You can now login.');
        }
    </script>
</body>
</html>
