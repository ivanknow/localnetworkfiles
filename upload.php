<?php
$uploadDirectory = 'uploads/'; // Specify the directory where you want to save the uploaded files

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = $_FILES['file'];

    // Check for errors during file upload
    if ($file['error'] === UPLOAD_ERR_OK) {
        $fileName = $file['name'];
        $destination = $_POST['folder']."/". $fileName;

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            echo "File uploaded successfully to $destination!";
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "File upload error: " . $file['error'] ;
    }

    echo "<h2><a href='index.html'>VOLTAR</a></h2>";
}
?>
