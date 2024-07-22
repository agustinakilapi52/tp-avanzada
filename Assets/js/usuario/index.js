const tableContainer = document.getElementById('tableContainer');

const getAll = async () => {
    try {
        const response = await fetch(principal + 'View/usuario/action/listar_usuario.php');
        if (!response.ok) {
            throw new Error('Error fetching data');
        }
        const data = await response.json();
        renderTable(data);
    } catch (error) {
        console.error('Error:', error);
    }
};

const renderTable = (data) => {
    tableContainer.innerHTML = ''; 

    data.forEach(e => {
        const tr = document.createElement('tr');

        const tdId = document.createElement('td');
        tdId.textContent = e.id_usuario;
        tr.appendChild(tdId);

        const tdNombre = document.createElement('td');
        tdNombre.textContent = e.imgperfil;
        tr.appendChild(tdNombre);

        const tdRuta = document.createElement('td');
        tdRuta.textContent = e.usnombre;
        tr.appendChild(tdRuta);

        const tdTelefono = document.createElement('td');
        tdTelefono.textContent = e.ustelefono;
        tr.appendChild(tdTelefono);

        const tdMail = document.createElement('td');
        tdMail.textContent = e.usmail;
        tr.appendChild(tdMail);

        const tdEstado = document.createElement('td');
        tdEstado.textContent = e.estado;
        tr.appendChild(tdEstado);

        const tdAcciones = document.createElement('td');
        const divAcciones = document.createElement('div');

        // Crear el botón "Editar"
        const btnEditar = document.createElement('button');
        btnEditar.textContent = 'Editar';
        btnEditar.classList.add('btn-editar');
        btnEditar.addEventListener('click', () => {
            
            console.log('Editar usuario:', e.id_usuario);
           
        });

        divAcciones.appendChild(btnEditar);
        tdAcciones.appendChild(divAcciones);
        tr.appendChild(tdAcciones);

        tableContainer.appendChild(tr);
    });
};


getAll();




function cambiarEstadoUsuario(estado, id_usuario) {
    let form = new FormData();
    form.append('estado', estado);
    form.append('id_usuario', id_usuario);
    return $.ajax({
        type: "POST",
        url: principal + "View/usuario/action/estado_usuario.php",
        data: form,
        processData: false,
        contentType: false,
        beforeSend: function () {
            loadingAlert();
        },
    });
}


function cambiarEstado(e) {
    let estado, id_usuario;
    id_usuario = e.children[0].getAttribute('data-id');

    if (e.children[0].classList.contains('fa-ban')) {
        estado = 0;
    } else {
        estado = 1;
    }


    if (confirm('¿Confirma el cambio de estado del usuario?')) {
        cambiarEstadoUsuario(estado, id_usuario)
            .done(function (data) {
          
                alert('Se ha actualizado el estado del usuario.');
                console.log(data);
                getAllUser();
            })
            .fail((err, textStatus, xhr) => {
                let errors = JSON.parse(err.responseText);
                errors = errors.join(". ");
            
                alert('Error: ' + errors);
            });
    }
}

