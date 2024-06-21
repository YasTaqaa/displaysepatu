<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_sepatu = $_POST['id_sepatu'];
    $gambar_sepatu = $_POST['gambar_sepatu'];

    // Hapus data sepatu dari database
    $sql = "DELETE FROM sepatu WHERE id_sepatu = '$id_sepatu'";

    if ($conn->query($sql) === TRUE) {
        // Hapus file gambar dari direktori
        $file_path = "uploads/" . $gambar_sepatu;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        echo "Sepatu berhasil dihapus.<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Redirect kembali ke halaman display_sepatu.php setelah penghapusan
    header("Location: display_sepatu.php");
    exit;
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

</body>

</html>