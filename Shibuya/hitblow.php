<?php
  require('myLib.php');

	setcookie("username", $_POST["username"], time()+(60*60*24*7));

	$uname = $_POST["username"];
	$pickNumber = $_POST["number"];

  if(!isset($_SESSION))session_start();

  $_logData = array();
  $rst = 'SELECT * FROM log ORDER BY id DESC LIMIT 100'
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<title>Hit & Blow</title>
</head>


<body>
<p><?php echo $uname; ?></p>

<div>
<p>相手の数字を打ち込む場所</p>
<textarea name="callMessage" id="jsi-msg" cols="3" rows="1"></textarea>
</div>

<button type="button" name="jsi-button" onclick="document.write('<?php  '$hitblow->AddLog(callMessage.value)' ?>');">Call</button>

<li>過去ログ</li>
  <tbody id="board">
  <?php foreach($_logData as $log){?>
    <tr><td><?php htmlspecialchars($log["username"])?></td><td><?php htmlspecialchars($log["message"])?></td></tr>
  <?php } ?>
<script>

function createXMLHttpRequest(){
  var xmlHttpRequest = new XMLHttpRequest();
  request.open('POST', 'http://localhost/ServerTeam/auth.php', false);
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  request.send(
        "username=" + encodeURIComponent("<?php echo $name; ?>") + "&"
      + "number=" + encodeURIComponent("<?php echo $pick; ?>")
  );
  return xmlHttpObject;
}

function loadLogData(){
  var request = createXMLHttpRequest();
  request.open('GET', 'http://localhost/ServerTeam/loadLogData.php', false);
  request.onreadystatechange = function(){
    var response = request.responseText;
    var json     = JSON.parse(response);
    var html="";
    for(i=0; i<json["body"].length; i++){
      html += json["body"][i]["name"] +":"+ json["body"][i]["message"] + "<br>";
    }
    document.querySelector("#board").innerHTML = html;
  }
  request.send();
}

function displayHtml(){
  if((httpObj.readtState == 4) && (httpObj.status = 200) && httpObj.responceText){
    document.getElementById("board").innerHTML = httpObj.responceText + document.getElementById("board").innerHTML;
  }
}
}
setInterval('loadLogData()',2000);

</script>

<form action="end.php" method="POST">
<button>ログアウト</button>
</form>
</body>
</html>
