<?php
${basename(__FILE__, '.php')} = function () {
    $result = [
        "success" => true,
        "message" => "Invalid Request"

    ];
    $this->response($this->json($result), 200);
    error_log("delete.php function called");
};
