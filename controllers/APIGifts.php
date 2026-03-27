<?php
namespace Controllers;

use Model\Gift;
use Model\Register;

class APIGifts {
    public static function index() {

        if(!isAdmin()) {
            echo json_encode([]);
            return;
        }
        
        $gifts = Gift::allWithJoins();

        foreach($gifts as $gift) {
            $gift->total = Register::totalArray(["gift_id" => $gift->id, "package_id" => 1]);
        }

        echo json_encode($gifts);
        return;
    }
}