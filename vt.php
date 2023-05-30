<?php

session_start();

try {
    $db = new PDO("mysql:hostname=localhost; dbname=ziyaretci_defteri; charset=utf8", "root", "123");
}catch(PDOException $e) {
    die($e->getMessage());
}