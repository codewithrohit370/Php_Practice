
<?php

$signupMessage = "";

if (isset($_POST['signup'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {

        $signupMessage = "Passwords do not match!";

    }

    elseif (strlen($password) < 8) {

        $signupMessage = "Password must be at least 8 characters!";

    }

    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $signupMessage = "Please enter a valid email address!";

    }

    else {

        // 4. Check existing email
        $checkEmail = "SELECT user_id FROM authentication WHERE email = ?";

        $stmt = mysqli_prepare($check, $checkEmail);

        mysqli_stmt_bind_param($stmt, "s", $email);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {

            $signupMessage = "Email already registered!";

        } else {

            // 5. Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // 6. Insert user
            $insertQuery = "INSERT INTO authentication 
                            (full_name, email, password)
                            VALUES (?, ?, ?)";

            $insertStmt = mysqli_prepare($check, $insertQuery);

            mysqli_stmt_bind_param(
                $insertStmt,
                "sss",
                $name,
                $email,
                $hashedPassword
            );

            if (mysqli_stmt_execute($insertStmt)) {

                $signupMessage = "Account created successfully!";

            } else {

                $signupMessage = "Something went wrong. Please try again.";

            }

            mysqli_stmt_close($insertStmt);
        }

        mysqli_stmt_close($stmt);
    }
}
?>
