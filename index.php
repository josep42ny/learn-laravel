<?php

require 'functions.php';
//require 'router.php';

class Person
{
  public $name;
  public $age;

  function breathe(): void
  {
    echo "{$this->name} is breathing";
  }
}


$person = new Person();
$person->name = 'John Doe';
$person->age = 25;

dd($person->breathe());
