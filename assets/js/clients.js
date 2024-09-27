//-----------------------------------------------------------
//--------------------> Funciones <--------------------------
//-----------------------------------------------------------

/**
 * Obtener los datos de un cliente especifico 
 * 
 * @param {number} id Id del cliente 
 * @returns {object|null} Objeto del cliente
 */
async function getClient(id){
    const data = await fetch(api_base_url + 'clientes.php/get-one?id=' + id)
        .then(res => {
            if(!res.ok) throw new Error('Ocurrio un error en el servidor')
            return res.json()
        })
        .catch(error => {
            console.log(error);
            return null
        })
    
    return data
}

/**
 * Eliminar cliente junto a sus datos relacionados
 * 
 * @param {number} id id del cliente a eliminar
 * @returns {boolean} Resultado de la operacion
 */
async function deleteClient(id){
    const data = await fetch(api_base_url + 'clientes.php/delete', {
            method: 'POST',
            body: JSON.stringify({ id })
        })
        .then(res => res.json())
        .catch(error => {
            console.log(error);
            return null
        })

    return data;
}

/**
 * Eliminar un cliente con boton de confirmacion
 * 
 * @param {Int} id id del usuario 
 */
async function deleteClientEvent(id)
{
    const options = {
        title: "Estas seguro de eliminar este cliente?",
        text: "Perderas toda la informacion relacionada con el mismo y los concesionarios que le pertenecen",
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
                    const response = await deleteClient(id);
                    
                    if(response) {
                        Swal.fire({
                            title: "Cliente eliminado",
                            text: "El cliente fue eliminado del sistema junto a toda su informacion",
                            icon: "success",
                            confirmButtonColor: '#dcac0c',
                            confirmButtonText: 'Aceptar',
                        });
                    
                        ad_loadData(getClients(), printClients);
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
function printClients(clients){
    loadPreloader()
    listComponent.innerHTML = '';
    const fragment = document.createDocumentFragment();

    clients.forEach(client => {
        const tr = document.createElement('tr');
        let td;

        td = document.createElement('td')
        td.classList.add('col-1')
        td.textContent = client.id
        tr.appendChild(td)
        
        td = document.createElement('td')
        td.classList.add('col-4')
        td.textContent = client.name + ' ' + client.subname
        tr.appendChild(td)
        
        td = document.createElement('td')
        td.classList.add('col-4')
        td.textContent = client.province
        tr.appendChild(td)
        
        td = document.createElement('td')
        td.classList.add('col-3')
        td.innerHTML = `<button class="btn btn-primary" data-type=\"list-view\" onClick="openModalView(${client.id})" data-id=\"${client.id}\" data-bs-toggle="modal" data-bs-target="#viewModal">
                            <svg width="17px" height="17px" viewBox="0 0 24 24" stroke-width="1.5" fill="none" xmlns="http://www.w3.org/2000/svg" color="#FFFF"><path d="M3 13C6.6 5 17.4 5 21 13" stroke="#FFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M12 17C10.3431 17 9 15.6569 9 14C9 12.3431 10.3431 11 12 11C13.6569 11 15 12.3431 15 14C15 15.6569 13.6569 17 12 17Z" stroke="#FFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </button>
                        <button class="btn btn-secondary" data-type=\"list-view\" onClick="openModalEdit(${client.id})" data-id=\"${client.id}\" data-bs-toggle="modal" data-bs-target="#manageModal">
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
function clearForm(){
    document.getElementById("name-input").value = "";
    document.getElementById("subname-input").value = "";
    document.getElementById("email-input").value = "";
    document.getElementById("phone-input").value = "";
    document.getElementById("location-input").value = "";
    document.getElementById("client-input").value = 0
}

/**
 * Abrir modal #manageModal preparado para editar los datos del cliente indicado
 * 
 * @param {Int} id Id del cliente a editar 
 */
async function openModalEdit(id){
    document.getElementById('manageModalTitle').textContent = 'Editar cliente #' + id
    
    loadModalPreloader('manageModalLoader', 'Cargando...')
    const client = await getClient(id);
    
    if(client) {
        document.getElementById("name-input").value = client.name
        document.getElementById("subname-input").value = client.subname
        document.getElementById("email-input").value = client.email
        document.getElementById("phone-input").value = client.phone
        document.getElementById("location-input").value = client.location_id
        document.getElementById("client-input").value = client.id
        
        closeModalPreloader('manageModalLoader')
    } else {
        loadModalPreloader('manageModalLoader', 'Ocurrio un error al cargar los datos')
    }
}

/**
 * Abrir modal #manageModal preparado para crear un nuevo cliente
 * 
 */
function openModalCreate(){
    clearForm();
    document.getElementById('manageModalTitle').textContent = 'Agregar nuevo cliente'
}

async function openModalView(id){
    document.getElementById('viewModalTitle').textContent = 'Cliente #' + id
    
    loadModalPreloader('viewModalLoader', 'Cargando...')
    const client = await getClient(id)

    if(client){
        // Configurar datos del cliente
        const vimage = (client.image)
                        ? storage_base_url + '/users/' + client.id + '/' + client.image
                        : storage_base_url + '/not-found.png'
        
        document.querySelector('#viewModal img').setAttribute('src', vimage)
        document.getElementById('viewModal-name').textContent = client.name + ' ' + client.subname
        document.getElementById('viewModal-email').textContent = client.email
        document.getElementById('viewModal-phone').textContent = client.phone
        document.getElementById('viewModal-location').textContent = client.city + ', ' + client.province

        closeModalPreloader('viewModalLoader')
    } else {
        loadModalPreloader('viewModalLoader', 'Ocurrio un error')
    }
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
        subname : document.getElementById("subname-input").value,
        email : document.getElementById("email-input").value,
        phone : document.getElementById("phone-input").value,
        location_id : document.getElementById("location-input").value,
    }
    let successMessage = 'Cliente agregado';

    const clientId = +document.getElementById("client-input").value

    if(clientId){
        fn = 'update';
        data.id = clientId;
        successMessage = 'Datos actualizados';
    }

    validateLocation(data.location_id)

    fetch(api_base_url + 'clientes.php/' + fn, {
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
                ad_loadData(getClients(), printClients);
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

//---------> Manejo de eventos click dentro del contenedor #List
document.getElementById('List').addEventListener('click', e => {

    //--> Boton eliminar
    if(e.target.dataset.type == 'list-delete'){
        deleteClientEvent(e.target.dataset.id)
    }

})

//---------> Cancelar evento por defecto del boton cancelar en #manageModal
document.getElementById('manageModal_close').addEventListener('click', (e) =>{
    e.preventDefault()
})


//-----------------------------------------------------------
//-----------------> Ejecucion del codigo <------------------
//-----------------------------------------------------------
document.addEventListener('DOMContentLoaded', () => {

    ad_loadData(getClients(), printClients);

})