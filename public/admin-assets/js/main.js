// Toast Notification
function showToast(message, type = "info", duration = 3000) {
    // Define the CSS classes and icons for different types
    const toastTypes = {
        success: { class: "toast-success", icon: "fa-check-circle" },
        error: { class: "toast-error", icon: "fa-ban" },
        warning: { class: "toast-warning", icon: "fa-triangle-exclamation" },
        info: { class: "toast-info", icon: "fa-circle-question" },
    };

    const toastType = toastTypes[type] || toastTypes.info;

    // Create toast element with icon
    var toast = $(`
    <div class="toast ${toastType.class}">
        <button class="close-btn">&times;</button>
        <div class="message-container">
        <i class="fas ${toastType.icon}"></i>
        <span>${message}</span>
        </div>
        <div class="progress-bar" style="animation-duration: ${duration}ms"></div>
    </div>
`);

    // Append to toast container
    $("#toast-container").append(toast);

    // Show toast with animation
    setTimeout(function () {
        toast.addClass("show");
    }, 100);

    // Remove toast after the specified duration
    setTimeout(function () {
        removeToast(toast);
    }, duration);

    // Close button click event
    toast.find(".close-btn").on("click", function () {
        removeToast(toast);
    });
}

function removeToast(toast) {
    toast.removeClass("show");
    setTimeout(function () {
        toast.remove();
    }, 500); // Wait for the animation to complete
}

// Toggle Screen Options dropdown with jQuery
$("#screenOptionsBtn").on("click", function () {
    var screenOptions = $("#screenOptions");
    if (screenOptions.is(":visible")) {
        screenOptions.slideUp(); // Slide up to hide
    } else {
        screenOptions.slideDown(); // Slide down to show
        screenOptions.css("display", "flex"); // Ensure flex display when shown
    }
});

function goBack() {
    window.history.back();
}
