<?php 
    $customers = array(1,2,3,4,5,6,7);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'components/head.php'; ?>
    <title>AutoDealer | Inicio</title>
</head>

<body>

    <section class="menu">
        <p class="text-center mt-3">
            <img src="assets/images/logo-h.png" width="200">
        </p>

        <div class="menu__links">

        </div>
    </section>

    <section class="container ad">
        <div class="ad__title">
            <svg width="24px" height="24px" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="#FFFF"><path d="M1 20V19C1 15.134 4.13401 12 8 12V12C11.866 12 15 15.134 15 19V20" stroke="#FFFF" stroke-width="1.5" stroke-linecap="round"></path><path d="M13 14V14C13 11.2386 15.2386 9 18 9V9C20.7614 9 23 11.2386 23 14V14.5" stroke="#FFFF" stroke-width="1.5" stroke-linecap="round"></path><path d="M8 12C10.2091 12 12 10.2091 12 8C12 5.79086 10.2091 4 8 4C5.79086 4 4 5.79086 4 8C4 10.2091 5.79086 12 8 12Z" stroke="#FFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M18 9C19.6569 9 21 7.65685 21 6C21 4.34315 19.6569 3 18 3C16.3431 3 15 4.34315 15 6C15 7.65685 16.3431 9 18 9Z" stroke="#FFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
            <div>
                <h2>Clientes</h2>
                <p>Lista de los clientes habilitados en el sistema</p>
            </div>
        </div>

        <div>
            
        </div>

        <table class="table ad-table">
            <thead>
                <tr>
                    <th class="col-1">#</th>
                    <th class="col-5">Nombre</th>
                    <th class="col-4">Provincia</th>
                    <th class="col-2 text-center">Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $cliente) { ?>
                    <tr>
                        <td class="col-1"><?= $cliente ?></td>
                        <td class="col-4">Lautaro Silverii</td>
                        <td class="col-4">Buenos Aires</td>
                        <td class="col-3 text-center">
                            <button class="btn btn-secondary">⨀</button>
                            <button class="btn btn-danger">⨂</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </section>
    
</body>
</html>