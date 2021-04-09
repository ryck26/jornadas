/*
 * Titulo			            : DetalleSession.php
 * Descripción                  : js
 * Compañía			            :  UTL
 * Fecha de creación            : 01-julio-2019
 * Desarrollador                : Ricardo Franco
 * Versión			            : 1.0
 */


function DetalleSession() {
    this.ctr = "controlador/procesos/Controlador_detalle_sesion.php";
    
    //Combos
    this.OpcionesConsejos = ko.observableArray();
    this.OpcionesSesiones = ko.observableArray();
    
    //visible
     this.VSesion = ko.observable(false);

    this.post = null;
    this.table = null;
    this.tabla = null;
    this.tabla_asistencia = null;
    this.tablaDocumentos = null;

    
    //Modelo
    this.Modelo = {
        CveConsejo: ko.observable(''),
        CveSesion: ko.observable(''),
        Ubicacion: ko.observable(''),
        HInicio: ko.observable(''),
        HFin: ko.observable(''),
        Desarrollo: ko.observable(),
        
        NombreArchivo: ko.observable('')
    };

    this.Envio = {
        CveConsejo: 0,
        CveSesion: 0,
        yDatos: []
    };

   //Método inicial constructor
    this.init();

}

/**
 * Constructor
 * Inicializará funciones o modelo
 */
DetalleSession.prototype.init = function () {
    this.Modelo.CveConsejo.extend({kavie: {required: false}});
    this.Modelo.CveSesion.extend({kavie: {required: false}});
    this.Modelo.Ubicacion.extend({kavie: {required: false,minLength: 3}});
    this.Modelo.HInicio.extend({kavie: {required: false}});
    this.Modelo.HFin.extend({kavie: {required: false}});
    this.Modelo.Desarrollo.extend({kavie: {required: false,minLength: 3}});
    this.fnDesarollo();
    this.fnConsejos();
    //this.fnCargarModal();
};

/**
 * 
 */
DetalleSession.prototype.fnCancelar = function () {
    this.fnLimpiar();
    Kavie.deactivate(this.Modelo);
}


DetalleSession.prototype.fnGuardaUbicacion = function () {
    //console.log(this.Modelo,Kavie.isValid(this.Modelo));
	
    if (this.Modelo.CveConsejo()> 0 && this.Modelo.CveSesion() > 0 && this.Modelo.Ubicacion() !="" && this.Modelo.HInicio() !="" && this.Modelo.HFin() !="" ) {
        // console.log(this.Modelo);
		this.Modelo.yAccion = 1;
        inicio.preloader()
        this.post = $.post(this.ctr, this.Modelo);

        this.post.done(function (data) {
            if (!$.isEmptyObject(data) && data == '1') {
                inicio.registroOk().then(function(){
                    
                }.bind(this));
                
            } else {
                inicio.registroNoOk();
            }
            //this.fnCancelar();
        }.bind(this));
    } //fin if validacion

};

DetalleSession.prototype.fnActualizar = function () {
    

    if (Kavie.isValid(this.Modelo)) {
		this.Modelo.yAccion = 2;
        // console.log(this.Modelo);
        inicio.preloader()
        this.post = $.post(this.ctr, this.Modelo, 'html');

        this.post.done(function (data) {
            if (!$.isEmptyObject(data) && data == '1') {
                inicio.registroOk();
                
                
            } else {
                inicio.registroNoOk();
            }
           this.fnTabla();
           this.fnCancelar()
        }.bind(this));
    } //fin if validacion
};

DetalleSession.prototype.fnGuardarDesarrollo = function () {
    this.Modelo.yAccion = 2;
    this.Modelo.Desarrollo($(".summernote").summernote('code'));
    // console.log(this.Modelo);
    inicio.preloader()
    this.post = $.post(this.ctr, this.Modelo);

    this.post.done(function (data) {
        if (!$.isEmptyObject(data) && data == '1') {
            inicio.registroOk();
            
            
        } else {
            inicio.registroNoOk();
        }
        this.fnTabla();
        this.fnCancelar()
    }.bind(this));

};


