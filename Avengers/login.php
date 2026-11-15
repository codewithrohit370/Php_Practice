<?php

    session_start();


$loginMessage = "";

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // 1. Check empty fields
    if (empty($email) || empty($password)) {

        $loginMessage = "Please fill all fields!";

    } else {

        // 2. Find user by email
       $query = "SELECT user_id, full_name, email, password, account_role
          FROM authentication WHERE email = ?";

        $stmt = mysqli_prepare($check, $query);

        if (!$stmt) {
            die("SQL Error: " . mysqli_error($check));
        }

        mysqli_stmt_bind_param($stmt, "s", $email);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        // 3. Check user exists
        if (mysqli_num_rows($result) === 1) {

            $user = mysqli_fetch_assoc($result);

            // 4. Verify password
            if (password_verify($password, $user['password'])) {

                session_regenerate_id(true);

                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['name'] = $user['full_name'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['account_role'];

    if ($user['account_role'] === 'admin') {

        header("Location: Admin.php");
        exit();

    } else {

        header("Location: member-dashboard.php");
        exit();

    }
} else {

                $loginMessage = "Incorrect email or password!";

            }

        } else {

            $loginMessage = "Incorrect email or password!";

        }

        mysqli_stmt_close($stmt);
    }
}

?>
