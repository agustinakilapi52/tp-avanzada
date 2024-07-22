const tableContainer = document.getElementById('tableContainer');

const getAllMenusHistorico = async () => {
    try {
        const response = await fetch(principal + 'View/menu/action/listaMenu.php');
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
    tableContainer.innerHTML = ''; // Limpiar contenido anterior de la tabla

    data.forEach(e => {
        const tr = document.createElement('tr');

        const tdId = document.createElement('td');
        tdId.textContent = e.idmenu;
        tr.appendChild(tdId);

        const tdNombre = document.createElement('td');
        tdNombre.textContent = e.menombre;
        tr.appendChild(tdNombre);

        const tdRuta = document.createElement('td');
        tdRuta.textContent = e.medescripcion;
        tr.appendChild(tdRuta);

        const tdMenuPadre = document.createElement('td');
        tdMenuPadre.textContent = e.menu_padre;
        tr.appendChild(tdMenuPadre);

        const tdEstado = document.createElement('td');
        tdEstado.textContent = e.estado === "0000-00-00 00:00:00" || e.estado === null ? 'Activo' : 'Inactivo';
        tr.appendChild(tdEstado);

        const tdAcciones = document.createElement('td');
        const divAcciones = document.createElement('div');

        const aEdit = document.createElement('a');
        const iconEdit = document.createElement('i');
        iconEdit.className = 'fa-solid fa-pen btn_accion_edit';
        iconEdit.setAttribute('data-id', e.idmenu);
        iconEdit.onclick = function() {
            modalEditMenu(this);
        };
        aEdit.appendChild(iconEdit);
        divAcciones.appendChild(aEdit);

        const aDelete = document.createElement('a');
        const iconDelete = document.createElement('i');
        iconDelete.className = e.estado === "0000-00-00 00:00:00" || e.estado === null ?
            'fa-solid fa-ban btn_accion_delete' : 'fa-solid fa-check btn_accion_active';
        iconDelete.setAttribute('data-id', e.idmenu);
        aDelete.onclick = function() {
            cambiarEstado(this);
        };
        aDelete.appendChild(iconDelete);
        divAcciones.appendChild(aDelete);

        tdAcciones.appendChild(divAcciones);
        tr.appendChild(tdAcciones);

        tableContainer.appendChild(tr);
    });
};

getAllMenusHistorico();