/**
 * 
 */
DetalleSession.prototype.fnConsejos = function () {
    this.Modelo.yAccion = 3;

    inicio.preloader()
    this.post = $.post(this.ctr, this.Modelo);
    this.post.done(function (data) {
        // console.log(data);
        if (!$.isEmptyObject(data)) {
            data = JSON.parse(data);

            data.forEach(function (item) {
                this.OpcionesConsejos.push(item);
            }.bind(this));
        }
        swal.close();
    }.bind(this));
};



/**
 * 
 */
DetalleSession.prototype.fnSesion = function () {
    this.Modelo.yAccion = 4;
    this.OpcionesSesiones.removeAll();
    inicio.preloader();
    this.post = $.post(this.ctr, this.Modelo);

    this.post.done(function (data) {
        // console.log(data);
        if (!$.isEmptyObject(data)) {
            data = JSON.parse(data);

            data.forEach(function (item) {
                this.OpcionesSesiones.push(item);
            }.bind(this));
        }
        delete this.Modelo.yAccion
        swal.close();
    }.bind(this));
};

DetalleSession.prototype.DatosSesion = function (option, item) {
    if (typeof item != 'undefined') {
        option.dataset.ubicacion = item.ubicacion;
        option.dataset.desarrollo = item.desarrollo;
        option.dataset.hora_inicio = item.hora_inicio;
        option.dataset.hora_fin = item.hora_fin;
        
    }
}


/**
 * 
 */ 
DetalleSession.prototype.changeConsejo = function () {

    if (typeof this.Modelo.CveConsejo() != 'undefined') {
       this.fnSesion();
    }else{
        this.fnCancelar();
        
    }
}

/**
 * 
 */ 
DetalleSession.prototype.changeSesion = function (e) {
    
    if (typeof this.Modelo.CveSesion() != 'undefined') {
        this.Modelo.Ubicacion(e.target.options[e.target.selectedIndex].dataset.ubicacion);
        this.Modelo.Desarrollo(e.target.options[e.target.selectedIndex].dataset.desarrollo);
        $(".summernote").summernote('code',e.target.options[e.target.selectedIndex].dataset.desarrollo);
        this.Modelo.HInicio(e.target.options[e.target.selectedIndex].dataset.hora_inicio);
        this.Modelo.HFin(e.target.options[e.target.selectedIndex].dataset.hora_fin);
        this.VSesion(true);
        
    }else{
        this.OpcionesSesiones.removeAll();
        this.fnCancelar();
        this.VSesion(false);
    }
}

/**
 * Modal para asistencia
 */
DetalleSession.prototype.fnModalAsistencia = function(){
    
    $("#myModal").modal('show');
    document.getElementById('tituloAsistencia').innerHTML = 'Alta de asistenacia';
    this.fnTablaParticipantes();
}

DetalleSession.prototype.fnTabla = function () {

    this.Modelo.yAccion = 3;
    this.post = $.post(this.ctr, this.Modelo);
    this.post.done(function (data) {
        if(!$.isEmptyObject(data)){
        
            data = JSON.parse(data)

            this.tabla = $('#xTablaDetalleSession').DataTable({
                "lengthChange": true,
                "responsive": true,
                //        "paging": false,
                "lengthMenu": [
                    [25, 50, 100, -1],
                    [25, 50, 100, "Todos"]
                ],
                "processing": false,
                //        "ordering": false,
                "data": data,
                "destroy": true,
                "serverSide": false,
                "language": inicio.tDataTable(),
                "initComplete": function () {},
                "createdRow": this.acciones.bind(this),
                "autoWidth": true,
                "columns": [
                    {"data": null,
                        render: function (data, type, row, meta) {
                            return (meta.row + 1);
                        }
                    },
                    {"data": null,render:function(data){
                            return (data.paterno+' '+data.materno+' '+data.nombre)
                        }
                    },
                    {"data": null},
                    {"data": null},
                    {"data": null},
                    {"data": null},
                    {"data": null}
                ]
            });
        }
    }.bind(this));
};

