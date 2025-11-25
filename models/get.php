<?php
class Get extends Common{

    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;    
    }

    public function getStudents($id = null){
        $sql = "SELECT * FROM students WHERE is_archived = 0 ";

        if($id != null){
            $sql .= " AND recno = $id";
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
                

                return $this->generateResponse($data, "Success", "Successfully retrieved records.", $code);
            }
            else{
                $errmsg = "No data found";
                $code = 404;

                return $this->generateResponse(null, "Failed", $errmsg, $code);

            }


        }
        catch(\PDOException $err){
            $errmsg = $err->getMessage();
            $code = 403;
        }
        
        return $this->generateResponse(null, "Failed", $errmsg, $code);
    }

    public function getFaculty(){
        return "This is ur faculty.";
    }


}
?>