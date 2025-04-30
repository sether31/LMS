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
