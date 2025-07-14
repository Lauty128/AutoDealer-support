//-----------------------------------------------------------
//--------------------> Funciones <--------------------------
//-----------------------------------------------------------

/**
 * Eliminar marca junto a sus datos relacionados
 * 
 * @param {number} id id del cliente a eliminar
 * @returns {boolean} Resultado de la operacion
 */
async function deleteMark(id){
    const data = await fetch(api_base_url + 'marcas.php/delete', {
            method: 'POST',
            body: JSON.stringify({ id })
        })
        .then(res => res.json())
        .catch(error => {
            console.log(error);
            return null
        })

    // Si la operacion fue exitosa limpiamos cache
    if(data){
        sessionStorage.removeItem(cacheKeys.marks);
    }

    return data;
}

/**
 * Eliminar un cliente con boton de confirmacion
 * 
 * @param {Int} id id del usuario 
 */
async function deleteMarkEvent(id)
{
    const options = {
        title: "Estas seguro de eliminar esta marca?",
        text: "Perderas toda la informacion relacionada con la mismo incluido los vehiculos",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#9e9e9e",
        cancelButtonText: "Cancelar",
        confirmButtonText: "Eliminar"
    }

    Swal.fire(options)
            .then(async (result) => {
                if (result.isConfirmed) {
                    const response = await deleteMark(id);
                    
                    if(response) {
                        Swal.fire({
                            title: "Marca eliminada",
                            text: "La marca fue eliminado del sistema junto a toda su informacion relacionada",
                            icon: "success",
                            confirmButtonColor: '#dcac0c',
                            confirmButtonText: 'Aceptar',
                        });
                    
                        clearForm('filtersForm')
                        ad_loadData(getMarks(), printMarks);
                    } else {
                        Swal.fire({
                            title: "Ocurrio un error",
                            text: "No se logro eliminar la marca por culpa de un error interno",
                            icon: "error",
                            showConfirmButton: false,
                            timer: 1200
                        });
                    }
                }
            });
}

/**
 * Imprimir clientes en la tabla #List
 * 
 * @param {Object} clients Listado de clientes
 * - id
 * - name
 * - subname
 * - province
 */
function printMarks(marks){
    loadPreloader()
    listComponent.innerHTML = '';
    const fragment = document.createDocumentFragment();

    marks.forEach(client => {
        const tr = document.createElement('tr');
        let td;

        td = document.createElement('td')
        td.classList.add('col-1')
        td.textContent = client.id
        tr.appendChild(td)
        
        td = document.createElement('td')
        td.classList.add('col-4')
        td.textContent = client.name
        tr.appendChild(td)
        
        td = document.createElement('td')
        td.classList.add('col-4')
        td.textContent = client.vehicles
        tr.appendChild(td)
        
        td = document.createElement('td')
        td.classList.add('col-3')
        td.innerHTML = `<button class="btn btn-secondary" data-type=\"list-edit\" onClick="openModalEdit(${client.id}, '${client.name}')" data-id=\"${client.id}\" data-bs-toggle="modal" data-bs-target="#manageModal">
                            <svg width="17px" height="17px" viewBox="0 0 24 24" stroke-width="1.5" fill="none" xmlns="http://www.w3.org/2000/svg" color="#FFFF"><path d="M14.3632 5.65156L15.8431 4.17157C16.6242 3.39052 17.8905 3.39052 18.6716 4.17157L20.0858 5.58579C20.8668 6.36683 20.8668 7.63316 20.0858 8.41421L18.6058 9.8942M14.3632 5.65156L4.74749 15.2672C4.41542 15.5993 4.21079 16.0376 4.16947 16.5054L3.92738 19.2459C3.87261 19.8659 4.39148 20.3848 5.0115 20.33L7.75191 20.0879C8.21972 20.0466 8.65806 19.8419 8.99013 19.5099L18.6058 9.8942M14.3632 5.65156L18.6058 9.8942" stroke="#FFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </button>
                        <button class="btn btn-danger" data-type=\"list-delete\" data-id=\"${client.id}\">
                            <svg width="17px" height="17px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="#FFFF" stroke-width="1.5"><path d="M20 9L18.005 20.3463C17.8369 21.3026 17.0062 22 16.0353 22H7.96474C6.99379 22 6.1631 21.3026 5.99496 20.3463L4 9" fill="#FFFF"></path><path d="M20 9L18.005 20.3463C17.8369 21.3026 17.0062 22 16.0353 22H7.96474C6.99379 22 6.1631 21.3026 5.99496 20.3463L4 9H20Z" stroke="#FFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M21 6H15.375M3 6H8.625M8.625 6V4C8.625 2.89543 9.52043 2 10.625 2H13.375C14.4796 2 15.375 2.89543 15.375 4V6M8.625 6H15.375" stroke="#FFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </button>`;
        tr.appendChild(td)

        fragment.appendChild(tr)
    });

    listComponent.appendChild(fragment)
    clearPreloader()
}

