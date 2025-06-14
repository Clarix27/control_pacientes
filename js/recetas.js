document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('formRecetas');

  form.addEventListener('submit', async function(e) {
    e.preventDefault();

    // Prepara datos del formulario
    const formData = new FormData(this);

    try {
      // Envía la petición al backend
      const res = await fetch('controladores/registro_receta.php', {
        method: 'POST',
        body: formData
      });

      const json = await res.json();
      showAlert(json.message, json.success);

      // Si fue exitoso, limpia el formulario
      if (json.success) {
        form.reset();
      }

    } catch (error) {
      showAlert('Ocurrio un error al registrar algo.', false);
    }
  });

  /**
   * Muestra una alerta centrada con mensaje y cierre.
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
    
    // Si fue exitoso, redirige tras 2 segundos
    if (isSuccess) {
      setTimeout(() => {
        // opcional: box.remove();
        window.location.href = 'Lista_titulares.php'; // <- Ajusta aquí tu página de destino
      }, 2000);
    }
  }
});
