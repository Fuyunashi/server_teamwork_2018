<?php
require("myLib.php");

$_logData[] = [];
if(!isset($_SESSION)){
session_start();
}
$sql = 'SELECT * FROM log ORDER BY id DESC LIMIT 100'

try{
  $dbh = connectDB();
  $sth = $dbh->prepare($sql);
  $sth->exceute();
  while(true){
      $buff = $sth->fetch(PDO::FETCH_ASSOC);

      if( $buff === false ){
        break;
      }
      $_logData[] = [
         "id"      => $buff["id"],
         "name"    => $buff["username"],
         "message" => $buff["message"]
     ];
  }
}
catch(PDOException $e){
    $dbh->rollBack();
    print("エラー検出 : GetLog");
}

$flag = false;

$this->sendjson($flag,$_logData);
