<?php
/**
 * @var $dbc mysqli
 */
require_once '../dataBase/mysqli_connect.php';
require_once '../class/Cinema.php';
//查询服务
header("Content-Type: application/json;charset=utf-8");
if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])&&$_SERVER['REQUEST_METHOD']=='POST') {
    //从电影库中搜索，要求关键字搜索
    if (isset($_POST['search'])&&$_POST['search']!="") {
        $response=[];
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
                $image = safeSelectQuery($dbc,
                    'select url from images where name=?',
                    [$movie->getName()]);
                $response[]=[
                    'name'=>$movie->getName(),
                    'image'=>$image->fetch_row()[0],
                    'id'=>$movie->getId(),
                    'time'=>$movie->getTime(),
                    'director'=>$movie->getDirector(),
                    'country'=>$movie->getCountry(),
                    'length'=>$movie->getLength(),
                    'introduce'=>$movie->getIntroduce()
                ];
            }
        }
        echo json_encode($response);
    }
}
?>
