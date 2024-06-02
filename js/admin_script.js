let profile = document.querySelector('.header .flex .profile');

document.querySelector('#user-btn').onclick = () =>{
    profile.classList.toggle('active');
    navbar.classList.remove('active');
}

let navbar = document.querySelector('.header .flex .navbar');

document.querySelector('#menu-btn').onclick = () =>{
    navbar.classList.toggle('active');
    profile.classList.remove('active');
}

window.onscroll = () => {
    profile.classList.remove('active');
    navbar.classList.remove('active');
}

subimages = document.querySelectorAll('.update-product .image-container .sub-images img');
mainImage = document.querySelector('.update-product .image-container .main-image img');

subimages.forEach(images => {
    images.onclick = () => {
        let src = images.getAttribute('src');
        mainImage.src = src;
    }
});