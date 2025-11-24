<?php

include "./config/database.php";
include "./models/get.php";
include "./models/post.php";


$db = new Connection();
$pdo = $db->connect();

$get = new Get($pdo);
$post = new Post($pdo);



if (isset($_REQUEST["request"])) {
    $req = explode('/', rtrim(($_REQUEST["request"]), "/"));
} else {
    $req = null;
    echo "No value found";
}

//$req <-- array
//example.com/ex1/ex2/ex3
//$req <-- [ex1, ex2, ex3]
switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
            switch($req[0]){
                case 'students':
                        echo json_encode($get->getStudents($req[1] ?? null));
                    break;
                case 'faculty':
                        echo $get->getFaculty();
                    break;
                case 'login':
                        echo "This is my get login";
                    break;
                default:
                    echo "No such route.";
                    break;
            }
        break;
    case 'POST':
          $data = json_decode(file_get_contents("php://input"));  
          switch($req[0]){
                case 'addstudent':
                        echo json_encode($post->addStudent($data));
                    break;
                case 'addfaculty':
                        echo "This is my post faculty";
                    break;
                case 'loginagain':
                        echo "This is my post login";
                    break;
                default:
                    echo "No such route.";
                    break;
            }
        break;
    case 'PUT';
        break;
}

$pdo = null;
?>