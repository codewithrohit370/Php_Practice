
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
    if (document.querySelector(".member-card")) {
        gsap.from(".member-card", {
            scrollTrigger: {
                trigger: ".members-section",
                start: "top 80%",
                toggleActions: "play none none none"
            },
            y: 70,
            opacity: 0,
            scale: 0.95,
            duration: 0.7,
            stagger: 0.15,
            ease: "power2.out"
        });
    }

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
