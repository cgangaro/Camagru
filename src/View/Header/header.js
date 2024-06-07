function burgerMenu() {
    var x = document.getElementById("menuUnrolled");
    if (x.style.display === "flex") {
        x.style.display = "none";
    } else {
        x.style.display = "flex";
    }
}