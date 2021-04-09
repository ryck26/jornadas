function FormularioReporteCompromisos(){
    this.crt = "controlador/reportes/Controlador_reporte_compromisos.php";
    this.opcionesConsejo = ko.observableArray();
    this.opcionesSesion = ko.observableArray();
    this.opcionesParticipante = ko.observableArray();
    this.Modelo = {
        accion: 0,
        cve_consejo: ko.observable(),
        cve_sesion: ko.observable(),
        cve_participante: ko.observable(),
        cve_acuerdo_compromiso: 0
    };
    //Textos modal
    this.modNombreConsejo = ko.observable(); 
    this.modTituloCompromiso = ko.observable(); 
    this.modDescripcionCompromiso = ko.observable(); 
    this.modFechaRegistro = ko.observable(); 
    this.modFechaCumplimiento = ko.observable(); 
    this.modPorcentaje = ko.observable(); 
    
    this.post = null;
}

FormularioReporteCompromisos.prototype.fnListaConsejos = function(){
    this.Modelo.accion=1;
    inicio.preloader();
    this.post = $.post(this.crt, this.Modelo);
    this.post.done(function(data){
            if(!$.isEmptyObject(data))
            {
                data = JSON.parse(data);
                data.forEach(function(item){
                objCompromisos.opcionesConsejo.push(item);
                }.bind(this));
            }     
        });
    swal.close();
}

FormularioReporteCompromisos.prototype.fnListaSesiones = function(){
    this.Modelo.accion=2;
	$('#xTablaCompromisos').find('tbody').empty();
	
    inicio.preloader();
    this.post = $.post(this.crt, this.Modelo);
    this.post.done(function(data){
            if(!$.isEmptyObject(data))
            {
                data = JSON.parse(data);
                data.forEach(function(item){
                objCompromisos.opcionesSesion.push(item);
                }.bind(this));
            }     
        });
    swal.close();
}

FormularioReporteCompromisos.prototype.fnListaParticipantes = function(){
    this.Modelo.accion=3;
	$("#xTablaCompromisos").DataTable().clear().draw();
    inicio.preloader();
    this.post = $.post(this.crt, this.Modelo);
    this.post.done(function(data){
            if(!$.isEmptyObject(data))
            {
                data = JSON.parse(data);
                data.forEach(function(item){
                objCompromisos.opcionesParticipante.push(item);
                }.bind(this));
            }     
        });
    swal.close();
}

FormularioReporteCompromisos.prototype.fnTablaCompromisos = function (data) {
    var o = this;
    inicio.preloader();
    this.table = $('#xTablaCompromisos').DataTable({
        "bLengthChange": true,
        "autoWidth": false,
        "responsive": true,
        "paging": true,
        "bProcessing": false,
        "ordering": false,
        "data": data,
       "sAjaxSource": objCompromisos.crt + "?accion=4&cve_participante="+objCompromisos.Modelo.cve_participante(),
        "bDestroy": true,
        "serverSide": false,
        "oLanguage": {
 
            "sLoadingRecords": "Espere un momento - cargando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sEmptyTable": "No hay registros para mostrar",
            "sInfo": "Mostrando registros de _START_ a _END_ de un total de _TOTAL_ registros",
            "oPaginate": {
                "sPrevious": "Página anterior",
                "sNext": "Siguiente página",
                "sLast": "Última página",
                "sFirst": "Primer página"
            },
            "sSearch": "Buscar:"
        },
 
        "fnInitComplete": function ()
        {
            swal.close();
        },

        "fnCreatedRow": function (row, data, index) {
            $(row).find(".detalles").click(function (){
                objCompromisos.modNombreConsejo(data["nombre"]);
                objCompromisos.modTituloCompromiso(data["titulo"]);
                objCompromisos.modDescripcionCompromiso(data["descripcion"]);
                objCompromisos.modFechaRegistro(data["fecha_registro"].slice(0, 10));
                objCompromisos.modFechaCumplimiento(data["fecha_cumplimiento"].slice(0, 10));
                $("#barraProgreso").attr("aria-valuenow", data["porcentaje_avance"]);
                $("#barraProgreso").attr("style", "width: "+data["porcentaje_avance"]+"%;");
                objCompromisos.modPorcentaje(data["porcentaje_avance"]+"%");
                objCompromisos.Modelo.cve_acuerdo_compromiso = data["cve_acuerdo_compromiso"];
                objCompromisos.fnTablaAvances();
            });

        },
        "bAutoWidth": false,
      //-----------------------ARMADO DE COLUMNAS-----------------------------
       "aoColumns": [
            {"mData": "cve_acuerdo_compromiso", "bVisible": false},
            {"mData": null, "bVisible": true,
            render:function(data, type, row, meta)
            {return meta.row+1}},
            {"mData": "titulo", "bVisible": true},
            {"mData": "detalles", 
                "mRender": function (data, type, full){
                    return "<center> "
                    + "<button class='btn btn-info detalles' data-toggle='modal' data-target='#exampleModal'><span class='fa fa-eye' aria-hidden='true'></span></button>"
                    + "</center>";
                },
            "sClass": "text-center", "bSortable": true}
       ]
    });
}

