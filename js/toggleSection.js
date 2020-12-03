
// Used in conjunction with the Section Toggler component
function toggleSection(section) {

  // Variables
  const loginButton = document.querySelector('#login-button');
  const registerButton = document.querySelector('#register-button');
  const heading = document.querySelector('.login-register__heading');
  const registerForm = document.querySelector('.register__form');
  const loginForm = document.querySelector('.login__form');


  // Checks which toggle button the user has pressed
  if (section == 'login') {
    
    // Set active button class
    loginButton.classList.add('active');
    registerButton.classList.remove('active');

    // Set appropriate heading content
    heading.textContent = 'Login';

    // Display / hide appropriate forms
    loginForm.style.display = 'block';
    registerForm.style.display = 'none';

  }
  

  else if (section == 'register') {
    
    registerButton.classList.add('active');
    loginButton.classList.remove('active');

    heading.textContent = 'Register';

    registerForm.style.display = 'block';
    loginForm.style.display = 'none';

  }

}