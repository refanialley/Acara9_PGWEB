<?php
require 'koneksi.php';

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    die("ID tidak valid. <a href='index.php'>Kembali</a>");
}
$id = (int) $_GET['id'];

$stmt = $conn->prepare("DELETE FROM koperasi_provinsi WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $conn->close();
    header("Location: index.php?pesan=hapus");
    exit;
}

echo "Error: " . $stmt->error . "<br><a href='index.php'>Kembali</a>";
$conn->close();