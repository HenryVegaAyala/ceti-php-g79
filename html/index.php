<?php

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

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;

                th, td {
                    padding: 12px;
                    text-align: left;
                    border-bottom: 1px solid #ddd;
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
    </style>
</head>
<body>
<div class="container">
    <h1><?php echo $hello; ?></h1>

    <div class="alert alert-info">
        Esta es una alerta de información.
    </div>

    <div class="card">
        <h2>Nuevo Usuario</h2>
        <form method="POST" action="">
            <input type="hidden" name="action" value="create">
            <input type="hidden" name="id" value="1">

            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required value="">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required value="">
            </div>

            <div class="form-group">
                <label for="phone">Teléfono:</label>
                <input type="tel" id="phone" name="phone" required value="">
            </div>

            <button type="submit" class="btn btn-primary">Enviar</button>

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
                <tr>
                    <td>1</td>
                    <td>Juan Pérez</td>
                    <td>j@yopmail.com</td>
                    <td>955201758</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>