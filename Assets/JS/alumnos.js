$(document).ready(function () {
    const startDateInput = $('#startDate');
    const endDateInput = $('#endDate');

    endDateInput.prop('disabled', true);

    startDateInput.on('change', function () {
        const startDate = startDateInput.val();
        if (startDate) {
            endDateInput.prop('disabled', false);
            endDateInput.attr('min', startDate);
        } else {
            endDateInput.prop('disabled', true);
        }
    });

    endDateInput.on('change', function () {
        const startDate = startDateInput.val();
        const endDate = endDateInput.val();

        if (startDate && new Date(endDate) < new Date(startDate)) {
            alert("La fecha final no puede ser antes de la fecha inicial.");
            endDateInput.val('');
        }
    });

    $.getJSON('../Modules/Alumnos/get_filters.php', function (data) {
        data.periodos.forEach(periodo => {
            $('#periodoFilter').append(`<option value="${periodo.id_periodo}">${periodo.fecha}</option>`);
        });
        data.grupos.forEach(grupo => {
            $('#grupoFilter').append(`<option value="${grupo.id_grupo}">Grupo ${grupo.id_grupo}</option>`);
        });
        data.grados.forEach(grado => {
            $('#gradoFilter').append(`<option value="${grado.id_grado}">${grado.descripcion}</option>`);
        });
    });

    const table = $('#alumnostable').DataTable({
        ajax: {
            url: '../Modules/Alumnos/fetch_alumnos.php',
            dataSrc: '',
            data: function (d) {
                d.periodo = $('#periodoFilter').val();
                d.grupo = $('#grupoFilter').val();
                d.grado = $('#gradoFilter').val();
            }
        },
        language: {
            "decimal": ",",
            "emptyTable": "No hay datos disponibles en la tabla",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
            "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
            "infoFiltered": "(filtrado de _MAX_ entradas en total)",
            "lengthMenu": "Mostrar _MENU_ entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "No se han encontrado resultados",
            "paginate": {
                "first": "Primera",
                "last": "Última",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": activar para ordenar la columna de manera ascendente",
                "sortDescending": ": activar para ordenar la columna de manera descendente"
            }
        },
        columns: [
            { data: 'id_alumno' },
            { data: 'matricula' },
            { data: 'apaterno' },
            { data: 'amaterno' },
            { data: 'nombre' },
            { data: 'id_grupo' },      // Grupo
            { data: 'grado' },         // Grado
            { data: 'periodo' },       // Periodo
            {
                data: null,
                orderable: false,
                render: function (data) {
                    return `
                        <button class="btn btn-default btn-sm historial-btn" data-id="${data.id_alumno}" onclick="historial('${data.id_alumno}')"><i class="fa-solid fa-sliders"></i></button>
                    `;
                }
            }
        ]
    });

    $('#periodoFilter, #grupoFilter, #gradoFilter').on('change', function () {
        table.ajax.reload();
    });

    $('#filterDate').click(function () {
        const startDate = $('#startDate').val();
        const endDate = $('#endDate').val();
        table.ajax.reload();
    });

    // Eliminar la función resetFilters existente y mantener solo limpiarFiltros
    $('#limpiarFiltros').click(function() {
        // Limpiar todos los filtros
        $('#periodoFilter').val('').trigger('change');
        $('#grupoFilter').val('').trigger('change');
        $('#gradoFilter').val('').trigger('change');
        $('#startDate').val('');
        $('#endDate').val('');
        endDateInput.prop('disabled', true);

        // Limpiar la búsqueda de DataTables
        table.search('');
        
        // Limpiar la búsqueda en cada columna
        table.columns().every(function() {
            let column = this;
            column.search('');
        });

        // Recargar y redibujar la tabla
        table.ajax.reload();
        table.draw();
    });
});

function historial(id) {
    $.getJSON(`../Modules/Alumnos/fetch_alumno.php?id=${id}`, function (data) {
        const url = `../Modules/Alumnos/alumno.php?id_alumno=${data.id_alumno}`;
        window.location.href = url;
    });
}