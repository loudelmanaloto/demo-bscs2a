<?php

class Auth extends Common
{

    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    private function isSamePassword($inputPassword, $existingPassword)
    {
        $hash = crypt($inputPassword, $existingPassword);
      
        return $hash === $existingPassword;
    }

    private function generateSalt($length){
        $urs = md5(uniqid(mt_rand(), true));
        $b64String = base64_encode($urs);
        $mb64String = str_replace("+", ".", $b64String);
        return substr($mb64String, 0, $length);
    }

    private function encryptPassword($password){
        $hashFormat = "$2y$10$";
        $saltLength = 22;
        $salt = $this->generateSalt($saltLength);
        return crypt($password, $hashFormat . $salt);
    }


    public function login($data)
    {
        $username = $data->username;
        $password = $data->password;

        $code = 0;
        $remarks = "";
        $message = "";

        try {

            $sql = "SELECT * FROM accounts WHERE username = ?";
            $preparedStatement = $this->pdo->prepare($sql);
            $preparedStatement->execute([$username]);

            if ($preparedStatement->rowCount() > 0) {
                $result = $preparedStatement->fetchAll()[0];
                if ($this->isSamePassword($password, $result['password'])) {
                    $code = 200;
                    $remarks = "success";
                    $message = "Logged in successfully";

                    return $this->generateResponse(null, $remarks, $message, $code);
                }

                $code = 401;
                $remarks = "failed";
                $message = "Incorrect password";
                return $this->generateResponse(null, $remarks, $message, $code);
            } else {
                #user not found
                $code = 404;
                $remarks = "failed";
                $message = "User not found.";
                return $this->generateResponse(null, $remarks, $message, $code);
            }
        } catch (\PDOException $err) {
            $message = $err->getMessage();
            $code = 403;
        }

        return $this->generateResponse(null, $remarks, $message, $code);


        #retrieve user records
        #if user exists compare input password to retrieved password
        #if user doesnt exists throw an error message 
        #if password is not the same, throw an error message
    }


    public function addAccount($data)
    {
     
        $errmsg = "";
        $code = 0;
        $sql = "INSERT INTO accounts(username, password) VALUES (?,?)";
    
        try {
            $preparedStmt = $this->pdo->prepare($sql);
            $preparedStmt->execute([$data->username, $this->encryptPassword($data->password)]);
            $code = 200;
            $data = null;

            return array("data" => $data, "code" => $code);
        } catch (\PDOException $err) {
            $errmsg = $err->getMessage();
            $code = 400;
        }
        return array("errmsg" => $errmsg, "code" => $code);
    }
}
