<?php
class Get{

    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;    
    }

    public function getStudents($id = null){
        $sql = "SELECT * FROM students ";

        if($id != null){
            $sql .= " WHERE recno = $id";
        }

        $data = array();
        $errmsg = "";
        $code = 0;

        try{
            
            if($result = $this->pdo->query($sql)->fetchAll()){
                foreach($result as $record){
                   array_push($data, $record); 
                }
                $result = null;
                $code = 200;
                
                return array(
                    "code"=>$code, 
                    "data"=>$data
                );
            }
            else{
                $errmsg = "No data found";
                $code = 404;
            }


        }
        catch(\PDOException $err){
            $errmsg = $err->getMessage();
            $code = 403;
        }
        
        return array("code"=>$code, "errmsg"=>$errmsg);

    }

    public function getFaculty(){
        return "This is ur faculty.";
    }


}
?>