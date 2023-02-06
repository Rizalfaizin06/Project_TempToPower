<?php
if (!session_id()) {
    session_start();
}
require '../../fungsiAdmin.php';
?>
<table class="table">
    <?php

if (isset($_POST["btnCariKelMapel"]) || isset($_SESSION['sessionKeywordKelMapel'])) {
    if (isset($_SESSION['sessionKeywordKelMapel'])) {
        if (isset($_POST["KeywordKelMapel"]) && $_SESSION['sessionKeywordKelMapel'] != $_POST["KeywordKelMapel"]) {
            $keywordKelMapel = $_POST['KeywordKelMapel'];
            $_SESSION['sessionKeywordKelMapel'] = $keywordKelMapel;
        } else {
            $keywordKelMapel = $_SESSION['sessionKeywordKelMapel'];
        }
    } else {
        $keywordKelMapel = $_POST['KeywordKelMapel'];
        $_SESSION['sessionKeywordKelMapel'] = $keywordKelMapel;
    }

    $jumlahData = count(query("SELECT RFIDB, mapel.idBuku, namaBuku, COUNT(case when status = 1 then RFIDB end) stock FROM mapel LEFT JOIN buku ON buku.idBuku = mapel.idBuku GROUP BY mapel.idBuku HAVING namaBuku LIKE '%$keywordKelMapel%'"));
    $jumlahDataPerHalaman = 5;
    $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);

    $halamanAktif = (isset($_SESSION['sessionHalamanKelolaMapel'])) ? $_SESSION['sessionHalamanKelolaMapel'] : 1;
    $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

    $namaBuku = query("SELECT RFIDB, mapel.idBuku, namaBuku, COUNT(case when status = 1 then RFIDB end) stock FROM mapel LEFT JOIN buku ON buku.idBuku = mapel.idBuku GROUP BY mapel.idBuku HAVING namaBuku LIKE '%$keywordKelMapel%' ORDER BY namaBuku LIMIT $awalData, $jumlahDataPerHalaman");
} else {
    $jumlahData = count(query("SELECT RFIDB, mapel.idBuku, namaBuku, COUNT(case when status = 1 then RFIDB end) stock FROM mapel LEFT JOIN buku ON buku.idBuku = mapel.idBuku GROUP BY mapel.idBuku"));
    $jumlahDataPerHalaman = 5;
    $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);

    $halamanAktif = (isset($_SESSION['sessionHalamanKelolaMapel'])) ? $_SESSION['sessionHalamanKelolaMapel'] : 1;
    $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

    // $namaBuku = query("SELECT RFIDB, mapel.idBuku, namaBuku, COUNT(case when status = 1 then RFIDB end) stock FROM mapel LEFT JOIN buku ON buku.idBuku = mapel.idBuku GROUP BY mapel.idBuku");
    
    $namaBuku = query("SELECT RFIDB, mapel.idBuku, namaBuku, COUNT(case when status = 1 then RFIDB end) stock FROM mapel LEFT JOIN buku ON buku.idBuku = mapel.idBuku GROUP BY mapel.idBuku ORDER BY namaBuku LIMIT $awalData, $jumlahDataPerHalaman");
}

?>
    <thead class="table-dark">
        <tr>
            <th>No.</th>
            <th>ID</th>
            <th>Nama Buku</th>
            <th>Stock</th>
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
            <td><?= $oneView["idBuku"]; ?>
            </td>
            <td><?= $oneView["namaBuku"]; ?>
            </td>
            <td><?= $oneView["stock"]; ?>
            </td>
            <?php
        if ($oneView["stock"] > 0) {
            $stat = 'Tersedia';
        } else {
            $stat = 'Kosong';
        }?>
            <td><?= $stat; ?>
            </td>
            <td>
                <a href="ubahMapel.php?idbuku=<?= $oneView["idBuku"]; ?>"
                    class="btn btn-success">ubah</a>
                <a href="hapusMapel.php?idbuku=<?= $oneView["idBuku"]; ?>"
                    class="btn btn-danger" onclick="return confirm('yakin?');">hapus</a>
            </td>
        </tr>
        <?php $i++; endforeach;
if ($jumlahData == '0') {
    echo "<tr>
                            <td colspan='6' align='center' style='color: red; font-style: italic; font-size: 20px;'>Tidak ada data Mapel</td>
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
        <li class="page-item"><a class="page-link" href="?halamanKelMapel=1">Awal</a>
        </li>
        <?php endif; ?>

        <?php if ($halamanAktif > 1 && $jumlahData !=0) : ?>
        <li class="page-item"><a class="page-link"
                href="?halamanKelMapel=<?= $halamanAktif - 1 ?>">&laquo;</a>
        </li>
        <?php endif; ?>

        <?php for ($i = $awalNavigasi; $i <= $akhirNavigasi; $i++) :
            if ($i == $halamanAktif) :?>
        <li class="page-item"><a class="page-link"
                href="?halamanKelMapel=<?= $i ?>"
                style="font-size: 20px; color: red;"><?= $i ?></a>
        </li>
        <?php else : ?>
        <li class="page-item"><a class="page-link"
                href="?halamanKelMapel=<?= $i ?>"><?= $i ?></a></li>
        <?php endif;?>
        <?php endfor;?>

        <?php if ($halamanAktif < $jumlahHalaman) : ?>
        <li class="page-item"><a class="page-link"
                href="?halamanKelMapel=<?= $halamanAktif + 1 ?>">&raquo;</a>
        </li>

        <?php if ($halamanAktif < $jumlahHalaman - $banyakNavigasi && $jumlahData !=0) : ?>
        <li class="page-item"><a class="page-link"
                href="?halamanKelMapel=<?= $jumlahHalaman ?>">Akhir</a>
        </li>
        <?php endif; ?>

        <?php endif; ?>


    </ul>
</nav>