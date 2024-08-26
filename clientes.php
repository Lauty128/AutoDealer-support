<?php 
    # ------------ Importar variables
    require_once 'api/config/app.php';
    require_once 'api/config/database.php';
    
    use DB\Database;
    $database = new Database();
    $bd = $database->connect();

    $sql = "SELECT u.id, u.name, u.subname, l.province
            FROM users u
                INNER JOIN locations l ON u.location_id = l.id";

    # Prepare the query
    $query = $bd->prepare($sql);
    $query->execute();

    # Get array with the received data
    $customers = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="assets/css/index.css">
    <title>Document</title>
</head>
<body>
    
    <h1>Clientes</h1>

    <table class="table table-striped ad-table">
        <thead>
            <tr>
                <th class="col-2">#</th>
                <th class="col-6">Nombre</th>
                <th class="col-4">Provincia</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customers as $cliente) { ?>
                <tr>
                    <td class="col-2"><?= $cliente['id'] ?></td>
                    <td class="col-6"><?= $cliente['name'] . ' ' . $cliente['subname'] ?></td>
                    <td class="col-4"><?= $cliente['province'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</body>
</html>