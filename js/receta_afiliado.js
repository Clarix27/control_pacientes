document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('formRecetas_t');

  form.addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const idPersona = formData.get('pk_titular');

    try {
      const res = await fetch('controladores/registro_receta.php', {
        method: 'POST',
        body: formData
      });

      const text = await res.text();
      console.log('RESPUESTA CRUDA:', text);
      const json = JSON.parse(text);

      showAlert(json.message, json.success);

      if (json.success) {
        setTimeout(() => {
          // opcional: box.remove();
          window.location.href = `Historial_titular.php?id=${encodeURIComponent(idPersona)}`;
        }, 1500);
      }

    } catch (error) {
      showAlert('Ocurrio un error al registrar algo.', false);
    }
  });

  /**
   * @param {string} message
   * @param {boolean} isSuccess 
   */
  function showAlert(message, isSuccess) {
    const existing = document.querySelector('.alert');
    if (existing) existing.remove();

    const box = document.createElement('div');
    box.classList.add('alert', isSuccess ? 'success' : 'error');
    box.innerHTML = `
      <button class="close-btn">&times;</button>
      <p>${message}</p>
    `;

    document.body.appendChild(box);

    box.querySelector('.close-btn')
      .addEventListener('click', () => box.remove());
  }
});
