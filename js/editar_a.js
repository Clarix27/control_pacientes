document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('formEditarBeneficiario');

  form.addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const idPersona = formData.get('pk_titular');

    try {
      const res = await fetch('controladores/procesar_edicion_afiliado.php', {
        method: 'POST',
        body: formData
      });

      const json = await res.json();
      showAlert(json.message, json.success);

      if (json.success) {
        form.reset();
        setTimeout(() => {
          // opcional: box.remove();
          window.location.href = `Historial_titular.php?id=${encodeURIComponent(idPersona)}`;
        }, 1000);
      }

    } catch (error) {
      showAlert('Error de conexión. Intenta de nuevo.', false);
    }
  });

  /**
   * 
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
    setTimeout(() => {
      if (document.body.contains(box)) {
        box.remove();
      }
    }, 2000);
  }
});
