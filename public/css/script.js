const mobile = document.querySelector('#menu-btn');
const mobileLink = document.querySelector('.sidebar');
const mobileLinks = document.querySelectorAll('.sidebar-menu a');
const closesidebar = document.querySelector('.sidebar #close')

mobileLinks.forEach(link => {
    link.addEventListener('click', () => {
        // Supprimer la classe 'active' de tous les liens
        mobileLinks.forEach(link => {
            link.classList.remove('active');
        });

        // Ajouter la classe 'active' uniquement au lien cliqué
        link.classList.add('active');
    });
});
    

let isDragging = false;

const wrapper = document.querySelector('.filter-wrapper');
const arrows = document.querySelectorAll('.main-filter .main-arrow i')

const dragging = (e) => {
    if(!isDragging)return;
    wrapper.scrollLeft -= e.movementX;
}
const dragStop = () => {
    isDragging = false;
}
wrapper.addEventListener('mousedown', () => isDragging = true)
wrapper.addEventListener('mousemove', dragging)
wrapper.addEventListener('mouseup', dragStop)
arrows.forEach(icon =>{
    icon.addEventListener('click', () => {

        if (icon.classList == 'back-menu fas fa-chevron-left') {
            wrapper.scrollLeft -= 250
        } else {
            wrapper.scrollLeft += 250
        }
    })
})

const Rwrapper = document.querySelector('.highlight-wrapper')
const Rarrows = document.querySelectorAll('.main-highlight .main-arrow i')

Rarrows.forEach(icon =>{
    icon.addEventListener('click', () => {

        if (icon.classList == 'back fas fa-chevron-left') {
            Rwrapper.scrollLeft -= 300
        } else {
            Rwrapper.scrollLeft += 300
        }
    })
})



const Rdragging = (e) => {
    if(!isDragging)return;
    Rwrapper.scrollLeft -= e.movementX;
}

const RdragStop = () => {
    isDragging = false;
}

Rwrapper.addEventListener('mousedown', () => isDragging = true)
Rwrapper.addEventListener('mousemove', Rdragging)
Rwrapper.addEventListener('mouseup', RdragStop)



mobile.addEventListener("click", function(){
    mobileLink.classList.toggle("active")
});

closesidebar.addEventListener("click", function(){
    mobileLink.classList.remove("active")
});

window.onscroll = () => {
    mobileLink.classList.remove("active")
}

mobileLink.addEventListener("click", function() {
    const menuBars = document.querySelector('is-active');
    if (window.innerWidth <= 768 && menuBars) {
        mobile.classList.toggle("is-active");
        mobileLink.classList.toggle("active")
    }
})




