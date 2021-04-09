function DetalleAsistencia() {
    this.ctr = "controlador/procesos/Controlador_detalle_sesion.php";

    this.post = null;
    this.table = null;

    this.Envio = {
        CveConsejo: 0,
        CveSesion: 0,
        yDatos: []
    };
    this.init();
}

/**
 * Constructor
 * InicializarÃ¡ funciones o modelo
 */
DetalleAsistencia.prototype.init = function () {

    this.fnTabla();

    $("div>div.col-12.offset-5 #xBtnModal").click( function (e) {
        e.preventDefault();
        alert("hola-1")
    //     obj_asistencia.fnPrepararDatos();
    });

};

DetalleAsistencia.prototype.fnPrepararDatos = function () {
    var rowData;
    this.Asistencia = [];

    var checkedCount = $(this.table.rows().nodes()).find('.cadenaEnviar:checkbox:checked');
    
    for (var checkbox of checkedCount) {

        rowData = this.table.row($(checkbox).parent().parent()).data();
        this.Asistencia.push(rowData);
    }

    if (this.Asistencia.length > 0) {
      
        this.fnGuardar(JSON.stringify(this.Asistencia));

    } else {

        inicio.aviso("Seleccione algún registro");
    }
};

DetalleAsistencia.prototype.fnGuardar = function (data) {
    this.Envio.yAccion = 6;
    this.Envio.yDatos = data;
    // console.log(this.Modelo);
    inicio.preloader()
    this.post = $.post(this.ctr, this.Envio);

    this.post.done(function (data) {
        if (!$.isEmptyObject(data) && data == '1') {
            inicio.registroOk().then(function () {

            }.bind(this));
            obj_detalle.fnTablaAsistencia();
        } else {
            inicio.registroNoOk();
        }


        $("#myModal").modal('hide');
    }.bind(this));
}

DetalleAsistencia.prototype.fnTabla = function () {

    this.Envio.yAccion = 5;
    this.Envio.CveConsejo = document.getElementById("myModal").dataset.consejo;
    this.Envio.CveSesion = document.getElementById("myModal").dataset.sesion;
    inicio.preloader();

    this.post = $.post(this.ctr, this.Envio);
    this.post.done(function (data) {

        if (!$.isEmptyObject(data)) {

            data = JSON.parse(data)


            this.table = $('div.modal-body #xTablaParticipantes').DataTable({
                lengthChange: true,
                responsive: true,
                //        "paging": false,
                lengthMenu: [
                    [25, 50, 100, -1],
                    [25, 50, 100, "Todos"]
                ],
                processing: false,
                ordering: false,
                data: data,
                destroy: true,
                serverSide: false,
                language: inicio.tDataTable(),
                initComplete: function () {
                    swal.close();
                },
                createdRow: this.acciones.bind(this),
                autoWidth: false,
                columns: [{
                        data: null,
                        class: "text-right",
                        render: function (data, type, row, meta) {
                            return (meta.row + 1);
                        }
                    },
                    {
                        data: null
                    },
                    {
                        data: null,
                        render: function (data) {
                            return (data.paterno + ' ' + data.materno + ' ' + data.nombre)
                        }
                    },
                    {
                        data: null,
                        render: function (data) {
                            return (data.s_paterno + ' ' + data.s_materno + ' ' + data.s_nombre)
                        }
                    },
                    {
                        data: null
                    },
                    {
                        data: null
                    }

                ]
            });
        }
    }.bind(this));

};


DetalleAsistencia.prototype.acciones = function (row, data, index) {

    var seleccionar = $("<input>", {
        type: "checkbox",
        class: " cadenaEnviar",
        'data-id': "fila" + index
    });
    var suplente = $("<button>", {
        id: "fila" + index,
        class: "btn btn-info  ",
        html: "Asistencia suplente"
    });
    var quitar = $("<button>", {
        class: "btn btn-danger rounded-circle shadow",
        html: "<i class='fa fa-ban'></i>"
    });

    //Por default suplente como falso
    data.suplente = 0;


    //Mostrar nombre suplente
    $(row).children().eq(1).empty().append(seleccionar);


    //Mostrar nombre suplente
    suplente.click(function () {

        Swal.fire({
            title: '¿Estás seguro de registrar asistencia al suplente?',
            text: "Da click en confirmar para continuar",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#00b293',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar'
        }).then((result) => {
            if (result.value) {
                data.suplente = 1;
                quitar.prop("disabled", false);
                suplente.prop("disabled", true);

            }
        })
    });

    suplente.prop("disabled", true);
    $(row).children().eq(4).empty().append(suplente);


    quitar.prop("disabled", true);
    $(row).children().eq(5).empty().append(quitar);

    //Mostrar nombre suplente
    quitar.click(function () {
        data.suplente = 0;
        suplente.prop("disabled", false);
        quitar.prop("disabled", true);

    });

}


//Checkbox  
$(document).on("click", ".cadenaEnviar", function (e) {
    var checked = this;
    var nombre = checked.dataset.id;
    if (checked.checked) {

        $("tr>td").find("#" + nombre).prop('disabled', false);

    } else {

        $("tr>td").find("#" + nombre).prop('disabled', true)

    }

});


$(function(){
    obj_asistencia = new DetalleAsistencia();
    
   
    
})
