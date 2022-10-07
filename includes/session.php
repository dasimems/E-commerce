<?php
session_start();

function errormessage()
{
    if (isset($_SESSION['errormessage']) || !empty($_SESSION['errormessage'])) {
        $message = $_SESSION['errormessage'];
        $output = "<div class='display-message'><p class='message' id='error-message'>{$message}</p></div>";
        $_SESSION["errormessage"] = null;
        return $output;
    }
}

function sucessmessage()
{
    if (isset($_SESSION['successmessage']) || !empty($_SESSION['successmessage'])) {
        $message = $_SESSION['successmessage'];
        $output = "<div class='display-message'><p class='message' id='success-message'>{$message}</p></div>";
        $_SESSION["successmessage"] = null;
        return $output;
    }
}

function checkotp()
{
    if (isset($_GET['update']) && (isset($_GET['phone']) || isset($_GET['email']))) {
        if ($_GET['update'] === 'updatephone' || $_GET['update'] === 'updateemail') {
            if (isset($_SESSION['new_phone']) || isset($_SESSION['new_email'])) {
                if (!empty($_SESSION['new_phone']) || !empty($_SESSION['new_email'])) {
                    echo 'style="display: flex;"';
                }
            }
        }
    }
}

function returnValue($value)
{
    return $value;
}
