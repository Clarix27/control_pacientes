document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('formControlP');

  form.addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    try {
      const res = await fetch('controladores/control_paciente.php', {
        method: 'POST',
        body: formData
      });

      const text = await res.text();
      console.log('RESPUESTA CRUDA:', text);
      const json = JSON.parse(text);

      //const json = await res.json();
      showAlert(json.message, json.success);

      if (json.success) {
  document.getElementById('modalFormulario').style.display = 'none';
  setTimeout(() => {
    location.reload();
  }, 1000);
}


    } catch (error) {
      showAlert('Ocurrio un error al registrar algo.', false);
    }
  });

  /**
   * 
   * @param {string} message
   * @param {boolean} isSuccess
   */
  function showAlert(message, isSuccess) {
    // Remueve alerta previa
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

function abrirModalEditarDesdeAttr(btn) {
  const paciente = {
    nombre: btn.getAttribute('data-nombre'),
    paterno: btn.getAttribute('data-paterno'),
    materno: btn.getAttribute('data-materno')
  };

  const titular = {
    nombre: btn.getAttribute('data-nombre-t'),
    paterno: btn.getAttribute('data-paterno-t'),
    materno: btn.getAttribute('data-materno-t')
  };

  const sonIguales = (
    paciente.nombre === titular.nombre &&
    paciente.paterno === titular.paterno &&
    paciente.materno === titular.materno
  );

  document.getElementById('edit_id_consulta').value = btn.getAttribute('data-id');
  document.getElementById('edit_area').value = btn.getAttribute('data-area');
  document.getElementById('edit_pago').value = btn.getAttribute('data-pago');

  document.getElementById('edit_nombre_p').value = paciente.nombre;
  document.getElementById('edit_paterno_p').value = paciente.paterno;
  document.getElementById('edit_materno_p').value = paciente.materno;

  document.getElementById('edit_nombre_t').value = titular.nombre;
  document.getElementById('edit_paterno_t').value = titular.paterno;
  document.getElementById('edit_materno_t').value = titular.materno;

  if (sonIguales) {
    document.getElementById('grupoTitular').style.display = 'none';
  } else {
    document.getElementById('grupoTitular').style.display = 'block';
  }

  document.getElementById('modalEditar').style.display = 'flex';
}



function cerrarModalEditar() {
  document.getElementById('modalEditar').style.display = 'none';
  document.getElementById('formEditarConsulta').reset();
}

document.getElementById('formEditarConsulta').addEventListener('submit', async function(e) {
  e.preventDefault();
  const formData = new FormData(this);

  try {
    const res = await fetch('controladores/editar_consulta.php', {
      method: 'POST',
      body: formData
    });

    const result = await res.json();

    if (result.success) {
      cerrarModalEditar();
      setTimeout(() => location.reload(), 500);
    } else {
      alert('Error al actualizar: ' + result.message);
    }
  } catch (err) {
    console.error(err);
    alert('Error al actualizar.');
  }
});