/**
 * Limpiar formulario
 */
function clearForm(id){
    document.getElementById(id).reset()
}

/**
 * Abrir modal #manageModal preparado para editar los datos del cliente indicado
 * 
 * @param {Int} id Id de la marca a editar 
 * @param {String} name Nombre de la marca 
 */
async function openModalEdit(id, name){
    document.getElementById('manageModalTitle').textContent = 'Editar marca #' + id
    
    loadModalPreloader('manageModalLoader', 'Cargando...')
    
    document.getElementById("id-input").value = id
    document.getElementById("name-input").value = name    
    closeModalPreloader('manageModalLoader')
}

/**
 * Abrir modal #manageModal preparado para crear un nuevo cliente
 * 
 */
function openModalCreate(){
    clearForm('manageForm');
    document.getElementById('manageModalTitle').textContent = 'Agregar nueva marca';
}


//-----------------------------------------------------------
//-----------------------> Eventos <-------------------------
//-----------------------------------------------------------

//--------> Manejar envio de formulario para creacion o edicion de cliente
document.getElementById('manageForm').addEventListener('submit', async (event) => {
    event.preventDefault();

    let fn = 'create';
    const data = {
        name : document.getElementById("name-input").value,
    }
    let successMessage = 'Marca agregada';

    const clientId = +document.getElementById("id-input").value

    if(clientId){
        fn = 'update';
        data.id = clientId;
        successMessage = 'Datos actualizados';
    }

    fetch(api_base_url + 'marcas.php/' + fn, {
            method: 'POST',
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(data => {
            // Cerrar modal
            document.getElementById('manageModal_close').click()

            if(data){
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: successMessage,
                    showConfirmButton: false,
                    timer: 1500
                  });
                
                // Si la operacion fue exitosa limpiamos cache
                sessionStorage.removeItem(cacheKeys.marks);
                
                // Limpiar busqueda
                clearForm('filtersForm')

                // Volvemos a cargar el listado
                ad_loadData(getMarks(), printMarks);
            } else {
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "No se pudo realizar la operacion",
                    showConfirmButton: false,
                    timer: 1500
                  });
            }
        })
        .catch(err => {
            console.log(err);
            return null
        })

})


document.getElementById('filtersForm').addEventListener("submit", (e) => {
    e.preventDefault()

    const formData = new FormData(e.target);
    const filters = {};
    
    // Actualizar parametros de busqueda en la url
    const params = new URLSearchParams(window.location.search);
    if (formData.get('search')){
        params.set('search', formData.get('search'));
        filters.search = formData.get('search')
    } else {
        delete filters.search
        params.delete('search');
    }

    // Actualizar la URL sin recargar la página
    const newUrl = window.location.pathname + '?' + params.toString();
    history.replaceState(null, '', newUrl);

    // Actualizar listado
    ad_loadData(getMarks(filters), printMarks);
})


//---------> Manejo de eventos click dentro del contenedor #List
document.getElementById('List').addEventListener('click', e => {

    //--> Boton eliminar
    if(e.target.dataset.type == 'list-delete'){
        deleteMarkEvent(e.target.dataset.id)
    }

})


//---------> Cancelar evento por defecto del boton cancelar en #manageModal
document.getElementById('manageModal_close').addEventListener('click', (e) =>{
    e.preventDefault()
})


//-----------------------------------------------------------
//-----------------> Ejecucion del codigo <------------------
//-----------------------------------------------------------
document.addEventListener('DOMContentLoaded', async () => {
    // Verificar si hay parametros de busqueda en la url
    const urlParams = new URLSearchParams(window.location.search);
    const filters = {}
    
    // Actualiza filtros si existe en los parametros
    if(urlParams.get('search')){
        filters.search = urlParams.get('search');
        document.getElementById('FilterInput').value = urlParams.get('search')
    }
    
    ad_loadData(getMarks(filters), printMarks);
})