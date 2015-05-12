<?php
//This setup file is put together only really to set up the DB and is not representative of the application at large.


require "Config/config.php";

try {
    $dbh = new PDO("mysql:host=".DBIP, DBUSER, DBPASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

} catch (PDOException $e) {
    die("DB ERROR: ". $e->getMessage());
}

$sql = file_get_contents('SQL.sql');
$qr = $dbh->exec($sql);

$dbh = new PDO('mysql'.':host='.DBIP.';dbname='.DBNAME.';charset=utf8', DBUSER, DBPASSWORD,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

$sql = file_get_contents('Triggers.sql');
$dbh->exec($sql);

$hashedPass = password_hash("rootpassword", PASSWORD_DEFAULT);
$sql = "INSERT INTO USER (username, passwordhash, email, admin) VALUES ('admin', '{$hashedPass}', 'Podginator@gmail.com, 1')";
$dbh->exec($sql);
$sql = "INSERT INTO ENTRY (entryname,
                  entrycontent,
                  userid,
                  category)
                  VALUES ('First Post!!',
                  'First Post',
                  1,
                  'General')";
$dbh->exec($sql);
//header("Location:".URL);
?>