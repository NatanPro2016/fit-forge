document
    .getElementById("registrationForm")
    .addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent form submission for validation
        let isValid = true;

        // Clear existing errors
        document
            .querySelectorAll(".error")
            .forEach((error) => (error.textContent = ""));

        // Name validation
        const name = document.getElementById("name");
        if (!name.value.trim()) {
            setError(name, "Name is required.");
            isValid = false;
        }

        // Email validation
        const email = document.getElementById("email");
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email.value.trim()) {
            setError(email, "Email is required.");
            isValid = false;
        } else if (!emailRegex.test(email.value.trim())) {
            setError(email, "Enter a valid email address.");
            isValid = false;
        }

        // Username validation
        const username = document.getElementById("username");
        if (
            username.value.trim().length < 3 ||
            username.value.trim().length > 20
        ) {
            setError(username, "Username must be between 3 and 20 characters.");
            isValid = false;
        }

        // Password validation
        const password = document.getElementById("password");
        if (
            password.value.trim().length < 3 ||
            password.value.trim().length > 200
        ) {
            setError(
                password,
                "Password must be between 3 and 200 characters."
            );
            isValid = false;
        }

        // Sex validation
        const sex = document.getElementById("sex");
        if (!sex.value) {
            setError(sex, "Please select your sex.");
            isValid = false;
        }

        // Age validation
        const age = document.getElementById("age");
        if (!age.value || age.value <= 0) {
            setError(age, "Age must be a positive number.");
            isValid = false;
        }

        // If all fields are valid, submit the form
        if (isValid) {
            this.submit();
        }
    });

// Utility function to set error messages
function setError(input, message) {
    const errorElement = input.parentElement.querySelector(".error");
    errorElement.textContent = message;
    input.classList.add("error-border");
}
