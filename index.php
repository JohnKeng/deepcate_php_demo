<?

echo "<h1>無限分類實作</h1>";
echo "無限分類是開發中經常會用的到功能，下面有經典的遞歸實現和全路徑實現兩種方式。<br/><br/>";
echo "註：此範例用意是展示如何使用無限分類的數據，實際上與無限分類技術沒有關係。<br/>資料庫中的無限類別數據都是手動插入的。且實際業務上大多以JSON格式讓前端用JS來做演示的效果。<br/>使用無限分類資料結構結合遞歸的方式，在實際開發上是很實用的；而全路徑方式沒有實際的開發意義，程序健壯性差。<br/>";

echo "<br/>----------<br/>";
echo "原理：以pid為父節點id，使用遞歸函數根據 WHERE id=pid找出上一級並遞歸至頂層";


echo "<br/><br/>遞歸方法：";
echo "<a href='Recursion.php'>mysqli_connect</a> ";
echo "<a href='Recursion_PDO.php'>PDO</a><br/><br/>";





echo "完整資料表如下：<br/>";
echo "<pre>";
    require_once('db_inc.php');
    $sql    = 'SELECT * FROM `deepcate`';
    $result = $link->query($sql);

    while( $row = $result->fetch_array(MYSQLI_ASSOC) ){
        $catename = $row['catename'];
        $id = $row['id'];
        $pid = $row['pid'];
        $path = $row['path'];
        echo "id: $id \t pid: $pid \t path: $path \t catename: $catename <br />";
    }

echo "</pre>";


echo "<br/>----------<br/>";
echo "原理：利用fullpath字段做正序排列，再以字段長度計算層級深度<br/>全路徑優點是查詢方便，缺點是增加/移動分類時難維護";
echo "<br/><br/>全路徑方法：";
echo "<a href='Fullpath.php'>mysqli_connect</a> ";
echo "<br/><br/>全路徑(fullpath select) 資料表如下：<br/>";
echo "<pre>SELECT id,catename,path,concat(path,',',id) as fullpath FROM `deepcate` where 1 order by fullpath asc; </pre>";
echo "<pre>";

    $sqlfullpath    = "SELECT id,catename,path,concat(path,',',id) as fullpath FROM `deepcate` where 1 order by fullpath asc";
    $rs = $link->query($sqlfullpath);
 

    while( $row = $rs->fetch_array(MYSQLI_ASSOC) ){
        $catename = $row['catename'];
        $id = $row['id'];
        $fullpath = $row['fullpath'];
        echo "id: $id \tcatename: $catename \tfullpath: $fullpath  <br />";
    }

echo "</pre>";
    mysqli_free_result($result);
    mysqli_close($link);

 


    // 遞歸函數示範
    // function deeploop(&$i = 1){
    //     echo $i;
    //     $i++;
    //     if($i<10){ deeploop($i); }
    // }
    // deeploop();
