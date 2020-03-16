<?php
	header('content-type:text/html;charset=utf-8');
	@$link = mysql_connect('localhost:3306','root','') or die('连接数据库失败，原因：'.mysql_error());
	mysql_query('set names utf8');
	$db_selected=mysql_query("use movie_info",$link);
	$result = mysql_query(" select * from info",$link);
	$row = mysql_fetch_row($result);

    // session_start();
    // $_SESSION['user'] = $_POST['user'];
    // $_SESSION['pwd'] = $_POST['pwd'];

    if(!empty($_POST)){
        $fields = array('name','pwd');
        $values = array($_POST['name'],md5($_POST['pwd']));
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
                     window.location.href = 'zhuye.php';
                    </script>";

                }else {
                    echo "<script>
                    alert('密码错误');
                    window.location.href = 'zhuye.php';
                    </script>";
                    break;
                }
            }
        }   
        if($i>=count($goods))
            echo "<script>
                  alert('用户不存在');
                  window.location.href = 'zhuye.php';
                  </script>";       
        mysql_free_result($result1);            
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Title</title>
    <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css\css.css">
    <script src="js/jquery-3.4.1.js"></script>
    <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
</head>
<body style="min-width: 800px">
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
<div id="carousel-example-generic" class="carousel slide row" data-ride="carousel"
     style="position: relative;height: 290px;margin: 0px">
    <ol class="carousel-indicators" style="position: absolute;bottom: 60px">
        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
        <li data-target="#carousel-example-generic" data-slide-to="3"></li>
        <li data-target="#carousel-example-generic" data-slide-to="4"></li>
    </ol>
    <div class="btn-gp">
        <button class="btn btn-active actively now_movie" style="outline: none">正在热映</button>
        <button class="btn future_movie" style="outline: none">即将上映</button>
    </div>
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <div class="bg-img1"></div>
        </div>
        <div class="item">
            <div class="bg-img2"></div>
        </div>
        <div class="item">
            <div class="bg-img3"></div>
        </div>
        <div class="item">
            <div class="bg-img4"></div>
        </div>
        <div class="item">
            <div class="bg-img5"></div>
        </div>
    </div>
    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<div class="movie">
    
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

    $('.now_movie').click(function(){
        $('.movie').load('now_movie.php');
    });

    $('.future_movie').click(function(){
        $('.movie').load('future_movie.php')
    }) ; 

    $(".btn-gp").find("button").hover(function () {
        $(this).addClass("btn-active");
    }, function () {
        $(this).removeClass("btn-active")
    });

    $(".btn").on("click",function () {
        $(this).addClass("actively");
        $(this).siblings().removeClass("actively")
        $(this).siblings().removeClass("btn-active")
    });


    $(document).ready(function(){
        $('.movie').load('now_movie.php');
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

