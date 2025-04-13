import checkPassword from '../utils/checkPassword.js';

const loginPassword = document.querySelector('#login-password');
const checkBoxPassword = document.querySelector('#check-password');

checkPassword(loginPassword, checkBoxPassword);