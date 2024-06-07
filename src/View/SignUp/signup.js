var signupButton = document.getElementById('signupButton');
var signupForm = document.getElementById('signupForm');

signupForm.addEventListener('keypress', function (e) {
    if (e.keyCode === 13) {
        e.preventDefault();
    }
});

signupButton.addEventListener("submit", function () {
    signupButton.disabled = true;
});
