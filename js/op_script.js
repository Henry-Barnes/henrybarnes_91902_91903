// Toggles the "nav-items" dropdown open/closed when the hamburger icon is clicked
function changeIcon(icon) {
    const navItems = document.querySelector(".nav-items");
    navItems.classList.toggle("show");

    if (icon.classList.contains("fa-bars")) {
        icon.classList.remove("fa-bars");
        icon.classList.add("fa-xmark");
    } else {
        icon.classList.remove("fa-xmark");
        icon.classList.add("fa-bars");
    }
}

// Opens the advanced filter side panel
function openNav() {
    document.getElementById("myFilterpanel").style.width = "320px";
}

// Closes the advanced filter side panel
function closeNav() {
    document.getElementById("myFilterpanel").style.width = "0";
}
