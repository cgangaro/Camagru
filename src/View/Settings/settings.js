var settingsButtonsPart = document.getElementById('settingsButtonsPart');
var changeSettingsForm = document.getElementById('changeSettingsForm');
var changeUsernameButton = document.getElementById('changeUsernameButton');
var changeEmailButton = document.getElementById('changeEmailButton');
var changePasswordButton = document.getElementById('changePasswordButton');
var settingsTitle = document.getElementById('settingsTitle');
var confirmSettingsButtonsPart = document.getElementById('confirmSettingsButtonsPart');

var settingsUpdateButton = document.getElementById('settingsUpdateButton');
var settingsCancelButton = document.getElementById('settingsCancelButton');
var settingsInput = document.getElementById('settingsInput');

var returnerror = document.getElementById('returnerror');

var commentNotifButton = document.getElementById('commentNotifButton');
var commentNotifForm = document.getElementById('commentNotifForm');
var commentNotifInput = document.getElementById('commentNotifInput');


changeUsernameButton.addEventListener("click", function () {
    settingsButtonsPart.style.display = 'none';
    changeSettingsForm.style.display = 'flex';
    confirmSettingsButtonsPart.style.display = 'flex';
    settingsTitle.innerHTML = "Change Username";
    settingsInput.placeholder = "Username...";
    settingsInput.name = "username";
});

changeEmailButton.addEventListener("click", function () {
    settingsButtonsPart.style.display = 'none';
    changeSettingsForm.style.display = 'flex';
    confirmSettingsButtonsPart.style.display = 'flex';
    settingsTitle.innerHTML = "Change Email";
    settingsInput.placeholder = "Email...";
    settingsInput.name = "email";
});

changePasswordButton.addEventListener("click", function () {
    settingsButtonsPart.style.display = 'none';
    changeSettingsForm.style.display = 'flex';
    confirmSettingsButtonsPart.style.display = 'flex';
    settingsTitle.innerHTML = "Change Password";
    settingsInput.placeholder = "Password...";
    settingsInput.name = "password";
});

settingsCancelButton.addEventListener("click", function () {
    changeSettingsForm.style.display = 'none';
    confirmSettingsButtonsPart.style.display = 'none';
    returnerror.style.display = 'none';
    settingsButtonsPart.style.display = 'flex';
    settingsTitle.innerHTML = "Settings";
    settingsInput.value = "";
    settingsInput.placeholder = "";
    settingsInput.name = "";
    returnerror.innerHTML = "";
});

settingsUpdateButton.addEventListener("click", function () {
    if (settingsInput.value.length <= 0) {
        returnerror.innerHTML = "Error: empty input";
        returnerror.style.color = 'red';
        returnerror.style.display = 'flex';
    } else {
        update();
    }
});

commentNotifButton.addEventListener("click", function () {
    var formData = new FormData(commentNotifForm);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../../Controller/settingsFunctions.php', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            location.replace(window.location.origin + '/View/Loading/loading.php');
        }
    };
    xhr.send(formData);
});

changeSettingsForm.addEventListener('keypress', function (e) {
    if (e.keyCode === 13) {
        e.preventDefault();
    }
});

function update() {
    if (settingsInput.name == "username" && !checkUsernameCharacters(settingsInput.value)) {
        returnerror.innerHTML = "Error: invalid username";
        returnerror.style.color = 'red';
        returnerror.style.display = 'flex';
        return;
    } else if (settingsInput.name == "email" && !checkEmailCharacters(settingsInput.value)) {
        returnerror.innerHTML = "Error: invalid email";
        returnerror.style.color = 'red';
        returnerror.style.display = 'flex';
        return;
    } else if (settingsInput.name == "password" && !checkPwdCharacters(settingsInput.value)) {
        returnerror.innerHTML = "Error: invalid password";
        returnerror.style.color = 'red';
        returnerror.style.display = 'flex';
        return;
    }
    var formData = new FormData(changeSettingsForm);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../../Controller/settingsFunctions.php', true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            returnerror.innerHTML = "";
            returnerror.style.display = 'flex';
            switch (xhr.responseText) {
                case "error:emptyinput":
                    returnerror.innerHTML = "Error: empty input";
                    returnerror.style.color = 'red';
                    break;
                case "error:invaliduid":
                    returnerror.innerHTML = "Error: invalid username";
                    returnerror.style.color = 'red';
                    break;
                case "error:uidexist":
                    returnerror.innerHTML = "Error: username already in use";
                    returnerror.style.color = 'red';
                    break;
                case "error:invalidemail":
                    returnerror.innerHTML = "Error: invalid email";
                    returnerror.style.color = 'red';
                    break;
                case "error:emailexist":
                    returnerror.innerHTML = "Error: email already in use";
                    returnerror.style.color = 'red';
                    break;
                case "error:changeemail":
                    returnerror.innerHTML = "Error: sorry, try again";
                    returnerror.style.color = 'red';
                    break;
                case "error:invalidpassword":
                    returnerror.innerHTML = "Error: invalid password";
                    returnerror.style.color = 'red';
                    break;
                case "successchangeusername":
                    returnerror.innerHTML = "Username updated successfully";
                    returnerror.style.color = 'green';
                    settingsInput.value = "";
                    break;
                case "successchangeemail":
                    returnerror.innerHTML = "Email updated successfully";
                    returnerror.style.color = 'green';
                    settingsInput.value = "";
                    break;
                case "successchangepassword":
                    returnerror.innerHTML = "Password updated successfully";
                    returnerror.style.color = 'green';
                    settingsInput.value = "";
                    break;
            }
        }
    };
    xhr.send(formData);
}