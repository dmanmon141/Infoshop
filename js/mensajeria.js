document.addEventListener('DOMContentLoaded', () => {

    const socket = new WebSocket("ws://localhost:8080");

    socket.onmessage = function (event) {
        const message = JSON.parse(event.data);
        const container = document.querySelector(".bloque-error");
        container.innerHTML += `<div class="${message.clase}">
            <div class="credenciales">
              <div class="crgroup1">
                <img src=${message.imagen}>
                <p>${message.usuario}</p>
              </div>

              <p id="fecha">${message.hora}</p>
            </div>
            <div class="contenido">
              <p>${message.texto}</p>

            </div>
          </div>`;
        container.scrollTop = container.scrollHeight;
       
        console.log("Usuario logeado: " + usuarioActual);
        console.log("Usuario del mensaje: " + message.usuario);
        if(message.usucod !== usuarioActual){
             const audio = new Audio('../audio/notification.mp3');
            audio.play();
        }
    }

const textarea = document.getElementById("respuesta-contenido");
const formulario = document.querySelector(".respondermensaje");

textarea.addEventListener("keydown", function(event) {
    if (event.key === "Enter" && !event.shiftKey) {
        event.preventDefault();
        formulario.requestSubmit();
    }
});


    document.querySelector(".respondermensaje").addEventListener("submit", function (e) {
        console.log("Funciona el post");
        e.preventDefault();
        const contenido = document.getElementById("respuesta-contenido").value;
        document.getElementById("respuesta-contenido").value = "";
        const ticketid = document.getElementById("ticketidmensaje").value;
        fetch("backend/responder-mensaje.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `respuesta-contenido=${encodeURIComponent(contenido)}&ticketidmensaje=${encodeURIComponent(ticketid)}`
        })
    })

})