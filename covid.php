<?php
session_start();
	include 'conn.php';


if($_SESSION['role']!="Admin"){
    header('location:index.php');
}

//pagination

$total="SELECT covid_appointments.appointment_id AS id,covid_patients.first_name AS first_name,covid_patients.last_name AS last_name,covid_patients.address AS Address,covid_patients.phone AS phone,covid_patients.email AS email,covid_clinics.clinic_name AS clinic_name,covid_clinics.clinic_address AS clinic_address,covid_appointments.appointment_date AS date,covid_clinic_slots.time AS slot,covid_appointments.appointment_status AS status FROM `covid_appointments` LEFT OUTER JOIN covid_patients ON covid_appointments.patient_id=covid_patients.patient_id LEFT OUTER JOIN covid_clinics ON covid_appointments.clinic_id=covid_clinics.clinic_id LEFt OUTER JOIN covid_clinic_slots ON covid_appointments.slot_id=covid_clinic_slots.slot_id";
$count=mysqli_query($conn,$total);
$nr=mysqli_num_rows($count);

//if we get data from the post then save it in a session variable
if(isset($_POST['limit-records'])) {
    $_SESSION['item_per_page'] = $_POST['limit-records'];
}

//if the session variable is empty then assign item_per_page a value of 500 else assgin it the session variable
if(empty($_SESSION['item_per_page'])){
    $_SESSION['item_per_page']=500;
}
else{
    $item_per_page=$_SESSION['item_per_page'];
}

$item_per_page=$_SESSION['item_per_page'];

$totalpages=ceil($nr/$item_per_page);

if(isset($_GET['page'])&& !empty($_GET['page'])){
$page=$_GET['page'];
}
else{
    $page=1;
}

$offset=($page-1)*$item_per_page;
$_SESSION['offset']=$offset;

$q="SELECT covid_appointments.appointment_id AS id,covid_patients.first_name AS first_name,covid_patients.last_name AS last_name,covid_patients.address AS Address,covid_patients.phone AS phone,covid_patients.email AS email,covid_clinics.clinic_name AS clinic_name,covid_clinics.clinic_address AS clinic_address,covid_appointments.appointment_date AS date,covid_clinic_slots.time AS slot,covid_appointments.appointment_status AS status FROM `covid_appointments` LEFT OUTER JOIN covid_patients ON covid_appointments.patient_id=covid_patients.patient_id LEFT OUTER JOIN covid_clinics ON covid_appointments.clinic_id=covid_clinics.clinic_id LEFt OUTER JOIN covid_clinic_slots ON covid_appointments.slot_id=covid_clinic_slots.slot_id ORDER BY id DESC LIMIT $item_per_page OFFSET $offset";

$result1=mysqli_query($conn,$q);
$row_count=mysqli_num_rows($result1);

//this is for the number of records per page...


//starting exports queries:




 ?>


<!DOCTYPE html>
<html lang="en">
<html>
<head>


        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css"/>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>


    <!-- My own css CSS -->
    <link rel="stylesheet" href="styles.css">
	<title>AekpaniNetwork's Covid System</title>


</head>
<body id="mytable">


<div class="container-fluid">
<div class="row">

    <div class="col-sm-12 col-lg-12 col-xl-12 col-md-12 text-center justify-content-center">

        <h1 class="">AekpaniNetwork's Covid System</h1>
    </div>
</div>

<div class="row">

    <div class="col-sm-2 col-lg-2 col-xl-2 col-md-2  justify-content-left">
        <form method="POST" enctype="multipart/form-data" action="export.php">
        <input class="btn btn-primary" name="export_current_r" type="submit" value="Export Current Records">
        </form>
    </div>
    
     <div class="col-sm-10 col-lg-10 col-xl-10 col-md-10  justify-content-left">
    <form method="POST" enctype="multipart/form-data" action="export.php">
         <input class="btn btn-primary" name="export_all_r" type="submit" value="Export All Records">
        </form>
      
    </div>
    
</div>


    <div class="row acc-to-the-search">

        <div class="col-sm-12 col-lg-12 col-xl-12 col-md-12">


                <form method="post" action="#">
                    <select name="limit-records" id="limit-records">
                        <option disabled="disabled" selected="selected">
                          <?php
                                echo "--LIMIT-RECORD--";

                            ?>

                        </option>
                        <?php foreach([10,100,500,1000,5000] as $limit): ?>
                            <option <?php if( isset($_POST["limit-records"]) && $_POST["limit-records"] == $limit) echo "selected" ?> value="<?= $limit; ?>"><?= $limit; ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>

    </div>



    <div class="row">
        <div class="col-sm-12">
            <div style="">
                <table id="" class="table table-hover table-striped table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                         <th>Patient Name</th>
                <th>Patient Address</th>
                <th>Patient Phone</th>
                <th>Patient Email</th>
                <th>Patient Clinic</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Status</th>
             

                    </tr>
                    </thead>
                    <tbody>
                   <?php while($customer=mysqli_fetch_assoc($result1)){  ?>
                        <tr>
                            <td><?= $customer['id']; ?></td>
                            <td><?= $customer['first_name']." ".$customer['last_name'];  ?></td>
                            <td><?= $customer['Address']; ?></td>
                            <td><?= $customer['phone']; ?></td>
                            <td><?= $customer['email']; ?></td>
                            <td><?= $customer['clinic_name']." ".$customer['clinic_address'] ?></td>
                            <td><?= $customer['date']; ?></td>
                            <td><?= $customer['slot']; ?></td>
                            <td><?= $customer['status']; ?></td>
                          
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!--- row of table ends here !-->

    <div class="row">
        <div class="col-sm-12 col-lg-12 col-xl-12 col-md-12">
            <nav aria-label="Page navigation example">
                <ul class="pagination pagination-sm justify-content-end">
                    <li class="page-item">
                        <a class="page-link" href="covid.php?page=<?php echo $page-1; ?>">Previous</a>
                    </li>

                    <?php
                    for($i=1;$i<=$totalpages;$i++){//actual link

                        if($i==$page){
                            echo "<li class='page-item'><a  class='page-link active' href='covid.php?page=$i' >$i</a></li>";
                        }
                        else{
                            if($i>10){
                                $lastpage=$totalpages-1;
                                echo "<li  class='page-item'><a href='covid.php?page=$lastpage' class='page-link' >..</a></li>";
                            break;
                            }else{
                            echo "<li  class='page-item'><a href='covid.php?page=$i' class='page-link' >$i</a></li>";
                            }
                        }

                    } ?>


                    <li class="page-item">
                        <a class="page-link" href="covid.php?page=<?php echo $page+1; ?>">Next</a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>

</div>










<script>
    function loadDoc() {
        var i=0;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("mytable").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "index.php?page=7", true);
        xhttp.send();
    }
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('table').dataTable({
            searching: true,
            paging: false,
            info: false,
            bPaginate: false,
            bLengthChange: false,
        });
    })
</script>


<script type="text/javascript">
    $(document).ready(function(){
        $("#limit-records").change(function(){
            $('form').submit();
        })
    })
</script>




</body>
</html>
