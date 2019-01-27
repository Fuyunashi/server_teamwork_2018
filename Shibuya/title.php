<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>

<h1>テスト</h1>
<form action="hitblow.php" method="POST">
	USERNAME   :<input type="text"  name="username" value="<?= $_COOKIE['username'] ?>"><br>
	NUMBER(3桁):<input type="text"  name="number"><br>
	<button>ログイン</button>
</form>

</body>
</html>
