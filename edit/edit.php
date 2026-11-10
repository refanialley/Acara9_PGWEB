<?php
require '../koneksi.php';

$id        = $_POST['id'] ?? '';
$provinsi  = trim($_POST['provinsi'] ?? '');
$longitude = str_replace(',', '.', trim($_POST['longitude'] ?? ''));
$latitude  = str_replace(',', '.', trim($_POST['latitude'] ?? ''));
$jumlah    = trim($_POST['jumlah_koperasi'] ?? '');
$tanggal   = $_POST['tanggal_data'] ?? '';

$error = '';
if (!ctype_digit((string) $id)) {
    $error = 'ID tidak valid.';
} elseif ($provinsi === '') {
    $error = 'Provinsi tidak boleh kosong.';
} elseif (!is_numeric($longitude) || $longitude < -180 || $longitude > 180) {
    $error = 'Longitude harus angka antara -180 sampai 180.';
} elseif (!is_numeric($latitude) || $latitude < -90 || $latitude > 90) {
    $error = 'Latitude harus angka antara -90 sampai 90.';
} elseif (!ctype_digit($jumlah)) {
    $error = 'Jumlah koperasi harus angka bulat positif.';
} elseif ($tanggal === '') {
    $error = 'Tanggal data harus diisi.';
}

if ($error !== '') {
    die("Error: $error <br><a href='index.php?id=" . (int) $id . "'>Kembali ke form edit</a>");
}

$id        = (int) $id;
$longitude = (float) $longitude;
$latitude  = (float) $latitude;
$jumlah    = (int) $jumlah;

$stmt = $conn->prepare(
    "UPDATE koperasi_provinsi
     SET provinsi = ?, longitude = ?, latitude = ?, jumlah_koperasi = ?, tanggal_data = ?
     WHERE id = ?"
);
$stmt->bind_param("sddisi", $provinsi, $longitude, $latitude, $jumlah, $tanggal, $id);

if ($stmt->execute()) {
    $conn->close();
    header("Location: ../index.php?pesan=edit");
    exit;
}

echo "Error: " . $stmt->error . "<br><a href='index.php?id=$id'>Kembali ke form edit</a>";
$conn->close();