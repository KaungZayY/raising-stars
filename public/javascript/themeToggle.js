document.addEventListener("DOMContentLoaded", function() {
    //Icons
    const sunIcon = document.querySelector("#sun");
    const moonIcon = document.querySelector("#moon");

    //Theme Vars
    const userTheme = localStorage.getItem("theme");
    const systemTheme = window.matchMedia("(prefers-color-scheme: dark)").matches;

    const iconToggle = () => {
        moonIcon.classList.toggle("display-none");
        sunIcon.classList.toggle("display-none");
    }

    //Initial Theme Check
    const themeCheck = () => {
        if(userTheme === "dark" || (!userTheme && systemTheme)){
            document.documentElement.classList.add("dark");
            moonIcon.classList.add("display-none");
            return;
        }
        sunIcon.classList.add("display-none");
    }

    //Manual Theme Switch
    const themeSwitch = () => {
        if(document.documentElement.classList.contains("dark")){
            document.documentElement.classList.remove("dark");
            localStorage.setItem("theme", "light");
            iconToggle();
            return;
        }
        document.documentElement.classList.add("dark");
        localStorage.setItem("theme", "dark");
        iconToggle();
    }

    //Call Theme Switch on Clicking Buttons
    sunIcon.addEventListener("click", () => {
        themeSwitch();
    });

    moonIcon.addEventListener("click", () => {
        themeSwitch();
    });

    //Invoke theme check on load
    themeCheck();
});