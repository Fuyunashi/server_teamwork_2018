<?php

function connectDB(){
	$dsn  = 'mysql:host=127.0.0.1;dbname=hitblow;charset=utf8mb4';   //接続先
	$user = 'root';         //MySQLのユーザーID
	$pw   = '';   //MySQLのパスワード

  try  {
    $pdo = new PDO(
      $dsn,
      $user,
      $pw,
      array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    ));
  }
  catch(PDOException $e){
    exit('データベースに接続できませんでした'.$e->getMessage());
  }

  return $pdo;
}

class hitblowAPI {
  //初期化
  function auth(){
		$firstContactSql = null;
    //初めてのアクセスなら新しく作る
		if(!isset($_SESSION['username'])){
			$_SESSION['username'] = $_POST['username'];
			$firstContactSql = 'INSERT INTO user(username,pickNumber) VALUES(:name,:number)';
		}

    $sql = 'SELECT loginState FROM user WHERE loginState = :state AND username != :name';
    $updateSql = 'UPDATE user SET loginState = :state WHERE username = :name';
    try{
      $dbh = connectDB();
      $dbh->beginTransaction();
			if($firstContactSql != null){
				$prepare = $dbh->prepare($firstContactSql);
				$prepare->execute(array(':name' => $_POST["username"],":number" => 0));
			}
      //自分のログイン状態を変更
      $prepare = $dbh->prepare($updateSql);
      $prepare->execute(array(':state' => "login",":name" => $_POST['username']));
      //対戦相手を決める
      //$prepare = $dbh->prepare($sql);
      //$prepare->execute(array(':state' => "login",":name" => $_POST['username']));
      $state = $prepare->fetchAll();
    }
    catch(PDOException $e){
      $dbh->rollBack();
      print("エラー検出 : auth");
      $error = $e->getMessage();
    }
  }

  function end(){
    session_start();
    $sql = 'UPDATE user SET loginState = :state WHERE username = :name';

    try{
      $dbh = connectDB();                 //接続
      $dbh->beginTransaction();
      $stmt = $dbh->prepare($sql);         //SQL準備
      $stmt->execute(array(':state' => "logout",':name' => $_SESSION['username']));
      $dbh->commit();
    }
    catch( PDOException $e ){
      $dbh->rollBack();
      print("エラー検出 : end");
    }
  }

  function set($number){
		session_start();
    //初めてのアクセスなら新しく作る
    if(!isset($_SESSION['username'])){
      $_SESSION['username'] = $_POST['username'];
      $sql = 'INSERT INTO user(username,pickNumber) VALUES(:name,:number)';
    } else {
      $sql = 'UPDATE user SET pickNumber = :number WHERE username = :name';
    }

		try{
			$dbh = connectDB();                 //接続
			$dbh->beginTransaction();
			$stmt = $dbh->prepare($sql);         //SQL準備
			$stmt->execute(array(':name' => $_POST['username'],':number' => $_POST['number']));
			$dbh->commit();
		}
		catch( PDOException $e ){
			$dbh->rollBack();
      print("エラー検出 : set");
		}
	}

	function AddLog($message){
		session_start();
		$sql = 'INSERT INTO log(username,message) VALUES(:name,:message)';

		try{
			$dbh = connectDB();
			$dbh->beginTransaction();
			$stmt = $dbh->prepare($sql);
			$stmt->execute(array(':name' => $_POST['username'],':message' => $message));
			$dbh->commit();
		}
		catch(PDOException $e){
			$dbh->rollBack();
			print("エラー検出 : AddLog");
		}
	}
}


?>
