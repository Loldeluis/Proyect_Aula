const form = document.querySelector('form');

form.addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    const errorDiv = document.getElementById('mensaje-error');

    if (password !== confirmPassword) {
        e.preventDefault();
        if (errorDiv) {
            errorDiv.textContent = '❌ Las contraseñas no coinciden.';
            errorDiv.style.color = 'red';
        } else {
            alert('Las contraseñas no coinciden.');
        }
    }
});