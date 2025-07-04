<?php
include "../Modules/Contacts/metricasContactos.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM Contact List</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../Assets/CSS/contactos.css">
</head>

<body>
    <div class="container">
        <div class="header-section">
            <br>
            <h2 style="font-weight: 600; margin: 40px 0; font-size: 1.5rem;">Gestión de Contactos</h2>

        </div>
        <div class="metrics-container">
            <div class="metric-card">
                <div class="metric-value"><?php echo $contador; ?></div>
                <div class="metric-label">Contactos totales</div>
            </div>
            <div class="metric-card">
                <div class="metric-value"></div>
                <div class="metric-label"></div>
            </div>
            <div class="metric-card">
                <div class="metric-value"><?php echo $conteoMes; ?></div>
                <div class="metric-label">Nuevos este mes</div>
            </div>
        </div>
        <div class="filter-container mb-3 d-flex flex-wrap justify-content-between align-items-center">
            <a href="../Modules/Contacts/Crear.php" class="btn btn-primary mb-2" id="addRecord"><i class="fas fa-user-plus"></i> Crear Contacto</a>
            <a href="" class="btn btn-danger mb-2" id="printPDF"><i class="fas fa-file-pdf"></i> Imprimir</a>
            <div class="d-flex flex-wrap">
                <input type="date" id="startDate" class="form-control me-2 mb-2" style="width: 160px;" placeholder="Desde">
                <input type="date" id="endDate" class="form-control me-2 mb-2" style="width: 160px;" placeholder="Hasta" disabled>
                <button class="btn btn-success mb-2" id="filterDate"><i class="fas fa-filter"></i> Filtrar</button>
            </div>
        </div>
        <div class="table-responsive">
            <table id="contactosTable" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Número Telefónico</th>
                        <th>WhatsApp</th>
                        <th>Formato</th>
                        <th>Fecha Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Datos dinámicos -->
                </tbody>
            </table>
        </div>
    </div>
    <center>

        <!-- Modal de edición -->
        <div id="editar" class="overlay">
            <div class="popup">
                <h2>Edición de Datos</h2>
                <form id="formData">
                    <input type="hidden" id="contactoId" name="contactoId">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Ingrese su nombre" required>

                    <label for="apellidoPaterno">Apellido Paterno:</label>
                    <input type="text" id="apellidoPaterno" name="apellidoPaterno"
                        placeholder="Ingrese su apellido paterno" required>

                    <label for="apellidoMaterno">Apellido Materno:</label>
                    <input type="text" id="apellidoMaterno" name="apellidoMaterno"
                        placeholder="Ingrese su apellido materno" required>

                    <label for="telefono">Número Telefónico:</label>
                    <input type="text" id="telefono" name="telefono" placeholder="Ingrese su número telefónico"
                        required>

                    <label for="whatsapp">Whatsapp:</label>
                    <select class="form-control" id="whatsapp" name="whatsapp" required>
                        <option value="">Selecciona una opción</option>
                        <option value="Sí">Sí</option>
                        <option value="No">No</option>
                    </select>

                    <label for="formato">Formato:</label>
                    <input type="text" id="formato" name="formato" placeholder="Ingrese el formato" required>

                    <div>
                        <button type="button" class="btn btn-success" onclick="guardarEdicion()">Guardar</button>
                        <button type="button" class="btn btn-secondary" onclick="cancelar()">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </center>

    <!-- Modal de confirmación de eliminación -->
    <div class="modal fade" id="borrar" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este contacto?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Eliminar</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="../Assets/JS/contactos.js"></script>
</body>
</html>