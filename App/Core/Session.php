<?php
declare(strict_types=1);

namespace App\Core;

class Session {
    public static function setFlash($type, $message) {
        $_SESSION['flash'][$type] = $message;
    }

    public static function getFlash($type) {
        if (isset($_SESSION['flash'][$type])) {
            $msg = $_SESSION['flash'][$type];
            unset($_SESSION['flash'][$type]);
            return $msg;
        }
        return null;
    }
}