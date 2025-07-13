document.addEventListener("DOMContentLoaded", () => {
    const elements = {
        searchIcon: document.getElementById("search_icon"),
        searchClose: document.getElementById("search_close"),
        navMenu: document.getElementById("nav-menu"),
        searchInput: document.getElementById("search"),
        mainMenu: document.querySelector(".main-menu"),
        logoCont: document.querySelector(".logo-cont"),
    };

    // Toggle elements visibility and state
    const toggleSearchElements = () => {
        elements.searchInput.classList.toggle("show");
        elements.logoCont.classList.toggle("hide");
        elements.navMenu.classList.toggle("hide");
        elements.mainMenu.classList.toggle("expanded-width");
    };

    // Switch icons based on current state
    const toggleIcons = () => {
        const isSearchActive = elements.searchIcon.style.display === "none";
        elements.searchIcon.style.display = isSearchActive ? "block" : "none";
        elements.searchClose.style.display = isSearchActive ? "none" : "block";
    };

    // Handle search icon click
    const onSearchIconClick = () => {
        toggleSearchElements();
        toggleIcons();
    };

    // Handle search close icon click
    const onSearchCloseClick = () => {
        toggleSearchElements();
        toggleIcons();
    };

    // Event listeners for both icons
    elements.searchIcon.addEventListener("click", onSearchIconClick);
    elements.searchClose.addEventListener("click", onSearchCloseClick);




    const gallery = document.querySelectorAll('.gallery');
    const galleryImg = document.querySelectorAll('.gallery img');
    const lightbox = document.querySelector('.lightbox');
    const lightboxImg = lightbox.querySelector('img');
    const closeBtn = lightbox.querySelector('.close');
    const leftArrow = lightbox.querySelector('.arrow.left');
    const rightArrow = lightbox.querySelector('.arrow.right');

    let currentIndex = 0;

    const showLightbox = (index) => {
        currentIndex = index;
        lightboxImg.src = galleryImg[currentIndex].src;
        lightbox.classList.add('active');
    };

    const closeLightbox = () => {
        lightbox.classList.remove('active');
    };

    const showNext = () => {
        currentIndex = (currentIndex + 1) % galleryImg.length;
        lightboxImg.src = galleryImg[currentIndex].src;
    };

    const showPrev = () => {
        currentIndex = (currentIndex - 1 + galleryImg.length) % galleryImg.length;
        lightboxImg.src = galleryImg[currentIndex].src;
    };

    gallery.forEach((galleryImg, index) => {
        galleryImg.addEventListener('click', () => showLightbox(index));
    });

    closeBtn.addEventListener('click', closeLightbox);
    leftArrow.addEventListener('click', showPrev);
    rightArrow.addEventListener('click', showNext);

    document.addEventListener('keydown', (e) => {
        if (!lightbox.classList.contains('active')) return;
        if (e.key === 'ArrowRight') showNext();
        if (e.key === 'ArrowLeft') showPrev();
        if (e.key === 'Escape') closeLightbox();
    });


});

jQuery(document).ready(function ($) {

    // Get the current URL (without query parameters)
    let currentUrlForMenu = window.location.href.split('?')[0];

    // Loop through each .nav-link
    $(".nav-link").each(function() {
        // Check if the href attribute of the link matches the current URL
        if (this.href === currentUrlForMenu) {
            $(this).addClass("active"); // Add the active class to the matched link
        }
    });

    // Optional: Highlight the active link when clicked (this will remove the active class from all links and add it to the clicked link)
    $(".nav-link").on("click", function() {
        $(".nav-link").removeClass("active"); // Remove active class from all links
        $(this).addClass("active");          // Add active class to the clicked link
    });


    $(window).on("load", function() {
        $(".image-slider").slick({
            fade: true,
            speed: 2000,
            autoplay: true,
            autoplaySpeed: 1000,
            arrows: false,
            dots: false,
        });
    });

    const header = $(".header");
    const headerHeight = header.outerHeight();

    $(window).on("scroll", function () {
        if ($(window).scrollTop() > headerHeight) {
            header.addClass("sticky");
        } else {
            header.removeClass("sticky");
        }
    });

    $("#hamburger").on("click", function () {
        $(".nav-list").css("left", 0);
    });

    $("#close-menu").on("click", function () {
        $(".nav-list").css("left", "-100%");
    });

    const currentUrl = window.location.href;
    $(".profile-menu-item a").each(function () {
        if (this.href === currentUrl) {
            $(".profile-menu-item").removeClass("active");
            $(this).parent().addClass("active");
        }
    });

    function goBack() {
        window.history.back();
    }

    $(".profile-form-group")
        .has('input[type="password"]')
        .each(function () {
            // Reference to the input field and its parent group
            const $passwordInput = $(this).find('input[type="password"]');
            const $parentGroup = $(this);

            // Create the eye icon and eye-slash icon elements
            const $eyeIcon = $(
                '<span class="eye-icon" style="cursor: pointer; display: block;"><i class="fa-regular fa-eye"></i></span>'
            );
            const $eyeSlashIcon = $(
                '<span class="eye-icon" style="cursor: pointer; display: none;"><i class="fa-regular fa-eye-slash"></i></span>'
            );

            // Append both icons to the parent group
            $parentGroup.append($eyeIcon, $eyeSlashIcon);

            // Toggle password visibility on eye/eye-slash icon click
            $eyeIcon.on("click", function () {
                $passwordInput.attr("type", "text"); // Show password
                $eyeIcon.hide(); // Hide the eye icon
                $eyeSlashIcon.show(); // Show the eye-slash icon
            });

            $eyeSlashIcon.on("click", function () {
                $passwordInput.attr("type", "password"); // Hide password
                $eyeSlashIcon.hide(); // Hide the eye-slash icon
                $eyeIcon.show(); // Show the eye icon
            });
        });

    $(document).on("click", function (event) {
        // Check if the click happened outside of the dropdown and button
        if (
            !$(event.target).closest(
                ".comment-actions-dropdown, .comment-actions-dropdown-btn"
            ).length
        ) {
            $(".comment-actions-dropdown").removeClass("show"); // Hide all dropdowns
        }
    });

    $(".comment-actions-dropdown-btn").on("click", function () {
        // Hide all other dropdowns
        $(".comment-actions-dropdown")
            .not($(this).siblings(".comment-actions-dropdown"))
            .removeClass("show");

        // Toggle the dropdown for the clicked button
        $(this).siblings(".comment-actions-dropdown").toggleClass("show");
    });


const $firstFaq = $(".faq:first");
  $firstFaq.addClass("open");
  $firstFaq.find(".faq-answer").show();
  $firstFaq.find(".icon").html("−");

  // Click functionality for FAQ
  $(".faq-question").click(function () {
    const $answer = $(this).next(".faq-answer");
    const $icon = $(this).find(".icon");
    const $container = $(this).closest(".faq");

    // Close all FAQs except the current one
    $(".faq").not($container).removeClass("open");
    $(".faq-answer").not($answer).slideUp(300);
    $(".faq-question .icon").not($icon).html("+");

    // Toggle the current FAQ
    $container.toggleClass("open");
    $answer.stop().slideToggle(300);
    $icon.html($icon.html() === "+" ? "−" : "+");
  });

});
