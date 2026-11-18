
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/connection.php';

// 1. Check whether user is logged in
if (empty($_SESSION['user_id'])) {
    header("Location: Avengers.php");
    exit();
}

// 2. Verify actual role from database
$userId = (int) $_SESSION['user_id'];

$stmt = mysqli_prepare(
    $check,
    "SELECT account_role FROM authentication WHERE user_id = ? LIMIT 1"
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

// 3. Allow only admin
if (!$user || $user['account_role'] !== 'admin') {
    header("Location: member-dashboard.php");
    exit();
}

// CSRF protection
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$message = "";

// 4. Insert member
if (isset($_POST['submit'])) {

    if (
        !isset($_POST['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
    ) {
        exit("Invalid request.");
    }

    $member_name = trim($_POST['Mamber_name'] ?? '');
    $game_name = trim($_POST['Game_name'] ?? '');
    $role = trim($_POST['role'] ?? '');
    $age = filter_var($_POST['age'] ?? '', FILTER_VALIDATE_INT);
    $post = trim($_POST['Post'] ?? '');

    if (
        $member_name === '' ||
        $game_name === '' ||
        $role === '' ||
        $age === false ||
        $age < 1 ||
        $post === ''
    ) {
        $message = "Please enter valid member details.";
    }

    elseif (
        !isset($_FILES['image']) ||
        $_FILES['image']['error'] !== UPLOAD_ERR_OK
    ) {
        $message = "Please select a valid image.";
    }

    else {

        $tmp_name = $_FILES['image']['tmp_name'];
        $fileSize = $_FILES['image']['size'];

        // Allow only genuine image formats
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($tmp_name);

        $allowedTypes = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp'
        ];

        if (!isset($allowedTypes[$mime])) {
            $message = "Only JPG, PNG and WEBP images are allowed.";
        }

        elseif ($fileSize > 2 * 1024 * 1024) {
            $message = "Image size must be below 2MB.";
        }

        else {

            $extension = $allowedTypes[$mime];

            // Generate a unique filename
            $image = bin2hex(random_bytes(16)) . '.' . $extension;

            $uploadPath = __DIR__ . '/src/' . $image;

            if (move_uploaded_file($tmp_name, $uploadPath)) {

                // Prepared SQL statement
                $query = "INSERT INTO member
                (Member_name, Game_name, Role, Age, Guild_Post, image_path)
                VALUES (?, ?, ?, ?, ?, ?)";

                $insertStmt = mysqli_prepare($check, $query);

                if ($insertStmt) {

                    mysqli_stmt_bind_param(
                        $insertStmt,
                        "sssiss",
                        $member_name,
                        $game_name,
                        $role,
                        $age,
                        $post,
                        $image
                    );

                    if (mysqli_stmt_execute($insertStmt)) {
                        $message = "Member added successfully!";
                    } else {
                        $message = "Unable to add member.";
                        unlink($uploadPath);
                    }

                    mysqli_stmt_close($insertStmt);

                } else {
                    $message = "Database query error.";
                    unlink($uploadPath);
                }

            } else {
                $message = "Image upload failed.";
            }
        }
    }
}

// Escape output
function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

// Fetch members
$fatch_query = "SELECT * FROM member ORDER BY Member_ID DESC";
$check_query = mysqli_query($check, $fatch_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avengers Admin Panel</title>
</head>

<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #333;
        padding: 8px;
        text-align: center;
    }
</style>

<body>

<h1>Add Member</h1>

<?php if ($message !== ''): ?>
    <p><?php echo e($message); ?></p>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">

    <input type="hidden" name="csrf_token"
           value="<?php echo e($_SESSION['csrf_token']); ?>">

    <label>Enter Name</label>
    <input type="text" name="Mamber_name" required>

    <br><br>

    <label>Enter Game Name</label>
    <input type="text" name="Game_name" required>

    <label>Role</label>
    <select name="role" required>
        <option value="">Select Role</option>
        <option value="Rusher">Rusher</option>
        <option value="Sniper">Sniper</option>
        <option value="Secondary Rusher">Secondary Rusher</option>
        <option value="Nader">Nader</option>
        <option value="All Rounder">All Rounder</option>
    </select>

    <label>Enter Age</label>
    <input type="number" name="age" min="1" required>

    <label>Post</label>
    <select name="Post" required>
        <option value="">Select Post</option>
        <option value="Leader">Leader</option>
        <option value="Acting Leader">Acting Leader</option>
        <option value="Officer">Officer</option>
        <option value="Member">Member</option>
    </select>

    <label>Select Image</label>
    <input type="file" name="image"
           accept=".jpg,.jpeg,.png,.webp" required>

    <button type="submit" name="submit">Submit</button>

</form>

<hr>

<h2>Guild Members</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Member Name</th>
        <th>Game Name</th>
        <th>Role</th>
        <th>Age</th>
        <th>Post</th>
        <th>Image</th>
        <th>Update/Delete</th>
    </tr>

    <?php if ($check_query && mysqli_num_rows($check_query) > 0): ?>

        <?php while ($row = mysqli_fetch_assoc($check_query)): ?>

            <tr>
                <td><?php echo e($row['Member_ID']); ?></td>
                <td><?php echo e($row['Member_name']); ?></td>
                <td><?php echo e($row['Game_name']); ?></td>
                <td><?php echo e($row['Role']); ?></td>
                <td><?php echo e($row['Age']); ?></td>
                <td><?php echo e($row['Guild_Post']); ?></td>

                <td>
                    <img
                        src="src/<?php echo rawurlencode($row['image_path']); ?>"
                        width="40"
                        height="40"
                        alt="Member image">
                </td>

                <td>
                    <a href="update.php?id=<?php echo (int)$row['Member_ID']; ?>">
                        Update
                    </a>

                    /

                    <a href="deleteUser.php?id=<?php echo (int)$row['Member_ID']; ?>">
                        Delete
                    </a>
                </td>
            </tr>

        <?php endwhile; ?>

    <?php else: ?>

        <tr>
            <td colspan="8">No members found.</td>
        </tr>

    <?php endif; ?>

</table>

</body>
</html>
