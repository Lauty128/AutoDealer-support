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
                <input type="text" class="form-control">
                <button class="btn btn-primary">
                    <svg width="18px" height="18px" viewBox="0 0 24 24" stroke-width="1.5" fill="none" xmlns="http://www.w3.org/2000/svg" color="#FFFF"><path d="M17 17L21 21" stroke="#FFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M3 11C3 15.4183 6.58172 19 11 19C13.213 19 15.2161 18.1015 16.6644 16.6493C18.1077 15.2022 19 13.2053 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11Z" stroke="#FFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                </button>
            </div>
        </div>
        
    </section>
    

    <script>
        const api_base_url = '<?= constant('api_base_url') ?>';
        const storage_base_url = '<?= constant('storage_base_url') ?>';
    </script>

    <script src="assets/js/index.js"></script>
    <script>
        function clearTotalCache(){
            const keys = Object.keys(cacheKeys)

            keys.forEach(key => {
                sessionStorage.removeItem(cacheKeys[key]);
            });

            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Cache eliminada",
                showConfirmButton: false,
                timer: 1200
            });
        }
    </script>
</body>
</html>