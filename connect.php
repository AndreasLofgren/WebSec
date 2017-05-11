<?php
$dbms = "mysql";
$dbhost = 'localhost';
$username = 'root';
$password = 'root';
$database = 'WebSecExam';
$dsn = "$dbms:host=$dbhost;dbname=$database";
//create the connection
$conn = new PDO($dsn, $username, $password);

//test if connection is successfully
if (mysqli_connect_errno()) {
    die("Database connection failed: " .
    mysqli_connect_error() .
    " ( " . mysqli_connect_errno() . ")" );
}


