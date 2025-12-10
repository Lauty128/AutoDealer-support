//-----> Constantes globales
const listComponent = document.getElementById('List');
const preLoader = document.getElementById('preloadMessage');

const cacheKeys = {
    clients: 'autodealer.admin.clients',
    stores: 'autodealer.admin.stores',
    marks: 'autodealer.admin.marks',
    billings: 'autodealer.admin.billings'
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

/**
 * Abrir una operacion en una ventana emergente y refrescar la pagina cuando la ventana emergente se cierra
 * 
 * @param {string} url 
 * @param {mixed} mId 
 * @param {string} operacion 
 */
function abrirOperacion(url, mId = 0, operacion = 'operacion') {
  // Abrir ventana de operacion con un ancho de 800px 
  const ventana = window.open(url + '?mid=' + mId, operacion, "scrollbars=no,status=no,menubar=no,location=no")
  ventana.resizeTo(800, window.outerHeight);

  // Generar temporizador que verifique cada 1 segundo si la ventana se cerror
  const intervalId = setInterval(function() {
    // Verificamos si la ventana se cerró
    if (ventana.closed) {
        // Recargar pagina
        window.location.reload()
        // Detiene el temporizador
        clearInterval(intervalId); 
    }
  }, 1000);
}

/**
 * Abrir una operacion en una ventana emergente y obtener una respuesta a traves de un callback al cerrarla (sin refrescar la pagina)
 * 
 * @param {string} url 
 * @param {mixed} mId 
 * @param {string} operacion 
*/
function abrirOperacionConDevolucion(url, callback, mId = 0, operacion = 'operacion') {
  // Abrir ventana de operacion con un ancho de 800px 
  const ventana = window.open(url + '?mid=' + mId, operacion, "scrollbars=no,status=no,menubar=no,location=no")
  ventana.resizeTo(800, window.outerHeight);

  // Escuchar mensaje del hijo
  window.addEventListener("message", (event) => {
      if (event.data && event.data.response) {
        // Si hay una respuesta la enviamos por el callback
        callback(event.data.response)
      }
  });
}