<?php 
include '../koneksi.php';

$nama  = $_POST['nama'];
$barang = $_POST['barang'];
$jumlah = $_POST['jumlah'];
$tgl_pinjam = $_POST['tgl_pinjam'];
$tgl_kembali = $_POST['tgl_kembali'];
$kondisi = $_POST['kondisi'];
$status = $_POST['status'];

// Handle file upload
if (isset($_FILES['bukti']) && $_FILES['bukti']['error'] == UPLOAD_ERR_OK) {
    $upload_dir = '../gambar/pinjam/';
    $original_file_name = pathinfo($_FILES['bukti']['name'], PATHINFO_FILENAME);
    $file_extension = pathinfo($_FILES['bukti']['name'], PATHINFO_EXTENSION);

    // Generate a unique hashed file name
    $file_name = hash('sha256', $original_file_name . time()) . '.' . $file_extension;
    $file_path = $upload_dir . $file_name;

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES['bukti']['tmp_name'], $file_path)) {
        $bukti = $file_name;
    } else {
        $bukti = null; // Handle error if file move fails
    }
} else {
    $bukti = null; // Handle error if file upload fails
}

// Insert data into the database
mysqli_query($koneksi, "INSERT INTO pinjam (pinjam_peminjam, pinjam_barang, pinjam_jumlah, pinjam_tgl_pinjam, pinjam_tgl_kembali, pinjam_kondisi, pinjam_status, bukti) 
VALUES ('$nama', '$barang', '$jumlah', '$tgl_pinjam', '$tgl_kembali', '$kondisi', '$status', '$bukti')");

header("location:peminjaman.php");
