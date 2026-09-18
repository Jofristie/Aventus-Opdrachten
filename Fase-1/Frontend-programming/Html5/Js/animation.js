function fadeIn(el) {
    el.style.opacity = 0;
    var tick = function () {
        el.style.opacity = +el.style.opacity + 0.0001;
        if (+el.style.opacity < 1) {
            (window.requestAnimationFrame && requestAnimationFrame(tick)) || setTimeout(tick, 16)
        }
    };
    tick();
}

function voegCurtainEventsToe() {
    const curtains = document.querySelectorAll(".curtain");

    curtains.forEach(curtain => {
        curtain.addEventListener("click", () => {
            curtain.classList.add("open");
        });
    });
}

window.addEventListener("DOMContentLoaded", () => {
    const el = document.getElementById("animate-fadeIn");
    fadeIn(el);

    const rickbtn = document.getElementById("add_rickroll");
    const modalEl = document.getElementById("rickroll");
    const video = document.getElementById("rickVideo");

    const modal = new bootstrap.Modal(modalEl);

    rickbtn.addEventListener("click", () => {
        modal.show();
    })

    modalEl.addEventListener("shown.bs.modal", () => {
        video.currentTime = 0;
        video.muted = false;

        video.play().catch(() => {
            video.muted = true;
            video.play();
        })
    })

    modalEl.addEventListener("hidden.bs.modal", () => {
        video.pause();
        video.currentTime = 0;
    })  
});
