<?php
function printJson($success = false, $message = "", $data = [])
{
    header("content-type: application/json");
    echo json_encode(
        [
            "success" => $success,
            "message" => $message,
            "data" => $data
        ]
    );
}