FormularioReporteCompromisos.prototype.fnTablaAvances = function (data) {
    var o = this;
    inicio.preloader();
    this.table = $('#xTablaAvances').DataTable({
        "bLengthChange": true,
        "autoWidth": false,
        "responsive": true,
        "paging": true,
        "bProcessing": false,
        "ordering": false,
        "data": data,
       "sAjaxSource": objCompromisos.crt + "?accion=5&cve_acuerdo_compromiso="+objCompromisos.Modelo.cve_acuerdo_compromiso,
        "bDestroy": true,
        "serverSide": false,
        "oLanguage": {
 
            "sLoadingRecords": "Espere un momento - cargando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sEmptyTable": "No hay registros para mostrar",
            "sInfo": "Mostrando registros de _START_ a _END_ de un total de _TOTAL_ registros",
            "oPaginate": {
                "sPrevious": "Página anterior",
                "sNext": "Siguiente página",
                "sLast": "Última página",
                "sFirst": "Primer página"
            },
            "sSearch": "Buscar:"
        },
 
        "fnInitComplete": function ()
        {
            swal.close();
        },

        "fnCreatedRow": function (row, data, index) {

        },
        "bAutoWidth": false,
      //-----------------------ARMADO DE COLUMNAS-----------------------------
       "aoColumns": [
            {"mData": "cve_detalle_compromiso", "bVisible": false},
            {"mData": "nota", "bVisible": true},
            {"mData": "porcentaje_avance", "sClass": "text-center",
                "mRender": function (data){
                return data+"%"
            }},
            {"mData": "estatus", "sClass": "text-center", "mRender": function (data){
                switch(data)
                {
                    case "1":
                        return '<span class="badge badge-pill badge-success">&nbsp;</span>';
                    case "0": 
                        return '<span class="badge badge-pill badge-danger">&nbsp;</span>';
                    default:
                        return "a";
                }
            }}
       ]
    });
}

function resetForms(){
    $("#xCmbConsejo").empty();
    $("#xCmbSesion").empty();
    $("#xCmbParticipante").empty();
}

$(document).ready(function(){
    objCompromisos = new FormularioReporteCompromisos();
    ko.applyBindings(objCompromisos, document.getElementById("contenedorA"));

    objCompromisos.fnListaConsejos();
    
    $("#xCmbConsejo").change(function(){
        $("#xCmbSesion").empty();
        $("#xCmbParticipante").empty();
		console.log(objCompromisos.Modelo.cve_consejo());
        if(objCompromisos.Modelo.cve_consejo() != null)
            objCompromisos.fnListaSesiones();
        else
            $("#xTablaCompromisos").DataTable().clear().draw();
    });

    $("#xCmbSesion").change(function(){
        $("#xCmbParticipante").empty();
        if(objCompromisos.Modelo.cve_sesion() != null)
            objCompromisos.fnListaParticipantes();    
        else
            $("#xTablaCompromisos").DataTable().clear().draw();
    });

    $("#xCmbParticipante").change(function(){
        if(objCompromisos.Modelo.cve_participante() != null)
            objCompromisos.fnTablaCompromisos();
        else
            $("#xTablaCompromisos").DataTable().clear().draw();
    });
});