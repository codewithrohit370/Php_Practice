
document.addEventListener("DOMContentLoaded", function () {
    // Check that GSAP libraries are loaded
    if (typeof gsap === "undefined" || typeof ScrollTrigger === "undefined") {
        console.error("GSAP or ScrollTrigger failed to load.");
        return;
    }

    // Register ScrollTrigger
    gsap.registerPlugin(ScrollTrigger);

    // 1. Navbar animation on page load
    gsap.from(".navbar", {
        y: -60,
        opacity: 0,
        duration: 1,
        ease: "power3.out"
    });

    // 2. Hero section animation on page load
    gsap.from(".hero-section > *", {
        y: 50,
        opacity: 0,
        duration: 1,
        stagger: 0.2,
        ease: "power3.out",
        delay: 0.2
    });

    // 3. Guild leadership section
    if (document.querySelector("#leadership")) {
        gsap.from("#leadership > *", {
            scrollTrigger: {
                trigger: "#leadership",
                start: "top 80%",
                toggleActions: "play none none none"
            },
            y: 60,
            opacity: 0,
            duration: 0.8,
            stagger: 0.2,
            ease: "power3.out"
        });
    }

    // 4. All member cards
    // if (document.querySelector(".member-card")) {
    //     gsap.from(".member-card", {
    //         scrollTrigger: {
    //             trigger: ".members-section",
    //             start: "top 80%",
    //             toggleActions: "play none none none"
    //         },
    //         y: 70,
    //         opacity: 0,
    //         scale: 0.95,
    //         duration: 0.7,
    //         stagger: 0.15,
    //         ease: "power2.out"
    //     });
    // }

    

    // 5. Join Guild / Contact section
    if (document.querySelector(".contact-section")) {
        gsap.from(".contact-heading > *", {
            scrollTrigger: {
                trigger: ".contact-section",
                start: "top 80%",
                toggleActions: "play none none none"
            },
            y: 40,
            opacity: 0,
            duration: 0.7,
            stagger: 0.15,
            ease: "power3.out"
        });

        gsap.from(".guild-form", {
            scrollTrigger: {
                trigger: ".guild-form",
                start: "top 85%",
                toggleActions: "play none none none"
            },
            y: 60,
            opacity: 0,
            duration: 0.9,
            ease: "power3.out"
        });
    }

    // 6. Footer animation
    if (document.querySelector(".site-footer")) {
        gsap.from(".footer-column", {
            scrollTrigger: {
                trigger: ".site-footer",
                start: "top 90%",
                toggleActions: "play none none none"
            },
            y: 35,
            opacity: 0,
            duration: 0.7,
            stagger: 0.15,
            ease: "power2.out"
        });

        gsap.from(".footer-brand", {
            scrollTrigger: {
                trigger: ".site-footer",
                start: "top 90%",
                toggleActions: "play none none none"
            },
            x: -40,
            opacity: 0,
            duration: 0.8,
            ease: "power3.out"
        });
    }

    window.addEventListener("load", function () {
        ScrollTrigger.refresh();
    });
});


const authOverlay = document.getElementById('authOverlay');

const loginForm = document.getElementById('loginForm');
const signupForm = document.getElementById('signupForm');

const loginTab = document.getElementById('loginTab');
const signupTab = document.getElementById('signupTab');

const authTitle = document.getElementById('authTitle');
const authDescription = document.getElementById('authDescription');
const authSwitchText = document.getElementById('authSwitchText');

// OPEN POPUP
function openAuth(type = 'login') {
    authOverlay.classList.add('show');
    document.body.style.overflow = 'hidden';

    switchAuth(type);
}

// CLOSE POPUP
function closeAuth() {
    authOverlay.classList.remove('show');
    document.body.style.overflow = '';
}

// SWITCH LOGIN / SIGNUP
function switchAuth(type) {

    const isLogin = type === 'login';

    loginForm.hidden = !isLogin;
    signupForm.hidden = isLogin;

    loginTab.classList.toggle('active', isLogin);
    signupTab.classList.toggle('active', !isLogin);

    if (isLogin) {
        authTitle.innerHTML = 'MEMBER <span>LOGIN</span>';

        authDescription.textContent =
            'Welcome back, warrior. Enter the battlefield.';

        authSwitchText.innerHTML = `
            Don't have an account?
            <a href="#" onclick="switchAuth('signup'); return false;">
                Sign Up
            </a>
        `;

    } else {
        authTitle.innerHTML = 'CREATE <span>ACCOUNT</span>';

        authSwitchText.innerHTML = `
            Already have an account?
            <a href="#" onclick="switchAuth('login'); return false;">
                Login
            </a>
        `;
    }
}

// CLOSE WHEN CLICKING OUTSIDE POPUP
authOverlay.addEventListener('click', function (e) {
    if (e.target === authOverlay) {
        closeAuth();
    }
});

// CLOSE WITH ESCAPE KEY
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && authOverlay.classList.contains('show')) {
        closeAuth();
    }
});


