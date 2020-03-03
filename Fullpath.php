<?
    require_once('db_inc.php');
    echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">'; 

 
    function getCatePath($id){
        $sql = "SELECT * FROM `deepcate` WHERE id={$id}";
        $rs = mysqli_query($GLOBALS['link'], $sql);
        $row = mysqli_fetch_assoc($rs);
        $selfname=$row['catename'];
        $arr=explode(',',$row['path']);
        $str='';
        foreach($arr as $k=>$v){
            $sql="SELECT `catename` FROM `deepcate` where id={$v}";
            $result = mysqli_query($GLOBALS['link'], $sql);
            $catename=implode('',mysqli_fetch_assoc($result));
            if($k==count($arr)-1){
                $str=$str."<a href='conn.php'>"."$catename"."</a>"."><a href='conn.php'>$selfname</a>";
            }else{
                $str.="<a href='conn.php'>"."$catename"."</a>".">";
            }
        }
        return $str;
    }
    
    $res=getCatePath(10);
    echo "$res<br/><br/>";



    function cateList($path="",$result=[]){
        $sql = "SELECT id,catename,path,concat(path,',',id) as fullpath FROM `deepcate` WHERE 1 order by fullpath asc";
        $rs = mysqli_query($GLOBALS['link'], $sql);

        while( $row = mysqli_fetch_assoc($rs) ){
            // var_dump($row['fullpath']."$$$".$row['catename']);
            $deep=explode(',',trim($row['fullpath'],','));
            // 長度是按照fullpath的個數計算的
            $row['catename']=str_repeat("&nbsp;&nbsp;",intval(count($deep))).$row['catename'];
            $result[]=$row;
        }
        return $result;
    }
    
    function display(){
        $res=cateList();
        echo "<select name='deepcate'>";
        foreach($res as $k=>$v){
            echo "<option>{$v['catename']}</option>";
        }
        echo "</select>";
    }
    
    display();