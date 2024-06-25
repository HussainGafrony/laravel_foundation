<?php



function displayDoctorInfo($doctor)
{
    echo 'Name: ' . '<b>' . $doctor->getName() . '</b><br>';
    echo 'Age: ' . '<b>' . $doctor->getAge() . '</b><br>';
    echo 'Job: ' . '<b>' . $doctor->getJob() . '</b><br>';
    echo 'Original Salary: ' . '<b>' . $doctor->getSalary() . '</b><br>';
    $doctor->process();
    echo "<br><br>";
}