DetalleSession.prototype.acciones = function (row, data, index) {
    //  console.log(index)
    var info = $("<button>",{class: "btn btn-link ",text: "Información participante"});
    var suplente = $("<button>",{class: "btn btn-link ",text: "Suplente de..."});
    var editar = $("<button>", {class: "btn btn-info rounded-circle shadow",html: "<i class='fa fa-edit'></i> "});
    var text = eval(data.u_activo) == 1 ? "<i class='fa fa-check-circle'></i> " : "<i class='fa fa-ban'></i> ";
    var activar = $("<button>", {class:  eval(data.u_activo) == 1 ? "btn btn-success rounded-circle shadow" : "btn btn-danger rounded-circle shadow",html: text, disabled: eval(data.u_activo) == 1 ? false : true});
    var generar = $("<button>", {class: "btn btn-primary rounded-circle shadow",html: "<i class='fa fa-paper-plane'></i> "});


    //Mostrar nombre suplente
    info.click(function(){
       
        var texto ="<ul class='text-left'> <li>Nombre: <b>"+(data.paterno+' '+data.materno+' '+data.nombre)+"</b></li>"
                    +"<li>Celular: <b>"+data.celular+"</b></li> "
                    +"<li>Institución <b>"+data.institucion+"</b></li> "
                    +"<li>Usuario: <b>"+data.usuario+"</b></li> "
                    +"<li>Tipo participante: <b>"+data.tipo_participante+"</b></li> </ul> ";
        swal.fire({
            type: 'info',
            title: 'Información participante',
            html: texto,
            confirmButtonText: 'Ok',
            showLoaderOnConfirm: true,
            allowOutsideClick: false
        });
        
    });
   
    $(row).children().eq(2).empty().append(info);


    //Mostrar nombre suplente
    if(eval(data.cve_participante_primario) > 0){
        suplente.click(function(){
                    inicio.aviso("Nombre: "+(data.p_paterno+' '+data.p_materno+' '+data.p_nombre)+"");
                });
    }else{
        suplente = "-";
    }
    $(row).children().eq(3).empty().append(suplente);

    //Editar registro
    editar.click(function () {
        this.editar(data)
    }.bind(this));

    $(row).children().eq(4).empty().append(editar);

    //Activar registro
    activar.click(function(){
        this.fnDesactivar(data)
    }.bind(this));
        
    $(row).children().eq(5).empty().append(activar);

    //Generar contraseña y envíar correo
    generar.click(function () {
        this.fnGenerar(data)
    }.bind(this));
    
    $(row).children().eq(6).empty().append(generar);

}




/**
 * 
 */
DetalleSession.prototype.fnTablaAsistencia = function () {

    this.Modelo.yAccion = 7;

    if(this.Modelo.CveSesion() > 0){
        this.post = $.post(this.ctr, this.Modelo);
        this.post.done(function (data) {
            if(!$.isEmptyObject(data)){
            
                data = JSON.parse(data)
    
                this.tabla_asistencia = $('#xTablaAsistencia').DataTable({
                    "lengthChange": true,
                    "responsive": true,
                    //        "paging": false,
                    "lengthMenu": [
                        [25, 50, 100, -1],
                        [25, 50, 100, "Todos"]
                    ],
                    "processing": false,
                    //        "ordering": false,
                    "data": data,
                    "destroy": true,
                    "serverSide": false,
                    "language": inicio.tDataTable(),
                    "initComplete": function () {},
                    "createdRow": this.accionesAsistencia.bind(this),
                    "autoWidth": false,
                    "columns": [
                        {"data": null,
                            render: function (data, type, row, meta) {
                                return (meta.row + 1);
                            },class:"text-right"
                        },
                        {"data": null,render:function(data){
                                return (data.paterno+' '+data.materno+' '+data.nombre)
                            }
                        },
                        {"data": "institucion"},
                        {"data": null,class:"text-center"}
                        
                    ]
                });
            }
        }.bind(this));
    }
   
};


/**TODO: Asistencia acciones
 *
 */
