<?php
require_once 'config/Database.php';
require_once 'models/Usuario.php';

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuario($db);

// Crear la tabla si no existe
$usuario->createTable();

$messages = [
        'created' => 'Usuario creado exitosamente.',
        'updated' => 'Usuario actualizado exitosamente.',
        'deleted' => 'Usuario eliminado exitosamente.'
];

$mensaje = null;

$usuario_editar = null;
if (isset($_GET['edit'])) {
    $usuario->id = (int)($_GET['edit']);
    $resultado = $usuario->readOne();

    $usuario_editar = [
            'id' => $resultado['id'],
            'nombre' => $resultado['nombre'],
            'email' => $resultado['email'],
            'telefono' => $resultado['telefono']
    ];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"] ?? null;

    $usuario->nombre = $_POST["nombre"] ?? null;
    $usuario->email = $_POST["email"] ?? null;
    $usuario->telefono = $_POST["telefono"] ?? null;

    if (isset($_POST["id"]) && !empty($_POST["id"])) {
        $usuario->id = (int)$_POST["id"];
    }

    $acciones = [
            'create' => ['method' => 'create', 'message' => 'created', 'error' => 'Error al crear el usuario'],
            'update' => ['method' => 'update', 'message' => 'updated', 'error' => 'Error al actualizar el usuario'],
            'delete' => ['method' => 'delete', 'message' => 'deleted', 'error' => 'Error al eliminar el usuario'],
    ];


    if (isset($acciones[$action])) {
        $config = $acciones[$action];

        //  crear usuario
        if ($config['method'] == 'create') {
            $respuesta = $usuario->create();

            if ($respuesta) {
                header("Location: index.php?message={$config['message']}");
                exit();
            } else {
                $mensaje = $config['error'];
            }
        }

        // actualizar usuario
        if ($config['method'] == 'update') {
            $respuesta = $usuario->update();
            if ($respuesta) {
                header("Location: index.php?message={$config['message']}");
                exit();
            } else {
                $mensaje = $config['error'];
            }
        }


        // eliminar usuario
        if ($config['method'] == 'delete') {
            $resultado = $usuario->delete();

            if ($resultado) {
                header("Location: index.php?message={$config['message']}");
                exit();
            } else {
                $mensaje = $config['error'];
            }
        }
    }

}

$usuarios = $usuario->readAll();

$hello = "Crud Usuarios - PostgresSQL 16";

?>

<!Doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Crud de usuarios - PostgresSQl</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            color: white;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 1px 10px 30px rgba(0, 0, 0, 0.2);

            h2 {
                color: #333;
                margin-bottom: 20px;
                border-bottom: 2px solid #667eea;
                padding-bottom: 10px;
            }

            .form {
                margin-bottom: 20px;
            }

            .form-group {
                margin-bottom: 15px;

                label {
                    display: block;
                    margin-bottom: 5px;
                    color: #555;
                    font-weight: 500;
                }

                input {
                    width: 100%;
                    padding: 12px;
                    border: 2px solid #ddd;
                    border-radius: 5px;
                    font-size: 14px;
                    transition: border-color 0.3s;

                    &:focus {
                        border-color: #667eea;
                        outline: none;
                    }
                }
            }

            .btn {
                padding: 12px 25px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 14px;
                font-weight: 500;
                transition: transform 0.2s, box-shadow 0.3s;
                text-decoration: none;
                display: inline-block;

                &:hover {
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                }
            }

            .btn-primary {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
            }

            .btn-secondary {
                background: #6c757d;
                color: white;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;

                th, td {
                    padding: 12px;
                    text-align: left;
                    border-bottom: 1px solid #ddd;

                    .actions {
                        display: flex;
                        gap: 5px;
                    }
                }

                th {
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    color: white;
                }

                tr {
                    &:hover {
                        background-color: #f5f5f5;
                    }
                }
            }
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;

            &.alert-success {
                background-color: #d4edda;
                color: #155724;
                border: 1px solid #c3e6cb;
            }

            &.alert-error {
                background-color: #f8d7da;
                color: #721c24;
                border: 1px solid #f5c6cb;
            }
        }
    </style>

</head>
<body>
<div class="container">
    <h1><?php echo $hello; ?></h1>

    <?php if (isset($_REQUEST['message']) && !empty($_REQUEST['message'])): ?>
        <div class="alert alert-success">
            <?php echo $messages[$_REQUEST['message']]; ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <h2>Nuevo Usuario</h2>
        <form method="POST" action="" class="form">
            <input type="hidden" name="action" value="<?php echo isset($usuario_editar['id']) ? 'update' : 'create' ?>">
            <input type="hidden" name="id" value="<?php echo $usuario_editar['id'] ?? null ?>">

            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required
                       value="<?php echo $usuario_editar['nombre'] ?? '' ?>">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required
                       value="<?php echo $usuario_editar['email'] ?? '' ?>">
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="tel" id="telefono" name="telefono" required
                       value="<?php echo $usuario_editar['telefono'] ?? '' ?>">
            </div>

            <button type="submit" class="btn btn-primary">Enviar</button>

            <button class="btn btn-secondary">Cancelar</button>

        </form>

        <div class="card">
            <h2>Lista de usuarios</h2>

            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($usuarios as $usuario) : ?>
                    <tr>
                        <td><?php echo $usuario['id'] ?></td>
                        <td><?php echo $usuario['nombre'] ?></td>
                        <td><?php echo $usuario['email'] ?></td>
                        <td><?php echo $usuario['telefono'] ?></td>
                        <td>
                            <div class="actions">
                                <div>
                                    <a href="?edit=<?php echo $usuario['id'] ?>">Editar</a>
                                </div>
                                <div>
                                    <form method="post" action="">
                                        <input type="hidden" name="id" value="<?php echo $usuario['id'] ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <button type="submit" class="">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>