<?php
include 'doctor.php';
include 'function.php';


$heartDoctor = new HeartDoctor('Ahmed', 45, 2000, 'HeartDoctor');
$newHeartDoctorSalary = $heartDoctor->calculateSalary(0.30);
displayDoctorInfo($heartDoctor);
echo 'New Salary with 30% increase: ' . '<b>' . $newHeartDoctorSalary . '</b><br>';

echo "<hr>";

$noseDoctor = new NoseDoctor('Ali', 40, 1800, 'NoseDoctor');
$newNoseDoctorSalary = $noseDoctor->calculateSalary(0.05);
displayDoctorInfo($noseDoctor);
echo 'New Salary with 5% increase: ' . '<b>' . $newNoseDoctorSalary . '</b><br>';

echo "<hr>";

$dentistDoctor = new DentistDoctor('Sara', 38, 1500, 'DentistDoctor');
displayDoctorInfo($dentistDoctor);
