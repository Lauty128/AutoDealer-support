//-----> Constantes globales
const listComponent = document.getElementById('List');
const typeList = listComponent.dataset.type;
const preLoader = document.getElementById('preloadMessage');


//-----> Funciones globales
function manageErrorImage(event){
    const defaultImageUrl = storage_base_url + 'not-found.png'
    event.target.setAttribute('src', defaultImageUrl)
}

function clearPreloader(){
    const div = preLoader;
    div.innerHTML = ""
}

function loadPreloader(){
    const div = preLoader;
    div.innerHTML = "<p class=\"mt-4 text-center\">Cargando...</p>"
}

function loadModalPreloader(id, content){
    const preLoader = document.getElementById(id)

    if(preLoader){
        preLoader.firstElementChild.textContent = content;
        preLoader.classList.add('modalLoader--active')
    }
}

function closeModal(id){
    const modal = new bootstrap.Modal(document.getElementById(id))
    modal.hide()
}

function closeModalPreloader(id){
    const preLoader = document.getElementById(id)

    if(preLoader)
        preLoader.classList.remove('modalLoader--active')
}

async function ad_loadData(service, printFunction){
    const data = await service;
    
    if(!data){
        alert('Ocurrio un error al buscar los clientes')
        return;
    }

    printFunction(data)
}

//-----> Consultas a la API
async function getClients(){
    const data = await fetch(api_base_url + 'clientes.php/get')
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

async function getStores(){
    const data = await fetch(api_base_url + 'concesionarios.php/get')
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