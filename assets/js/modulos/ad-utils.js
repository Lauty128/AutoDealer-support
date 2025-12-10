/**
 * Cargar una imagen not-found a un elemento <img>
 * Colocar en un onError
 */
function manageErrorImage(event){
    const defaultImageUrl = storage_base_url + 'not-found.png'
    event.target.setAttribute('src', defaultImageUrl)
}

/**
 * Generar una URL con parametros includios
 * @param {string} url url
 * @param {object} filters parametros a agregar 
 * @returns 
 */
function generateUrlFilters(url, filters = {}){
    if(isEmpty(filters)){
        return url
    }
    let newUrl = url + '?'

    const keys = Object.keys(filters);
    keys.forEach(key => {
        newUrl += key + '=' + filters[key] + '&'
    })

    return newUrl
}

/**
 * Si un elemento es vacio
 */
const isEmpty = (obj) => JSON.stringify(obj) === '{}';

/**
 * Vaciar formulario si existe
 * 
 * @param {string} id 
 */
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