import checkPassword from '../utils/checkPassword.js';

const birthdayInput = document.getElementById('signup-bday');
const today = new Date();
const formattedDate = today.toISOString().split('T')[0];

birthdayInput.addEventListener('change', ()=>{
  let check = birthdayInput.value > formattedDate;
  if(check){
    document.querySelector('#signup-bday').style.borderColor = 'var(--invalid)';
  } else{
    document.querySelector('#signup-bday').style.borderColor = 'var(--valid)';
  }
});

const signupPassword = document.querySelector('#signup-password');
const eyeShow = document.querySelector('.eye-show');

checkPassword(signupPassword, eyeShow);