<?php

require 'directoryReader.php';

// Function to handle image upload
function handleImageUpload($uploadDirectory)
{
    //Max file size 
    $maxFileSize = 1024*1024;
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
        $file = $_FILES['image'];

        // Check for errors during file upload
        if ($file['error'] === UPLOAD_ERR_OK) {
            // Validate file type (allowing only images)
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($file['type'], $allowedTypes)) {
                die('Invalid file type. Only JPEG, PNG, and GIF images are allowed.');
            }

          

            $uploadPath = $uploadDirectory . DIRECTORY_SEPARATOR . $file['name'];

            // Move the uploaded file to the directory
            move_uploaded_file($file['tmp_name'], $uploadPath);

            // Redirect to avoid resubmission on page refresh
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit;
        } else {
            // Handle upload errors if needed
            die('Error during file upload');
        }
    }
}

// Directory where images are stored
$imageDirectory = 'images';

// Handle image upload
handleImageUpload($imageDirectory);

// Read images from the directory
$images = directoryReader($imageDirectory);

if (!$images) {
    die('No images found');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Image Gallery</title>
</head>
<body class="bg-gray-200 p-4">

<div class="max-w-6xl mx-auto">
    <div class="flex item-center justify-between">
        <div class="flex">
            <img class="w-16 h-16" src="logo.png" alt="logo">
            <h1 class="text-2xl mb-8"><strong>PHP Basic Course</strong> <br> Simple Image Gallery</h1>
        </div>

        <!-- Image Upload Form -->
        <form action="index.php" method="post" enctype="multipart/form-data" class="mb-4">
    <label for="imageUpload" class="block text-sm font-medium text-gray-700">Upload Image</label>
    <input type="file" id="imageUpload" name="image" class="mt-1 p-2 border rounded-md" accept="image/jpeg, image/png, image/gif">
    <button type="submit" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">Upload</button>
</form>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 border-t border-gray-300 pt-3">
        <?php foreach ($images as $image) : ?>
            <div>
                <img class="h-auto max-w-full rounded-lg" src="<?php echo $image ?>" alt="">
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
