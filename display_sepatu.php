<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

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
    width: 25%;
    text-align: center;
    font-size: 40px;
    border-radius: 100px;
}

.container {
    width: 80%;
    margin: 10px auto;
    padding: 20px;
    background: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.shoe-item {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin: 10px;
    width: 300px;
    position: relative;
}

.shoe-item img {
    max-width: 100%;
    height: auto;
    border-radius: 5px;
    margin-bottom: 10px;
}

.shoe-item h3 {
    color: #333;
    margin-top: 0;
}

.shoe-item p {
    margin: 5px 0;
    color: #555;
}

.delete-btn {
    margin-top: 10px;
    text-align: center;
    width: 40%;
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

.header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 15px auto;
    width: 20%;
    text-align: center;
    border-radius: 100px;
}

.search-form {
    display: flex;
    align-items: center;
}

.search-form input[type="text"] {
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.search-form input[type="submit"] {
    background: #3ad7e9;
    color: #333;
    border: none;
    padding: 5px 10px;
    margin-left: 5px;
    border-radius: 5px;
    cursor: pointer;
}

.search-form input[type="submit"]:hover {
    background: #aff4fb;
}
</style>

<body>
    <header>
        <nav class="navbar">
            <a href="index.php">Home</a>
            <a href="display_sepatu.php">Display</a>
            <a href="upload_gambar_sepatu.php">Upload</a>
        </nav>
    </header>

    <h2>Display Sepatu</h2>

    <div class="header-container">
        <div class="search-form">
            <form action="display_sepatu.php" method="get">
                <input type="text" name="search" placeholder="Search...">
                <input type="submit" value="Search">
            </form>
        </div>
    </div>

    <div class="container">
        <?php
        include 'koneksi.php';

        $search = isset($_GET['search']) ? $_GET['search'] : '';

        if ($search) {
            $sql = "SELECT * FROM sepatu WHERE nama_sepatu LIKE '%$search%'";
        } else {
            $sql = "SELECT * FROM sepatu";
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='shoe-item'>";
                echo "<h3>" . $row["nama_sepatu"] . "</h3>";
                echo "<p>Deskripsi: " . $row["deskripsi"] . "</p>";
                echo "<p>Jenis: " . $row["jenis"] . "</p>";
                echo "<p>Merek: " . $row["merek"] . "</p>";
                echo "<p>Warna: " . $row["warna"] . "</p>";
                echo "<p>Ukuran: " . $row["ukuran"] . "</p>";
                echo "<img src='uploads/" . $row["gambar_sepatu"] . "' alt='" . $row["nama_sepatu"] . "'><br>";
                echo "<div class='delete-btn'>";
                echo "<form action='hapus_sepatu.php' method='post'>";
                echo "<input type='hidden' name='id_sepatu' value='" . $row["id_sepatu"] . "'>";
                echo "<input type='hidden' name='gambar_sepatu' value='" . $row["gambar_sepatu"] . "'>";
                echo "<input type='submit' value='Hapus' onclick='return confirm(\"Apakah Anda yakin ingin menghapus sepatu ini?\");'>";
                echo "</form>";
                echo "</div>";
                echo "</div><hr>";
            }
        } else {
            echo "0 hasil";
        }

        $conn->close();
        ?>
    </div>
</body>

</html>