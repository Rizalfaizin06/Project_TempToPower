<?php
if (!session_id()) {
    session_start();
}
require '../../fungsiAdmin.php';

if ((isset($_POST['filter']) && ! empty($_POST['filter'])) || !empty($_SESSION['filterPeminjaman'])) {
    if (!empty($_POST['filter']) && $_POST['filter'] != $_SESSION['filterPeminjaman']) {
        $filter = $_POST['filter'];
    } else {
        $filter = $_SESSION['filterPeminjaman'];
    }
    // echo $filter;
    if ($filter == '1') {
        if (!isset($_SESSION['tanggalPeminjaman']) || !empty($_POST['tanggal'])) {
            $_SESSION['filterPeminjaman'] = $filter;
            $tgl= date("Y-m-d", strtotime($_POST['tanggal']));
            $_SESSION['tanggalPeminjaman'] = $tgl;
        }
        $tgls = $_SESSION['tanggalPeminjaman'];
        // echo "masuk satu";
            
        $jumlahData = count(query("SELECT * FROM peminjaman WHERE DATE(tanggalPinjam)= '$tgls'"));
        $jumlahDataPerHalaman = 8;
        $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
        $halamanAktif = (isset($_SESSION["SessionHalamanRekapPeminjam"])) ? $_SESSION["SessionHalamanRekapPeminjam"] : 1;
        $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

        // echo $_SESSION['tanggalPeminjaman'];
        echo '<b>Data Peminjam Tanggal '.$tgls.'</b><br /><br />';

        $absen = query("SELECT namaAnggota, namaBuku, tanggalPinjam, tanggalKembali FROM peminjaman P, buku B, mapel M, anggota A WHERE P.RFIDB=B.RFIDB AND B.idBuku=M.idBuku AND P.RFIDP=A.RFIDP AND DATE(tanggalPinjam)= '$tgls' ORDER BY tanggalPinjam DESC, namaAnggota, tanggalKembali LIMIT $awalData, $jumlahDataPerHalaman");

        $query = "SELECT * FROM peminjaman WHERE DATE(tanggalPinjam)='".$tgls."'";
    } elseif ($filter == '2') {
        // echo "masuk";
        if (!isset($_SESSION['bulanTahunPeminjaman']) || !empty($_POST['bulan'])) {
            $_SESSION['filterPeminjaman'] = $filter;
            $bln= $_POST['bulan'];
            $_SESSION['bulanTahunPeminjaman'] = $bln;
        }

        $bln = date("m", strtotime($_SESSION['bulanTahunPeminjaman']));

        $thn = date("Y", strtotime($_SESSION['bulanTahunPeminjaman']));

            
        $jumlahData = count(query("SELECT namaAnggota, namaBuku, tanggalPinjam, tanggalKembali FROM peminjaman P, buku B, mapel M, anggota A WHERE P.RFIDB=B.RFIDB AND B.idBuku=M.idBuku AND P.RFIDP=A.RFIDP AND MONTH(tanggalPinjam)= '$bln' AND YEAR(tanggalPinjam)='$thn'"));
        $jumlahDataPerHalaman = 8;
        $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
        $halamanAktif = (isset($_SESSION["SessionHalamanRekapPeminjam"])) ? $_SESSION["SessionHalamanRekapPeminjam"] : 1;
        $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

        echo '<b>Data Peminjam Bulan '.date("F", strtotime($_SESSION['bulanTahunPeminjaman'])).', Tahun '.$thn.'</b><br /><br />';

        $absen = query("SELECT namaAnggota, namaBuku, tanggalPinjam, tanggalKembali FROM peminjaman P, buku B, mapel M, anggota A WHERE P.RFIDB=B.RFIDB AND B.idBuku=M.idBuku AND P.RFIDP=A.RFIDP AND MONTH(tanggalPinjam)= '$bln' AND YEAR(tanggalPinjam)='$thn' ORDER BY tanggalPinjam DESC, namaAnggota, tanggalKembali LIMIT $awalData, $jumlahDataPerHalaman");

        $query = "SELECT * FROM peminjaman WHERE DATE(tanggalPinjam)='".$bln."'";
    } elseif ($filter == '3') {
        // echo "masuk tahum";
        if (!isset($_SESSION['tahunPeminjaman']) || !empty($_POST['tahun'])) {
            $_SESSION['filterPeminjaman'] = $filter;
            $thn= $_POST['tahun'];
            $_SESSION['tahun'] = $thn;
        }
        $thn = $_SESSION['tahun'];
        // echo $thn;
            
        $jumlahData = count(query("SELECT namaAnggota, namaBuku, tanggalPinjam, tanggalKembali FROM peminjaman P, buku B, mapel M, anggota A WHERE P.RFIDB=B.RFIDB AND B.idBuku=M.idBuku AND P.RFIDP=A.RFIDP AND YEAR(tanggalPinjam)='$thn'"));
        $jumlahDataPerHalaman = 8;
        $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
        $halamanAktif = (isset($_SESSION["SessionHalamanRekapPeminjam"])) ? $_SESSION["SessionHalamanRekapPeminjam"] : 1;
        $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

        echo '<b>Data Peminjam Tahun '.$thn.'</b><br /><br />';

        $absen = query("SELECT namaAnggota, namaBuku, tanggalPinjam, tanggalKembali FROM peminjaman P, buku B, mapel M, anggota A WHERE P.RFIDB=B.RFIDB AND B.idBuku=M.idBuku AND P.RFIDP=A.RFIDP AND YEAR(tanggalPinjam)='$thn' ORDER BY tanggalPinjam DESC, namaAnggota, tanggalKembali LIMIT $awalData, $jumlahDataPerHalaman");

        $query = "SELECT namaAnggota, namaBuku, tanggalPinjam, tanggalKembali FROM peminjaman P, buku B, mapel M, anggota A WHERE P.RFIDB=B.RFIDB AND B.idBuku=M.idBuku AND P.RFIDP=A.RFIDP AND DATE(tanggalPinjam)='".$thn."'";
    } else {
        // echo "masuk semua";
        if (!isset($_SESSION['filterPeminjaman']) || !empty($_POST['filter'])) {
            $_SESSION['filterPeminjaman'] = $filter;
        }
            
        $jumlahData = count(query("SELECT * FROM peminjaman"));
        $jumlahDataPerHalaman = 8;
        $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
        $halamanAktif = (isset($_SESSION["SessionHalamanRekapPeminjam"])) ? $_SESSION["SessionHalamanRekapPeminjam"] : 1;
        $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

        echo '<b>Menampilkan Semua Data</b><br /><br />';

        $absen = query("SELECT namaAnggota, namaBuku, tanggalPinjam, tanggalKembali FROM peminjaman P, buku B, mapel M, anggota A WHERE P.RFIDB=B.RFIDB AND B.idBuku=M.idBuku AND P.RFIDP=A.RFIDP ORDER BY tanggalPinjam DESC, namaAnggota, tanggalKembali LIMIT $awalData, $jumlahDataPerHalaman");

        $query = "SELECT * FROM absensi";
    }
}

