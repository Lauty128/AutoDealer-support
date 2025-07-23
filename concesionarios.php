<?php
    include "session/validate.php";
    include "config.php";
    
    $customers = array(1,2,3,4,5,6,7);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'components/head.php'; ?>
    <title>AutoDealer | Concesionarios</title>
</head>

<body>

    <?php include "components/menu.php" ?>    

    <section class="container ad">
        <div class="ad__title">
            <svg width="20px" height="20px" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="#FFF"><path d="M3 10V19C3 20.1046 3.89543 21 5 21H19C20.1046 21 21 20.1046 21 19V10" stroke="#FFF" stroke-width="1.5"></path><path d="M14.8333 21V15C14.8333 13.8954 13.9379 13 12.8333 13H10.8333C9.72874 13 8.83331 13.8954 8.83331 15V21" stroke="#FFF" stroke-width="1.5" stroke-miterlimit="16"></path><path d="M21.8183 9.36418L20.1243 3.43517C20.0507 3.17759 19.8153 3 19.5474 3H15.5L15.9753 8.70377C15.9909 8.89043 16.0923 9.05904 16.2532 9.15495C16.6425 9.38698 17.4052 9.81699 18 10C19.0158 10.3125 20.5008 10.1998 21.3465 10.0958C21.6982 10.0526 21.9157 9.7049 21.8183 9.36418Z" stroke="#FFF" stroke-width="1.5"></path><path d="M14 10C14.5675 9.82538 15.2879 9.42589 15.6909 9.18807C15.8828 9.07486 15.9884 8.86103 15.9699 8.63904L15.5 3H8.5L8.03008 8.63904C8.01158 8.86103 8.11723 9.07486 8.30906 9.18807C8.71207 9.42589 9.4325 9.82538 10 10C11.493 10.4594 12.507 10.4594 14 10Z" stroke="#FFF" stroke-width="1.5"></path><path d="M3.87567 3.43517L2.18166 9.36418C2.08431 9.7049 2.3018 10.0526 2.6535 10.0958C3.49916 10.1998 4.98424 10.3125 6 10C6.59477 9.81699 7.35751 9.38698 7.74678 9.15495C7.90767 9.05904 8.00913 8.89043 8.02469 8.70377L8.5 3H4.45258C4.18469 3 3.94926 3.17759 3.87567 3.43517Z" stroke="#FFF" stroke-width="1.5"></path></svg>
            <div>
                <h2>Concesionarias</h2>
                <p>Lista de los concesionarios habilitados en el sistema</p>
            </div>
        </div>

        <div class="ad__filtersContainer">
            <form action="" id="filtersForm">
                <div class="col">
                    <label for="FilterInput" class="ms-1">Buscador</label>
                    <input type="text" class="form-control" name="search" placeholder="Nombre, provincia..." id="FilterInput">
                </div>
                <div class="col">
                    <label for="filter-client" class="ms-1">Cliente</label>
                    <select name="user" id="filter-client" class="form-select">
                        <option value="0">Todos</option>
                        <!-- Options -->
                    </select>
                </div>
                <button type="submit">
                    <svg width="18px" height="18px" viewBox="0 0 24 24" stroke-width="1.5" fill="none" xmlns="http://www.w3.org/2000/svg" color="#FFFF"><path d="M17 17L21 21" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M3 11C3 15.4183 6.58172 19 11 19C13.213 19 15.2161 18.1015 16.6644 16.6493C18.1077 15.2022 19 13.2053 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                </button>
            </form>
        </div>

        <button class="btn btn-primary mb-4" onClick="openModalCreate()" data-bs-toggle="modal" data-bs-target="#manageModal">
            Nuevo concesionario
        </button>

        <table class="table ad-table">
            <thead>
                <tr>
                    <th class="col-6">Nombre</th>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewModalTitle"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body viewModal-body">
                    <img src="<?= constant('storage_base_url') ?>/not-found.png" onerror="manageErrorImage(event)" style="width: 150px; height: 100px; object-fit:cover">
                    <div class="col mt-3">
                            <span>Nombre</span>
                            <p id="viewModal-name"></p>
                        </div>
                    <div class="row mt-3">
                        <div class="col">
                            <span>Nombre usuario</span>
                            <p id="viewModal-username"></p>
                        </div>
                        <div class="col">
                            <span>Dueño</span>
                            <p id="viewModal-owner"></p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <span>Correo electronico</span>
                            <p id="viewModal-email"></p>
                        </div>
                        <div class="col">
                            <span>Telefono</span>
                            <p id="viewModal-phone"></p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <span>Ubicación</span>
                            <p id="viewModal-location"></p>
                        </div>
                        <div class="col-6">
                            <span>Dirección</span>
                            <p id="viewModal-address"></p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <span>Moneda</span>
                            <p id="viewModal-currency"></p>
                        </div>
                        <div class="col-6">
                            <span>Conversión de dolar</span>
                            <p id="viewModal-dolar"></p>
                        </div>
                    </div>

                    <div class="mt-3">
                        <span>Descripción</span>
                        <p id="viewModal-description" style="font-size: .9em"></p>
                    </div>

                    <div class="mt-3">
                        <span>Mapa</span>
                        <p id="viewModal-map"></p>
                    </div>

                    <hr>

                    <div class="mt-2">
                        <h5 style="font-size: 1em">Operaciones</h5>
                        <div class="d-flex gap-2 mt-2">
                            <button class="btn btn-secondary" style="font-size: .75em; padding: 0">
                                <a href="" id="viewModal-op-view" target="_blank" style="display: block; padding: 5px 14px; color: #fff">
                                    Ver pagina
                                </a>
                            </button>
                            <!-- <button class="btn btn-secondary" style="font-size: .75em">
                                Cambiar contraseña
                            </button> -->
                        </div>
                    </div>

                    <div class="modalLoader" id="viewModalLoader">
                        <p>Cargando...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="manageModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="manageModalTitle"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="manageForm">
                        <input type="hidden" name="id" id="id-input" value="0">
                        <div class="mt-4 mb-5">
                            <input type="file" name="image" accept="image/*">
                        </div>
                        <div class="mt-3">
                            <label class="mb-1" for="name-input">Nombre concesionario</label>
                            <input type="text" name="name" id="name-input" class="form-control">
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label class="mb-1" for="name-input">Usuario</label>
                                <input type="text" name="username" id="username-input" class="form-control">
                            </div>
                            <div class="col">
                                <label class="mb-1" for="client-input" class="ms-1">Cliente</label>
                                <select name="user_id" id="client-input" class="form-select">
                                    <!-- Options -->
                                </select>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="mb-1" for="email-input">Correo electronico</label>
                            <input type="email" name="email" id="email-input" class="form-control">
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <label class="mb-1" for="phone-input">Telefono</label>
                                <input type="text" name="phone" id="phone-input" class="form-control">
                            </div>
                            <div class="col-6">
                                <label class="mb-1" for="location-input">Ubicación</label>
                                <input type="text" name="location_id" id="location-input" class="form-control">
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="mb-1" for="address-input">Dirección</label>
                            <input type="text" name="address" id="address-input" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label class="mb-1" for="map-input">Mapa</label>
                            <input type="text" name="map" id="map-input" class="form-control">
                        </div>
                        <div class="col mt-3">
                            <label class="mb-1" for="location-input">Descripción</label>
                            <textarea name="description" id="description-input" rows="4" class="form-control"></textarea>
                        </div>

                        <div class="row">
                            <div class="col mt-3">
                                <label class="mb-1" for="primary_color-input">Color principal</label>
                                <input type="color" name="primary_color" id="primary_color-input" class="form-control" style="height: 38px; width: 55px">
                            </div>
                            <div class="col mt-3">
                                <label class="mb-1" for="dark_theme-input">Modo oscuro</label>
                                <select name="dark_theme" id="dark_theme-input" class="form-select">
                                    <option value="0">No</option>
                                    <option value="1">Si</option>
                                </select>
                            </div>
                        </div>

                        <br>
                        <hr>

                        <div class="row mt-3">
                            <div class="col-6">
                                <label class="mb-1" for="price_currency-input">Moneda</label>
                                <select name="price_currency" id="price_currency-input" class="form-select">
                                    <option value="ARS">ARS</option>
                                    <option value="USD">USD</option>
                                    <option value="COP">COP</option>
                                    <option value="CLP">CLP</option>
                                    <option value="MXN">MXN</option>
                                    <option value="PEN">PEN</option>
                                    <option value="PYG">PYG</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="mb-1" for="dolar_conversion-input">Conversion a dolar</label>
                                <input type="number" name="dolar_conversion" id="dolar_conversion-input" class="form-control">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-6">
                                <label class="mb-1" for="personal_info-input">Mostrar dueño</label>
                                <select name="personal_info" id="personal_info-input" class="form-select">
                                    <option value="0">No</option>
                                    <option value="1">Si</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="mb-1" for="message_notify-input">Obtener notificaciones</label>
                                <select name="message_notify" id="message_notify-input" class="form-select">
                                    <option value="0">No</option>
                                    <option value="1">Si</option>
                                </select>
                            </div>
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
        const base_url = '<?= constant('base_url') ?>';
        const system_base_url = '<?= constant('system_base_url') ?>';
        const storage_base_url = '<?= constant('storage_base_url') ?>';
    </script>

    <script src="assets/js/index.js"></script>
    <script src="assets/js/concesionarios.js"></script>
</body>
</html>