<?php
class Common{
    public function generateResponse($data, $remark, $message, $statusCode){
        $status = array(
            "remark" => $remark,
            "message" => $message
        );

        http_response_code($statusCode);

        return array(
            "payload" => $data,
            "status" => $status,
            "prepared_by" => "Loudel Manaloto",
            "date_generated" => date_create()
        );
    }
}



?>