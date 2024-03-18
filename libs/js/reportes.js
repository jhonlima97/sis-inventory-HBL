var tbl_reporte;

var idioma_espanol = {
    "sProcessing": "Procesando...",
    "sLengthMenu": "Mostrar _MENU_ Registros por página",
    "sZeroRecords": "No se encontraron resultados",
    "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ Registros",
    "sInfoEmpty": "Mostrando 0 a 0 de 0 Registros",
    "sInfoFiltered": "(filtrado de un total de _MAX_ Registros)",
    "sInfoPostFix": "",
    "sSearch": "Buscar:",
    "sUrl": "",
    "oPaginate": {
        "sFirst": "Primero",
        "sPrevious": "Anterior",
        "sNext": "Siguiente",
        "sLast": "Último"
    }
};

function configurarTabla() {
    return {
        "ordering": false,
        "bLengthChange": true,
        "searching": { "regex": false },
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
        // ... tus otras configuraciones ...
        "columns": [
            { "defaultContent": "" },
            { "data": "area" },
            { "data": "tipo_bien" },
            { "data": "cod_patrimonial" },
            { "data": "marca" },
            { 
                "data": "modelo",
                "render": function (data, type, row) {
                    if (data === null || data === "") {
                        return '<em>Sin Modelo</em>';
                    } else {
                        return data;
                    }
                }
            },
            { 
                "data": "serie",
                "render": function (data, type, row) {
                    if (data === null || data === "") {
                        return '<em>Sin Serie</em>';
                    } else {
                        return data;
                    }
                }
            },
            {
                "data": "estado",
                render: function (data, type, row) {
                    if (data == 'MALO') {
                        return '<b> M <b/>'
                    }
                }
            }//,
            /*{
                "data": null,
                render: function (data, type, row) {
                    return "<button class='editar btn btn-primary btn-sm'><i class='fas fa-edit'></i></button>";
                }
            }*/
        ],
        "columnDefs": [
            {
                "className": "text-center",
                "targets": "_all"
            }
        ],
        "language": idioma_espanol,
        destroy: true,
        select: true
    };
}

$('#select_bien').on('change', function() {
    var selectedOption = $(this).val();
    getTabla(selectedOption);
});

function getTabla(tabla) {
    
    // Verificar si tbl_reporte ya está inicializado
    if (!tbl_reporte) {
        tbl_reporte = $("#tbl_reporte").DataTable(configurarTabla());
    }

    // Limpiar y cargar datos solo si se proporciona una tabla
    if (tabla !== "") {
        tbl_reporte.search('').draw();
        tbl_reporte.clear().draw();
        tbl_reporte.ajax.url("https://inventario-hbl.000webhostapp.com/sis-inventory-HBL/controllers/reportes/get_reporte.php?tabla=" + tabla).load();
    } else {
        // Si no se proporciona una tabla, simplemente limpiar los datos
        tbl_reporte.clear().draw();
    }


    // Lógica para numerar las filas
    tbl_reporte.on('draw.dt', function () {
        var PageInfo = tbl_reporte.page.info();
        tbl_reporte.column(0, { page: 'current' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });
}

function Reporte_bajas(){
    window.open("https://inventario-hbl.000webhostapp.com/sis-inventory-HBL/views/fpdf/rptEquiposBajas.php", "_blank");
}






