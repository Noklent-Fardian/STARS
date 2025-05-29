document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.querySelector(".sidebar");

    function adjustFooterPosition() {
        const contentHeight = document.querySelector("#content").offsetHeight;
        const windowHeight = window.innerHeight;
        const headerHeight = document.querySelector(".topbar").offsetHeight;
        const footerHeight = document.querySelector(
            "footer.sticky-footer"
        ).offsetHeight;

        if (contentHeight < windowHeight - headerHeight - footerHeight) {
            document.querySelector(".min-content-height").style.minHeight =
                windowHeight - headerHeight - footerHeight - 40 + "px";
        }
    }

    function ensureSidebarHeight() {
        if (!sidebar) return;

        const lastItem = sidebar.querySelector(
            ".sidebar-heading:last-of-type, .nav-item:last-of-type"
        );
        if (!lastItem) return;

        const lastItemBottom = lastItem.offsetTop + lastItem.offsetHeight;
        const windowHeight = window.innerHeight;
        const minSidebarHeight = Math.max(lastItemBottom + 100, windowHeight);

        sidebar.style.minHeight = `${minSidebarHeight}px`;
    }
    function setStateSidebar() {
        const sidebarElement = document.getElementById("accordionSidebar");
        if (!sidebarElement) return;

        const isSidebarToggled =
            $("body").hasClass("sidebar-toggled") &&
            $("#accordionSidebar").hasClass("toggled");

        localStorage.setItem("sidebar-toggled", isSidebarToggled.toString());
    }

    window.setStateSidebar = setStateSidebar;
    const sidebarElement = document.getElementById("accordionSidebar");
    if (sidebarElement) {
        sidebarElement.style.transition = "all 0.2s ease-in-out";

        if (localStorage.getItem("sidebar-toggled") === "true") {
            $("body").addClass("sidebar-toggled");
            $(sidebarElement).addClass("toggled");
        }


        setTimeout(() => {
            sidebarElement.style.transition = "";
        }, 100);
    }

    $("#sidebarToggleTop, #sidebarToggle").on("click", function () {
        setStateSidebar();
    });

    adjustFooterPosition();
    ensureSidebarHeight();

    window.addEventListener("resize", adjustFooterPosition);
    window.addEventListener("resize", ensureSidebarHeight);
    window.addEventListener("load", ensureSidebarHeight);

    const collapseTriggers = document.querySelectorAll(
        '[data-toggle="collapse"]'
    );
    collapseTriggers.forEach((trigger) => {
        trigger.addEventListener("click", function () {
            setTimeout(ensureSidebarHeight, 350);
        });
    });

    if (sidebar) {
        sidebar.addEventListener("scroll", function (e) {
            const scrollTop = this.scrollTop;
            const scrollHeight = this.scrollHeight;
            const offsetHeight = this.offsetHeight;

            if (scrollTop === 0) {
                this.scrollTop = 1;
            } else if (scrollTop + offsetHeight >= scrollHeight) {
                this.scrollTop = scrollTop - 1;
            }
        });
    }
});

// Preloader animation with percentage counter
$(window).on("load", function () {
    let percentageCounter = 0;
    const percentageElement = $(".progress-percentage");
    const loadingText = $(".loading-text");
    const progressBar = $(".progress-bar");
    const texts = [
        "Loading resources...",
        "Initializing application...",
        "Preparing STARS...",
        "Almost ready...",
    ];
    let currentTextIndex = 0;

    const percentageInterval = setInterval(function () {
        percentageCounter += 2;
        percentageElement.text(percentageCounter + "%");
        progressBar.css("width", percentageCounter + "%");

        if (percentageCounter === 24 || percentageCounter === 26) {
            currentTextIndex = 1;
            loadingText.fadeOu(75, function () {
                $(this).text(texts[currentTextIndex]).fadeIn(75);
            });
        } else if (percentageCounter === 48 || percentageCounter === 52) {
            currentTextIndex = 2;
            loadingText.fadeOut(75, function () {
                $(this).text(texts[currentTextIndex]).fadeIn(75);
            });
        } else if (percentageCounter === 74 || percentageCounter === 76) {
            currentTextIndex = 3;
            loadingText.fadeOut(75, function () {
                $(this).text(texts[currentTextIndex]).fadeIn(75);
            });
        }

        if (percentageCounter >= 100) {
            clearInterval(percentageInterval);

            setTimeout(function () {
                $(".preloader").fadeOut(75);
            }, 75);
        }
    }, 10);
});

$(document).ready(function () {
    // Add animation to form elements when page loads
    $(".form-group").each(function (i) {
        $(this).css({
            opacity: 0,
            transform: "translateY(20px)",
        });

        setTimeout(function () {
            $(".form-group").eq(i).css({
                opacity: 1,
                transform: "translateY(0)",
                transition: "all 0.4s ease-out",
            });
        }, 100 * (i + 1));
    });

    // Style validation on submit attempt
    $("form").on("submit", function () {
        if (this.checkValidity() === false) {
            $(this).find(":invalid").first().focus();
            $(this).addClass("was-validated");
            return false;
        }
    });
});
