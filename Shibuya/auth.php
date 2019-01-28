<?php

require("lib.php");

$name = $_POST["username"];
$pick = $_POST["number"];


$hitblow = new hitblowAPI();
$hitblow->auth();
$hitblow->set($pick);
