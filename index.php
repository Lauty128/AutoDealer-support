<?php
    include "config.php";
    
    $customers = array(1,2,3,4,5,6,7);
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
            <svg width="24px" height="24px" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="#FFFF"><path d="M1 20V19C1 15.134 4.13401 12 8 12V12C11.866 12 15 15.134 15 19V20" stroke="#FFFF" stroke-width="1.5" stroke-linecap="round"></path><path d="M13 14V14C13 11.2386 15.2386 9 18 9V9C20.7614 9 23 11.2386 23 14V14.5" stroke="#FFFF" stroke-width="1.5" stroke-linecap="round"></path><path d="M8 12C10.2091 12 12 10.2091 12 8C12 5.79086 10.2091 4 8 4C5.79086 4 4 5.79086 4 8C4 10.2091 5.79086 12 8 12Z" stroke="#FFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M18 9C19.6569 9 21 7.65685 21 6C21 4.34315 19.6569 3 18 3C16.3431 3 15 4.34315 15 6C15 7.65685 16.3431 9 18 9Z" stroke="#FFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
            <div>
                <h2>Clientes</h2>
                <p>Lista de los clientes habilitados en el sistema</p>
            </div>
        </div>

        <div class="ad__filtersContainer">
            <form action="">
                <input type="text" class="form-control" name="search" placeholder="Nombre, apellido, dni..." id="FilterInput">
                <button type="submit">
                    <svg width="18px" height="18px" viewBox="0 0 24 24" stroke-width="1.5" fill="none" xmlns="http://www.w3.org/2000/svg" color="#FFFF"><path d="M17 17L21 21" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M3 11C3 15.4183 6.58172 19 11 19C13.213 19 15.2161 18.1015 16.6644 16.6493C18.1077 15.2022 19 13.2053 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                </button>
            </form>
        </div>

        <button class="btn btn-primary mb-4" onClick="openModalCreate()" data-bs-toggle="modal" data-bs-target="#manageModal">
            Nuevo cliente
        </button>

        <table class="table ad-table">
            <thead>
                <tr>
                    <th class="col-1">#</th>
                    <th class="col-5">Nombre</th>
                    <th class="col-4">Provincia</th>
                    <th class="col-2 text-center">Opciones</th>
                </tr>
            </thead>
            <tbody id="List">
                <!-- Cargado desde Javascript -->
            </tbody>
        </table>
        <div id="preloadMessage">
            <p class="mt-4 text-center">Cargando...</p>
        </div>
        
    </section>
    
    <!-- Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewModalTitle"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body viewModal-body">
                    <img src="<?= constant('storage_base_url') ?>/not-found.png" onerror="manageErrorImage(event)" style="width: 100px; height: 100px; object-fit:cover">
                    <div class="mt-3">
                        <span>Nombre</span>
                        <p id="viewModal-name"></p>
                    </div>
                    <div class="mt-3">
                        <span>Correo electronico</span>
                        <p id="viewModal-email"></p>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <span>Telefono</span>
                            <p id="viewModal-phone"></p>
                        </div>
                        <div class="col-6">
                            <span>Ubicación</span>
                            <p id="viewModal-location"></p>
                        </div>
                    </div>

                    <div class="mt-2">
                        <h5 style="font-size: 1em">Operaciones</h5>
                        <div class="d-flex gap-2 mt-2">
                            <button class="btn btn-secondary" style="font-size: .75em">
                                Ver concesionarios
                            </button>
                            <button class="btn btn-secondary" style="font-size: .75em">
                                Cambiar contraseña
                            </button>
                        </div>
                    </div>

                    <div class="modalLoader" id="viewModalLoader">
                        <p>Cargando...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="manageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="manageModalTitle"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="manageForm">
                        <div class="row mt-3">
                            <div class="col-6">
                                <label for="name-input">Nombre</label>
                                <input type="text" name="name" id="name-input" class="form-control">
                            </div>
                            <div class="col-6">
                                <label for="subname-input">Apellido</label>
                                <input type="text" name="subname" id="subname-input" class="form-control">
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="email-input">Correo electronico</label>
                            <input type="email" name="email" id="email-input" class="form-control">
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <label for="phone-input">Telefono</label>
                                <input type="text" name="phone" id="phone-input" class="form-control">
                            </div>
                            <div class="col-6">
                                <label for="location-input">Ubicación</label>
                                <input type="text" name="location" id="location-input" class="form-control">
                            </div>
                            <input type="hidden" name="client" id="client-input" value="0">
                        </div>
                        <div class="mt-3" id="manageModal-password">
                            <label for="password-input">Contraseña</label>
                            <input type="password" name="password" id="password-input" class="form-control">
                        </div>

                        <div class="row mt-4 gap-2 justify-content-end me-1">
                            <button class="btn btn-secondary" style="width: fit-content;" id="manageModal_close" data-bs-dismiss="modal" aria-label="Close">
                                Cancelar
                            </button>
                            <button class="btn btn-primary" style="width: fit-content;" type="submit">
                                Guardar
                            </button>
                        </div>
                    </form>

                    <div class="modalLoader" id="manageModalLoader">
                        <p>Cargando...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const api_base_url = '<?= constant('api_base_url') ?>';
        const storage_base_url = '<?= constant('storage_base_url') ?>';
    </script>

    <script src="assets/js/index.js"></script>
    <script src="assets/js/clients.js"></script>
</body>
</html>