import checkPassword from '../utils/checkPassword.js';

const loginPassword = document.querySelector('#login-password');
const checkBoxPassword = document.querySelector('#check-password');

checkPassword(loginPassword, checkBoxPassword);

const otpContainer = document.querySelector('.otp');
const otpCloseBtn = document.querySelector('.otp .close');

otpCloseBtn.addEventListener('click', ()=>{
  otpContainer.classList.remove('show');
});
