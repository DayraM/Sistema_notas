$(document).ready(function () {
    $('#miTabla').DataTable({
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excel', text: '<i class="bi bi-file-earmark-excel"></i> Excel', className: 'btn btn-success btn-sm' },
            { extend: 'pdf', text: '<i class="bi bi-file-earmark-pdf"></i> PDF', className: 'btn btn-danger btn-sm' }
        ],
        language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json' }
    });
});

function prepararNota(id) {
    document.getElementById('id_alumno_nota').value = id;
}

function prepararEdicion(id, nombre, apellido, correo, telefono, fecha) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_nombre').value = nombre;
    document.getElementById('edit_apellido').value = apellido;
    document.getElementById('edit_correo').value = correo;
    document.getElementById('edit_telefono').value = telefono;
    document.getElementById('edit_fecha').value = fecha;
}

function confirmarEliminacion(idNota, idAlumno) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href =
                "acciones.php?eliminar_nota=" + idNota + "&id_alumno=" + idAlumno;
        }
    });
}

function confirmarEliminacionAlumno(idAlumno) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href =
                "acciones.php?eliminar_alumno=" + idAlumno;
        }
    });
}
