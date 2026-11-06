
<?php
include_once('connection.php');

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form data
    $member_name = trim($_POST['Mamber_name'] ?? '');
    $game_name   = trim($_POST['Game_name'] ?? '');
    $role        = $_POST['role'] ?? '';
    $age         = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
    $post        = $_POST['Post'] ?? '';

    $image = $_FILES['image'] ?? null;
    $finalImage = $_FILES['cropped_image'] ?? null;


    // Basic validation
    if (
        $member_name === '' ||
        $game_name === '' ||
        $role === '' ||
        $age === false || $age === null || $age < 1 ||
        $post === '' ||
        !$image ||
        $image['error'] !== UPLOAD_ERR_OK ||
        !$finalImage ||
        $finalImage['error'] !== UPLOAD_ERR_OK 
    ) {
        $message = 'Please enter valid details and crop an image.';

    } else {

        // Validate original image
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $originalMime = $finfo->file($image['tmp_name']);

        $allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];

        if (
            !in_array($originalMime, $allowedTypes, true) ||
            $image['size'] > 5 * 1024 * 1024 ||
            getimagesize($image['tmp_name']) === false
        ) {
            $message = 'Select a valid JPG, PNG or WebP image under 5 MB.';

        } else {

            // Validate cropped image
            $finalMime = $finfo->file($finalImage['tmp_name']);
            $dimensions = getimagesize($finalImage['tmp_name']);

            if (
                $finalMime !== 'image/jpeg' ||
                !$dimensions ||
                $dimensions[0] !== 600 ||
                $dimensions[1] !== 600 ||
                $finalImage['size'] > 5 * 1024 * 1024
            ) {
                $message = 'Invalid cropped image. Please crop again.';

            } else {

                // Create upload directory
                $uploadDir = __DIR__ . '/src/members/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                // Generate unique filename
                $filename = bin2hex(random_bytes(16)) . '.jpg';

                $destination = $uploadDir . $filename;

                if (move_uploaded_file($finalImage['tmp_name'], $destination)) {

                    $imagePath = 'members/' . $filename;

                    // Insert member into database
                    $stmt = mysqli_prepare(
                          $check,
                            "INSERT INTO member
                             (Member_name, Game_name, Role, Age, Guild_Post, image_path)
                            VALUES (?, ?, ?, ?, ?, ?)"
                    );

                    if ($stmt) {

                        mysqli_stmt_bind_param(
                            $stmt,
                            'sssiss',
                            $member_name,
                            $game_name,
                            $role,
                            $age,
                            $post,
                            $imagePath,
                        );

                        if (mysqli_stmt_execute($stmt)) {
                            $message = 'Member added successfully!';
                        } else {
                            unlink($destination);
                            $message = 'Database insert failed: ' .
                                mysqli_stmt_error($stmt);
                        }

                        mysqli_stmt_close($stmt);

                    } else {
                        unlink($destination);
                        $message = 'Database query preparation failed.';
                    }

                } else {
                    $message = 'Could not save the uploaded image.';
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Avengers Admin Panel</title>

    <!-- Cropper.js CSS -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css"
    >

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        form {
            max-width: 600px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        input,
        select,
        button {
            padding: 10px;
        }

        button {
            cursor: pointer;
        }

        #crop-area {
            margin: 20px 0;
        }

        #crop-area[hidden] {
            display: none !important;
        }

        .crop-container {
            width: min(100%, 420px);
            height: 420px;
            background: #10141d;
        }

        .crop-container img {
            display: block;
            max-width: 100%;
        }

        .crop-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 12px;
        }

        .message {
            margin: 15px 0;
            padding: 10px;
            background: #eee;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
        }

        table img {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
    </style>
</head>

<body>

    <h1>Add Member</h1>

    <?php if ($message !== ''): ?>
        <p class="message">
            <?php echo htmlspecialchars($message); ?>
        </p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" id="member-form">

        <label>Enter Name</label>
        <input type="text" name="Mamber_name" required>

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

        <label for="image">Select Image</label>

        <input
            type="file"
            id="image"
            name="image"
            accept="image/jpeg,image/png,image/webp"
            required
        >

        <!-- Crop area -->
        <div id="crop-area" hidden>

            <h3>Crop Your Image</h3>

            <div class="crop-container">
                <img id="crop-preview" alt="Image preview">
            </div>

            <div class="crop-buttons">
                <button type="button" id="zoom-in">
                    Zoom In +
                </button>

                <button type="button" id="zoom-out">
                    Zoom Out -
                </button>

                <button type="button" id="reset-crop">
                    Reset
                </button>
            </div>

        </div>

        <!-- Cropped image will be attached by JavaScript -->
        <input
            type="file"
            name="cropped_image"
            id="cropped_image"
            hidden
        >

        <button type="submit" name="submit" id="submit-btn">
            Submit
        </button>

    </form>


    <!-- Members table -->
    <h2>All Members</h2>

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

        <?php

        $fetch_query = "SELECT * FROM member ORDER BY Member_ID DESC";
        $check_query = mysqli_query($check, $fetch_query);

        if ($check_query && mysqli_num_rows($check_query) > 0) {

            while ($row = mysqli_fetch_assoc($check_query)) {

        ?>

            <tr>

                <td>
                    <?php echo htmlspecialchars($row['Member_ID']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($row['Member_name']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($row['Game_name']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($row['Role']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($row['Age']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($row['Guild_Post']); ?>
                </td>

                <td>
                    <img
                        src="src/<?php echo htmlspecialchars($row['image_path']); ?>"
                        alt="Member image"
                    >
                </td>

                <td>
                    <a href="update.php?id=<?php echo urlencode($row['Member_ID']); ?>">
                        Update
                    </a>

                    /

                    <a href="deleteUser.php?id=<?php echo urlencode($row['Member_ID']); ?>">
                        Delete
                    </a>
                </td>

            </tr>

        <?php
            }

        } else {
            echo '<tr><td colspan="8">No members found.</td></tr>';
        }

        ?>

    </table>


    <!-- Cropper.js JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

    <script>

        const imageInput = document.getElementById('image');
        const cropPreview = document.getElementById('crop-preview');
        const cropArea = document.getElementById('crop-area');

        const form = document.getElementById('member-form');
        const croppedInput = document.getElementById('cropped_image');
        const submitBtn = document.getElementById('submit-btn');

        let cropper = null;
        let imageURL = null;
        let isPreparing = false;


        // Image selection
        imageInput.addEventListener('change', function () {

            const file = this.files[0];

            if (!file) return;

            if (!file.type.startsWith('image/')) {
                alert('Please select an image.');
                this.value = '';
                return;
            }

            if (cropper) {
                cropper.destroy();
                cropper = null;
            }

            if (imageURL) {
                URL.revokeObjectURL(imageURL);
            }

            croppedInput.value = '';

            imageURL = URL.createObjectURL(file);

            cropPreview.onload = function () {

                cropper = new Cropper(cropPreview, {

                    aspectRatio: 1,
                    viewMode: 1,
                    dragMode: 'move',
                    autoCropArea: 0.8,

                    responsive: true,
                    background: false,

                    zoomOnWheel: true,
                    movable: true,
                    zoomable: true,

                    cropBoxMovable: false,
                    cropBoxResizable: false

                });

            };

            cropPreview.src = imageURL;
            cropArea.hidden = false;

        });


        // Zoom in
        document.getElementById('zoom-in').addEventListener('click', function () {

            if (cropper) {
                cropper.zoom(0.1);
            }

        });


        // Zoom out
        document.getElementById('zoom-out').addEventListener('click', function () {

            if (cropper) {
                cropper.zoom(-0.1);
            }

        });


        // Reset crop
        document.getElementById('reset-crop').addEventListener('click', function () {

            if (cropper) {
                cropper.reset();
            }

        });


        // Form submit
        form.addEventListener('submit', function (event) {

            if (!cropper || isPreparing) {
                event.preventDefault();

                if (!cropper) {
                    alert('Please select an image first.');
                }

                return;
            }

            event.preventDefault();

            isPreparing = true;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Preparing Image...';


            // Generate final square image
            const canvas = cropper.getCroppedCanvas({

                width: 600,
                height: 600,

                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high'

            });


    canvas.toBlob(function (blob) {

    if (!blob) {
        alert("Image cropping failed!");

        isPreparing = false;
        submitBtn.disabled = false;
        submitBtn.textContent = "Submit";

        return;
    }

    const file = new File(
        [blob],
        "cropped-image.jpg",
        { type: "image/jpeg" }
    );

    const dataTransfer = new DataTransfer();
    dataTransfer.items.add(file);

    croppedInput.files = dataTransfer.files;

    console.log("2. Cropped file attached:", croppedInput.files[0]);

    submitBtn.textContent = "Uploading...";

    HTMLFormElement.prototype.submit.call(form);

}, "image/jpeg", 0.90);

        });

    </script>

</body>
</html>
