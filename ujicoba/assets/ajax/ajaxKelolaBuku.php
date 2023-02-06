<?php
if (!session_id()) {
    session_start();
}
require '../../fungsiAdmin.php';
?>
<table class="table">
    <?php

if (isset($_POST["btnCariKelBuku"]) || isset($_SESSION['sessionKeywordKelBuku'])) {
    if (isset($_SESSION['sessionKeywordKelBuku'])) {
        if (isset($_POST["KeywordKelBuku"]) && $_SESSION['sessionKeywordKelBuku'] != $_POST["KeywordKelBuku"]) {
            $keywordKelBuku = $_POST['KeywordKelBuku'];
            $_SESSION['sessionKeywordKelBuku'] = $keywordKelBuku;
        } else {
            $keywordKelBuku = $_SESSION['sessionKeywordKelBuku'];
        }
    } else {
        $keywordKelBuku = $_POST['KeywordKelBuku'];
        $_SESSION['sessionKeywordKelBuku'] = $keywordKelBuku;
    }

    $jumlahData = count(query("SELECT RFIDB, mapel.idBuku, namaBuku, status FROM mapel RIGHT JOIN buku ON buku.idBuku = mapel.idBuku WHERE namaBuku LIKE '%$keywordKelBuku%'"));
    $jumlahDataPerHalaman = 5;
    $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);

    $halamanAktif = (isset($_SESSION['sessionHalamanKelolaBuku'])) ? $_SESSION['sessionHalamanKelolaBuku'] : 1;
    $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

    $namaBuku = query("SELECT RFIDB, mapel.idBuku, namaBuku, status FROM mapel RIGHT JOIN buku ON buku.idBuku = mapel.idBuku WHERE namaBuku LIKE '%$keywordKelBuku%' ORDER BY idBuku, status DESC, RFIDB LIMIT $awalData, $jumlahDataPerHalaman");
} else {
    $jumlahData = count(query("SELECT * FROM buku"));
    $jumlahDataPerHalaman = 5;
    $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);

    $halamanAktif = (isset($_SESSION['sessionHalamanKelolaBuku'])) ? $_SESSION['sessionHalamanKelolaBuku'] : 1;
    $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

    $namaBuku = query("SELECT RFIDB, mapel.idBuku, namaBuku, status FROM mapel RIGHT JOIN buku ON buku.idBuku = mapel.idBuku ORDER BY idBuku, status DESC, RFIDB LIMIT $awalData, $jumlahDataPerHalaman");
}








?>
    <thead class="table-dark">
        <tr>
            <th>No.</th>
            <th>RFID</th>
            <th>ID</th>
            <th>Nama Buku</th>
            <th>Status</th>
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
            <td><?= $oneView["RFIDB"]; ?>
            </td>
            <td><?= $oneView["idBuku"]; ?>
            </td>
            <td><?= $oneView["namaBuku"]; ?>
            </td>
            <?php
    if ($oneView["status"] == 1) {
        $stat = 'Tersedia';
    } else {
        $stat = 'Dipinjam';
    }?>
            <td><?= $stat; ?>
            </td>
            <td>
                <a href="ubahBuku.php?rfidb=<?= $oneView["RFIDB"]; ?>"
                    class="btn btn-success">ubah</a>
                <a href="hapusBuku.php?rfidb=<?= $oneView["RFIDB"]; ?>"
                    class="btn btn-danger" onclick="return confirm('yakin?');">hapus</a>
            </td>
        </tr>
        <?php $i++; endforeach;
if ($jumlahData == '0') {
    echo "<tr>
                    <td colspan='6' align='center' style='color: red; font-style: italic; font-size: 20px;'>Tidak ada data Buku</td>
                </tr>";
}
?>
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
        <li class="page-item"><a class="page-link" href="?halamanKelBuku=1">Awal</a>
        </li>
        <?php endif; ?>

        <?php if ($halamanAktif > 1 && $jumlahData !=0) : ?>
        <li class="page-item"><a class="page-link"
                href="?halamanKelBuku=<?= $halamanAktif - 1 ?>">&laquo;</a>
        </li>
        <?php endif; ?>

        <?php for ($i = $awalNavigasi; $i <= $akhirNavigasi; $i++) :
            if ($i == $halamanAktif) :?>
        <li class="page-item"><a class="page-link"
                href="?halamanKelBuku=<?= $i ?>"
                style="font-size: 20px; color: red;"><?= $i ?></a>
        </li>
        <?php else : ?>
        <li class="page-item"><a class="page-link"
                href="?halamanKelBuku=<?= $i ?>"><?= $i ?></a></li>
        <?php endif;?>
        <?php endfor;?>

        <?php if ($halamanAktif < $jumlahHalaman) : ?>
        <li class="page-item"><a class="page-link"
                href="?halamanKelBuku=<?= $halamanAktif + 1 ?>">&raquo;</a>
        </li>

        <?php if ($halamanAktif < $jumlahHalaman - $banyakNavigasi && $jumlahData !=0) : ?>
        <li class="page-item"><a class="page-link"
                href="?halamanKelBuku=<?= $jumlahHalaman ?>">Akhir</a>
        </li>
        <?php endif; ?>

        <?php endif; ?>


    </ul>
</nav>