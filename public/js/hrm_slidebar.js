const menuBtn = document.getElementById("menuBtn");

menuBtn.addEventListener("click", () => {
    const slidebar = document.querySelector('.slidebar-dashboard');
    !slidebar.classList.contains('slide-active') ? slidebar.classList.add('slide-active') : slidebar.classList.remove('slide-active')
    // slide-active
})