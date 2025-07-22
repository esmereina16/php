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
    $base_datos = "escuelaa";

    $conn = new mysqli($host, $usuario, $contrasena, $base_datos);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    echo "<div class='container mt-4'><div class='alert alert-success'>Conexión exitosa</div>";

    // Insertar nuevo registro si se ha enviado el formulario
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $edad = $_POST["edad"];

        if (!empty($nombre) && !empty($apellido) && is_numeric($edad)) {
            $stmt = $conn->prepare("INSERT INTO personas (nombre, apellido, edad) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $nombre, $apellido, $edad);
            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>Nuevo registro agregado exitosamente</div>";
            } else {
                echo "<div class='alert alert-danger'>Error al agregar registro: " . $stmt->error . "</div>";
            }
            $stmt->close();
        } else {
            echo "<div class='alert alert-warning'>Por favor, complete todos los campos correctamente.</div>";
        }
    }
    ?>

    <!-- Formulario para agregar nuevo registro -->
    <div class="container mb-4">
        <h2>Agregar nueva persona</h2>
        <form method="POST" action="">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre" required />
                </div>
                <div class="col-md-4">
                    <input type="text" name="apellido" class="form-control" placeholder="Apellido" required />
                </div>
                <div class="col-md-2">
                    <input type="number" name="edad" class="form-control" placeholder="Edad" required min="0" />
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Agregar</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Formulario para ingresar datos -->
    <div class="container mb-4">
        <h2>Ingresar datos</h2>
        <form method="POST" action="">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre" required />
                </div>
                <div class="col-md-4">
                    <input type="text" name="apellido" class="form-control" placeholder="Apellido" required />
                </div>
                <div class="col-md-2">
                    <input type="number" name="edad" class="form-control" placeholder="Edad" required min="0" />
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100">Ingresar</button>
                </div>
            </div>
        </form>
    </div>

    <?php
    $sql = "SELECT id, nombre, apellido, edad FROM personas";
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
CODIGO CON BOTON DE ELIMINAR Y MODIFICAR
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
    $base_datos = "escuelaa";

    $conn = new mysqli($host, $usuario, $contrasena, $base_datos);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    echo "<div class='container mt-4'><div class='alert alert-success'>Conexión exitosa</div>";

    // Insertar nuevo registro si se ha enviado el formulario
    if ($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_POST['delete_id']) && !isset($_POST['update_id'])) {
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $edad = $_POST["edad"];

        if (!empty($nombre) && !empty($apellido) && is_numeric($edad)) {
            $stmt = $conn->prepare("INSERT INTO personas (nombre, apellido, edad) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $nombre, $apellido, $edad);
            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>Nuevo registro agregado exitosamente</div>";
            } else {
                echo "<div class='alert alert-danger'>Error al agregar registro: " . $stmt->error . "</div>";
            }
            $stmt->close();
        } else {
            echo "<div class='alert alert-warning'>Por favor, complete todos los campos correctamente.</div>";
        }
    }

    // Eliminar registro si se ha enviado el formulario de eliminación
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_id'])) {
        $delete_id = $_POST['delete_id'];
        $stmt = $conn->prepare("DELETE FROM personas WHERE id = ?");
        $stmt->bind_param("i", $delete_id);
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Registro eliminado exitosamente</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al eliminar registro: " . $stmt->error . "</div>";
        }
        $stmt->close();
    }

    // Actualizar registro si se ha enviado el formulario de modificación
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_id'])) {
        $update_id = $_POST['update_id'];
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $edad = $_POST["edad"];

        if (!empty($nombre) && !empty($apellido) && is_numeric($edad)) {
            $stmt = $conn->prepare("UPDATE personas SET nombre = ?, apellido = ?, edad = ? WHERE id = ?");
            $stmt->bind_param("ssii", $nombre, $apellido, $edad, $update_id);
            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>Registro actualizado exitosamente</div>";
            } else {
                echo "<div class='alert alert-danger'>Error al actualizar registro: " . $stmt->error . "</div>";
            }
            $stmt->close();
        } else {
            echo "<div class='alert alert-warning'>Por favor, complete todos los campos correctamente.</div>";
        }
    }
    ?>

    <!-- Formulario para agregar nuevo registro -->
    <div class="container mb-4">
        <h2>Agregar nueva persona</h2>
        <form method="POST" action="">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre" required />
                </div>
                <div class="col-md-4">
                    <input type="text" name="apellido" class="form-control" placeholder="Apellido" required />
                </div>
                <div class="col-md-2">
                    <input type="number" name="edad" class="form-control" placeholder="Edad" required min="0" />
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Agregar</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Formulario para ingresar datos -->
    <div class="container mb-4">
        <h2>Ingresar datos</h2>
        <form method="POST" action="">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre" required />
                </div>
                <div class="col-md-4">
                    <input type="text" name="apellido" class="form-control" placeholder="Apellido" required />
                </div>
                <div class="col-md-2">
                    <input type="number" name="edad" class="form-control" placeholder="Edad" required min="0" />
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100">Ingresar</button>
                </div>
            </div>
        </form>
    </div>

    <?php
    $sql = "SELECT id, nombre, apellido, edad FROM personas";
    $resultado = $conn->query($sql);
    ?>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th scope="col">id</th>
                <th scope="col">nombre</th>
                <th scope="col">apellido</th>
                <th scope="col">edad</th>
                <th scope="col">acción</th>
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
                    echo "<td>";
                    // Botón Eliminar
                    echo "<form method='POST' action='' style='display:inline;'>";
                    echo "<input type='hidden' name='delete_id' value='" . htmlspecialchars($fila["id"]) . "'>";
                    echo "<button type='submit' class='btn btn-danger btn-sm'>Eliminar</button>";
                    echo "</form>";
                    // Botón Modificar
                    echo "<form method='POST' action='' style='display:inline; margin-left: 5px;'>";
                    echo "<input type='hidden' name='update_id' value='" . htmlspecialchars($fila["id"]) . "'>";
                    echo "<input type='text' name='nombre' value='" . htmlspecialchars($fila["nombre"]) . "' class='form-control d-inline-block w-auto' style='width: 100px;' required>";
                    echo "<input type='text' name='apellido' value='" . htmlspecialchars($fila["apellido"]) . "' class='form-control d-inline-block w-auto' style='width: 100px;' required>";
                    echo "<input type='number' name='edad' value='" . htmlspecialchars($fila["edad"]) . "' class='form-control d-inline-block w-auto' style='width: 60px;' required min='0'>";
                    echo "<button type='submit' class='btn btn-warning btn-sm'>Modificar</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>0 resultados</td></tr>";
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
