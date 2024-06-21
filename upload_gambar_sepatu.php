<?php
include 'koneksi.php';

$notification = "";
$notification_type = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target_dir = "uploads/";
    $original_file_name = basename($_FILES["fileToUpload"]["name"]);
    $file_extension = strtolower(pathinfo($original_file_name, PATHINFO_EXTENSION));
    $unique_file_name = uniqid() . '.' . $file_extension;
    $target_file = $target_dir . $unique_file_name;
    $uploadOk = 1;

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $notification = "File bukan gambar.";
        $notification_type = "error";
        $uploadOk = 0;
    }

    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        $notification = "Maaf, ukuran file terlalu besar.";
        $notification_type = "error";
        $uploadOk = 0;
    }

    if ($file_extension != "jpg" && $file_extension != "png" && $file_extension != "jpeg" && $file_extension != "gif") {
        $notification = "Maaf, hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.";
        $notification_type = "error";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        $notification = "Maaf, file tidak diunggah.";
        $notification_type = "error";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $nama_sepatu = $_POST['nama_sepatu'];
            $deskripsi = $_POST['deskripsi'];
            $jenis = $_POST['jenis'];
            $merek = $_POST['merek'];
            $warna = $_POST['warna'];
            $ukuran = $_POST['ukuran'];
            $gambar_sepatu = $unique_file_name;

            $sql = "INSERT INTO sepatu (nama_sepatu, deskripsi, jenis, merek, warna, ukuran, gambar_sepatu) 
                    VALUES ('$nama_sepatu', '$deskripsi', '$jenis', '$merek', '$warna', '$ukuran', '$gambar_sepatu')";

            if ($conn->query($sql) === TRUE) {
                $notification = "Sepatu berhasil ditambahkan.";
                $notification_type = "success";
            } else {
                $notification = "Error: " . $sql . "<br>" . $conn->error;
                $notification_type = "error";
            }
        } else {
            $notification = "Maaf, ada kesalahan saat mengunggah file.<br>Error detail: " . $_FILES["fileToUpload"]["error"];
            $notification_type = "error";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Upload Gambar Sepatu</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
    body {
        background-image: url('image/khn1.png');
        margin: 0;
        padding: 0;
        background-size: cover;
    }

    header {
        background-color: rgba(10, 220, 250);
        padding: 15px 0;
    }

    .navbar {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .navbar a {
        color: #333;
        margin: 0 15px;
        font-size: 18px;
        text-decoration: none;
    }

    .navbar a:hover {
        text-decoration: underline;
    }

    h2 {
        color: #333;
        background: #3ad7e9;
        padding: 10px;
        margin: 15px auto;
        width: 50%;
        text-align: center;
        font-size: 40px;
        border-radius: 100px;
    }

    form input[type="submit"] {
        background: #3ad7e9;
        color: #333;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    form input[type="submit"]:hover {
        background: #aff4fb;
    }

    .notification {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        z-index: 1000;
    }

    .notification.success {
        background: #3ad7e9;
        color: #333;
    }

    .notification.error {
        background: #ff6961;
        color: #333;
    }
    </style>
</head>

<body>

    <header>
        <nav class="navbar">
            <a href="index.php">Home</a>
            <a href="display_sepatu.php">Display</a>
            <a href="upload_gambar_sepatu.php">Upload</a>
        </nav>
    </header>

    <?php if (!empty($notification)): ?>
    <div class="notification <?php echo $notification_type; ?>">
        <?php echo $notification; ?>
    </div>
    <?php endif; ?>

    <h2>Upload Gambar dan Detail Sepatu</h2>
    <div class="container">
        <form action="upload_gambar_sepatu.php" method="post" enctype="multipart/form-data">
            Nama Sepatu: <input type="text" name="nama_sepatu" required><br>
            Deskripsi: <textarea name="deskripsi" required></textarea><br>
            Jenis: <input type="text" name="jenis" required><br>
            Merek: <input type="text" name="merek" required><br>
            Warna: <input type="text" name="warna" required><br>
            Ukuran: <input type="text" name="ukuran" required><br>
            Pilih gambar untuk diunggah:
            <input type="file" name="fileToUpload" id="fileToUpload" required><br>
            <input type="submit" value="Upload Gambar" name="submit">
        </form>
    </div>
</body>

</html>