<?
    require_once('db_inc.php');
    echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">'; 

    // 遞歸麵包屑
    function getCatePath($cid,&$result=[]){
        $sql = "SELECT * FROM deepcate WHERE id=$cid";
        $rs  = mysqli_query($GLOBALS['link'], $sql);
        $row = mysqli_fetch_assoc($rs);
        //print_r($row);
        if($row){
            $result[]=$row;
            getCatePath($row['pid'],$result);
        }
        krsort($result);
        return $result;
    }
    //$res=getCatePath(10);
    //print_r($res);
    function displayCatePath($cid,$url="link.php?cid="){
        $res=getCatePath($cid);
        $str='';
        foreach ($res as $key => $value) {
            if($key==0){
                $str.="<a href='{$url}{$value['id']}'>{$value['catename']}</a>";
            }else{
                $str.="<a href='{$url}{$value['id']}'>{$value['catename']}</a>>";
            }
        }
        return $str;
    }

    echo displayCatePath(10,'link.php?page=2&id=');
    echo "<br/><br/>";



    // 遞歸下拉選單
    function cateList($pid=0, &$result_array=[], $spac=0){
        $spac = $spac + 2;
        $sql    = "SELECT * FROM `deepcate` WHERE `pid`=$pid";
        $result = mysqli_query($GLOBALS['link'], $sql);
        // $result = $GLOBALS['link']->query($sql);
        if(!$result) print_r($GLOBALS['link']->error);

        while( $row = $result->fetch_array(MYSQLI_ASSOC) ){
            $row['catename'] = str_repeat('&nbsp;&nbsp;', $spac).$row['catename'];
            $result_array[] = $row;
            cateList($row['id'], $result_array, $spac);
        }
        return $result_array;
    }

    function displayCate($pid=0,$select=1){
        $rs = cateList($pid);
        $str = '';
        $str.=  "<select name='cate'>";
        foreach ($rs as $k => $v) {
            $selectstr='';
            if($v['id']==$select){
                $selectstr="selected";
            }
            $str.= "<option {$selectstr}>{$v['catename']}</option>";
        }
        return $str.= "</select>";
    }
    echo displayCate(0,1);




















