// $(document).ready(function () {
// 	// $('.tanggalTok, .bulanTok, .tahunTok')
// 	// 	.hide();
// 	// var select = document.getElementById('filter');
// 	// var option;
// 	// console.log(select);
// 	// for (var i = 0; i < select.options.length; i++) {
// 	// 	option = select.options[i];

// 	// 	if (option.value == '2') {
// 	// 		// or
// 	// 		// if (option.text == 'Malaysia') {
// 	// 		option.selected = true;

// 	// 		// For a single select, the job's done
// 	// 		return;
// 	// 	}
// 	// }

// 	$('#loginAdmin').hide();

// 	// $(document).on('click', '.delete', function () {
// 	// 	var id = $(this).attr("id");
// 	// 	if (confirm("Are you sure you want to remove this?")) {
// 	// 		location.href = 'ubahBuku.php?rfidb=' + id;
// 	// 	}
// 	// });

// 	// $(".del").click(function () {
// 	// 	if (confirm('Are you sure to hide')) {
// 	// 		location.href = 'newPage.html';
// 	// 	}
// 	// });

// 	// $(".remove").click(function () {
// 	// 	var id = $(this).parents("tr").attr("id");


// 	// 	if (confirm('Are you sure to remove this record ?')) {
// 	// 		$.ajax({
// 	// 			url: 'hapusBuku.php',
// 	// 			type: 'GET',
// 	// 			data: {
// 	// 				id: id
// 	// 			},
// 	// 			error: function () {
// 	// 				alert('Something is wrong');
// 	// 			},
// 	// 			success: function (data) {
// 	// 				$("#" + id).remove();
// 	// 				alert("Record removed successfully");
// 	// 			}
// 	// 		});
// 	// 	}
// 	// });




// 	// ---------------Start Home Script

// 	setInterval(function () {
// 		jQuery.ajax({
// 			type: "GET",
// 			url: "assets/ajax/warning-public.php",
// 			data: "",
// 			success: function (data) {
// 				$("#tablePeringatan").html(data);
// 			}
// 		});
// 	}, 60000);

// 	setInterval(function () {
// 		jQuery.ajax({
// 			type: "GET",
// 			url: "assets/ajax/pengunjung-public.php",
// 			data: "",
// 			success: function (data) {
// 				$("#listPengunjung").html(data);
// 			}
// 		});
// 	}, 1000);

// 	setInterval(function () {
// 		jQuery.ajax({
// 			type: "GET",
// 			url: "assets/ajax/buku-public.php",
// 			data: "",
// 			success: function (data) {
// 				$("#tableBuku").html(data);
// 			}
// 		});
// 	}, 1000);

// 	setInterval(function () {
// 		jQuery.ajax({
// 			type: "GET",
// 			url: "assets/ajax/absensi-public.php",
// 			data: "",
// 			success: function (data) {
// 				$("#tableAbsen").html(data);
// 			}
// 		});
// 	}, 1000);


// 	// ---------------End Home Script

// 	// ---------------Start Kelola Script

// 	setInterval(function () {
// 		jQuery.ajax({
// 			type: "GET",
// 			url: "assets/ajax/ajaxKelolaBuku.php",
// 			data: "",
// 			success: function (data) {
// 				$("#kelolaBuku").html(data);
// 			}
// 		});
// 	}, 1000);

// 	setInterval(function () {
// 		jQuery.ajax({
// 			type: "GET",
// 			url: "assets/ajax/ajaxKelolaMapel.php",
// 			data: "",
// 			success: function (data) {
// 				$("#kelolaMapel").html(data);
// 			}
// 		});
// 	}, 1000);

// 	setInterval(function () {
// 		jQuery.ajax({
// 			type: "GET",
// 			url: "assets/ajax/ajaxKelolaAnggota.php",
// 			data: "",
// 			success: function (data) {
// 				$("#kelolaAnggota").html(data);
// 			}
// 		});
// 	}, 1000);

// 	setInterval(function () {
// 		jQuery.ajax({
// 			type: "GET",
// 			url: "assets/ajax/ajaxRekapPengunjung.php",
// 			data: "",
// 			success: function (data) {
// 				$("#rekapPengunjung").html(data);
// 			}
// 		});
// 	}, 1000);

// 	setInterval(function () {
// 		jQuery.ajax({
// 			type: "GET",
// 			url: "assets/ajax/ajaxRekapPeminjam.php",
// 			data: "",
// 			success: function (data) {
// 				$("#rekapPeminjam").html(data);
// 			}
// 		});
// 	}, 1000);




























// 	// setInterval(function () {
// 	// 	jQuery.ajax({
// 	// 		type: "GET",
// 	// 		url: "assets/ajax/buku.php",
// 	// 		data: "",
// 	// 		success: function (data) {
// 	// 			$(".table-buku").html(data);
// 	// 			console.log("succ");
// 	// 		}
// 	// 	});
// 	// }, 1000);


// 	$('#filter').change(function () {
// 		// console.log($(this).val());
// 		if ($(this).val() == '1') {


// 			$('.bulanTok, .tahunTok').hide();
// 			$('.tanggalTok').show();


// 		} else if ($(this).val() == '2') {

// 			$('.tanggalTok, .tahunTok').hide();
// 			$('.bulanTok').show();

// 		} else if ($(this).val() == '3') {

// 			$('.tanggalTok, .bulanTok').hide();
// 			$('.tahunTok').show();

// 		} else if ($(this).val() == '4') {
// 			$('.tanggalTok, .bulanTok, .tahunTok')
// 				.hide();
// 		}

// 		// $('.tanggalTok input, .bulanTok input, .tahunTok select').val(
// 		// 	'');
// 	});

// });

// {
// 	/* <script>
// 	    $(document).ready(function() { // Ketika halaman selesai di load
// 	        $('.fTanggal').datepicker({
// 	            dateFormat: 'yy-mm-dd' // Set format tanggalnya jadi yyyy-mm-dd
// 	        });
// 	        $('.tanggalTok, .bulanTok, .tahunTok')
// 	            .hide(); // Sebagai default kita sembunyikan form filter tanggal, bulan & tahunnya
// 	        $('.filter').change(function() { // Ketika user memilih filter
// 	            if ($(this).val() == '1') { // Jika filter nya 1 (per tanggal)
// 	                $('.bulanTok, .tahunTok').hide(); // Sembunyikan form bulan dan tahun
// 	                $('.tanggalTok').show(); // Tampilkan form tanggal
// 	            } else if ($(this).val() == '2') { // Jika filter nya 2 (per bulan)
// 	                $('.tanggalTok, .tahunTok').hide(); // Sembunyikan form tanggal
// 	                $('.bulanTok').show(); // Tampilkan form bulan dan tahun
// 	            } else if ($(this).val() == '3') { // Jika filter nya 2 (per bulan)
// 	                $('.tanggalTok, .bulanTok').hide(); // Sembunyikan form tanggal dan bulan
// 	                $('.tahunTok').show(); // Tampilkan form tahun
// 	            } else { // Jika filternya 3 (per tahun)
// 	                $('.tanggalTok, .bulanTok, .tahunTok')
// 	                    .hide(); // Sembunyikan form tanggal dan bula// Tampilkan form tahun
// 	            }
// 	            $('.tanggalTok input, .bulanTok select, .tahunTok select').val(
// 	                ''); // Clear data pada textbox tanggal, combobox bulan & tahun
// 	        })
// 	    })
// 	</script> */
// }