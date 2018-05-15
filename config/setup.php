<?php
session_start();
include('database.php');
	try {

	$conn = new PDO("mysql:host=localhost", 'root', 'root42');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE DATABASE IF NOT EXISTS camagru";
    $conn->exec($sql);
    $conn->query("USE camagru");

    /// TABLE MEMBERS ///
    $sql = "CREATE TABLE IF NOT EXISTS members(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    login VARCHAR(25) NOT NULL DEFAULT 0, 
    passwd VARCHAR(255) NOT NULL DEFAULT 0,
    email VARCHAR(55) DEFAULT 0,
    cle VARCHAR(32) DEFAULT 0,
    actif INT DEFAULT 0,
    notif INT DEFAULT 1,
    reg_date TIMESTAMP
    )";
    $conn->exec($sql);

    /// TABLE PICTURES ///
    $sql = "CREATE TABLE IF NOT EXISTS pictures(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    img LONGTEXT,
    likes INT DEFAULT 0,
    login VARCHAR(25) NOT NULL DEFAULT 0,
    reg_date TIMESTAMP
    )";
    $conn->exec($sql);

    /// TABLE COMMENTS ///
    $sql = "CREATE TABLE IF NOT EXISTS comments(
    img_id INT NOT NULL,
    login VARCHAR(25) NOT NULL,
    comment TEXT NOT NULL,
    reg_date TIMESTAMP
    )";
    $conn->exec($sql);

    /// TABLE LIKES ///
    $sql = "CREATE TABLE IF NOT EXISTS likes(
    img_id INT NOT NULL,
    login VARCHAR(25) NOT NULL
    )";
    $conn->exec($sql);
    }
catch(Exception $e)
    {
		 echo $sql . "<br>" . $e->getMessage();
    }

?>
