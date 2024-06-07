document.addEventListener('DOMContentLoaded', function () {

    var scrollpos = localStorage.getItem('scrollpos');
    if (scrollpos) window.scrollTo(0, scrollpos);
    localStorage.setItem('scrollpos', 0);

    var sendCommentButton = document.querySelectorAll(".sendCommentButton");

    sendCommentButton.forEach(function (button) {
        button.addEventListener("click", function () {
            button.disabled = true;
            saveComment(button.value);
        });
        button.addEventListener('keypress', function (e) {
            if (e.keyCode === 13) {
                e.preventDefault();
            }
        });
    });

    var sendLikeButton = document.querySelectorAll(".sendLikeButton");

    sendLikeButton.forEach(function (button) {
        button.addEventListener("click", function () {
            saveLike(button.value);
        });
    });
});

function saveComment(imageId) {
    var input = document.getElementById('input_comment_' + imageId);
    if (input.value.length > 240) {
        var errorPart = document.getElementById('errorComment_' + imageId);
        errorPart.innerHTML = "Max length -> 240 characters";
        errorPart.style.display = 'flex';
    } else {
        var button = document.getElementById('commentButton_' + imageId);
        button.disabled = true;
        var form = document.getElementById('commentForm_' + imageId);
        var formData = new FormData(form);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'Controller/comments.php', true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                localStorage.setItem('scrollpos', window.scrollY);
                location.reload();
            }
        };
        xhr.send(formData);
    }
}

function saveLike(imageId) {
    var resultDiv = document.getElementById('result');
    var form = document.getElementById('likeForm_' + imageId);
    var formData = new FormData(form);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'Controller/likes.php', true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            localStorage.setItem('scrollpos', window.scrollY);
            location.reload();
        }
    };
    xhr.send(formData);
}
