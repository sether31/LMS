import getShowImage from "../utils/getShowImage.js";

const sidebar = document.querySelector('.sidebar');
const hamburgerBtn = document.querySelector('.sidebar-hamburger-btn');

hamburgerBtn.addEventListener('click', function(){
  this.classList.toggle('click');
  sidebar.classList.toggle('show');
});

const moduleBtn = document.querySelectorAll('.module-btn');
moduleBtn.forEach((btn)=>{
  btn.addEventListener('click', ()=>{
    const moduleContent = btn.parentElement.querySelector('.module-content');
    const arrowContainer = btn.querySelector('span');
  
    moduleContent.classList.toggle('show');
    arrowContainer.classList.toggle('rotate');
  });
});

document.querySelectorAll('.sidebar nav ul .main-list').forEach((mainList)=>{
  mainList.addEventListener('click', ()=>{
    mainList.classList.toggle('active');
  });
});

// general settings
getShowImage(
  document.querySelector('#update-course-picture'),
  document.querySelector('.update-image-container')
);

console.log(
  document.querySelector('#update-course-picture'),
  document.querySelector('.update-image-container')
)