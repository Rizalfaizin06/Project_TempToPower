<?php
if (!session_id()) {
    session_start();
    require 'fungsiAdmin.php';
}

if (!empty($_POST['Data1'])) {
    if ($_POST['sendMode'] == 'pinjam') {
        pinjam($_POST);
    } elseif ($_POST['sendMode'] == 'kembali') {
        kembali($_POST);
    } elseif ($_POST['sendMode'] == 'absen') {
        absen($_POST);
    } else {
        echo "Gagal";
    }
}

if (isset($_POST['buttonFilter'])) {
    $_SESSION["sessionFilterStart"] = $_POST['startTime'];
    $_SESSION["sessionFilterEnd"] = $_POST['endTime'];
    $sessionStartDate = date("Y-m-d H:i:s", strtotime($_SESSION["sessionFilterStart"]));
    $sessionEndDate = date("Y-m-d H:i:s", strtotime($_SESSION["sessionFilterEnd"]));
    
    // var_dump($_SESSION["sessionFilterStart"]);
    // var_dump($sessionStartDate);
}

if (isset($_POST['buttonClear'])) {
    $_SESSION["sessionFilterStart"] = "";
    $_SESSION["sessionFilterEnd"] = "";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Krenova</title>
	<!-- <link rel="stylesheet" type="text/css" href="assets/css/style-public.css"> -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/icon/bootstrap-icons.css">
</head>

<body>
<?php

                                    // if (isset($_POST['keywordLogData'])) {
                                    //     echo $_POST['keywordLogData'];
                                    // } elseif (isset($_SESSION["sessionKeywordLogData"])) {
                                    //     echo $_SESSION["sessionKeywordLogData"];
                                    // } else {
                                    //     echo '';
                                    // }
                                    ?>
	<div class="container">

		<div class="mb-4 mt-3 text-center">
			<h1 class="display-3 fw-bold">
				Data Log<br />
				<span class="text-primary fw-normal display-6">SMKN 1 WIROSARI</span>
			</h1>
		</div>
        <!-- <form action="" method="post">
            <label for="start_time">Start Time:</label>
            <input type="datetime-local" id="start_time" name="start_time">
            <br><br>
            <label for="end_time">End Time:</label>
            <input type="datetime-local" id="end_time" name="end_time" >
            <br><br>
            <input type="submit" value="Search">
        </form> -->
		<div class="card shadow">
			<div class="card-header bg-dark text-bg-dark">
				<h3 class="text-center">Table Log</h3>
			</div>
			<div class="card-body">

				<div class="row mt-2">
					<div class="col-12 col-lg-12">
						<form action="" method="post">
							<div class="input-group mb-3">
								<input type="text" onfocus="(this.type='datetime-local')" class="form-control w-25" placeholder="Waktu Mulai" name="startTime" value="<?php 
                                    if (!empty($_SESSION['sessionFilterStart'])) {
                                        echo $sessionStartDate;
                                    } else {
                                        echo "";
                                    }
                                ?>">
								<input type="text" onfocus="(this.type='datetime-local')" class="form-control w-25" placeholder="Waktu Selesai" name="endTime" value="<?php 
                                    if (!empty($_SESSION['sessionFilterStart'])) {
                                        echo $sessionEndDate;
                                    } else {
                                        echo "";
                                    }
                                ?>">
								
								<button class="btn btn-outline-dark w-25" type="submit" id="button-addon1"
									name="buttonFilter">Filter</button>
								<button class="btn btn-outline-dark w-25" type="submit" id="button-addon2"
									name="buttonClear">Clear</button>
							</div>
						</form>
					</div>
				</div>
				<div class="table-responsive" id="tableLogData">
					<table class="table" id="tableLogData">
						<thead class="table-light">
							<tr>
								<!-- <th>No.</th> -->
								<th>waktu</th>
								<th>suhuDingin</th>
								<th>SuhuPanas</th>
								<th>Selisih</th>
								<th>voltase</th>
							</tr>
						</thead>
						<tbody class="table-group-divider">
							<?php
                            // WHERE datetime_field BETWEEN '$start_time' AND '$end_time'
                            if (!empty($_SESSION['sessionFilterStart'])) {
                                $logData = query("SELECT * FROM log_data WHERE waktu BETWEEN '$sessionStartDate' AND '$sessionEndDate'");
                            } else {
                                $jumlahLogData = count(query("SELECT id FROM log_data"));
                                $limitData = 15;
                                $awalData = $jumlahLogData - $limitData;
                                $logData = query("SELECT * FROM log_data order by waktu LIMIT $awalData, $limitData");
                            }
                            
                            // var_dump($jumlahLogData);
                            // $logData = query("SELECT RFIDB, mapel.idLogData, namaLogData, COUNT(case when status = 1 then RFIDB end) stock FROM mapel LEFT JOIN LogData ON LogData.idLogData = mapel.idLogData GROUP BY mapel.idLogData");

                            // if ((empty($logData))) {
                            //     echo "<tr><td class='text-center' colspan='4' style='color: red; font-style: italic; font-size: 20px;'>LogData tidak ditemukan</td></tr>";
                            // }

                            $i = 1;
                            $selisih = array();
                            $voltase = array();
                            $suhuPanas = array();
                            $suhuDingin = array();
                            $tm = array();

                            foreach ($logData as $oneView):
                                // $label2[] = strval(number_format($oneView["suhuPanas"], 2, '. ', '')) . " v";
                                $voltase[] = $oneView["voltase"];
                                // $suhuPanas = $oneView["suhuPanas"];
                                // $suhuDingin = $oneView["suhuDingin"];
                                $selisihRaw = $oneView["suhuPanas"] - $oneView["suhuDingin"];
                                $selisih[] = strval(number_format($selisihRaw, 2, '. ', '')) . " °C";
                                // $voltase2[] = $oneView["suhuPanas"];
                                $tanggal = date("Y-m-d", strtotime($oneView["waktu"]));
                                $jam = date("H:i:s", strtotime($oneView["waktu"]));
                                array_push($suhuDingin, $oneView["suhuDingin"]);
                                array_push($suhuPanas, $oneView["suhuPanas"]);
                                array_push($tm, $jam);
                                // var_dump($jam);
                                // $tm = date("Y-m-d H:i:s", strtotime($oneView["waktu"]));
                                ?>
                                <tr>
                                <!-- <td><?=$i;?>
                                </td> -->
                                <td><?=$tanggal . " " . $jam?>
                                </td>
                                <td><?=$oneView["suhuDingin"];?>
                                </td>
                                <td><?=$oneView["suhuPanas"];?>
                                </td>
                                <td><?=$selisihRaw;?>
                                </td>
                                <td><?=$oneView["voltase"];?>
                                </td>
                                </tr>
                            <?php $i++;endforeach;
                            if ((empty($logData))) {
                                echo "<tr><td class='text-center' colspan='5' style='color: red; font-style: italic; font-size: 20px;'>Data Tidak Ditemukan</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>    


				</div>
			</div>
		</div>





        <?php

        $selisih = json_encode($selisih);
        $voltase = json_encode($voltase);
        $suhuPanas = json_encode($suhuPanas);
        $suhuDingin = json_encode($suhuDingin);
        $tm = json_encode($tm);
        // var_dump($suhuDingin);
        // $label2 = json_encode($label2);
        // $voltase2 = json_encode($voltase2);

        ?>



        <div class="d-flex flex-column">
            <div class="card shadow p-3 mt-3 mb-3">
                <canvas id="line-chart1">
                </canvas>
            </div>
            <div class="card shadow p-3 mt-3 mb-3">
                <canvas id="line-chart2">
                </canvas>
            </div>
            
            <!-- <canvas id="line-chart3">

            </canvas> -->
        </div>
    </div>
<!--

<canvas id="line-chart1"></canvas>
<canvas id="line-chart2"></canvas>
<canvas id="line-chart3"></canvas> -->














<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
<script>
    var ct1 = document.getElementById("line-chart1").getContext("2d");
    var ct2 = document.getElementById("line-chart2").getContext("2d");
    // var ct3 = document.getElementById("line-chart3").getContext("2d");




    var chart = new Chart(ct1, {
        type: "line",
        data: {
            labels: <?php echo $selisih; ?>,
            datasets: [{
                label: "Selisih",
                data: <?php echo $voltase; ?>,
                backgroundColor: "rgba(255, 255, 0, 0.3)",
                borderColor: "rgba(200, 200, 0, 1)",
                borderWidth: 1
            }],
        },
        options: {
            scales: {
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Voltase'
                    }
                }],
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Selisih Suhu'
                    }
                }],
            }
        }
    });
    
    
    // console.log(<?php echo $tm; ?>);
    
    
    var chart = new Chart(ct2, {
        type: "line",
        data: {
            labels: <?php echo $tm; ?>,
            datasets: [
                {
                label: "Suhu Panas",
                data: <?php echo $suhuPanas; ?>,
                backgroundColor: "rgba(255, 0, 20, 0.2)",
                borderColor: "rgba(255, 0, 20, 1)",
                borderWidth: 1

            },
            {
                label: "Suhu Dingin",
                data: <?php echo $suhuDingin; ?>,
                backgroundColor: "rgba(0, 240, 255, 0.5)",
                borderColor: "rgba(51, 153, 255, 1)",
                borderWidth: 1

            },
        ]
        },
        options: {
            scales: {
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Suhu (derajat)'
                    }
                }],
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Waktu'
                    }
                }]
            }
        }
    });


    </script>
	<script src="assets/js/jquery-3.6.0.min.js"></script>
	<script src="assets/js/script-public.js"></script>
	<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>