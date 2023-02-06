<?php
if (!session_id()) {
    session_start();
}
require '../../fungsiAdmin.php';
?>
<table class="table">

    <?php

if (isset($_POST["btnCariKelAnggota"]) || isset($_SESSION['sessionKeywordKelAnggota'])) {
    if (isset($_SESSION['sessionKeywordKelAnggota'])) {
        if (isset($_POST["KeywordKelAnggota"]) && $_SESSION['sessionKeywordKelAnggota'] != $_POST["KeywordKelAnggota"]) {
            $keywordKelAnggota = $_POST['KeywordKelAnggota'];
            $_SESSION['sessionKeywordKelAnggota'] = $keywordKelAnggota;
        } else {
            $keywordKelAnggota = $_SESSION['sessionKeywordKelAnggota'];
        }
    } else {
        $keywordKelAnggota = $_POST['KeywordKelAnggota'];
        $_SESSION['sessionKeywordKelAnggota'] = $keywordKelAnggota;
    }

    $jumlahData = count(query("SELECT RFIDP, namaAnggota, kelas, email FROM anggota WHERE namaAnggota LIKE '%$keywordKelAnggota%'"));
    $jumlahDataPerHalaman = 5;
    $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);

    $halamanAktif = (isset($_SESSION['sessionHalamanKelolaAnggota'])) ? $_SESSION['sessionHalamanKelolaAnggota'] : 1;
    $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

    $namaBuku = query("SELECT RFIDP, namaAnggota, kelas, email FROM anggota WHERE namaAnggota LIKE '%$keywordKelAnggota%' ORDER BY namaAnggota LIMIT $awalData, $jumlahDataPerHalaman");
} else {
    $jumlahData = count(query("SELECT RFIDP, namaAnggota, kelas, email FROM anggota"));
    $jumlahDataPerHalaman = 5;
    $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);

    $halamanAktif = (isset($_SESSION['sessionHalamanKelolaAnggota'])) ? $_SESSION['sessionHalamanKelolaAnggota'] : 1;
    $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

    $namaBuku = query("SELECT RFIDP, namaAnggota, kelas, email FROM anggota ORDER BY namaAnggota LIMIT $awalData, $jumlahDataPerHalaman");
}

?>

    <thead class="table-dark">
        <tr>
            <th>No.</th>
            <th>RFIDP</th>
            <th>Nama Anggota</th>
            <th>Kelas</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php

$i = $awalData + 1;
foreach ($namaBuku as $oneView) : ?>
        <tr>
            <td><?= $i; ?>
            </td>
            <td><?= $oneView["RFIDP"]; ?>
            </td>
            <td><?= $oneView["namaAnggota"]; ?>
            </td>
            <td><?= $oneView["kelas"]; ?>
            </td>
            <td><?= $oneView["email"]; ?>
            </td>
            <td>
                <a href="ubahAnggota.php?rfidp=<?= $oneView["RFIDP"]; ?>"
                    class="btn btn-success">ubah</a>
                <a href="hapusAnggota.php?rfidp=<?= $oneView["RFIDP"]; ?>"
                    class="btn btn-danger" onclick="return confirm('yakin?');">hapus</a>
            </td>
        </tr>
        <?php $i++; endforeach;
if ($jumlahData == '0') {
    echo "<tr>
                            <td colspan='6' align='center' style='color: red; font-style: italic; font-size: 20px;'>Tidak ada data Anggota</td>
                        </tr>";
}?>
    </tbody>
</table>

<?php if ($jumlahData != 0) :
    echo "Total Buku : ". $jumlahData;
endif; ?>

<!-- navigasi -->
<?php $banyakNavigasi = 2;

$awalNavigasi = (($halamanAktif - $banyakNavigasi) < 1)? 1 :$halamanAktif - $banyakNavigasi;

$akhirNavigasi = (($halamanAktif + $banyakNavigasi) > $jumlahHalaman)? $jumlahHalaman :$halamanAktif + $banyakNavigasi;

?>
<nav aria-label="Page navigation example">
    <ul class="pagination">

        <?php if ($halamanAktif > $banyakNavigasi + 1 && $jumlahData !=0) : ?>
        <li class="page-item"><a class="page-link" href="?halamanKelAnggota=1">Awal</a>
        </li>
        <?php endif; ?>

        <?php if ($halamanAktif > 1 && $jumlahData !=0) : ?>
        <li class="page-item"><a class="page-link"
                href="?halamanKelAnggota=<?= $halamanAktif - 1 ?>">&laquo;</a>
        </li>
        <?php endif; ?>

        <?php for ($i = $awalNavigasi; $i <= $akhirNavigasi; $i++) :
            if ($i == $halamanAktif) :?>
        <li class="page-item"><a class="page-link"
                href="?halamanKelAnggota=<?= $i ?>"
                style="font-size: 20px; color: red;"><?= $i ?></a>
        </li>
        <?php else : ?>
        <li class="page-item"><a class="page-link"
                href="?halamanKelAnggota=<?= $i ?>"><?= $i ?></a></li>
        <?php endif;?>
        <?php endfor;?>

        <?php if ($halamanAktif < $jumlahHalaman) : ?>
        <li class="page-item"><a class="page-link"
                href="?halamanKelAnggota=<?= $halamanAktif + 1 ?>">&raquo;</a>
        </li>

        <?php if ($halamanAktif < $jumlahHalaman - $banyakNavigasi && $jumlahData !=0) : ?>
        <li class="page-item"><a class="page-link"
                href="?halamanKelAnggota=<?= $jumlahHalaman ?>">Akhir</a>
        </li>
        <?php endif; ?>

        <?php endif; ?>


    </ul>
</nav>