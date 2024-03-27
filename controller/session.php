<?php
// Hàm gán session
function setSession($key, $value) {
    $_SESSION[$key] = $value;
}

// Hàm lấy session
function getSession($key='') {
    if(empty($key)) {
        return $_SESSION;
    } else {
        if(isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }
}

// Hàm xóa session
function removeSession($key='') {
    if(empty($key)) {
        session_destroy();
        return true;
    }
    else {
        if(isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
            return true;
        }
    }
}

// Hàm gán flash data
function setFlashData($key, $value) {
    $key = "flash_" . $key;
    return setSession($key, $value);
}

// Hàm lấy flash data
function getFlashData($key) {
    $key = "flash_" . $key;
    $data = getSession($key);
    removeSession($key);
    return $data;
}
?>