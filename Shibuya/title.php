<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="Style.css">
<head>
	<title>Login</title>
</head>
<body>

<h1>テスト</h1>
<form action="hitblow.php" method="POST">
	<p>USERNAME   :<input type="text"  name="username" value="<?= $_COOKIE['username'] ?>"><br></p>
	<p>NUMBER(3桁):<input type="text"  name="number"><br></p>
	<button>ログイン</button>
</form>

</body>
</html>
