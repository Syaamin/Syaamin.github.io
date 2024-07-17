<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
            padding: 20px;
        }
        .container {
            max-width: 600px;
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
            margin-bottom: 8px;
        }
        input[type=text], input[type=email], input[type=password], select {
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
        .alert {
            padding: 10px;
            margin-top: 10px;
            border-radius: 4px;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .back-link {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            color: #333;
            background-color: #f0f0f0;
            padding: 10px 20px;
            border-radius: 4px;
            border: 1px solid #ccc;
            transition: background-color 0.3s ease;
        }
        .back-link:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="radio-group">
                <label>Select User Type:</label><br>
                    <input type="radio" name="userType" value="student" required> Student
					<input type="radio" name="userType" value="admin" required> Admin
            </div>

            <label for="username">User Name:</label>
            <input type="text" id="username" name="username" required><br><br>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            
            <label for="confirmpassword">Confirm Password:</label>
            <input type="password" id="confirmpassword" name="confirmpassword" required><br><br>
            
            <input type="submit" name="btnsignup" value="Submit">

            <?php
                include("config.php");

                $error_message = "";
                $success_message = "";

                if (isset($_POST['btnsignup'])) {
                    $username = trim($_POST['username']);
                    $email = trim($_POST['email']);
                    $password = trim($_POST['password']);
                    $confirmpassword = trim($_POST['confirmpassword']);
                    $userType = $_POST['userType'];

                    $isValid = true;

                    // Check fields are empty or not
                    if ($username == '' || $email == '' || $password == '' || $confirmpassword == '') {
                        $isValid = false;
                        $error_message = "Please fill all fields.";
                    }

                    // Check if confirm password matching or not
                    if ($isValid && ($password != $confirmpassword)) {
                        $isValid = false;
                        $error_message = "Confirm password not matching";
                    }

                    // Check if Email-ID is valid or not
                    if ($isValid && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $isValid = false;
                        $error_message = "Invalid Email-ID.";
                    }

                    // Insert records
                    if ($isValid) {
                        if ($userType === 'admin') {
                            $insertSQL = "INSERT INTO admin(username, LIB_EMAIL, password) VALUES (?, ?, ?)";
                        } elseif ($userType === 'student') {
                            $insertSQL = "INSERT INTO student(username, STU_EMAIL, password) VALUES (?, ?, ?)";
                        }

                        $stmt = $conn->prepare($insertSQL);

                        if ($userType === 'admin' || $userType === 'student') {
                            $stmt->bind_param("sss", $username, $email, $password); // Store plain-text password
                            $stmt->execute();
                            $stmt->close();

                            $success_message = "Account created successfully.";
                        }
                    }
                }

                // Display Error message
                if (!empty($error_message)) {
                    echo '<div class="alert alert-danger">' . $error_message . '</div>';
                }

                // Display Success message
                if (!empty($success_message)) {
                    echo '<div class="alert alert-success">' . $success_message . '</div>';
                }
            ?>
        </form>

        <!-- Back to Home link -->
        <a href="index.php" class="back-link">Back to Home</a>
    </div>
</body>
</html>
