import checkPassword from '../utils/checkPassword.js';

const loginPassword = document.querySelector('#login-password');
const checkBoxPassword = document.querySelector('#check-password');

checkPassword(loginPassword, checkBoxPassword);

// OTP modal close functionality
const otpContainer = document.querySelector('.otp');
const otpCloseBtn = document.querySelector('.otp .close');

if (otpContainer && otpCloseBtn) {
  otpCloseBtn.addEventListener('click', () => {
    otpContainer.classList.remove('show');

    // unset OTP
    fetch('../../src/auth/unsetOtpPop.php', {
      method: 'POST'
    }).catch(err => {
      console.error('Failed to unset otp-pop session:', err);
    });
  });
}
