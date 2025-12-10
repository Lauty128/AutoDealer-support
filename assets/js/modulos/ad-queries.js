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
 * Obtener lista de todos los clientes del sistema
 * 
 * @returns {Array} Array con listado de clientes
 */
async function getClients(filters = {}){
    // Si esta cacheado se devuelve sin consultar a la API    
    if(sessionStorage.getItem(cacheKeys.clients) && isEmpty(filters))
        return JSON.parse(sessionStorage.getItem(cacheKeys.clients))

    // Generar url
    const url = generateUrlFilters(api_base_url + 'clientes.php/get', filters);

    // Hacer consulta a la API
    const data = await fetch(url)
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
    if(data && isEmpty(filters))
        sessionStorage.setItem(cacheKeys.clients, JSON.stringify(data))

    return data
}

/**
 * Obtener lista de concesionarios del sistema
 * 
 * @returns {Array} Array con listado de concesionarios
 */
async function getStores(filters = {}){
    // Si esta cacheado se devuelve sin consultar a la API
    if(sessionStorage.getItem(cacheKeys.stores) && isEmpty(filters))
        return JSON.parse(sessionStorage.getItem(cacheKeys.stores))

    // Generar url
    const url = generateUrlFilters(api_base_url + 'concesionarios.php/get', filters);

    // Hacer consulta a la API
    const data = await fetch(url)
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
    if(data && isEmpty(filters))
        sessionStorage.setItem(cacheKeys.stores, JSON.stringify(data))

    return data
}

/**
 * Obtener lista de concesionarios del sistema
 * 
 * @returns {Array} Array con listado de concesionarios
 */
async function getBillings(filters = {}){
    // Si esta cacheado se devuelve sin consultar a la API
    if(sessionStorage.getItem(cacheKeys.billings) && isEmpty(filters))
        return JSON.parse(sessionStorage.getItem(cacheKeys.billings))

    // Generar url
    const url = generateUrlFilters(api_base_url + 'facturas.php/get', filters);

    // Hacer consulta a la API
    const data = await fetch(url)
        .then(res => {
            if(!res.ok) throw new Error('Ocurrio un error en el servidor')
            return res.json()
        })
        .catch(error => {
            console.log(error);
            return null
        })
    
    console.log('Facturas cacheados..')

    // Guardar resultado en cache si no es nulo
    if(data && isEmpty(filters))
        sessionStorage.setItem(cacheKeys.billings, JSON.stringify(data))

    return data
}

/**
 * Obtener lista de todas las marcas del sistema
 * 
 * @returns {Array} Array con listado de marcas
 */
async function getMarks(filters = {}){
    // Si esta cacheado se devuelve sin consultar a la API    
    if(sessionStorage.getItem(cacheKeys.marks))
        return JSON.parse(sessionStorage.getItem(cacheKeys.marks))

    // Generar url
    const url = generateUrlFilters(api_base_url + 'marcas.php/get', filters);

    // Hacer consulta a la API
    const data = await fetch(url)
        .then(res => {
            if(!res.ok) throw new Error('Ocurrio un error en el servidor')
            return res.json()
        })
        .catch(error => {
            console.log(error);
            return null
        })
    
    console.log('Marcas cacheadas..')

    // Guardar resultado en cache si no es nulo
    if(data)
        sessionStorage.setItem(cacheKeys.marks, JSON.stringify(data))

    return data
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