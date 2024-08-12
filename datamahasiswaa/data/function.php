<?php
// Koneksi Database
$koneksi = mysqli_connect("localhost", "root", "", "db_mahasiswa");

// Cek Koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Membuat fungsi query dalam bentuk array
function query($query)
{
    global $koneksi;
    $result = mysqli_query($koneksi, $query);

    // Cek jika query gagal
    if (!$result) {
        die("Query gagal: " . mysqli_error($koneksi));
    }

    // Membuat variabel array
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

// Membuat fungsi tambah
function tambah($data)
{
    global $koneksi;

    // Menggunakan prepared statements untuk menghindari SQL injection
    $stmt = $koneksi->prepare("INSERT INTO mahasiswa (nim, nama, kelas, jurusan, semester) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $data['nim'], $data['nama'], $data['kelas'], $data['jurusan'], $data['semester']);

    // Eksekusi statement
    $stmt->execute();

    // Cek apakah ada baris yang terpengaruh
    $affected_rows = $stmt->affected_rows;

    // Tutup statement
    $stmt->close();

    return $affected_rows;
}

// Membuat fungsi hapus
function hapus($nim)
{
    global $koneksi;

    // Menggunakan prepared statements untuk menghindari SQL injection
    $stmt = $koneksi->prepare("DELETE FROM mahasiswa WHERE nim = ?");
    $stmt->bind_param("s", $nim);

    // Eksekusi statement
    $stmt->execute();

    // Cek apakah ada baris yang terpengaruh
    $affected_rows = $stmt->affected_rows;

    // Tutup statement
    $stmt->close();

    return $affected_rows;
}

// Membuat fungsi ubah
function ubah($data)
{
    global $koneksi;

    // Menggunakan prepared statements untuk menghindari SQL injection
    $stmt = $koneksi->prepare("UPDATE mahasiswa SET nama = ?, kelas = ?, jurusan = ?, semester = ? WHERE nim = ?");
    $stmt->bind_param("sssss", $data['nama'], $data['kelas'], $data['jurusan'], $data['semester'], $data['nim']);

    // Eksekusi statement
    $stmt->execute();

    // Cek apakah ada baris yang terpengaruh
    $affected_rows = $stmt->affected_rows;

    // Tutup statement
    $stmt->close();

    return $affected_rows;
}
?>
