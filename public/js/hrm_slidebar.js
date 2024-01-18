const menuBtn = document.getElementById("menuBtn");

menuBtn.addEventListener("click", () => {
    const slidebar = document.querySelector('.slidebar-dashboard');
    !slidebar.classList.contains('slide-active') ? slidebar.classList.add('slide-active') : slidebar.classList.remove('slide-active')
    // slide-active
    MainSub.forEach(function(sub) {
        const SubMenu = sub.querySelector('#sub-menu');
        const menuBtn_click = sub.querySelector('#open-sub-menu');
        SubMenu.classList.remove('open-menu');
        menuBtn_click.classList.remove('active');
    });
})

const MainSub = document.querySelectorAll('#main-sub-menu')
MainSub.forEach(function(sub) {
    const menuBtn_click = sub.querySelector('#open-sub-menu');
    menuBtn_click.addEventListener('click', () => {
        const slidebar = document.querySelector('.slidebar-dashboard');
        !slidebar.classList.contains('slide-active') ? slidebar.classList.add('slide-active') : null
        if (!menuBtn_click.classList.contains('active')) {
            menuBtn_click.classList.add('active')
        } else {
            menuBtn_click.classList.remove('active')
        }
        const SubMenu = sub.querySelector('#sub-menu');
        if (!SubMenu.classList.contains('open-menu')) {
            SubMenu.classList.add('open-menu')
        } else {
            SubMenu.classList.remove('open-menu')
        }
    })
    
});