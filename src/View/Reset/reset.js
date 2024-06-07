var resetForm = document.getElementById('resetForm');
var resetButton = document.getElementById('resetButton');
var resetPwdInput = document.getElementById('resetPwdInput');
var resetPwdRepeatInput = document.getElementById('resetPwdRepeatInput');

var pwdResetContent = document.getElementById('pwdResetContent');
var pwdResetSuccessContent = document.getElementById('pwdResetSuccessContent');

resetButton.addEventListener("click", function () {
    if (resetPwdInput.value.length <= 0 || resetPwdRepeatInput.value.length <= 0) {
        resetError.innerHTML = "Error: empty input";
        resetError.style.color = 'red';
        resetError.style.display = 'flex';
    } else if (resetPwdInput.value != resetPwdRepeatInput.value) {
        resetError.innerHTML = "Error: passwords don't match";
        resetError.style.color = 'red';
        resetError.style.display = 'flex';
    } else {
        send();
    }
});

function send() {
    var formData = new FormData(resetForm);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../../Controller/resetFunctions.php', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            resetError.innerHTML = "";
            resetPwdInput.value = "";
            resetPwdRepeatInput.value = "";
            switch (xhr.responseText) {
                case "error:pwddontmatch":
                    resetError.innerHTML = "Error: passwords don't match";
                    resetError.style.color = 'red';
                    resetError.style.display = 'flex';
                    break;
                case "error:pwdinvalid":
                    resetError.innerHTML = "Error: invalid password";
                    resetError.style.color = 'red';
                    resetError.style.display = 'flex';
                    break;
                case "error:mysqliqueryerror":
                    resetError.innerHTML = "Error: try again";
                    resetError.style.color = 'red';
                    resetError.style.display = 'flex';
                    break;
                case "error:tokenselecterror":
                    resetError.innerHTML = "Error: invalid token";
                    resetError.style.color = 'red';
                    resetError.style.display = 'flex';
                    break;
                case "successresetpassword":
                    pwdResetContent.style.display = 'none';
                    pwdResetSuccessContent.style.display = 'block';
                    resetError.style.display = 'none';
                    break;
            }
        }
    };
    xhr.send(formData);
}