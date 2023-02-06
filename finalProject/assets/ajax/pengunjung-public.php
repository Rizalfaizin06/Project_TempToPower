	<?php
require '../../fungsiAdmin.php';
$jumlahPengunjung = query("SELECT COUNT(*) FROM absensi WHERE tanggal='$tanggal'")[0]["COUNT(*)"];
$jumlahPengunjungWaspada = query("SELECT COUNT(*) FROM absensi WHERE tanggal='$tanggal' AND suhu > 36")[0]["COUNT(*)"]; ?>
	<ul class="list-group pb-3">
		<li class="list-group-item fw-bold text-center bg-light">Pengunjung Hari Ini</li>
		<li class="list-group-item"><?= "Jumlah pengunjung hari ini adalah : ",$jumlahPengunjung; ?>
		</li>
		<li class="list-group-item"><?= "Jumlah pengunjung waspada adalah : ",$jumlahPengunjungWaspada; ?>
		</li>
	</ul>