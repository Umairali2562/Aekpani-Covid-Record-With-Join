<?php
session_start();
	include 'conn.php';
$item_per_page=$_SESSION['item_per_page'];
$offset=$_SESSION['offset'];

if(isset($_POST['export_all_r'])){
ob_start();
ob_end_clean();
header('Content-Type: text/csv;');
header('Content-Disposition: attachment; filename=results.csv');
$output=fopen("php://output","w");
fputcsv($output,array('ID','Patient Name','Patient Address','Patient Phone','Patient Email','Patient Clinic','Appointment Date','appointment Time','Status'));

$query="SELECT covid_appointments.appointment_id AS id,covid_patients.first_name AS first_name,covid_patients.address AS Address,covid_patients.phone AS phone,covid_patients.email AS email,covid_clinics.clinic_name AS clinic_name,covid_appointments.appointment_date AS date,covid_clinic_slots.time AS slot,covid_appointments.appointment_status AS status FROM `covid_appointments` LEFT OUTER JOIN covid_patients ON covid_appointments.patient_id=covid_patients.patient_id LEFT OUTER JOIN covid_clinics ON covid_appointments.clinic_id=covid_clinics.clinic_id LEFt OUTER JOIN covid_clinic_slots ON covid_appointments.slot_id=covid_clinic_slots.slot_id";
$result=mysqli_query($conn,$query);
while($row=mysqli_fetch_assoc($result)){
fputcsv($output,$row);

}
fclose($output);

}



//export current records
if(isset($_POST['export_current_r'])){
header("Content-disposition: attachment; filename=results.csv");
header("Content-Type: text/csv");

$output=fopen("php://output","w");

fputcsv($output,array('ID','Patient Name','Patient Address','Patient Phone','Patient Email','Patient Clinic','Appointment Date','appointment Time','Status'));


$query="SELECT covid_appointments.appointment_id AS id,covid_patients.first_name AS first_name,covid_patients.last_name AS last_name,covid_patients.address AS Address,covid_patients.phone AS phone,covid_patients.email AS email,covid_clinics.clinic_name AS clinic_name,covid_clinics.clinic_address AS clinic_address,covid_appointments.appointment_date AS date,covid_clinic_slots.time AS slot,covid_appointments.appointment_status AS status FROM `covid_appointments` LEFT OUTER JOIN covid_patients ON covid_appointments.patient_id=covid_patients.patient_id LEFT OUTER JOIN covid_clinics ON covid_appointments.clinic_id=covid_clinics.clinic_id LEFt OUTER JOIN covid_clinic_slots ON covid_appointments.slot_id=covid_clinic_slots.slot_id ORDER BY id DESC LIMIT $item_per_page OFFSET $offset";
$result=mysqli_query($conn,$query);
while($row=mysqli_fetch_assoc($result)){
fputcsv($output,$row);

}
fclose($output);
}













?>