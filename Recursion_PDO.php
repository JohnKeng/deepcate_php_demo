<?
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">'; 
// 連線
function conn(){
    try{
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=world",'root','myroot');
        $pdo->exec("set names utf8");
        return $pdo;
    }catch(PDOException $ex){
        $ex->getMessage();
    }
}



function getCatePath($cid,&$result=[]){
    $pdo = conn();
    $sql = "SELECT * FROM deepcate WHERE id=$cid";
    $res = $pdo->prepare($sql);
    $res->execute();
    $row = $res->fetch(PDO::FETCH_ASSOC);
    //print_r($row);
    if($row){
        $result[]=$row;
        getCatePath($row['pid'],$result);
    }
    krsort($result);
    return $result;
}
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


function cateList($pid = 0,$result = [],$num = 0){
    $num++;
    $pdo = conn();
    $sql = "select * from deepcate where pid = " . $pid;
    $res = $pdo->prepare($sql);
    $res->execute();
    while($data = $res->fetch(PDO::FETCH_ASSOC)){
        static $result;
        $data['catename'] = str_repeat("&nbsp;&nbsp;",$num) . $data['catename'];
        $result[] = $data;
        cateList($data['id'],$result,$num);
    }
    return $result;
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