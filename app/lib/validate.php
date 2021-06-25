<?php
class Validate {
    
    public function checkSpecialChar($data) {
        $regex = " #$%^&*()+=-[]';,./{}|:<>?~";
        if (strpbrk($data, $regex)) {
            return false;
        } else {
            return true;
        }
    }

    public function filter($data) {
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
?>