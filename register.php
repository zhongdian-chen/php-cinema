<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css\css.css">
	<title>注册</title>
</head>
<body>
	<form action="zhuye.php" method="post">
		<div class="register">
			<div class="item">
				<label>账&emsp;&emsp;号</label>
				<input id="name" class="input" name="name" type="text"  placeholder="请输入账号" required oninvalid="setCustomValidity('账户不能为空')" oninput="setCustomValidity('')" />
			</div>
			<div class="item">
				<label>密&emsp;&emsp;码</label>
				<input id="pwd" class="input" name="pwd" type="pwd" placeholder="请输入密码" required oninvalid="setCustomValidity('密码不能为空')" oninput="setCustomValidity('')"  />
			</div>
			<div class="item">
				<label>电话号码</label>
				<input id="phone" class="input" name="phone" type="text" maxlength="11" placeholder="请输入电话号码" required pattern="^1[0-9]{10}$" oninvalid="setCustomValidity('电话号码不能为空且长度为11')" oninput="setCustomValidity('')"/>
			</div>
			<div class="item">
				<label>&nbsp;</label>
				<input type="submit" class="submit" value="注册" />
			</div>
		</div>
	</form>
</body>
</html>