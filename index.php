<?php
require 'koneksi.php';

$sql    = "SELECT * FROM koperasi_provinsi ORDER BY jumlah_koperasi DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<body>

<h2>Koperasi Desa/Kelurahan Merah Putih per Provinsi</h2>
<p>Sumber: Dashboard Simkopdes (data per 21 Juli 2026)</p>

<?php
if (isset($_GET['pesan'])) {
    $daftar = [
        'tambah' => 'Data berhasil ditambahkan.',
        'edit'   => 'Data berhasil diupdate.',
        'hapus'  => 'Data berhasil dihapus.',
    ];
    if (isset($daftar[$_GET['pesan']])) {
        echo "<p style='color:green'>" . $daftar[$_GET['pesan']] . "</p>";
    }
}

echo "<a href='input/index.html'>Input</a><br><br>";

if ($result->num_rows > 0) {
    echo "<table border='1px' cellpadding='5'><tr>
            <th>Provinsi</th>
            <th>Longitude</th>
            <th>Latitude</th>
            <th>Jumlah Koperasi</th>
            <th>Tanggal Data</th>
            <th colspan='2'>Aksi</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row["provinsi"]) . "</td>
                <td>" . $row["longitude"] . "</td>
                <td>" . $row["latitude"] . "</td>
                <td align='right'>" . number_format($row["jumlah_koperasi"], 0, ',', '.') . "</td>
                <td>" . date('d-m-Y', strtotime($row["tanggal_data"])) . "</td>
                <td><a href='delete.php?id=" . $row["id"] . "'
                       onclick=\"return confirm('Yakin hapus data ini?')\">hapus</a></td>
                <td><a href='edit/index.php?id=" . $row["id"] . "'>edit</a></td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();
?>

</body>
</html>