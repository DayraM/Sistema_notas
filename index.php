<?php 
include 'conexion.php';

$query = "SELECT a.*, 
          (SELECT AVG(nota) FROM notas WHERE id_alumno = a.id) as promedio 
          FROM alumnos a";
$resultado = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Notas</title>
    <link href="public/vendor/bootstrap-5.0.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="public/vendor/datatables-1.10.25/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="public/vendor/datatables-1.10.25/plugins/buttons-1.7.1/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <link href="public/vendor/bootstrap-icons-1.13.1/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="public/vendor/sweetalert2-11.0.16/css/sweetalert2.min.css">

</head>

<body class="bg-light d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Sistema Académico</a>
        </div>
    </nav>

    <div class="container mb-4"> 
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-dark">Listado de Alumnos</h2>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalRegistro">
                <i class="bi bi-person-plus-fill"></i> Registrar Nuevo Alumno
            </button>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="miTabla" class="table table-hover table-striped table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Nombre Completo</th>
                                <th>Correo / Contacto</th>
                                <th>Nacimiento</th>
                                <th>Promedio</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $resultado->fetch_assoc()): 
                                $prom = ($row['promedio'] !== null) ? round($row['promedio'], 2) : null;
                                $estado = "Sin notas";
                                $clase = "bg-secondary";

                                if ($prom !== null) {
                                    if ($prom >= 9) { $estado = "Sobresaliente"; $clase = "bg-primary"; }
                                    elseif ($prom >= 7) { $estado = "Notable"; $clase = "bg-success"; }
                                    elseif ($prom >= 5) { $estado = "Bien"; $clase = "bg-warning text-dark"; }
                                    else { $estado = "Suspenso"; $clase = "bg-danger"; }
                                }
                            ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['nombre'] . " " . $row['apellido']; ?></td>
                                <td><?php echo $row['correo']; ?><br><small class="text-muted"><?php echo $row['telefono']; ?></small></td>
                                <td><?php echo $row['fecha_nacimiento']; ?></td>
                                <td class="fw-bold"><?php echo ($prom !== null) ? number_format($prom, 2) : "0.00"; ?></td>
                                <td><span class="badge <?php echo $clase; ?>"><?php echo $estado; ?></span></td>
                                <td>
                                    <button class="btn btn-sm btn-info text-white" onclick="prepararNota(<?php echo $row['id']; ?>)" data-bs-toggle="modal" data-bs-target="#modalNota" title="Agregar Nota">
                                        <i class="bi bi-journal-plus"></i>
                                    </button>

                                    <a href="notas.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary" title="Gestionar Notas">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    
                                    <button class="btn btn-sm btn-warning text-white" 
                                            onclick="prepararEdicion('<?php echo $row['id']; ?>', '<?php echo $row['nombre']; ?>', '<?php echo $row['apellido']; ?>', '<?php echo $row['correo']; ?>', '<?php echo $row['telefono']; ?>', '<?php echo $row['fecha_nacimiento']; ?>')" 
                                            data-bs-toggle="modal" data-bs-target="#modalEditar" title="Editar Alumno">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <button type="button"
                                            class="btn btn-sm btn-danger"
                                            onclick="confirmarEliminacionAlumno(<?php echo $row['id']; ?>)"
                                            title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endwhile; ?>                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalRegistro" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog"><div class="modal-content">
            <div class="modal-header bg-primary text-white"><h5 class="modal-title">Nuevo Estudiante</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
            <div class="modal-body">
                <form action="acciones.php" method="POST">
                    <input type="hidden" name="registrar_alumno" value="1">
                    <div class="mb-3"><label>Nombre</label><input type="text" name="nombre" class="form-control" required></div>
                    <div class="mb-3"><label>Apellido</label><input type="text" name="apellido" class="form-control" required></div>
                    <div class="row">
                        <div class="col-6 mb-3"><label>Teléfono</label><input type="text" name="telefono" class="form-control"></div>
                        <div class="col-6 mb-3"><label>Nacimiento</label><input type="date" name="fecha_nacimiento" class="form-control"></div>
                    </div>
                    <div class="mb-3"><label>Correo</label><input type="email" name="correo" class="form-control" required></div>
                    <div class="d-grid"><button type="submit" class="btn btn-primary">Guardar</button></div>
                </form>
            </div>
        </div></div>
    </div>

    <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog"><div class="modal-content">
            <div class="modal-header bg-warning text-dark"><h5 class="modal-title">Editar Estudiante</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <form action="acciones.php" method="POST">
                    <input type="hidden" name="actualizar_alumno" value="1">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="mb-3"><label>Nombre</label><input type="text" name="nombre" id="edit_nombre" class="form-control" required></div>
                    <div class="mb-3"><label>Apellido</label><input type="text" name="apellido" id="edit_apellido" class="form-control" required></div>
                    <div class="row">
                        <div class="col-6 mb-3"><label>Teléfono</label><input type="text" name="telefono" id="edit_telefono" class="form-control"></div>
                        <div class="col-6 mb-3"><label>Nacimiento</label><input type="date" name="fecha_nacimiento" id="edit_fecha" class="form-control"></div>
                    </div>
                    <div class="mb-3"><label>Correo</label><input type="email" name="correo" id="edit_correo" class="form-control" required></div>
                    <div class="d-grid"><button type="submit" class="btn btn-warning">Actualizar Datos</button></div>
                </form>
            </div>
        </div></div>
    </div>

    <div class="modal fade" id="modalNota" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog"><div class="modal-content">
            <div class="modal-header bg-info text-white"><h5 class="modal-title">Asignar Nota</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
            <div class="modal-body">
                <form action="acciones.php" method="POST">
                    <input type="hidden" name="registrar_nota" value="1">
                    <input type="hidden" name="id_alumno" id="id_alumno_nota">
                    <div class="mb-3"><label>Materia</label>
                        <select name="materia" class="form-select">
                            <option value="Matemáticas">Matemáticas</option>
                            <option value="Programación">Programación</option>
                            <option value="Base de Datos">Base de Datos</option>
                        </select>
                    </div>
                    <div class="mb-3"><label>Nota (0-10)</label>
                        <input type="number" name="nota" step="0.01" min="0" max="10" class="form-control" required>
                    </div>
                    <div class="d-grid"><button type="submit" class="btn btn-info text-white">Guardar Nota</button></div>
                </form>
            </div>
        </div></div>
    </div>

    <footer class="bg-primary text-white text-center py-3 mt-auto shadow-lg">
        <div class="container">
            <p class="mb-1 fw-bold">Universidad de las Fuerzas Armadas ESPE</p>
            <p class="mb-0 small">Aplicación de Tecnologías Web</p>
            <small class="text-white-50">&copy; Grupo 3 - 2026 </small>
        </div>
    </footer>

    <script src="public/vendor/jquery-3.5.1.js"></script>
    <script src="public/vendor/datatables-1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="public/vendor/bootstrap-5.0.2/js/bootstrap.bundle.min.js"></script>
    <script src="public/vendor/datatables-1.10.25/js/dataTables.bootstrap5.min.js"></script>
    <script src="public/vendor/datatables-1.10.25/plugins/buttons-1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="public/vendor/datatables-1.10.25/plugins/jszip-2.5.0/jszip.min.js"></script>
    <script src="public/vendor/datatables-1.10.25/plugins/pdfmake-0.1.36/pdfmake.min.js"></script>
    <script src="public/vendor/datatables-1.10.25/plugins/pdfmake-0.1.36/vfs_fonts.js"></script>
    <script src="public/vendor/datatables-1.10.25/plugins/buttons-1.7.1/js/buttons.html5.min.js"></script>
    <script src="public/vendor/sweetalert2-11.0.16/js/sweetalert2.min.js"></script>
    <script src="public/js/controles.js"></script>
    

</body>
</html>