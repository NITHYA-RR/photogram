<?php

trait SQlGetterSetter{


    public function __call($name, $arguments)
{
    if (substr($name, 0, 3) == "get" || substr($name, 0, 3) == "set") {
        $raw = substr($name, 3); // remove "get" or "set"
        // convert CamelCase → snake_case
        $property = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $raw));
        
        // Debug line:
        // echo "<pre>$name → $property</pre>";

        if (substr($name, 0, 3) == "get") {
            return $this->_get_data($property);
        } elseif (substr($name, 0, 3) == "set") {
            return $this->_set_data($property, $arguments[0]);
        }
    }

    throw new Exception("_CLASS_.::__call() → $name, function unavailable.");
}
private function _get_data($var){
    $allowed = ['id', 'post_text', 'multiple_images', 'image_url', 'like_count', 'owner', 'created_at'];  // Add your real columns
    if (!in_array($var, $allowed)) {
        throw new Exception("Invalid column '$var' requested.");
    }

    if(!$this->conn){
        $this->conn = Database::getConnection();
    }
    $sql = "SELECT `$var` FROM `post` WHERE `id`= $this->id";
    $result = $this->conn->query($sql);
    if($result and $result->num_rows == 1){
        return $result->fetch_assoc()["$var"];
    }
    else{
        return null;
    }
    
}

private function _set_data($var, $data){
    if(!$this->conn){
        $this->conn = Database::getConnection();
    }
    $sql = "UPDATE `post` SET `$var`='$data' WHERE `id`= $this->id";
    $result = $this->conn->query($sql);
    if($result){
        return true;
    }
    else{
        return false;
    }
    
}
}