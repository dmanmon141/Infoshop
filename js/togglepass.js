function togglePasswordVisibility() {
    var passwordInput = document.getElementById("contraseña-input");
    var togglePassword = document.querySelector(".toggle-password");
  
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      togglePassword.classList.add("show");
    } else {
      passwordInput.type = "password";
      togglePassword.classList.remove("show");
    }
  }
