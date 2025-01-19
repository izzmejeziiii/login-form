<?php

$host = "localhost";
$user = "root";
$pass = "";
$database = "form";

//database connection link
$dsn = "mysql:host=" . $host . ";dbname=" . $database;
//database object
$pdo = new PDO($dsn, $user, $pass);

//database processes will be in a  form of object
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
