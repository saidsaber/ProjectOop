<?php

trait validation
{
    private function isMin($field, $number)
    {
        $data = $_POST[$field];
        if (!isset($_SESSION["error"][$field])) {
            if (strlen($data) < $number) {
                $_SESSION['error'][$field] = "must be more than $number";
            }
        }
    }

    private function isConfirm($field)
    {
        $fieldconfirm = "confirm-" . $field;
        if (!isset($_SESSION["error"][$field])) {
            if ($_POST[$field] !== $_POST[$fieldconfirm]) {
                $_SESSION['error'][$fieldconfirm] = "the $field is not confirmed";
            }
        }
    }

    private function isRequired($field)
    {
        $data = $_POST[$field];
        if (!isset($_SESSION["error"][$field])) {
            if ($data == null) {
                $_SESSION["error"][$field] = "$field is required";
            }
        }
    }

    private function isPhone($field)
    {
        $phone = $_POST[$field];
        if (!isset($_SESSION["error"][$field])) {
            if (!preg_match('/^01[0125][0-9]{8}$/', $phone)) {
                $_SESSION['error'][$field] = 'Please enter a valid phone number';
            }
        }
    }

    private function isEmail($field)
    {
        $email = $_POST[$field];
        if (!isset($_SESSION['error'][$field])) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'][$field] = 'Please enter a valid email';
            }
        }
    }
}