<?php

//koneksi kedatabase
// $koneksi = mysqli_connect("localhost", "id18952921_rizal", ">R(xFzvAW#ln~1YB", "id18952921_krenova");
// $koneksi = mysqli_connect("localhost", "ninb9915_rizal", ">R(xFzvAW#ln~1YB", "ninb9915_Krenova");

$koneksi = mysqli_connect("127.0.0.1", "rizal", "rizal", "db_suhutodaya");

date_default_timezone_set('Asia/Jakarta');
$tanggal = date("Y-m-d");
$jam = date("H:i:s");

if (isset($_POST['Data1']) && !empty($_POST['Data1'])) {
    // absen($_POST);
    if ($_POST['sendMode'] == 'tambahBuku') {
        if (tambahBukuArduino($_POST) > 0) {
            echo "status:BERHASIL|";
        } else {
            echo "status:GAGAL|";
        }
    } elseif ($_POST['sendMode'] == 'tambahAnggota') {
        if (tambahAnggotaArduino($_POST) > 0) {
            echo "status:BERHASIL|";
        } else {
            echo "status:GAGAL|";
        }
    } elseif ($_POST['sendMode'] == 'pinjam') {
        if (pinjam($_POST) > 0) {
            echo "status:BERHASIL|";
        } else {
            echo "status:GAGAL|";
        }
    } elseif ($_POST['sendMode'] == 'kembali') {
        if (kembali($_POST) > 0) {
            echo "status:BERHASIL|";
        } else {
            echo "status:GAGAL|";
        }
    } elseif ($_POST['sendMode'] == 'absen') {
        if (absen($_POST) > 0) {
            echo "status:BERHASIL|";
        } else {
            echo "status:GAGAL|";
        }
    } else {
        echo "status:GAGAL|";
    }
}

//query
function query($query)
{
    global $koneksi;
    $baris = [];
    $result = mysqli_query($koneksi, $query);
    while ($bar = mysqli_fetch_assoc($result)) {
        $baris[] = $bar;
    }
    return $baris;
}

function tambahAnggotaArduino($data)
{
    global $koneksi;
    $RFIDP = $data["Data1"];

    $query = "INSERT INTO anggota VALUES ('$RFIDP', '', '', '')";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function tambahAnggota($data)
{
    global $koneksi;
    $RFIDP = $data["RFIDP"];
    $namaAnggota = $data["namaAnggota"];
    $kelas = $data["kelas"];
    $email = $data["email"];

    $query = "INSERT INTO anggota VALUES ('$RFIDP', '$namaAnggota', '$kelas', '$email')";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function ubahAnggota($data)
{
    global $koneksi;
    $RFIDP = $data["RFIDP"];
    $RFIDPBaru = $data["RFIDPBaru"];
    $namaAnggota = $data["namaAnggota"];
    $kelas = $data["kelas"];
    $email = $data["email"];

    $query = "UPDATE anggota SET RFIDP = '$RFIDPBaru', namaAnggota = '$namaAnggota', kelas = '$kelas', email = '$email' WHERE RFIDP = '$RFIDP'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function hapusAnggota($data)
{
    global $koneksi;

    $query = "DELETE FROM anggota WHERE RFIDP = '$data'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function tambahMapel($data)
{
    global $koneksi;
    $idBuku = $data["idBuku"];
    $namaBuku = $data["namaBuku"];

    $query = "INSERT INTO mapel VALUES ('$idBuku', '$namaBuku')";

    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}

function ubahMapel($data)
{
    global $koneksi;
    $idBuku = $data["idBuku"];
    $idBukuBaru = $data["idBukuBaru"];
    $namaBuku = $data["namaBuku"];
    // //$query = "UPDATE `mapel` SET `namaBuku`='MTK' WHERE idBuku = 'B001'";
    // var_dump($data);
    // die;
    $query = "UPDATE mapel SET namaBuku = '$namaBuku', idBuku = '$idBukuBaru' WHERE idBuku = '$idBuku'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function hapusMapel($data)
{
    global $koneksi;

    $query = "DELETE FROM mapel WHERE idBuku = '$data'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function tambahBuku($data)
{
    global $koneksi;
    $RFIDB = $data["RFIDB"];
    $idBuku = $data["idBuku"];
    $status = $data["status"];

    $query = "INSERT INTO buku VALUES ('$RFIDB', '$idBuku', '$status')";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function tambahBukuArduino($data)
{
    global $koneksi;
    $RFIDB = $data["Data1"];
    if (empty($RFIDB)) {
        return 0;
    }
    $query = "INSERT INTO buku VALUES ('$RFIDB', NULL, 1)";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function ubahBuku($data)
{
    global $koneksi;
    $RFIDB = $data["RFIDB"];
    $RFIDBBaru = $data["RFIDBBaru"];
    $idBuku = $data["idBuku"];
    $status = $data["status"];

    $query = "UPDATE buku SET idBuku = '$idBuku', RFIDB = '$RFIDBBaru', status = '$status' WHERE RFIDB = '$RFIDB'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function hapusBuku($data)
{
    global $koneksi;

    $query = "DELETE FROM buku WHERE RFIDB = '$data'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function pinjam($data)
{
    global $koneksi;
    global $tanggal;
    global $jam;
    $rfidP = $data['Data1'];
    $rfidB = $data['Data2'];
    $Da4 = $data['Data3'];
    $mode = $data['sendMode'];

    mysqli_query($koneksi, "INSERT INTO peminjaman VALUES (NULL, '$rfidP', '$rfidB', '2022-05-02','0000-00-00', 0)");

    mysqli_query($koneksi, "UPDATE buku SET status = 0 WHERE RFIDB = '$rfidB'");
    return mysqli_affected_rows($koneksi);
}

function kembali($data)
{
    global $koneksi;
    global $tanggal;
    global $jam;
    $rfidP = $data['Data1'];
    $rfidB = $data['Data2'];
    $Da4 = $data['Data3'];
    $mode = $data['sendMode'];

    mysqli_query($koneksi, "UPDATE peminjaman, buku SET tanggalKembali='$tanggal', status=1 WHERE peminjaman.RFIDB=buku.RFIDB AND RFIDP='$rfidP' AND buku.RFIDB='$rfidB' AND tanggalKembali='0000-00-00'");
    return mysqli_affected_rows($koneksi);
}

function absen($data)
{
    global $koneksi;
    global $tanggal;
    global $jam;
    $rfidP = $data['Data1'];
    $temp = $data['Data2'];
    $Da4 = $data['Data3'];
    $mode = $data['sendMode'];

    mysqli_query($koneksi, "INSERT INTO absensi VALUES (NULL, '$rfidP', '$tanggal', '$jam','$temp')");

    $nama = query("SELECT namaAnggota FROM anggota WHERE RFIDP = '$rfidP'")[0];
    echo "nama:" . $nama['namaAnggota'] . "|";

    return mysqli_affected_rows($koneksi);
}

function registrasi($data)
{
    global $koneksi;
    $username = strtolower(stripcslashes($data["username"]));
    $password = mysqli_real_escape_string($koneksi, $data["password"]);
    $password2 = mysqli_real_escape_string($koneksi, $data["password2"]);

    $result = mysqli_query($koneksi, "SELECT username FROM users WHERE username = '$username' ");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>
				alert('username sudah ada');
			</script>";
        return false;
    }

    if ($password !== $password2) {
        echo "<script>
				alert('konfirmasi password tidak sesuai');
			</script>";
        return false;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($koneksi, "INSERT INTO users VALUES (NULL, '$username', '$password', 0)");

    return mysqli_affected_rows($koneksi);
}
