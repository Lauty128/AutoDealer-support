//-----> Constantes globales
const listComponent = document.getElementById('List');
const typeList = listComponent.dataset.type;
const preLoader = document.getElementById('preloadMessage');

const cacheKeys = {
    clients: 'autodealer.admin.clients',
    stores: 'autodealer.admin.stores',
}

//-----> Funciones globales
function manageErrorImage(event){
    const defaultImageUrl = storage_base_url + 'not-found.png'
    event.target.setAttribute('src', defaultImageUrl)
}

function clearForm(id){
    const form = document.getElementById(id)
    if(form)
        form.reset()
    // manageForm
}

/**
 * Limpiar preloader de Lista (#list)
 */
function clearPreloader(){
    const div = preLoader;
    div.innerHTML = ""
}

/**
 * Cargar preloader de Lista (#list)
 */
function loadPreloader(){
    const div = preLoader;
    div.innerHTML = "<p class=\"mt-4 text-center\">Cargando...</p>"
}

/**
 * Ejecutar preloader de un modal
 * 
 * @param {String} id  Id del preloader que se quiere ejecutar
 * @param {String} content  Mensaje que mostrara el preloader
 * @returns {Void}
 */
function loadModalPreloader(id, content = 'Cargando...'){
    const preLoader = document.getElementById(id)

    if(preLoader){
        preLoader.firstElementChild.textContent = content;
        preLoader.classList.add('modalLoader--active')
    }
}

/**
 * Limpiar preloader del modal indicado
 * 
 * @param {String} id Id del preloader 
 */
function closeModalPreloader(id){
    const preLoader = document.getElementById(id)

    if(preLoader)
        preLoader.classList.remove('modalLoader--active')
}

/**
 * 
 * @param {Function} service Funcion estanciada que se encargara de obtener la informacion necesaria
 * @param {CallableFunction} printFunction Funcion utilizada para imprimir la informacion
 * @returns 
 */
async function ad_loadData(service, printFunction){
    const data = await service;
    
    if(!data){
        alert('Ocurrio un error al buscar los clientes')
        return;
    }

    printFunction(data)
}

//-----> Consultas a la API

/**
 * Obtener lista de todos los clientes del sistema
 * 
 * @returns {Array} Array con listado de clientes
 */
async function getClients(){
    // Si esta cacheado se devuelve sin consultar a la API
    if(sessionStorage.getItem(cacheKeys.clients))
        return JSON.parse(sessionStorage.getItem(cacheKeys.clients))

    // Hacer consulta a la API
    const data = await fetch(api_base_url + 'clientes.php/get')
        .then(res => {
            if(!res.ok) throw new Error('Ocurrio un error en el servidor')
            return res.json()
        })
        .catch(error => {
            console.log(error);
            return null
        })
    
    console.log('Clientes cacheados..')
    // Guardar resultado en cache si no es nulo
    if(data)
        sessionStorage.setItem(cacheKeys.clients, JSON.stringify(data))

    return data
}

/**
 * Obtener lista de concesionarios del sistema
 * 
 * @returns {Array} Array con listado de concesionarios
 */
async function getStores(){
    // Si esta cacheado se devuelve sin consultar a la API
    if(sessionStorage.getItem(cacheKeys.stores))
        return JSON.parse(sessionStorage.getItem(cacheKeys.stores))

    // Hacer consulta a la API
    const data = await fetch(api_base_url + 'concesionarios.php/get')
        .then(res => {
            if(!res.ok) throw new Error('Ocurrio un error en el servidor')
            return res.json()
        })
        .catch(error => {
            console.log(error);
            return null
        })
    
    console.log('Concesionarios cacheados..')
    // Guardar resultado en cache si no es nulo
    if(data)
        sessionStorage.setItem(cacheKeys.stores, JSON.stringify(data))

    return data
}

// -------------------> Locations <----------------------//

/**
 * Validar la ubicacion y si no existe se crea en el sistema
 * 
 * @param {number} id id de la ubicación
 * @returns {void}
 */
async function validateLocation(id){
    const data = await getLocation(id)

    if(!data || (data.length == 0)){
        fetch('https://apis.datos.gob.ar/georef/api/localidades-censales?max=6&campos=provincia.nombre,departamento.nombre&id=' + id)
            .then(res => res.json())
            .then(data => {
                if(data.cantidad > 0){
                    const city = data.localidades_censales[0]
                    const body = {
                        id,
                        city: city.nombre,
                        department: city.departamento.nombre,
                        province: city.provincia.nombre
                    }
                    createLocation(body)
                }
            })
            .catch(err => {
                console.log(err);
                return null
            })
    }
}

/**
 * Obtener una ubicacion especifica o null
 * 
 * @param {object} data Objeto con los datos de la ubicacion
 *  - id
 *  - city
 *  - department
 *  - province
 * @returns {void}
 */
async function createLocation(data) {
    if(!data)
        return;

    fetch(api_base_url + 'ubicaciones.php/create', {
            method: 'POST',
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .catch(err => {
            console.log(err);
            return null
        })
    
}

/**
 * Obtener una ubicacion especifica o null
 * 
 * @param {number} id id de la ubicación
 * @returns {object|null} Objeto de la ubicación
 */
async function getLocation(id){
    const data = await fetch(api_base_url + 'ubicaciones.php/get-one?id=' + id)
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