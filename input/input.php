<?php
require '../koneksi.php';

$provinsi = trim($_POST['provinsi'] ?? '');
$longitude = str_replace(',', '.', trim($_POST['longitude'] ?? ''));
$latitude  = str_replace(',', '.', trim($_POST['latitude'] ?? ''));
$jumlah    = trim($_POST['jumlah_koperasi'] ?? '');
$tanggal   = $_POST['tanggal_data'] ?? '';

// Validasi di sisi server (JavaScript bisa dilewati)
$error = '';
if ($provinsi === '') {
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
    die("Error: $error <br><a href='index.html'>Kembali ke form</a>");
}

$longitude = (float) $longitude;
$latitude  = (float) $latitude;
$jumlah    = (int) $jumlah;

$stmt = $conn->prepare(
    "INSERT INTO koperasi_provinsi (provinsi, longitude, latitude, jumlah_koperasi, tanggal_data)
     VALUES (?, ?, ?, ?, ?)"
);
$stmt->bind_param("sddis", $provinsi, $longitude, $latitude, $jumlah, $tanggal);

if ($stmt->execute()) {
    $conn->close();
    header("Location: ../index.php?pesan=tambah");
    exit;
}

echo "Error: " . $stmt->error . "<br><a href='index.html'>Kembali ke form</a>";
$conn->close();