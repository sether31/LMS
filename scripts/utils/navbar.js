
const navbarBurger = document.querySelector('#navbar-burger');
const navbar = document.querySelector('.navbar .wrapper .nav');

navbarBurger.addEventListener('click', function(){
  this.classList.toggle('click');
  navbar.classList.toggle('show');
});

