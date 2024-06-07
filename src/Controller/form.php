<?php
function emptyInputSignup($email, $username, $pwd, $pwdRepeat)
{
    if (empty($email) || empty($username) || empty($pwd) || empty($pwdRepeat)) {
        return true;
    } else {
        return false;
    }
}

function emptyInputLogin($usernameLogin, $pwdLogin)
{
    if (empty($usernameLogin) || empty($pwdLogin)) {
        return true;
    } else {
        return false;
    }
}

function pwdMatch($pwd, $pwdRepeat)
{
    if ($pwd !== $pwdRepeat) {
        return true;
    } else {
        return false;
    }
}

function validInput($input, $inputType)
{
    $lowercaseLetters = "abcdefghijklmnopqrstuvxyz";
    $uppercaseLetters = "ABCDEFGHIJKLMNOPQRSTUVXYZ";
    $numbers = "0123456789";
    $specialCharactersPassword = "+-_~@*%$";
    $specialCharactersUsername = "-_";
    $charactersAllowedUsername = $lowercaseLetters . $uppercaseLetters . $numbers . $specialCharactersUsername;
    $charactersAllowedPassword = $lowercaseLetters . $uppercaseLetters . $numbers . $specialCharactersPassword;
    $charactersAllowedComment = $charactersAllowedPassword;
    if (empty($input) || strlen($input) > 200) {
        return false;
    }
    if ($inputType == 0) {
        if (!checkInputStringFilter($input, $charactersAllowedUsername) || strlen($input) < 5 || strlen($input) > 10)
            return false;
        else
            return true;
    } else if ($inputType == 1) {
        if (filter_var(filter_var($input, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL) == false) {
            return false;
        } else {
            return true;
        }
    } else if ($inputType == 2) {
        if (
            !checkInputStringFilter($input, $charactersAllowedPassword) || strlen($input) < 8 || !checkStringContains($input, $uppercaseLetters) ||
            !checkStringContains($input, $numbers) || !checkStringContains($input, $specialCharactersPassword)
        )
            return false;
        else
            return true;
    } else if ($inputType == 3) {
        if (!checkInputStringFilter($input, $charactersAllowedComment))
            return false;
        else
            return true;
    }
}

function checkUppercase($input)
{
    for ($i = 0; $i < strlen($input); $i++) {
        if ($input[$i] >= 65 && $input[$i] <= 90)
            return false;
    }
    return true;
}

function checkStringContains($input, $filter)
{
    for ($i = 0; $i < strlen($input); $i++) {
        if (checkInputCharFilter($input[$i], $filter))
            return true;
    }
    return false;
}

function checkInputStringFilter($input, $filter)
{
    for ($i = 0; $i < strlen($input); $i++) {
        if (!checkInputCharFilter($input[$i], $filter))
            return false;
    }
    return true;
}

function checkInputCharFilter($input, $filter)
{
    for ($i = 0; $i < strlen($filter); $i++) {
        if ($input == $filter[$i])
            return true;
    }
    return false;
}
