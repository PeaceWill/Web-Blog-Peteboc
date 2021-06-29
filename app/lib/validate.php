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

    public function validateEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        } else {
            return true;
        }
    }

    public function validateImage($image) {
        $imageType = pathinfo($image, PATHINFO_EXTENSION);
        $validType = array('jpg', 'png', 'jpeg');
        if (in_array(strtolower($imageType), $validType)) {
            return true;
        } else {
            return false;
        }
    }

    public function validateGender($gender)
    {
        $validGender = array(1,0,-1);
        if (in_array($gender, $validGender)) {
            return true;
        } else {
            return false;
        }
    }
}
?>