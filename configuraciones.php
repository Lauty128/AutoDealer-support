<?php
    include "config.php";
    include "session/validate.php";
    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'components/head.php'; ?>
    <title>AutoDealer | Configuraciones</title>
</head>

<body>

    <?php include "components/menu.php" ?>    

    <section class="container ad">
        <div class="ad__title">
            <svg width="22px" height="22px" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="#FFFF"><path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="#FFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M19.6224 10.3954L18.5247 7.7448L20 6L18 4L16.2647 5.48295L13.5578 4.36974L12.9353 2H10.981L10.3491 4.40113L7.70441 5.51596L6 4L4 6L5.45337 7.78885L4.3725 10.4463L2 11V13L4.40111 13.6555L5.51575 16.2997L4 18L6 20L7.79116 18.5403L10.397 19.6123L11 22H13L13.6045 19.6132L16.2551 18.5155C16.6969 18.8313 18 20 18 20L20 18L18.5159 16.2494L19.6139 13.598L21.9999 12.9772L22 11L19.6224 10.3954Z" stroke="#FFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
            <div>
                <h2>Configuraciones</h2>
                <p>Configuraciones del sistema</p>
            </div>
        </div>


        <div>
            <h4>Limpiar cache</h4>
            <p class="text-secondary">En caso de experimentar problemas con los datos es recomendable limpiar la cache del sistema para consultar los datos nuevamente</p>
            <button class="btn btn-primary" onclick="clearTotalCache()">
                Limpiar
            </button>
        </div>
        <hr>

        
    </section>
    

    <?php include 'components/footer.php' ?> 
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