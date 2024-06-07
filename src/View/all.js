const lowercaseLetters = "abcdefghijklmnopqrstuvxyz";
const uppercaseLetters = "ABCDEFGHIJKLMNOPQRSTUVXYZ";
const numbers = "0123456789";
const specialCharacters = ".+-_~@";
const usernameSpecialCharacters = "-_";
const pwdSpecialCharacters = "+-_~@*%$";

const emailAllowedCharacters = lowercaseLetters + uppercaseLetters + numbers + specialCharacters;
const usernameAllowedCharacters = lowercaseLetters + uppercaseLetters + numbers + usernameSpecialCharacters;
const pwdAllowedCharacters = lowercaseLetters + uppercaseLetters + numbers + pwdSpecialCharacters;

const errorInvalidEmail = "Error: invalid email. Forbidden characters";
const errorInvalidUsername = "Error: invalid username. Characters allowed: a-z 0-9 -_";
const errorInvalidPassword = "Error: invalid password. Characters allowed: a-z 0-9 +-_~@*%$";
const errorEmptyInput = "Error: empty input";

function checkPwdCharacters(input) {
    for (i = 0; i < input.length; i++) {
        if (!checkCharacters(input[i], pwdAllowedCharacters)) {
            return false;
        }
    }
    return true;
}

function checkUsernameCharacters(input) {
    for (i = 0; i < input.length; i++) {
        if (!checkCharacters(input[i], usernameAllowedCharacters)) {
            return false;
        }
    }
    return true;
}

function checkEmailCharacters(input) {
    for (i = 0; i < input.length; i++) {
        if (!checkCharacters(input[i], emailAllowedCharacters)) {
            return false;
        }
    }
    return true;
}

function checkCharacters(inputChar, allowedCharacters) {
    for (y = 0; y < allowedCharacters.length; y++) {
        if (inputChar == allowedCharacters[y])
            return true;
    }
    return false;
}
