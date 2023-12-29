<?php
/**
 * @var $dbc mysqli
 */
require_once '../dataBase/mysqli_connect.php';
require_once '../class/Cinema.php';
//查询服务
if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])&&$_SERVER['REQUEST_METHOD']=='POST') {
    //从电影库中搜索，要求关键字搜索
    if (isset($_POST['search'])&&$_POST['search']!="") {
        $searches=preg_split('/\s+/',$_POST['search']);
        foreach ($searches as $search){
            $result = safeSelectQuery($dbc,
                'SELECT * FROM cinema WHERE name LIKE ?',
                ["%$search%"]);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_row()) {
                    $movies[$row[0]]=new Cinema(...$row);
                }
            }
        }
        if(isset($movies)){
            foreach ($movies as $movie){
                addCinemaCard($dbc, $movie->getName());
            }
        }else{
            echo '<div style="text-align: center;width: 100%;color: #6e6e6e">没有找到相关电影</div>';
        }
    }else{
        echo '<div style="text-align: center;width: 100%;color: #6e6e6e">没有找到相关电影</div>';
    }
}


function addCinemaCard($dbc, $name)
{
    $result = safeSelectQuery($dbc,
        'select * from images where name=?',
        [$name]);
    echo <<<EOF
    <div class="cinema-card">
        <div class="cinema-image">
            <img src="../../{$result->fetch_row()[1]}" alt="加载失败">
        </div>
        <div class="content">
            <div class="cinema-name">$name</div>
        <div class="button-div">
            <a href="cinemaDetails.php?name=$name" target="_blank" class="go-button">
                <span class="button-content">查看详情</span>
            </a>
        </div>       
        </div>
    </div>
EOF;
}
?>