DetalleSession.prototype.accionesAsistencia = function (row, data, index) {
    //  console.log(index)
    var eliminar = $("<button>",{class: "btn btn-danger rounded-circle shadow",title: "Eliminar asistencia", html: "<i class='fa fa-ban'></i>"});
    


    //Mostrar nombre suplente
    eliminar.click(function(){
        Swal.fire({
            title: '¿Estás seguro de eliminar el registro?',
            text: "Da click en confirmar para continuar",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#00b293',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar'
          }).then((result) => {
            if (result.value) {
               this.fnEliminarAsistencia(data);
            }
          })
      
        
        
    }.bind(this));
   
    $(row).children().eq(3).empty().append(eliminar);
}


/**
 * Recargar datos para actualizar información
 */
DetalleSession.prototype.fnEliminarAsistencia = function (data) {
    
    this.Modelo.yAccion = 8;
    this.Modelo.cveAsistenciaSesion = data.cve_asistencia_sesion;

    inicio.preloader()
    this.post = $.post(this.ctr, this.Modelo);

    this.post.done(function (data) {
        if (!$.isEmptyObject(data) && data == '1') {
            inicio.eliminacionOk().then(function(){
                
            }.bind(this));
            
        } else {
            inicio.eliminacionNoOk();
        }
        this.fnTablaAsistencia();
       
    }.bind(this));
   
};

/**
 * Pestaña desarrollo
 */
DetalleSession.prototype.fnDesarollo = function(){

    $(".summernote").summernote({
        lang: "es-ES",
        toolbar: [
        ["style", ["style"]],
        ["font", ["bold", "underline", "clear"]],
        ["fontname", ["fontname"]],
        ["color", ["color"]],
        ["para", ["ul", "ol", "paragraph"]],
        ["table", ["table"]],
        ["view", ["fullscreen", "help"]]
        ],
        tabsize: 2,
        height: 100,
        minHeight: 100
    });
}



DetalleSession.prototype.fnLimpiar = function(){
    
        this.Modelo.yAccion = 0;
        
        this.Modelo.Ubicacion('');
        this.Modelo.HInicio('');
        this.Modelo.HFin('');
        this.Modelo.Desarrollo('');

}

//++++++++++++++++++++++++++++++++++++++++++++   Asistencia --------------------------------------------------


