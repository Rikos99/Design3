<?php
const DB_HOST = 'localhost';
const DB_USERNAME = 'admin_user';
const DB_PASSWORD = 'root';
const DB_DATABASE = 'Design3';


$dbconnect = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
session_start();
?>