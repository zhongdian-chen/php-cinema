<?php
	header('content-type:text/html;charset=utf-8');
	@$link = mysql_connect('localhost:3306','root','') or die('连接数据库失败，原因：'.mysql_error());
	mysql_query('set names utf8');
	$db_selected=mysql_query("use movie_info",$link);

       if(!empty($_POST)){
        $fields = array('name','pwd');
        $values = array($_POST['name'],$_POST['pwd']);
        $sql = "select * from user_info";
        $result2 = mysql_query($sql,$link);
        $goods=array();
        while ($result2=mysql_fetch_assoc($result2)) {
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
                     window.location.href = 'xuanzuo.php';
                    </script>";

                }else {
                    echo "<script>
                    alert('密码错误');
                    window.location.href = 'xuanzuo.php';
                    </script>";
                    break;
                }
            }
        }   
        if($i>=count($goods))
            echo "<script>
                  alert('用户不存在');
                  window.location.href = 'xuanzuo.php';
                  </script>";       
        mysql_free_result($result2);            
    }


    $cur_q=parse_url($_SERVER["REQUEST_URI"],PHP_URL_QUERY);
    parse_str($cur_q,$myArray);
    $time = $myArray["time"];
    $day = $myArray["day"];
    $moviename = $myArray["name"];

    $result = mysql_query(" select * from info where name ='$moviename' ",$link);
    $row = mysql_fetch_row($result);

    $username = $_COOKIE['user'];
    $result1 = mysql_query(" select seat from buy_info where showing = '$time' and day = '$day' and name = '$moviename' and username = '$username'",$link);
    $row1 = mysql_fetch_row($result1);
  
  
?>
<html>
<head>
	<title>座位预定</title>
	<meta charset="UTF-8">
	<link href="stylecss.css" rel="stylesheet" type="text/css" />
	<script src="js/jquery-3.4.1.js"></script>

    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	<script>
		$(document).ready(function(){

                var seat_num ;
                var total_bill      = 0 ;
                var pricePerTicked  = 30;//单价
                var maximumSeats    =   5;//预定座位数目的最大限制

                $('#bookNowButton').hide(); // 隐藏预定按钮

                $('.seat').each(function() {       
                    var column_num = parseInt( $(this).index() ) + 1;
                    var row_num = parseInt( $(this).parent().index() )+1;    
                    seat_num = row_num+"-"+column_num ;  
                    $(this).text(seat_num); // 座位号
                    $(this).addClass("seat"+seat_num);  // 个座位加css
                });

                $("#seats .seat").click(function() {  
                        $('#errMsg').html('');
                        if($(this).hasClass('select')){ // 检查是否被选中
                            $(this).removeClass('select'); //如果选中了，移除选中的css
                            $(this).css('background-color','#D8D8D8'); // 重新加个背景

                            var currentSeatClass = $(this).attr('class').split(' ')[1]; 

                            console.log(currentSeatClass);
                             $( "#selected_seat ."+currentSeatClass ).remove();

                        }else if($(".your_selected_seat").length<maximumSeats && !$(this).hasClass('select')){ // 检查预定的座位数目是否超出限制
                            $(this).css('background-color','#71DCAA'); // 加背景颜色
                            $(this).addClass("select"); // 添加选中css


                            var column_num = parseInt( $(this).index() ) + 1;
                            var row_num = parseInt( $(this).parent().index() )+1;
                            if(!$(this).hasClass('btn disabled')){
                            $( "#selected_seat" ).append("<span class='your_selected_seat seat"+row_num+"-"+column_num+" '> 座位号: <b style='color:#EAABFF'>" + row_num+"排"+column_num +"座"+"</b> </br></span>");}
                            else{
                                $(this).css('background-color','#D8D8D8');
                            }

                        }else {
                            $('#errMsg').html('您选中的座位已经超过限制.');    
                        }

                        if($(".your_selected_seat").length){
                            $('#bookNowButton').fadeIn(1000);
                        }else {
                            $('#bookNowButton').fadeOut(1000);
                        }
                        //计算总价
                        total_bill = $(".your_selected_seat").length * pricePerTicked+"元";
                        $('#total > span').html(total_bill);
               		 });
				});
</script>
<script type="text/javascript">
    function buy(){
        $.ajax({
        type: "POST",//方法
        url: "api.php" ,//表单接收url
        data: $('#myform').serialize(),
         success: function (msg) {   //请求成功后执行的操作
                    alert("购买成功");
                   window.location.reload()  //刷新页面
          }
   });
    }
	 $(function(){
      $("#bookNowButton").click(function() {
        x();
        y();
        z();
        a();
        $("#layer-mask").show();
        $("#layer-pop").show();
        $("#layer-close").click(function(){
            $("#layer-mask").hide();
           $("#layer-pop").hide();
         });
    });
 });

    $(function(){
        $("#loginlink").click(function() {
            $("#layer-mask1").show();
            $("#layer-pop1").show();
            $("#layer-close1").click(function(){
                $("#layer-mask1").hide();
                $("#layer-pop1").hide();
            });
        });
    });
</script>
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

