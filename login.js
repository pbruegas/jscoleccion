(function () {
	'use strict'

	// Fetch all the forms we want to apply custom Bootstrap validation styles to
	var forms = document.querySelectorAll('.needs-validation')

	// Loop over them and prevent submission
	Array.prototype.slice.call(forms)
		.forEach(function (form) {
			form.addEventListener('submit', function (event) {
				if (!form.checkValidity()) {
					event.preventDefault()
					event.stopPropagation()
				}

				form.classList.add('was-validated')
			}, false)
		})
})()

document.addEventListener('DOMContentLoaded', function () {
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('confirm_password');
    const submitButton = document.querySelector('.submit-button');

    confirmPasswordField.addEventListener('input', function () {
        if (confirmPasswordField.value !== passwordField.value) {
            confirmPasswordField.setCustomValidity("Passwords don't match");
        } else {
            confirmPasswordField.setCustomValidity('');
        }
    });

    submitButton.addEventListener('click', function () {
        if (confirmPasswordField.value !== passwordField.value) {
            confirmPasswordField.setCustomValidity("Passwords don't match");
        }
    });
});

const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('confirm_password');
    const passwordMatchError = document.getElementById('passwordMatchError');

    confirmInput.addEventListener('input', () => {
        if (passwordInput.value !== confirmInput.value) {
            passwordMatchError.textContent = "Passwords don't match!";
            confirmInput.classList.add('input-error'); // Add class to make input red
        } else {
            passwordMatchError.textContent = "";
            confirmInput.classList.remove('input-error'); // Remove class to reset style
        }
    });

    document.getElementById('registrationForm').addEventListener('submit', function(event) {
        if (passwordInput.value !== confirmInput.value) {
            event.preventDefault(); // Prevent form submission if passwords don't match
            passwordMatchError.textContent = "Passwords don't match!";
            confirmInput.classList.add('input-error'); // Add class to make input red
        }
    });