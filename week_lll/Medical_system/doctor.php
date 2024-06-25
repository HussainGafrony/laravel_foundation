<?php
include 'person.php';
class HeartDoctor extends Doctor
{
    function process()
    {
        echo "Performing heart surgery";
    }
}

class NoseDoctor extends Doctor
{
    function process()
    {
        echo "Performing nose surgery";
    }
}
class DentistDoctor extends Doctor
{
    function process()
    {
        echo "Performing dental surgery";
    }
}
