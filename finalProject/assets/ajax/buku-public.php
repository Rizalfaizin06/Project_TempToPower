<?php
if (!session_id()) {
    session_start();
}
require '../../fungsiAdmin.php';
?>
<table class="table">
    <thead class="table-light">
        <tr>
            <th>No.</th>
            <th>Nama Buku</th>
            <th>Stock</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody class="table-group-divider">
        <?php
                
                
if (isset($_POST["buttonCariBuku"]) || isset($_SESSION['sessionKeywordBuku'])) {
    if (isset($_SESSION['sessionKeywordBuku'])) {
        if (isset($_POST["keywordBuku"]) && $_SESSION['sessionKeywordBuku'] != $_POST["keywordBuku"]) {
            $keywordBuku = $_POST['keywordBuku'];
            $_SESSION['sessionKeywordBuku'] = $keywordBuku;
        } else {
            $keywordBuku = $_SESSION['sessionKeywordBuku'];
        }
    } else {
        $keywordBuku = $_POST['keywordBuku'];
        $_SESSION['sessionKeywordBuku'] = $keywordBuku;
    }
        


    $jumlahDataBuku = count(query("SELECT RFIDB, mapel.idBuku, namaBuku, COUNT(case when status = 1 then RFIDB end) stock FROM mapel LEFT JOIN buku ON buku.idBuku = mapel.idBuku GROUP BY mapel.idBuku HAVING namaBuku LIKE '%$keywordBuku%' ORDER BY namaBuku"));
    $jumlahDataPerHalamanBuku = 5;
    $jumlahHalamanBuku = ceil($jumlahDataBuku / $jumlahDataPerHalamanBuku);

    $halamanAktifBuku = (isset($_SESSION['sessionHalamanBukuHome'])) ? $_SESSION['sessionHalamanBukuHome'] : 1;
    $awalDataBuku = ($jumlahDataPerHalamanBuku * $halamanAktifBuku) - $jumlahDataPerHalamanBuku;

    $buku = query("SELECT RFIDB, mapel.idBuku, namaBuku, COUNT(case when status = 1 then RFIDB end) stock FROM mapel LEFT JOIN buku ON buku.idBuku = mapel.idBuku GROUP BY mapel.idBuku HAVING namaBuku LIKE '%$keywordBuku%' ORDER BY namaBuku LIMIT $awalDataBuku, $jumlahDataPerHalamanBuku");




// $buku = query("SELECT RFIDB, mapel.idBuku, namaBuku, COUNT(case when status = 1 then RFIDB end) stock FROM mapel LEFT JOIN buku ON buku.idBuku = mapel.idBuku GROUP BY mapel.idBuku HAVING namaBuku LIKE '%$keywordBuku%'");
} else {
    $jumlahDataBuku = count(query("SELECT RFIDB, mapel.idBuku, namaBuku, COUNT(case when status = 1 then RFIDB end) stock FROM mapel LEFT JOIN buku ON buku.idBuku = mapel.idBuku GROUP BY mapel.idBuku ORDER BY namaBuku"));
    $jumlahDataPerHalamanBuku = 5;
    $jumlahHalamanBuku = ceil($jumlahDataBuku / $jumlahDataPerHalamanBuku);

    $halamanAktifBuku = (isset($_SESSION['sessionHalamanBukuHome'])) ? $_SESSION['sessionHalamanBukuHome'] : 1;
    $awalDataBuku = ($jumlahDataPerHalamanBuku * $halamanAktifBuku) - $jumlahDataPerHalamanBuku;

    $buku = query("SELECT RFIDB, mapel.idBuku, namaBuku, COUNT(case when status = 1 then RFIDB end) stock FROM mapel LEFT JOIN buku ON buku.idBuku = mapel.idBuku GROUP BY mapel.idBuku ORDER BY namaBuku LIMIT $awalDataBuku, $jumlahDataPerHalamanBuku");

    // $buku = query("SELECT RFIDB, mapel.idBuku, namaBuku, COUNT(case when status = 1 then RFIDB end) stock FROM mapel LEFT JOIN buku ON buku.idBuku = mapel.idBuku GROUP BY mapel.idBuku");
}

if ((empty($buku))) {
    echo "<tr><td class='text-center' colspan='4' style='color: red; font-style: italic; font-size: 20px;'>Buku tidak ditemukan</td></tr>";
}

$i = $awalDataBuku + 1;

foreach ($buku as $oneView) : ?>
        <tr>
            <td><?= $i; ?>
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
}

    ?>
            <td><?= $stat; ?>
            </td>
        </tr>
        <?php $i++; endforeach; ?>
    </tbody>
</table>


<?php if ($jumlahDataBuku != 0) :
    
    echo "<p>Total Buku : ". $jumlahDataBuku . "</p>";
endif;
?>

<!-- navigasi -->
<?php $banyakNavigasi = 2;

$awalNavigasi = (($halamanAktifBuku - $banyakNavigasi) < 1)? 1 :$halamanAktifBuku - $banyakNavigasi;

$akhirNavigasi = (($halamanAktifBuku + $banyakNavigasi) > $jumlahHalamanBuku)? $jumlahHalamanBuku :$halamanAktifBuku + $banyakNavigasi;

?>
<nav aria-label="Page navigation example">
    <ul class="pagination">

        <?php if ($halamanAktifBuku > $banyakNavigasi + 1 && $jumlahDataBuku !=0) : ?>
        <li class="page-item"><a class="page-link" href="?halamanBuku=1">Awal</a>
        </li>
        <?php endif; ?>

        <?php if ($halamanAktifBuku > 1 && $jumlahDataBuku !=0) : ?>
        <li class="page-item"><a class="page-link"
                href="?halamanBuku=<?= $halamanAktifBuku - 1 ?>">&laquo;</a>
        </li>
        <?php endif; ?>

        <?php for ($i = $awalNavigasi; $i <= $akhirNavigasi; $i++) :
            if ($i == $halamanAktifBuku) :?>
        <li class="page-item"><a class="page-link"
                href="?halamanBuku=<?= $i ?>"
                style="font-size: 20px; color: red;"><?= $i ?></a>
        </li>
        <?php else : ?>
        <li class="page-item"><a class="page-link"
                href="?halamanBuku=<?= $i ?>"><?= $i ?></a></li>
        <?php endif;?>
        <?php endfor;?>

        <?php if ($halamanAktifBuku < $jumlahHalamanBuku) : ?>
        <li class="page-item"><a class="page-link"
                href="?halamanBuku=<?= $halamanAktifBuku + 1 ?>">&raquo;</a>
        </li>
        <?php endif; ?>

        <?php if ($halamanAktifBuku < $jumlahHalamanBuku - $banyakNavigasi && $jumlahDataBuku !=0) : ?>
        <li class="page-item"><a class="page-link"
                href="?halamanBuku=<?= $jumlahHalamanBuku ?>">Akhir</a>
        </li>

        <?php endif; ?>


    </ul>
</nav>