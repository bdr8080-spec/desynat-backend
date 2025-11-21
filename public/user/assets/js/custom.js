// Toggle password visibility
document.querySelectorAll(".toggle-passwordone").forEach((toggle) => {
    toggle.addEventListener("click", function () {
        const input = this.parentElement.querySelector("input");
        const isPassword = input.getAttribute("type") === "password";

        input.setAttribute("type", isPassword ? "text" : "password");

        // Toggle icon
        this.classList.toggle("fa-eye");
        this.classList.toggle("fa-eye-slash");
    });
});

document.querySelectorAll(".toggle-passwordtwo").forEach((toggle) => {
    toggle.addEventListener("click", function () {
        const input = this.parentElement.querySelector("input");
        const isPassword = input.type === "password";

        // Toggle between text/password
        input.type = isPassword ? "text" : "password";

        // Toggle icon classes
        this.classList.toggle("fa-eye");
        this.classList.toggle("fa-eye-slash");
    });
});

// otp input
const inputs = document.querySelectorAll(".otp-input");
inputs.forEach((input, index) => {
    input.addEventListener("input", (e) => {
        const value = e.target.value;
        // Allow only digits
        if (!/^[0-9]$/.test(value)) {
            e.target.value = "";
            return;
        }
        // Move to next input
        if (value && index < inputs.length - 1) {
            inputs[index + 1].focus();
        }
    });

    input.addEventListener("keydown", (e) => {
        if (e.key === "Backspace" && !e.target.value && index > 0) {
            inputs[index - 1].focus();
        }
    });
});



// category page js


// your page link
var profileLink = "https://your-website.com/user/12345";

// Generate QR code
new QRCode(document.getElementById("qrCodeBox"), {
    text: profileLink,
    width: 100,
    height: 100
});

// Copy functionality
document.getElementById("copyLinkBtn").addEventListener("click", function () {
    navigator.clipboard.writeText(profileLink).then(() => {
        let msg = document.getElementById("copiedMsg");
        msg.style.display = "block";
        setTimeout(() => msg.style.display = "none", 1500);
    });
});

$('.storeCarousel').owlCarousel({
    loop: true,
    margin: 10,
    nav: false,
    dots: true,
    // autoplay: true,
    // autoplayTimeout: 2000, 
    autoplayHoverPause: true,
    slideTransition: 'linear',
    smartSpeed: 1000, // smooth transition
    responsive: {
        0: {
            items: 3
        },
        576: {
            items: 4
        },
        768: {
            items: 5
        },
        992: {
            items: 6
        },
        1024: {
            items: 7
        },
        1200: {
            items: 10
        }
    },
    slideBy: 1 // slides one by one
});


// whatstapp type image show
var images = [
    "assets/images/store1.jpg",
    "assets/images/item-1.svg",
    "assets/images/item-2.svg",
    "assets/images/store1.jpg",
    "assets/images/store1.jpg",
    "assets/images/store1.jpg"
];

var currentIndex = 0;
var timer = null;
var duration = 3000; // 3 sec like WhatsApp

function openGallery(index) {
    currentIndex = index;
    document.getElementById("statusViewer").style.display = "flex";

    generateProgressBars();
    showImage();
}

function generateProgressBars() {
    const container = document.getElementById("progressContainer");
    container.innerHTML = "";

    images.forEach((img, i) => {
        container.innerHTML += `
            <div class="progress-bar">
                <div class="progress-fill" id="bar${i}"></div>
            </div>
        `;
    });
}

function showImage() {
    document.getElementById("statusImage").src = images[currentIndex];
    startProgress();
}

function startProgress() {
    clearTimeout(timer);

    // Reset all bars
    document.querySelectorAll(".progress-fill").forEach(bar => {
        bar.style.width = "0%";
        bar.style.transition = "none";
    });

    // Small delay so restart animation properly
    setTimeout(() => {
        let bar = document.getElementById("bar" + currentIndex);
        bar.style.transition = `${duration}ms linear`;
        bar.style.width = "100%";
    }, 10);

    timer = setTimeout(() => {
        showNext();
    }, duration);
}

function showNext() {
    if (currentIndex < images.length - 1) {
        currentIndex++;
        showImage();
    } else {
        closeStatus(); // Close after last image like WhatsApp
    }
}

function showPrev() {
    if (currentIndex > 0) {
        currentIndex--;
        showImage();
    }
}

function closeStatus() {
    clearTimeout(timer);
    document.getElementById("statusViewer").style.display = "none";
}