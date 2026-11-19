
<?php

session_start();

require_once __DIR__ . '/connection.php';

// 1. Check login
if (empty($_SESSION['user_id'])) {
    header("Location: Avengers.php");
    exit();
}


// 2. Verify admin role from database
$userId = (int) $_SESSION['user_id'];

$stmt = mysqli_prepare(
    $check,
    "SELECT account_role FROM authentication
     WHERE user_id = ? LIMIT 1"
);

if (!$stmt) {
    http_response_code(500);
    exit("Database error.");
}

mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

// 3. Only admin can delete
if (!$user || $user['account_role'] !== 'admin') {
    header("Location: member-dashboard.php");
    exit();
}

// 4. Allow POST only
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: admin.php");
    exit();
}

// 5. CSRF verification
if (
    empty($_POST['csrf_token']) ||
    empty($_SESSION['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    http_response_code(403);
    exit("Invalid request.");
}

// 6. Validate member ID
$member_id = filter_input(
    INPUT_POST,
    'id',
    FILTER_VALIDATE_INT
);

if (!$member_id || $member_id <= 0) {
    header("Location: admin.php");
    exit();
}

// 7. Delete using prepared statement
$delete_query = "DELETE FROM member WHERE Member_ID = ?";

$deleteStmt = mysqli_prepare($check, $delete_query);

if (!$deleteStmt) {
    http_response_code(500);
    exit("Database query error.");
}

mysqli_stmt_bind_param($deleteStmt, "i", $member_id);

if (mysqli_stmt_execute($deleteStmt)) {
    header("Location: admin.php");
    exit();
} else {
    echo "Data not deleted.";
}

mysqli_stmt_close($deleteStmt);

?>