<div class="ab" hidden="hidden">
        <?php 
            do{
        ?>          
            <?php echo $row1[0]?>
        <?php 
                }while($row1=mysql_fetch_row($result1)); 
        ?></div> 
        

<div id="layer-mask1" class="layer-mask1"></div>
            <!--弹出层窗体-->
            <div id="layer-pop1" class="layer-pop1">
                <!--弹出层关闭-->
                <div id="layer-close1" class="layer-close1">×</div>
                <!--弹出层内容-->
                <div id="layer-content1" class="layer-content1">
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

    function personal(){
        if(document.getElementById('ab').innerHTML == "亲，请登录"){
            alert('请先登录');
        }
        else{
            window.location.href = 'personal.php';
        }
    }

        var num2 = $('.ab')[0].innerText.replace(/\s*/g,"").split(':').length;
        var arr=[];
        for(var i=1;i<parseInt(num2);i++){
            arr.push($('.ab')[0].innerText.replace(/\s*/g,"").split(':')[i].charAt(0) + '-' + $('.ab')[0].innerText.replace(/\s*/g,"").split(':')[i].charAt(2));
        }

       $(document).ready(function(){

        for(var i=0;i<arr.length;i++){
            $('.seat'+ arr[i]).addClass('btn disabled');
        }

     });
        
       
       
   </script>

       <div style="width:900px;margin: 0 auto;">
            <span id='screen'>
             <p>
                座位预定
            </p>
            </span>
            <div id="seats">
                <div class="seatsRaw">
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                </div>

                  <div class="seatsRaw">
                    <div class="seat " ></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                </div>

                <div class="seatsRaw">
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                </div>

                <div class="seatsRaw">
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                </div>

                <div class="seatsRaw">
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                </div>

                <div class="seatsRaw">
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                </div>

                <div class="seatsRaw">
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                    <div class="seat"></div>
                </div>

            </div>

              <div id="booking_desc">
                <div class="booking_left">
                    <p style="color: #FBBC53;font-weight: bold; font-size: larger;">您选中的座位 </p>
                    <div id="selected_seat"></div>
                    <br>
                    <button id="bookNowButton" type="button" style="color: black;">现在预定</button>
                    <div id="errMsg"></div>
                </div>

                <div class="booking_right">每个座位的单价: 30.00 元
                    <br><br>
                    <div id="total">总价：<span> 0 </span></div>
                </div>
             </div>
        </div>
<div id="layer-mask" class="layer-mask"></div>
        <!--弹出层窗体-->
    <div id="layer-pop" class="layer-pop">
        <!--弹出层关闭-->
        <div id="layer-close" class="layer-close">×</div>
        <!--弹出层内容-->
        <div id="layer-content" class="layer-content">
        	<?php do{
    				?>			
            <div id="loginHtml" style="background-color: #EEEEEE;margin:0;padding: 0;">
                <!-- 登录窗体 -->
                <form method="post" action="xuanzuo.php" name="myform" id="myform" onsubmit="return false" >
                   <img src="<?php echo $row[1]?>" width="80px" height="135px" style="margin-left:5px;margin-top: 5px; ">
                  <input id="moviename" name="name-info" hidden />
                   <input id="day" name="day-info" hidden />
                    <input id="time" name="movie-info" hidden/>
                     <input id="seat1" name="seat-info" hidden/>
                      <input id="zong1" name="zong" hidden />
                <div style="float: right;margin-left:10px;margin-top: 5px;"> 
                    <div id="name-info" style="color: black;"></div>
                    <div id="day-info" style="color: black;"></div>
                    <div id="movie-info" style="color: black;"></div>
                    <div id="seat-info" style="color: black;width: 100px;" ></div>
                    <div id='zong' style="color: black;"></div>
                </div>
                <input type="submit" value="购买" class="btn btn-danger" onclick="buy()" style="margin-left: 60px;margin-top: 15px; width:100px;"/>
                 <p><div id="success"></div></p>
                </form>
            </div>
             <?php 
        			}while($row=mysql_fetch_row($result)); 
    	     ?>
        </div>
    </div>
    <script type="text/javascript">
                        function a(){
                            $('#moviename').attr('value', $('#name-info').text());
                            $('#day').attr('value', $('#day-info').text());
                            $('#time').attr('value', $('#movie-info').text());
                            $('#seat1').attr('value', $('#seat-info').text());
                            $('#zong1').attr('value', $('#zong').text());
                        }

                       function x(){
                            var url = decodeURI(location.search,"UTF-8").split("=")[1];
                            url = url.substr(0,url.indexOf('&'));
                            var day = decodeURI(location.search,"UTF-8").split("=")[3];
                            var moviename = decodeURI(location.search,"UTF-8").split("&")[1];
                            moviename = moviename.substr(5,moviename.indexOf('='));
                            document.getElementById("movie-info").innerHTML = url;
                            document.getElementById("day-info").innerHTML = day;
                            document.getElementById('name-info').innerHTML = moviename;
                        }
                         function y(){
                         $('#seat-info').html($('.your_selected_seat').text());
                        }
                         function z(){
                            $('#zong').html($('#total').text());
                        }
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