?>
<table class="table">

    <tr class="table-dark">
        <th>No.</th>
        <th>Nama</th>
        <th>Buku</th>
        <th>Tanggal</th>
        <th>Status</th>
    </tr>

    <?php
        $i = $awalData + 1;
foreach ($absen as $oneView) : ?>
    <tr class="trLower">
        <td><?= $i;
    $i++?>
        </td>
        <td><?= $oneView["namaAnggota"]; ?>
        </td>
        <td><?= $oneView["namaBuku"]; ?>
        </td>
        <td><?= $oneView["tanggalPinjam"]; ?>
        </td>
        <?= ($oneView["tanggalKembali"] != "0000-00-00")? "<td>Sudah dikembalikan</td>" : "<td style='color: red; font-style: italic;'>Belum dikembalikan</td>" ; ?>


    </tr>
    <?php endforeach;
if ($jumlahData == '0') {
    echo "<tr>
                <td colspan='5' align='center' style='color: red; font-style: italic; font-size: 20px;'>Data tidak ditemukan</td>
            </tr>";
}?>

</table>


<?php if ($jumlahData != 0) :
    echo "Total Data : ". $jumlahData;
endif; ?>


<!-- navigasi -->
<?php $banyakNavigasi = 2;

$awalNavigasi = (($halamanAktif - $banyakNavigasi) < 1)? 1 :$halamanAktif - $banyakNavigasi;

$akhirNavigasi = (($halamanAktif + $banyakNavigasi) > $jumlahHalaman)? $jumlahHalaman :$halamanAktif + $banyakNavigasi;

?>
<nav aria-label="Page navigation example">
    <ul class="pagination">

        <?php if ($halamanAktif > $banyakNavigasi + 1 && $jumlahData !=0) : ?>
        <li class="page-item"><a class="page-link" href="?halamanRekapPeminjam=1">Awal</a>
        </li>
        <?php endif; ?>

        <?php if ($halamanAktif > 1 && $jumlahData !=0) : ?>
        <li class="page-item"><a class="page-link"
                href="?halamanRekapPeminjam=<?= $halamanAktif - 1 ?>">&laquo;</a>
        </li>
        <?php endif; ?>

        <?php for ($i = $awalNavigasi; $i <= $akhirNavigasi; $i++) :
            if ($i == $halamanAktif) :?>
        <li class="page-item"><a class="page-link"
                href="?halamanRekapPeminjam=<?= $i ?>"
                style="font-size: 20px; color: red;"><?= $i ?></a>
        </li>
        <?php else : ?>
        <li class="page-item"><a class="page-link"
                href="?halamanRekapPeminjam=<?= $i ?>"><?= $i ?></a></li>
        <?php endif;?>
        <?php endfor;?>

        <?php if ($halamanAktif < $jumlahHalaman) : ?>
        <li class="page-item"><a class="page-link"
                href="?halamanRekapPeminjam=<?= $halamanAktif + 1 ?>">&raquo;</a>
        </li>

        <?php if ($halamanAktif < $jumlahHalaman - $banyakNavigasi && $jumlahData !=0) : ?>
        <li class="page-item"><a class="page-link"
                href="?halamanRekapPeminjam=<?= $jumlahHalaman ?>">Akhir</a>
        </li>
        <?php endif; ?>

        <?php endif; ?>


    </ul>
</nav>