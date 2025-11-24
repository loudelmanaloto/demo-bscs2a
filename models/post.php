<?php
class Post{

    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;    
    }

    public function addStudent($data){
        $values = [];
        $errmsg = "";
        $code = 0;
        $sql = "INSERT INTO students(studentid, fullname) VALUES (?,?)";

        foreach($data as $value){
            array_push($values, $value);
        }

        try{
            $preparedStmt = $this->pdo->prepare($sql);
            $preparedStmt->execute($values);
            $code = 200;
            $data = null;

            return array("data"=>$data, "code"=>$code);
        }
        catch(\PDOException $err){
            $errmsg = $err->getMessage();
            $code = 400;
        }
        return array("errmsg"=>$errmsg, "code"=>$code);
    }

    
    public function editStudent($data){
        $errmsg = "";
        $code = 0;
        $sql = "UPDATE students SET fullname = ?, studentid = ? WHERE recno = ?";

        try{
            $preparedStmt = $this->pdo->prepare($sql);
            $preparedStmt->execute([$data->fullname, $data->studentid, $data->recno]);
            $code = 200;
            $data = null;

            return array("data"=>$data, "code"=>$code);
        }
        catch(\PDOException $err){
            $errmsg = $err->getMessage();
            $code = 400;
        }
        return array("errmsg"=>$errmsg, "code"=>$code);
    }

    public function archiveStudent($data){
        $errmsg = "";
        $code = 0;
        $sql = "UPDATE students SET is_archived = 1 WHERE recno = ?";

        try{
            $preparedStmt = $this->pdo->prepare($sql);
            $preparedStmt->execute([$data->recno]);
            $code = 200;
            $data = null;

            return array("data"=>$data, "code"=>$code);
        }
        catch(\PDOException $err){
            $errmsg = $err->getMessage();
            $code = 400;
        }
        return array("errmsg"=>$errmsg, "code"=>$code);
    }
    
    
    public function deleteStudent($id){
        $errmsg = "";
        $code = 0;
        $sql = "DELETE FROM students WHERE recno = ?";

        try{
            $preparedStmt = $this->pdo->prepare($sql);
            $preparedStmt->execute([$id]);
            $code = 200;
            $data = null;

            return array("data"=>$data, "code"=>$code);
        }
        catch(\PDOException $err){
            $errmsg = $err->getMessage();
            $code = 400;
        }
        return array("errmsg"=>$errmsg, "code"=>$code);
    }






    public function addFaculty(){
        return "This is ur post method faculty.";
    }


}
?>