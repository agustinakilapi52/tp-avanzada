document.addEventListener('DOMContentLoaded', () => {
    const tableContainer = document.getElementById('tableContainer');

// Asegúrate de que 'productos' esté definido y tenga los datos correctos
let productos = [];

const getAllProductos = async () => {
    tableContainer.innerHTML = '';
    const response = await fetch(principal + 'View/action/listaProducto.php');
    const data = await response.json();

    productos = data; // Asignar los datos a la variable 'productos'

    data.forEach(e => {
        const tr = document.createElement('tr');

        let td = document.createElement('td');
        td.textContent = e.id_producto;
        tr.appendChild(td);

        td = document.createElement('td');
        const img = document.createElement('img');
        img.src = 'libreria/Assets/uploads/fotosproductos/' + e.imgproducto;
        img.style.borderRadius = '50%';
        img.style.width = '100px';
        img.style.height = '100px';
        img.style.objectFit = 'cover';
        td.appendChild(img);
        tr.appendChild(td);

        td = document.createElement('td');
        td.textContent = e.pronombre;
        tr.appendChild(td);

        td = document.createElement('td');
        td.textContent = e.prodetalle;
        tr.appendChild(td);

        td = document.createElement('td');
        td.textContent = e.procantstock;
        tr.appendChild(td);

        td = document.createElement('td');
        td.textContent = '$' + e.proprecio;
        tr.appendChild(td);

        td = document.createElement('td');
        td.style.textAlign = 'center';

        const btnModal = document.createElement('button');
        btnModal.textContent = 'Editar';
        btnModal.className = 'btn btn-secondary btn-sm ms-2'; 
        btnModal.setAttribute('data-bs-toggle', 'modal');
        btnModal.setAttribute('data-bs-target', '#modal_edicion_producto');
        btnModal.setAttribute('data-id', e.id_producto); // Agregar data-id para usar en modalEditUser
        btnModal.onclick = function() { modalEditUser(e.id_producto); };
        td.appendChild(btnModal);

        tr.appendChild(td);
        tableContainer.appendChild(tr);
    });
};

getAllProductos();

function modalEditUser(id_producto) {
    let producto = productos.find(p => p.id_producto == id_producto);

    if (!producto) {
        console.error(`Producto con ID ${id_producto} no encontrado.`);
        return;
    }

    const imgElement = document.querySelector('.img_add');
  

    imgElement.src = 'libreria/Assets/uploads/fotosproductos/' + producto.imgproducto;
    

    document.getElementById('pronombre').value = producto.pronombre || '';
    document.getElementById('prodetalle').value = producto.prodetalle || '';
    document.getElementById('procantstock').value = producto.procantstock || '';
    document.getElementById('proprecio').value = producto.proprecio || '';
    document.getElementById('idproducto').value = producto.id_producto;

    let modal = new bootstrap.Modal(document.getElementById('modal_edicion_producto'));
    modal.show();
}

function cargarEdicionAjax(e) {
    return $.ajax({
        type: "POST",
        url: "action/editarProducto.php",
        data: new FormData(e),
        processData: false,
        contentType: false,
        beforeSend: function () {
            console.log('Loading...');
        },
    });
}

document.getElementById('formulario').onsubmit = function(event) {
    event.preventDefault();
    const btnSubmit = document.getElementById('btnSubmit');
    const autorizarForm = this;
    let id_tipo_crear = 3; // Crear un nuevo producto
    btnSubmit.disabled = true;

    if (confirm('¿Confirma la carga del producto?')) {
        cargarEdicionAjax(autorizarForm, id_tipo_crear)
            .done(data => {
                console.log(data);
                alert('Se ha creado el producto correctamente');
                window.location.replace(principal + "View/admin-productos.php");
            })
            .fail(err => {
                let errors = JSON.parse(err.responseText);
                errors = errors.join(". ");
                alert('Error: ' + errors);
                btnSubmit.disabled = false;
            });
    } else {
        btnSubmit.disabled = false;
    }
};

});

const changeImg = document.getElementById('changeImg');
changeImg.addEventListener('click', () => {
    let edit_img = changeImg.previousElementSibling.getAttribute('id');
    edit_img = document.getElementById(edit_img); 
    edit_img.click();
});
