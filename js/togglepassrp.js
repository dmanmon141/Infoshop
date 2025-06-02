function togglePasswordVisibilityrp() {
    var passwordInput = document.getElementById("repetir-contraseña-input");
    var togglePassword = document.querySelector(".toggle-password-rp");
  
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      togglePassword.classList.add("show");
    } else {
      passwordInput.type = "password";
      togglePassword.classList.remove("show");
    }
  }