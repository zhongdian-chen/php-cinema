<?php
	header('content-type:text/html;charset=utf-8');
	@$link = mysql_connect('localhost:3306','root','') or die('连接数据库失败，原因：'.mysql_error());
	mysql_query('set names utf8');
	$db_selected=mysql_query("use movie_info",$link);
	 $username =  $_COOKIE['user'];
	$result = mysql_query(" select * from buy_info where username = '$username'",$link);
	$row = mysql_fetch_row($result);
	$result1 = mysql_query("select img from info,buy_info where info.name=buy_info.name and buy_info.username='$username'",$link);
	$row1 = mysql_fetch_row($result1);

?>
<!DOCTYPE html>
<html>
<head>
	<title>个人中心</title>
	<link rel="stylesheet" href="css/css.css">
	 <script src="js/jquery-3.4.1.js"></script>

</head>
<body>

	<div style="width: 100%;height: 80px; background-color: rgb(50,50,50);position: relative">
		<img src="img/天空.png" width="55px" style="position: absolute;top: 17px;left: 280px">
		<p style="color: white;font-size: 28px;top: 17px;left: 370px;position: absolute;font-family: FZShuTi">天空影院</p>
		<!--登录、注册-->
		<div class="menu" style="margin-right: 200px">
			<ul>
				<a id="loginlink"><li id="ab" name="ab" style="margin-right: 30px;color: rgb(8,140,180);">亲，请登录</li></a>  
				<li onclick="exit()"><a style="color: rgb(8,140,180);text-decoration: none;">退出登录</a></li>
				<li style="list-style: none;color: rgb(8,140,180);cursor: pointer;" onclick="personal()" >个人中心</li>
				<script type="text/javascript">
					function exit(){
						var keys = document.cookie.match(/[^ =;]+(?=\=)/g);
						if (keys) {
							for (var i = keys.length; i--;) {
                                document.cookie = keys[i] + '=0;path=/;expires=' + new Date(0).toUTCString();//清除当前域名下的,例如：m.kevis.com
                                document.cookie = keys[i] + '=0;path=/;domain=' + document.domain + ';expires=' + new Date(0).toUTCString();//清除当前域名下的，例如 .m.kevis.com
                                document.cookie = keys[i] + '=0;path=/;domain=kevis.com;expires=' + new Date(0).toUTCString();//清除一级域名下的或指定的，例如 .kevis.com
                            }
                        }
                        window.location.href = 'zhuye.php';
                    }
                </script>
            </ul>
        </div>
    </div>

    <div id="layer-mask" class="layer-mask"></div>
        <!--弹出层窗体-->
    <div id="layer-pop" class="layer-pop">
        <!--弹出层关闭-->
        <div id="layer-close" class="layer-close">×</div>
        <!--弹出层内容-->
        <div id="layer-content" class="layer-content">
            <div style="height: 40px">
                <div class="loginbtn pop">登录</div>
                <div class="registerbtn pop">注册</div>
            </div>
            <form action="" method="post" name="pay">
                <div class="login">
                </div>
            </form>
        </div>
    </div>

<script type="text/javascript">
    $(document).ready(function(){
        $(".login").load("login.html");
        $('.registerbtn').addClass('pop_color');
    });

    $('.loginbtn').click(function(){
        $(".login").load("login.html");
        $(this).removeClass('pop_color');
        $(this).siblings().addClass('pop_color');
    });

    $('.registerbtn').click(function(){
        $(".login").load("register.html");
        $(this).removeClass('pop_color');
        $(this).siblings().addClass('pop_color');
    });

    function register(){
        document.pay.action="res.php";
    }

    $('')


    $(function(){
      $("#loginlink").click(function() {
        $("#layer-mask").show();
        $("#layer-pop").show();
        $("#layer-close").click(function(){
            $("#layer-mask").hide();
           $("#layer-pop").hide();
         });
    });
 });

</script>

	<div class="movie">
		<div style="float: left;"> 
		<?php do{?>
			<div style="margin-top: 50px;">
				<img src="<?php echo $row1[0]?>" width="150px;"></div>
		<?php
		}while($row1=mysql_fetch_row($result1)); 
			?>
		</div>
    <?php 
    do{
    ?>  
    <div style="width: 300px;float: left;" >
        <div style="width: 650px;height: 210px;margin-top: 60px;">
        	 
            <div style="float: right;margin-left:10px;height: 210px;width: 620px">
                <div> 
                	<p style="margin-bottom: 10px;width: 120px"><?php echo $row[6]?></p>
                    <p style="margin-bottom: 10px;width: 130px"><?php echo $row[3]?></p>
                    <p style="margin-bottom: 10px;width: 120px"><?php echo $row[4]?></p>
                    <p style="margin-bottom: 10px;width: 120px"><?php echo $row[5]?></p>
                   
                </div>
            </div>
        </div>
    <?php 
        }while($row=mysql_fetch_row($result)); 
    ?></div>
</div>
</body>
<?php 

if(isset($_COOKIE['user']))     
{
    $username = $_COOKIE['user'];
    echo "<script>
    document.getElementById('ab').innerText= '$username';
    </script>";
}
mysql_close($link);    
?>
</html>