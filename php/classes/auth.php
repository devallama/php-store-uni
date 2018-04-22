<?php
session_start();

function loginUser($username, $isAdmin) {
    $_SESSION['user'] = ['username' => $username, 'isAdmin' => $isAdmin];
}

function isLoggedIn() {
    if(isset($_SESSION['user'])) {
        return true;
    }
    return false;
}

function isAdmin() {
    if(isset($_SESSION['user']['isAdmin']) && $_SESSION['user']['isAdmin'] == 1) {
        return true;
    } 
    return false;
}

function getUser() {
    if(isLoggedIn()) {
        return $_SESSION['user']['username'];
    }
    return false;
}

function loggedInOnly() {
    if(!isLoggedIn()) {
        $response = [
            'message' => 'You must be logged in to view this page.',
        ];
        $_SESSION['response'] = $response;
        header('Location: ' . getRootPath() . '/index.php');
        exit();
    }
    return;
} 

function adminOnly() {
    if(!isAdmin()) {
        $response = [
            'message' => 'You must be an administrator to access this page.',
        ];
        $_SESSION['response'] = $response;
        header('Location: ' . getRootPath() . 'index.php');
        exit();
    }
    return;
}

function logout() {
    session_destroy();
    session_start();
}