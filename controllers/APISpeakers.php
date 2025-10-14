<?php
namespace Controllers;

use Model\Speaker;

class APISpeakers {
    public static function index() {
        $speakers = Speaker::allWithJoins();
        echo json_encode($speakers);
    }
}