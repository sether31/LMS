function getShowImage(input, container){
  input.addEventListener('change', (e)=>{
    const file = e.target.files[0];

    if(file){
      const reader = new FileReader();
      reader.onload = (data)=>{
        container.style.backgroundImage = `url(${data.target.result})`;
      }
      reader.readAsDataURL(file);
    }
  });
}

export default getShowImage;