import checkPassword from '../utils/checkPassword.js';

const signupPassword = document.querySelector('#signup-password');
const eyeShow = document.querySelector('.eye-show');

checkPassword(signupPassword, eyeShow);