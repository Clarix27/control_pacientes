
function showConfirm(message) {
  return new Promise(resolve => {
    const overlay = document.createElement('div');
    overlay.className = 'modal-overlay';

    const box = document.createElement('div');
    box.className = 'modal-box';
    box.innerHTML = `<p>${message}</p>`;

    const buttons = document.createElement('div');
    buttons.className = 'modal-buttons';

    const btnCancel = document.createElement('button');
    btnCancel.className = 'btn-cancel';
    btnCancel.textContent = 'Cancelar';
    btnCancel.addEventListener('click', () => {
      document.body.removeChild(overlay);
      resolve(false);
    });

    const btnConfirm = document.createElement('button');
    btnConfirm.className = 'btn-confirm';
    btnConfirm.textContent = 'Aceptar';
    btnConfirm.addEventListener('click', () => {
      document.body.removeChild(overlay);
      resolve(true);
    });

    buttons.append(btnCancel, btnConfirm);
    box.append(buttons);
    overlay.append(box);
    document.body.append(overlay);
  });
}

document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.delete-link')
    .forEach(link => link.addEventListener('click', async e => {
      e.preventDefault();
      const id = link.dataset.id;

      const ok = await showConfirm('¿Seguro que deseas restaurar este titular?');
      if (!ok) return;

      try {
        const formData = new FormData();
        formData.append('id', id);

        const res = await fetch('controladores/restaurar.php', {
          method: 'POST',
          body: formData
        });

        const text = await res.text();
        console.log('RESPUESTA CRUDA:', text);
        const json = JSON.parse(text);

        showAlert(json.message, json.success);

        if (json.success) {
          setTimeout(() => location.reload(), 1500);
        }

      } catch (error) {
        showAlert('Ocurrió un error al comunicarse con el servidor.', false);
      }
    }));

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
