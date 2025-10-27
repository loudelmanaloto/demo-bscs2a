<?php

include "./models/get.php";

$get = new Get();



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
                case 'student':
                        echo $get->getStudents();
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
          switch($req[0]){
                case 'addstudent':
                        echo "This is my post student";
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


?>