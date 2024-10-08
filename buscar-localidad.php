<?php
    include "config.php";
    include "session/validate.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'components/head.php'; ?>
    <title>AutoDealer | Clientes</title>
</head>

<body>

    <?php include "components/menu.php" ?>    

    <section class="container ad">
        <div class="ad__title">
            <svg width="20px" height="20px" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="#FFF"><path d="M20 10C20 14.4183 12 22 12 22C12 22 4 14.4183 4 10C4 5.58172 7.58172 2 12 2C16.4183 2 20 5.58172 20 10Z" stroke="#FFF" stroke-width="1.5"></path><path d="M12 11C12.5523 11 13 10.5523 13 10C13 9.44772 12.5523 9 12 9C11.4477 9 11 9.44772 11 10C11 10.5523 11.4477 11 12 11Z" fill="#FFF" stroke="#FFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
            <div>
                <h2>Buscar localidad</h2>
                <p>Encuentra el codigo de la localidad de interes</p>
            </div>
        </div>

        <br>
        <br>

        <div style="max-width: 800px; margin: auto">
            <h4>Encuentra la localidad de interes</h4>
            <p class="text-secondary">Para buscar una localidad solo debes escribir su nombre en el buscador y seleccionar la indicada</p>

            <div class="d-flex gap-2">
                <div class="form-floating" style="width: 100%">
                    <svg width="24px" height="24px" id="removeLocationButton" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="#616161"><path d="M9.17218 14.8284L12.0006 12M14.829 9.17157L12.0006 12M12.0006 12L9.17218 9.17157M12.0006 12L14.829 14.8284" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    <input type="text" class="form-control" id="locationInput" placeholder="" autocomplete="off"> 
                    <label for="locationInput">Ubicacion</label>
                </div>
                <button class="btn btn-primary" id="searchButton">
                    <svg width="18px" height="18px" viewBox="0 0 24 24" stroke-width="1.5" fill="none" xmlns="http://www.w3.org/2000/svg" color="#FFFF"><path d="M17 17L21 21" stroke="#FFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M3 11C3 15.4183 6.58172 19 11 19C13.213 19 15.2161 18.1015 16.6644 16.6493C18.1077 15.2022 19 13.2053 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11Z" stroke="#FFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                </button>
            </div>

            <table class="mt-4">
                <thead>
                    <tr>
                        <th>Ciudad</th>
                        <th>Departamento</th>
                        <th>Provincia</th>
                        <th>Codigo</th>
                    </tr>
                </thead>
                <tbody id="List">
                    
                </tbody>
            </table>
        </div>
        
    </section>
    

    <style>
        #removeLocationButton{
            position: absolute;
            top: 16px;
            right: 10px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* Esto evita que las columnas se expandan */
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
            white-space: nowrap; /* Evita que el texto se divida en varias líneas */
            overflow: hidden; /* Oculta el contenido desbordado */
            text-overflow: ellipsis; /* Añade "..." cuando el texto es demasiado largo */
        }

        th {
            background-color: #f2f2f2;
        }

        td {
            word-wrap: break-word; /* Permite que el texto largo se divida si es necesario */
            max-width: 250px; /* Limita el ancho máximo de las celdas */
        }
    </style>

    <script>
        const CityInput = document.getElementById("locationInput");
        const URL_BASE_GEOREF = 'https://apis.datos.gob.ar/georef/api/';
        const removeLocationButton = document.getElementById("removeLocationButton")
        const searchButton = document.getElementById('searchButton');
        const cityCode = document.getElementById('cityCode');


        searchButton.addEventListener('click', () => {
            const value = CityInput.value

            if(value.length >= 4){   
                console.log('Buscando...')
                searchButton.innerHTML = '...'
                fetch(URL_BASE_GEOREF + "localidades-censales?max=6&campos=provincia.nombre,departamento.nombre&nombre=" + value)
                    .then(result => result.json())
                    .then((result) => {
                        if(result.localidades_censales.length > 0){
                            displayResults(result.localidades_censales);
                        }else{
                            obtenerAsentamientos(value);
                        }
                    })
                    .catch((err) => console.log(err));

            }else{
                const resultList = document.getElementById('resultList');
            }
        })

        removeLocationButton.addEventListener('click', ()=>{
            removeLocationButton.style.display = 'none'
            CityInput.value = '';
        })

        function displayResults(locations) {
            const resultList = document.getElementById('List');
            resultList.innerHTML = '';

            if(locations.length == 0){
                const listItem = document.createElement('p');
                listItem.textContent = `Ningun resultado encontrado`;
                listItem.style.padding = '10px';

                resultList.appendChild(listItem);
                return
            }

            locations.forEach(location => {
                const html = `<tr>
                        <td>${location.nombre}</td>
                        <td>${location.departamento.nombre}</td>
                        <td>${location.provincia.nombre}</td>
                        <td>${location.id}</td>
                    </tr>`

                resultList.innerHTML += html;
            });

            searchButton.innerHTML = `<svg width="18px" height="18px" viewBox="0 0 24 24" stroke-width="1.5" fill="none" xmlns="http://www.w3.org/2000/svg" color="#FFFF"><path d="M17 17L21 21" stroke="#FFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M3 11C3 15.4183 6.58172 19 11 19C13.213 19 15.2161 18.1015 16.6644 16.6493C18.1077 15.2022 19 13.2053 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11Z" stroke="#FFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>`
        }

        function obtenerAsentamientos(value){
            fetch(URL_BASE_GEOREF + "asentamientos?max=6&campos=provincia.nombre,departamento.nombre&nombre=" + value)
                .then(result => result.json())
                .then((result) => {
                    displayResults(result.asentamientos);
                })
                .catch((err) => console.log(err));
        }
        
        function loadingUl(){
            const resultList = document.getElementById('resultList');
            resultList.innerHTML = '';
            resultList.style.display = 'block';

            const listItem = document.createElement('li');
            listItem.style.padding = '10px';
            listItem.style.cursor = 'pointer';
            listItem.textContent = 'Cargando...'

            resultList.appendChild(listItem)
        }
    </script>
</body>
</html>