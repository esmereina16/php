<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tabla Bootstrap con datos de BD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    
    <?php
    $host = "localhost";
    $usuario = "root";
    $contrasena = "";
    $base_datos = "escuela";

    $conn = new mysqli($host, $usuario, $contrasena, $base_datos);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    echo "<div class='container mt-4'><div class='alert alert-success'>Conexión exitosa</div>";

    $sql = "SELECT id, nombre , apellido , edad FROM personas";
    $resultado = $conn->query($sql);
    ?>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th scope="col">id</th>
                <th scope="col">nombre</th>
                <th scope="col">apellido</th>
                <th scope="col">edad</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($resultado->num_rows > 0) {
                while($fila = $resultado->fetch_assoc()) {
                    echo "<tr>";
                    echo "<th scope='row'>" . htmlspecialchars($fila["id"]) . "</th>";
                    echo "<td>" . htmlspecialchars($fila["nombre"]) . "</td>";
                    echo "<td>" . htmlspecialchars($fila["apellido"]) . "</td>";
                    echo "<td>" . htmlspecialchars($fila["edad"]) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>0 resultados</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <?php
    echo "</div>";
    $conn->close();
    ?>
</body>
</html>
















PRIMWR CODIGO


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=,initial-scale=1.0">

    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
<?php
$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "escuela";

$conn = new mysqli($host, $usuario, $contrasena, $base_datos);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
echo "Conexión exitosa";



$sql = "SELECT id, nombre, apellido, edad FROM personas";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    while($fila = $resultado->fetch_assoc()) {
        echo "id: " . $fila["id"] . " - Nombre: " . $fila["nombre"] . " - apellido: " . $fila["apellido"] .  " - edad: " . $fila["edad"] . "<br>";
    }
} else {
    echo "0 resultados";
}

$conn->close();
  
<!-- On tables -->
<table class="table-primary">...</table>
<table class="table-secondary">...</table>
<table class="table-success">...</table>
<table class="table-danger">...</table>
<table class="table-warning">...</table>
<table class="table-info">...</table>
<table class="table-light">...</table>
<table class="table-dark">...</table>

<!-- On rows -->
<tr class="table-primary">...</tr>
<tr class="table-secondary">...</tr>
<tr class="table-success">...</tr>
<tr class="table-danger">...</tr>
<tr class="table-warning">...</tr>
<tr class="table-info">...</tr>
<tr class="table-light">...</tr>
<tr class="table-dark">...</tr>

<!-- On cells (`td` or `th`) -->
<tr>
  <td class="table-primary">...</td>
  <td class="table-secondary">...</td>
  <td class="table-success">...</td>
  <td class="table-danger">...</td>
  <td class="table-warning">...</td>
  <td class="table-info">...</td>
  <td class="table-light">...</td>
  <td class="table-dark">...</td>
</tr>
?>
    
</body>
</html>

