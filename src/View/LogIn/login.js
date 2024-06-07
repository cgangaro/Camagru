var loginButton = document.getElementById('loginButton');
var loginForm = document.getElementById('loginForm');

loginForm.addEventListener('keypress', function (e) {
    if (e.keyCode === 13) {
        e.preventDefault();
    }
});

loginButton.addEventListener("submit", function () {
    loginButton.disabled = true;
});
