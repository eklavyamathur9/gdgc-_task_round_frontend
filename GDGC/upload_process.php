<?php
// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Directory to store uploaded files
    $uploadDir = 'uploads/';
    
    // Ensure the uploads directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Get form data
    $title = htmlspecialchars($_POST['title']);
    $author = htmlspecialchars($_POST['author']);
    $file = $_FILES['file'];

    // Validate the file
    if ($file['error'] === 0) {
        // Ensure the file is a PDF
        $fileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if ($fileType === 'pdf') {
            // Create a unique file name
            $fileName = uniqid('paper_') . '.pdf';
            $filePath = $uploadDir . $fileName;

            // Move the file to the uploads directory
            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                echo "<p>File uploaded successfully!</p>";
                echo "<p>Title: $title</p>";
                echo "<p>Author: $author</p>";
                echo "<p><a href='$filePath' target='_blank'>View Uploaded Paper</a></p>";
            } else {
                echo "<p>Error: Unable to save the file.</p>";
            }
        } else {
            echo "<p>Error: Only PDF files are allowed.</p>";
        }
    } else {
        echo "<p>Error: File upload failed.</p>";
    }
} else {
    echo "<p>Error: Invalid request.</p>";
}
?>
