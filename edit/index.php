<!DOCTYPE html>
<html>
<body>

<h2>Form Edit</h2>

<?php
require '../koneksi.php';

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    die("ID tidak ditemukan. Buka lewat tombol edit di <a href='../index.php'>halaman utama</a>.");
}
$id = (int) $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM koperasi_provinsi WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<form action='edit.php' onsubmit='return validateForm()' method='post'>";

    while ($row = $result->fetch_assoc()) {
        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";

        echo "<label for='prov'>Provinsi:</label><br>";
        echo "<input type='text' id='prov' name='provinsi' value='" . htmlspecialchars($row['provinsi'], ENT_QUOTES) . "'><br>";

        echo "<label for='long'>Longitude:</label><br>";
        echo "<input type='text' id='long' name='longitude' value='" . $row['longitude'] . "'><br>";

        echo "<label for='lat'>Latitude:</label><br>";
        echo "<input type='text' id='lat' name='latitude' value='" . $row['latitude'] . "'><br>";

        echo "<label for='jml'>Jumlah Koperasi:</label><br>";
        echo "<input type='text' id='jml' name='jumlah_koperasi' value='" . $row['jumlah_koperasi'] . "'><br>";

        echo "<label for='tgl'>Tanggal Data:</label><br>";
        echo "<input type='date' id='tgl' name='tanggal_data' value='" . $row['tanggal_data'] . "'><br><br>";
    }

    echo "<input type='submit' value='Submit'> ";
    echo "<a href='../index.php'>Batal</a>";
    echo "</form>";
} else {
    echo "Data tidak ditemukan. <a href='../index.php'>Kembali</a>";
}

$conn->close();
?>

<p id="informasi" style="color:red"></p>

<script>
function validateForm() {
    let prov = document.getElementById("prov").value.trim();
    let lng  = document.getElementById("long").value.trim().replace(",", ".");
    let lat  = document.getElementById("lat").value.trim().replace(",", ".");
    let jml  = document.getElementById("jml").value.trim();
    let tgl  = document.getElementById("tgl").value;
    let text = "";

    if (prov === "") {
        text = "Provinsi tidak boleh kosong.";
    } else if (lng === "" || isNaN(lng) || lng < -180 || lng > 180) {
        text = "Longitude harus angka antara -180 sampai 180.";
    } else if (lat === "" || isNaN(lat) || lat < -90 || lat > 90) {
        text = "Latitude harus angka antara -90 sampai 90.";
    } else if (!/^\d+$/.test(jml)) {
        text = "Jumlah koperasi harus berupa angka bulat dan tidak boleh negatif.";
    } else if (tgl === "") {
        text = "Tanggal data harus diisi.";
    }

    document.getElementById("informasi").innerHTML = text;
    return text === "";
}
</script>

</body>
</html>