DetalleSession.prototype.fnPrepararDatos = function () {
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

DetalleSession.prototype.fnGuardar = function (data) {
    this.Envio.yAccion = 6;
    this.Envio.yDatos = data;
    // console.log(this.Modelo);
    inicio.preloader()
    this.post = $.post(this.ctr, this.Envio);

    this.post.done(function (data) {
        if (!$.isEmptyObject(data) && data == '1') {
            inicio.registroOk().then(function () {

            }.bind(this));
            
            this.fnTablaAsistencia();
        } else {
            inicio.registroNoOk();
        }


        $("#myModal").modal('hide');
    }.bind(this));
}

DetalleSession.prototype.fnTablaParticipantes = function () {

    this.Envio.yAccion = 5;
    
    this.Envio.CveConsejo = this.Modelo.CveConsejo();
    this.Envio.CveSesion = this.Modelo.CveSesion();

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
                createdRow: this.accionesParticipantes.bind(this),
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


DetalleSession.prototype.accionesParticipantes = function (row, data, index) {

    var seleccionar = $("<input>", {
        type: "checkbox",
        class: " cadenaEnviar",
        'data-id': "fila" + index
    });
    var suplente = $("<button>", {
        id: "fila" + index,
        class: "btn btn-info  rounded-circle shadow",
        title: "Asistencia suplente",
		html: "<i class='fa fa-clipboard-list'></i>"
    });
    var quitar = $("<button>", {
        class: "btn btn-danger rounded-circle shadow",
		title: "Quitar suplente",
        html: "<i class='fa fa-ban'></i> "
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

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

//++++++++++++++++++++++++++++++++++++++ Documentos ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

/**
 * Eliminar fnEliminarAcuerdoCompromiso
 */
DetalleSession.prototype.fnEliminarAcuerdoCompromiso = function (cve_acuerdo_compromiso) {
    this.Modelo.cveAcuerdoCompromiso = cve_acuerdo_compromiso
    this.Modelo.CveSesion = document.getElementById("xSltSesiones").value;
    this.Modelo.yAccion = 11;

    inicio.preloader();
    this.post = $.post(this.ctr, this.Modelo);

    this.post.done(function (data) {
        // console.log(data);
        if (!$.isEmptyObject(data) && data == '1') {
            inicio.registroOk();
            this.fnTablaCompromisos();
        } else {
            inicio.registroNoOk();
        }

    }.bind(this));
};
/**
 * Modal para asistencia
 */
DetalleSession.prototype.fnModalDocumentos = function(){
    
    $("#ModalDocumentos").empty();
    $("#ModalDocumentos").load("vista/procesos/proceso_subir_archivo.html",function(){
        $("#modalSubirArchivo").modal("show");
        
        window.cve_proceso_documento = this.Modelo.CveSesion();
        window.tipo_proceso = 3;
        window.cve_participante_archivo = 0;
    }.bind(this));
    
    
}

DetalleSession.prototype.fnTablaDocumentos = function () {
   
    this.Envio.yAccion = 9;
    this.Envio.CveConsejo = document.getElementById("xSltConsejos").value;
    this.Envio.CveSesion = document.getElementById("xSltSesiones").value;

    this.post = $.post(this.ctr, this.Envio);
    this.post.done(function (data) {
        if(!$.isEmptyObject(data)){
        
            data = JSON.parse(data)

            this.tablaDocumentos = $('#xTablaDocumentos').DataTable({
                "lengthChange": true,
                "responsive": true,
                //        "paging": false,
                "lengthMenu": [
                    [25, 50, 100, -1],
                    [25, 50, 100, "Todos"]
                ],
                "processing": false,
                //        "ordering": false,
                "data": data,
                "destroy": true,
                "serverSide": false,
                "language": inicio.tDataTable(),
                "initComplete": function () {},
                "createdRow": this.accionesDocumentos.bind(this),
                "autoWidth": false,
                "columns": [
                    {"data": null,
                        render: function (data, type, row, meta) {
                            return (meta.row + 1);
                        },"className":"text-center" 
                    },
                    {"data": null,render:function(data){
                            return (data.nombre)
                        }
                    },
                    {"data": null,"className":"text-center"},
                    {"data": null,"className":"text-center"}
                    
                ]
            });
        }
    }.bind(this));
};

DetalleSession.prototype.accionesDocumentos = function (row, data, index) {

    var visualizar = $("<a>", {
        class: "btn btn-info rounded-circle shadow",
		title: "Descargar",
        html: "<i class='fa fa-download'></i>",
        href: "#",
        target: "_blank"
    });

    var quitar = $("<button>", {
        class: "btn btn-danger rounded-circle shadow",
		title: "Quitar suplente",
        html: "<i class='fa fa-ban'></i> "
    });

    
    
    //Mostrar nombre suplente
    visualizar.click(function (e) {
        e.preventDefault();  //stop the browser from following
        
        window.open(data.ruta,'_blank');
        
    });

    quitar.click(function (e) {
        e.preventDefault();  //stop the browser from following
       

    });


    $(row).children().eq(2).empty().append(visualizar);
    $(row).children().eq(3).empty().append(quitar);
}


// ++++++++++++++++++++++++++++++  Acuerdos y compromisos

//Tabla compromisos por consejo

DetalleSession.prototype.fnTablaCompromisos = function () {

    this.Envio.yAccion = 10;
    this.Envio.CveConsejo = document.getElementById("xSltConsejos").value;
    this.Envio.CveSesion = document.getElementById("xSltSesiones").value;

    this.post = $.post(this.ctr, this.Envio);
    this.post.done(function (data) {
        if(!$.isEmptyObject(data)){

            data = JSON.parse(data)

            this.tablaDocumentos = $('#xTablaAcuerdos').DataTable({
                "lengthChange": true,
                "responsive": true,
                //        "paging": false,
                "lengthMenu": [
                    [25, 50, 100, -1],
                    [25, 50, 100, "Todos"]
                ],
                "processing": false,
                //        "ordering": false,
                "data": data,
                "destroy": true,
                "serverSide": false,
                "language": inicio.tDataTable(),
                "initComplete": function () {},
                "createdRow": this.accionesAcuerdos.bind(this),
                "autoWidth": false,
                "columns": [
                    {"data": null,
                        render: function (data, type, row, meta) {
                            return (meta.row + 1);
                        },"className":"text-center"
                    },
                    {"data": null,render:function(data){
                            return (data.titulo)
                        }
                    },
                    {"data": null,render:function(data){
                            return (data.nombre)
                        }
                    },
                    {"data": null,"className":"text-center"},
                    {"data": null,"className":"text-center"},
                    {"data": null,"className":"text-center"}

                ]
            });
        }
    }.bind(this));
};

DetalleSession.prototype.accionesAcuerdos = function (row, data, index) {

    var visualizar = $("<button>", {
        class: "btn btn-info rounded-circle shadow ",
        html: "<i class='fa fa-eye'></i> ",
        title: "Mostrar descrición"

    });

    var editar = $("<button>", {
        class: "btn btn-primary rounded-circle shadow ",
        html: "<i class='fa fa-edit'></i> ",
        title: "Editar información"

    });

    var quitar = $("<button>", {
        class: "btn btn-danger rounded-circle shadow ",
        html: "<i class='fa fa-ban'></i> ",
        title: "Mostrar descrición"
    });

    //Mostrar detalle acuerdos
    visualizar.click(function (e) {
        e.preventDefault();  //stop the browser from following

        $("#ModalDescripcion .descripcion").empty().html(data.descripcion);
        $("#ModalDescripcion").modal("show");

    });

    //Mostrar detalle acuerdos
    editar.click(function (e) {
        e.preventDefault();  //stop the browser from following

        document.getElementById("compromisos").dataset.crud= 2;
        $("#MoldalAcuerdosCompromisos").empty();
        $("#MoldalAcuerdosCompromisos").load("vista/catalogos/catalogo_acuerdo_compromiso.php",function(){
            $("#AcuerdoCompromiso").modal("show");

            window.parametros.cve_acuerdo_compromiso = data.cve_acuerdo_compromiso;
            window.parametros.Descripcion = data.descripcion;
            window.parametros.Titulo = data.titulo;
            window.parametros.Fecha = data.fecha_cumplimiento;
            window.parametros.tipo = data.cve_tipo;

        }.bind(this));
    }.bind(this));

    quitar.click(function (e) {
        e.preventDefault();  //stop the browser from following
        Swal.fire({
            title: '¿Estás seguro de eliminar el registro?',
            text: "Da click en confirmar para continuar",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#00b293',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar'
        }).then((result) => {
            if (result.value) {
               this.fnEliminarAcuerdoCompromiso(data.cve_acuerdo_compromiso);
            }
        });

    }.bind(this));


    $(row).children().eq(3).empty().append(visualizar);
    $(row).children().eq(4).empty().append(editar);
    $(row).children().eq(5).empty().append(quitar);
}


/**
 * Modal para asistencia
 */
DetalleSession.prototype.fnModalAcuerdosCompromisos = function(valor){
    document.getElementById("compromisos").dataset.crud= valor;
    $("#MoldalAcuerdosCompromisos").empty();
    $("#MoldalAcuerdosCompromisos").load("vista/catalogos/catalogo_acuerdo_compromiso.php",function(){
        $("#AcuerdoCompromiso").modal("show");
        // window.cve_proceso_documento = this.Modelo.CveSesion();
        // window.tipo_proceso = 3;
        // window.cve_participante_archivo = 0;
        
    }.bind(this));
    
    
};
//-----------------------------------------------------------------------


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
//------------------------------------------------------------------------------------------------------------------

$(function () {
    obj_detalle = new DetalleSession();
    ko.applyBindings(new DetalleSession(), document.getElementById("Contenedor"));
    
    
    
})
