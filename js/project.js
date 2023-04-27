// Questions //
let questions = document.querySelectorAll(".questions .question-container");

questions.forEach((q) => {
    q.addEventListener("click", () => {
        q.classList.toggle("open");
        let icon = q.querySelector(".icon");
        if (q.classList.contains("open")) {
            icon.className = "fa-solid fa-minus fs-4 me-3 icon";
        }
        else {
            icon.className = "fa-solid fa-plus fs-4 me-3 icon";
        }
    });
});


// Add and remove active
const links = document.querySelectorAll(".navbar-nav .nav-link");

links.forEach((link) => {
    link.addEventListener("click", () => {
        // Remove active class
        links.forEach((link) => link.classList.remove("active"));
        // Add active class
        link.classList.add("active");
    });
});


// // Add and remove active
// const links_dashboard = document.querySelectorAll(".methods .nav-link");

// links_dashboard.forEach((link) => {
//     link.addEventListener("click", () => {
//         // Remove active class
//         links_dashboard.forEach((link) => link.classList.remove("active"));
//         // Add active class
//         link.classList.add("active");
//     });
// });


// Tabs of Tasks and posts
const btns = document.querySelectorAll(".profile .btns");
const contents = document.querySelectorAll(".profile .content");

btns.forEach((btn, index) => {
    btn.addEventListener("click", () => {
        btns.forEach((btn) => btn.classList.remove("active"));
        btn.classList.add("active");
        // add class active to content (task or post)
        contents.forEach((content) => {
            content.classList.remove("active");
        });
        contents[index].classList.add("active");
    });
});