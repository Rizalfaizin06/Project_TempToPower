<?php
require '../../fungsiAdmin.php';
$warning = query("SELECT peminjaman.RFIDP, peminjaman.RFIDB, buku.idBuku, mapel.namaBuku, kelas,  namaAnggota, tanggalPinjam, tanggalKembali, '$tanggal' AS tgl_sekarang, datediff('$tanggal', tanggalPinjam) AS selisih FROM peminjaman, anggota, buku, mapel WHERE peminjaman.RFIDP=anggota.RFIDP AND peminjaman.RFIDB=buku.RFIDB AND buku.idBuku=mapel.idBuku AND datediff('$tanggal', tanggalPinjam) >= 7 AND tanggalKembali LIKE '0000-00-00' "); ?>


<?php
                        if (empty($warning)) {
                            echo "<li class='list-group-item text-center'>Tidak ada peringatan</li>";
                        }
                        foreach ($warning as $oneView) : ?>

<?= "<li class='list-group-item'><marquee direction='left'>"; ?>
<?php printf("Peringatan!! Atas Nama %s dari kelas %s untuk segera mengembalikan buku %s.", $oneView["namaAnggota"], $oneView["kelas"], $oneView["namaBuku"]); ?>
<?= "</marquee></li>"; ?>

<?php endforeach;
