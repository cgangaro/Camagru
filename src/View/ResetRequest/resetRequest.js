var resetRequestForm = document.getElementById('resetRequestForm');
var resetRequestButton = document.getElementById('resetRequestButton');
var resetRequestInput = document.getElementById('resetRequestInput');
var resetRequestError = document.getElementById('resetRequestError');

resetRequestButton.addEventListener("click", function () {
    if (resetRequestInput.value.length <= 0) {
        resetRequestError.innerHTML = errorEmptyInput;
        resetRequestError.style.color = 'red';
        resetRequestError.style.display = 'flex';
    }
    if (!checkEmailCharacters(resetRequestInput.value)) {
        resetRequestInput.value = "";
        resetRequestError.innerHTML = "Error: invalid email. Forbidden characters";
        resetRequestError.style.color = 'red';
        resetRequestError.style.display = 'flex';
    } else {
        resetRequestButton.disabled = true;
        resetRequestError.innerHTML = "";
        send();
    }
});

resetRequestForm.addEventListener('keypress', function (e) {
    if (e.keyCode === 13) {
        e.preventDefault();
    }
});

function send() {
    var formData = new FormData(resetRequestForm);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../../Controller/resetFunctions.php', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            resetRequestError.innerHTML = "";
            resetRequestError.style.display = 'flex';
            switch (xhr.responseText) {
                case "error:emptyinput":
                    resetRequestError.innerHTML = errorEmptyInput;
                    resetRequestError.style.color = 'red';
                    break;
                case "error:invalidemail":
                    resetRequestError.innerHTML = errorInvalidEmail;
                    resetRequestError.style.color = 'red';
                    break;
                case "error:emaildoesntexist":
                    resetRequestError.innerHTML = "Error: email doesn't exist";
                    resetRequestError.style.color = 'red';
                    break;
                case "error:inittoken":
                    resetRequestError.innerHTML = "Error: try again";
                    resetRequestError.style.color = 'red';
                    break;
                case "error:emailnotverified":
                    resetRequestError.innerHTML = "Error: email is not verified";
                    resetRequestError.style.color = 'red';
                    break;
                case "error:sendresetpasswordmail":
                    resetRequestError.innerHTML = "Error: mail wasn't sent, try again";
                    resetRequestError.style.color = 'red';
                    break;
                case "successreseetrequestpassword":
                    resetRequestError.innerHTML = "Email sent";
                    resetRequestError.style.color = 'green';
                    resetRequestInput.value = "";
                    break;
            }
        }
        resetRequestButton.disabled = false;
    };
    xhr.send(formData);
}