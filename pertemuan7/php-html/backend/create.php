<?php

require './../config/db.php';

if (isset($_POST['submit'])) {
    global $db_connect;

    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $tempImage = $_FILES['image']['tmp_name'];

    // Tentukan path upload directory
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/upload';
    
    // Buat direktori jika belum ada
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $randomFilename = time() . '-' . md5(rand()) . '-' . $image;
    $uploadPath = $uploadDir . '/' . $randomFilename;

    $upload = move_uploaded_file($tempImage, $uploadPath);

    if ($upload) {
        $query = "INSERT INTO products (name, price, image) VALUES ('$name', '$price', '/upload/$randomFilename')";
        mysqli_query($db_connect, $query);
        
        // Redirect ke halaman sukses
        header("Location: ../success.php?name=" . urlencode($name));
        exit();
    } else {
        echo "Gagal mengunggah produk. Coba lagi.";
    }
}