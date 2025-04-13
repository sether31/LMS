function checkPassword(inputName, check){
  check.addEventListener('click', ()=>{
    if(inputName.type === 'password') {
      inputName.type = 'text';  
    } else {
      inputName.type = 'password';  
    }
  });
}

export default checkPassword;