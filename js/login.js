document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('formLogin').addEventListener('submit', async function(e) {
    e.preventDefault();

    // Prepara datos del formulario
    const formData = new FormData(this);

    try {
      // Envía la petición al backend
      const res = await fetch('controladores/back_login.php', {
        method: 'POST',
        body: formData
      });

      const json = await res.json();
      showAlert(json.message, json.success);

    } catch (error) {
      showAlert('Error de conexión. Intenta de nuevo.', false);
    }
  });

  /**
   * Muestra una alerta centrada con mensaje y cierre.
   * Si isSuccess es true, redirige tras 2 segundos.
   * @param {string} message - Texto a mostrar.
   * @param {boolean} isSuccess - true=success, false=error.
   */
  function showAlert(message, isSuccess) {
    // Remueve alerta previa
    const existing = document.querySelector('.alert');
    if (existing) existing.remove();

    // Crea el cuadro
    const box = document.createElement('div');
    box.classList.add('alert', isSuccess ? 'success' : 'error');
    box.innerHTML = `
      <button class="close-btn">&times;</button>
      <p>${message}</p>
    `;

    // Lo añadimos al body
    document.body.appendChild(box);

    // Cierre manual con la X
    box.querySelector('.close-btn')
       .addEventListener('click', () => box.remove());

    // Si fue exitoso, redirige tras 1 segundo
    if (isSuccess) {
      setTimeout(() => {
        // opcional: box.remove();
        window.location.href = 'inicio.html'; // <- Ajusta aquí tu página de destino
      }, 1000);
    }
  }
});
