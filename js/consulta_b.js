document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('formCB');

  form.addEventListener('submit', async function(e) {
    e.preventDefault();

    // Prepara datos del formulario
    const formData = new FormData(this);

    try {
      // Envía la petición al backend
      const res = await fetch('controladores/consulta_titular.php', {
        method: 'POST',
        body: formData
      });

      // Para hacer pruebas con los errores:
      const text = await res.text();
      console.log('RESPUESTA CRUDA:', text);
      const json = JSON.parse(text);

      //const json = await res.json();
      showAlert(json.message, json.success);

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
      // Cierre automático tras 2 segundos (2000 ms)
    setTimeout(() => {
      if (document.body.contains(box)) {
        box.remove();
      }
    }, 2000);
  }
});
