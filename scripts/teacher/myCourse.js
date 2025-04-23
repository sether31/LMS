import getShowImage from "../utils/getShowImage.js";

const addCourseModal = document.querySelector('#add-course-modal');
const openAddCourseBtn = document.querySelector('#add-course');
const closeAddCourseBtn = document.querySelector('#add-course-modal .close-btn');

openAddCourseBtn.addEventListener('click', ()=>{
  document.querySelector('#add-course-modal').style.display = 'grid';
});

closeAddCourseBtn.addEventListener('click', ()=>{
  addCourseModal.style.display = 'none';
});


getShowImage(
  document.querySelector('#course-image'),
  document.querySelector('#add-course-modal .input-image-container')
);


const searchInput = document.querySelector('#search-input');
const cards = document.querySelectorAll('.card');

searchInput.addEventListener('input', function(){
  const query = this.value.toLowerCase();

  cards.forEach((card) => {
    const title = card.querySelector('.card-title').textContent.toLowerCase();
    if (title.includes(query)) {
      card.style.display = 'block';
    } else {
      card.style.display = 'none';
    }
  });
});
