<?php

abstract class Person
{
    public $name;
    public $age;

    public function __construct($name, $age)
    {
        $this->name = $name;
        $this->age = $age;
    }

    public function getName()
    {
        return $this->name;
    }
    public function getAge()
    {
        return $this->age;
    }
}

class Doctor extends Person
{
    public $salary;
    public $job;

    public function __construct($name, $age, $salary, $job)
    {
        $this->name = $name;
        $this->age = $age;
        $this->salary = $salary;
        $this->job = $job;
    }
    function process()
    {
    }

    function calculateSalary($increaseRate)
    {
        return $this->salary * (1 + $increaseRate);
    }
    public function getSalary()
    {
        return $this->salary;
    }
    public function getJob()
    {
        return $this->job;
    }
}
