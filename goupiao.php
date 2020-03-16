<?php
	header('content-type:text/html;charset=utf-8');
	@$link = mysql_connect('localhost:3306','root','') or die('连接数据库失败，原因：'.mysql_error());
	mysql_query('set names utf8');
	$db_selected=mysql_query("use movie_info",$link);
	  	$cur_q=parse_url($_SERVER["REQUEST_URI"],PHP_URL_QUERY);
        parse_str($cur_q,$myArray);
        $movie = $myArray["movie"];
	$result = mysql_query(" select * from info where name = '$movie'",$link);
	$row = mysql_fetch_row($result);

	 if(!empty($_POST)){
        $fields = array('user','pwd');
        $values = array($_POST['name'],$_POST['pwd']);
        $sql = "select * from user_info";
        $result1 = mysql_query($sql,$link);
        $goods=array();
        while ($result2=mysql_fetch_assoc($result1)) {
            $goods[]=$result2;
        }
        for($i=0;$i<count($goods);$i++) {
            if($values[0]==$goods[$i]['user']) {        
                if($values[1]==$goods[$i]['pwd']) {
                    setcookie("user",$_POST['name'],time()+1000);
                    $UserName=$goods[$i]['user'];
                    echo "
                    <script src='js/jquery-3.4.1.js'></script>
                    <script>
                    $(document).ready(function(){
                        document.getElementById('ab').innerHTML= $UserName;
                    });
                     window.location.href = 'goupiao.php';
                    </script>";

                }else {
                    echo "<script>
                    alert('密码错误');
                    window.location.href = 'goupiao.php';
                    </script>";
                    break;
                }
            }
        } 
        if($i>=count($goods))
            echo "<script>
                  alert('用户不存在');
                  window.location.href = 'goupiao.php';
                  </script>";       
        mysql_free_result($result1);  
    }

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>购票</title>
	<link rel="stylesheet" href="css/css.css">

	 <script src="js/jquery-3.4.1.js"></script>
    <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
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



	<?php do{ ?>
	<div class="img" align="center"><img src="<?php echo $row[1]?>" width="80px" height="115px"></div>
	<div class="brief1">
		<p style="text-align: center;font-size: 20px;font-weight: bold;margin-top: 10px"><?php echo $row[2]?></p>
		<p style="text-align: center;opacity: 0.8;margin-top: 10px;"><?php echo $row[4]?>-<?php echo $row[3]?>-<?php echo $row[6]?></p>
	</div>
		  <style>
	ul{margin:0;padding:0;}
	li{list-style:none;}
	.box{background: #127bab; width: 455px; margin: auto;overflow: hidden;line-height: 30px; height: 30px; position:relative;}
	.box ul li{float:left;display:inline; vertical-align:top;height:30px;line-height:30px;margin: 0 20px;cursor: pointer;}
	.box ul {position: absolute;}
	.box span{float:left;height:100%;line-height:30px;font-size:16px;background:#ccc;width:30px;text-align:center;}
	.menu1{float:left; width:395px;overflow:hidden; height:30px; position:relative;}
	.prev{cursor: pointer;}
	.next{cursor: pointer;}

	</style>
    <script>
	window.onload=function(){
		var oBox=document.getElementById('box');
		var aSpan=oBox.getElementsByTagName('span');
		var oMenu=oBox.getElementsByTagName('div')[0];
		var oUl=oMenu.getElementsByTagName('ul')[0];
		var aLi=oUl.getElementsByTagName('li');
		var iW=0;
		for(var i=0;i<aLi.length;i++)
		{
			iW+=aLi[i].offsetWidth;
		}
		oUl.style.width=iW+210+'px';
		aSpan[0].onclick=function()
		{
			var iLeft=oUl.offsetLeft+150;
			iLeft>=0&&(iLeft=0);
			oUl.style.left=iLeft+'px';
		}
		aSpan[1].onclick=function()
		{

			var iLeft=oUl.offsetLeft-150;
			var maxLeft=oMenu.offsetWidth-oUl.offsetWidth;
			iLeft<=maxLeft&&(iLeft=maxLeft);

			oUl.style.left=iLeft+'px';
		}
	}
    </script>
	<div class="box" id="box">
        <span class="prev"><</span>
        <div class="menu1">
          <ul>
            <li id="time1" class="menu-click"></li>
            <li id="time2"></li>
            <li id="time3"></li>
            <li id="time4"></li>
            <li id="time5"></li>
          </ul>
      </div>
      <span class="next">></span> </div>
      </body>
	<div class="showing">
		<div class="showing-item">
			<span class="showing-time">14:25-16:16散场</span>
			<span class="showing-part">国语2D 1号厅</span>
			<span class="price">￥31.9</span>
			<a href="xuanzuo.php?time=14:25-16:16散场&name=<?php echo $row[2] ?>"><button class="buy">购票</button></a>
		</div>
		<div class="showing-item">
			<span class="showing-time">15:35-17:26散场</span>
			<span class="showing-part">国语2D 6号厅</span>
			<span class="price">￥31.9</span>
			<a href="xuanzuo.php?time=15:35-17:26散场&name=<?php echo $row[2] ?>"><button class="buy">购票</button></a>
		</div>
		<div class="showing-item">
			<span class="showing-time">16:30-18:21散场</span>
			<span class="showing-part">国语2D 1号厅</span>
			<span class="price">￥31.9</span>
			<a href="xuanzuo.php?time=16:30-18:21散场&name=<?php echo $row[2] ?>"><button class="buy">购票</button></a>
		</div>
		<div class="showing-item">
			<span class="showing-time">17:40-19:31散场</span>
			<span class="showing-part">国语2D 6号厅</span>
			<span class="price">￥31.9</span>
			<a href="xuanzuo.php?time=17:40-19:31散场&name=<?php echo $row[2] ?>"><button class="buy">购票</button></a>
		</div>
		<div class="showing-item">
			<span class="showing-time">18:35-20:26散场</span>
			<span class="showing-part">国语2D 1号厅</span>
			<span class="price">￥31.9</span>
			<a href="xuanzuo.php?time=18:35-20:26散场&name=<?php echo $row[2] ?>"><button class="buy">购票</button></a>
		</div>
		<div class="showing-item">
			<span class="showing-time">19:45-21:36散场</span>
			<span class="showing-part">国语2D 6号厅</span>
			<span class="price">￥31.9</span>
			<a href="xuanzuo.php?time=19:45-21:36散场&name=<?php echo $row[2] ?>"><button class="buy">购票</button></a>
		</div>
	</div>
	<?php 
			}while($row=mysql_fetch_row($result)); 
		?>
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


					$(".buy").click(function(){


            			var href = $(this).parent()[0].href;
            			href = href + '&day=' + $('li.menu-click')[0].innerText;
            			$('.showing-item  a').attr('href', href);
					});


			


            		$("li").click(function(){
            			$(this).addClass("menu-click");
            			$(this).siblings().removeClass("menu-click");
            		});

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

            		function personal(){
            			if(document.getElementById('ab').innerHTML == "亲，请登录"){
            				alert('请先登录');
            			}
            			else{
            				window.location.href = 'personal.php';
            			}
            		}


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


	    			var day1 = new Date();
            		day1.setTime(day1.getTime()-24*60*60*1000);
 					var s1 = day1.getFullYear()+"-" + (day1.getMonth()+1) + "-" + day1.getDate();
 					document.getElementById('time1').innerHTML = s1;
	    			var day2 = new Date();
            		day2.setTime(day2.getTime());
 					var s2 = day2.getFullYear()+"-" + (day2.getMonth()+1) + "-" + day2.getDate();
 					document.getElementById('time2').innerHTML = s2;
	    			var day3 = new Date();
            		day3.setTime(day3.getTime()+24*60*60*1000);
 					var s3 = day3.getFullYear()+"-" + (day3.getMonth()+1) + "-" + day3.getDate();
 					document.getElementById('time3').innerHTML = s3;
	    			var day4 = new Date();
            		day4.setTime(day4.getTime()+2*24*60*60*1000);
 					var s4 = day4.getFullYear()+"-" + (day4.getMonth()+1) + "-" + day4.getDate();
 					document.getElementById('time4').innerHTML = s4;
	    			var day5 = new Date();
            		day5.setTime(day5.getTime()+3*24*60*60*1000);
 					var s5 = day5.getFullYear()+"-" + (day5.getMonth()+1) + "-" + day5.getDate();
 					document.getElementById('time5').innerHTML = s5;
			</script>
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