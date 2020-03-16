   <?php 

   header('content-type:text/html;charset=utf-8');
    @$link = mysql_connect('localhost:3306','root','') or die('连接数据库失败，原因：'.mysql_error());
    mysql_query('set names utf8');
    $db_selected=mysql_query("use movie_info",$link);
    $result = mysql_query(" select * from info",$link);
    $row = mysql_fetch_row($result);


    
    do{
        if ($row[5] > date("Y-m-d")){
    ?>
    <a style="display: block; width: 810px" href="goupiao.php?movie=<?php echo $row[2]; ?>">
        <div style="width: 800px;height: 210px;margin-top: 50px">
            <div style="float: left;">
                <img src="<?php echo $row[1]; ?>" width='150px'>
            </div>
            <div style="float: left;margin-left: 20px;height: 210px;width: 620px">
                <div>
                    <p style="margin-bottom: 5px;width: 120px"><?php echo $row[3]?></p>
                    <p style="margin-bottom: 5px;width: 120px"><?php echo $row[4]?></p>
                    <p style="margin-bottom: 5px;width: 120px"><?php echo $row[5]?></p>
                    <p style="margin-bottom: 5px;width: 120px"><?php echo $row[6]?></p>
                    <p style="margin-top: 20px;text-align: left;"><?php echo $row[7]?></p>
                </div>
            </div>
        </div>
    <?php 
    }
        }while($row=mysql_fetch_row($result)); 
    ?></a>