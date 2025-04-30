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
