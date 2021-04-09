function ProcesoArchivo(){
    this.crt="controlador/procesos/Controlador_subir_archivo.php";
    this.GA=0;
}

ProcesoArchivo.prototype.fnSubirArchivo = function (nombre, ruta) {
    objArchivo.GA = 1;
   $.ajax({
       type: "POST",
       dataType: "json",
       url: objArchivo.crt,
       data: {"accion": objArchivo.GA,
        "nombre": nombre,
        "ruta": ruta,
        "cve_proceso": cve_proceso_documento,
        "tipo_proceso": tipo_proceso,
        "cve_participante": cve_participante_archivo
            },
            success: function (data, revision, jqXHR) {
                console.log("respuesta actualizar-->"+data);
              if (data = 1) {
                  // SUCCESS

                //   var msg = inicio.registroOk();
                // msg.then(function(){
                //     limpiarFormulario();
                //     objSesion.fnTabla();
                // });

                //   objDetalleConsejo.fnTablaDocumentos();
                  var msg = swal.fire({
                      
                    type: 'success',
                    title: '',
                    text: 'El archivo se subio correctamente',
                    confirmButtonText: 'Ok',
                    showLoaderOnConfirm: true,
                    allowOutsideClick: false
                    });
                   msg.then(function(){
                       switch(tipo_proceso)
                       {
                           case 1:
                                if(typeof objDetalleConsejo != 'undefined'){
                                    objDetalleConsejo.fnTablaDocumentos();
                                }
                                if(typeof objDetalleConsejo != 'undefined'){
                                    objDetalleConsejo.fnTablaParticipantes();
                                }
                               
                                
                                break;
                            case 2:
                                $("#modalSubirArchivo").modal("hide");
                                if(typeof objDetalleConsejo != 'undefined'){
                                    objDetalleConsejo.fnTablaDocumentos();
                                }
                                if(typeof objDetalleConsejo != 'undefined'){
                                    objDetalleConsejo.fnTablaParticipantes();
                                }
                               
                                break;
                            case 3:
                                $("#modalSubirArchivo").modal("hide");
                                
                                if(typeof objeSesion != 'undefined'){
                                    objSesion.fnTabla();
                                }
                                if(typeof obj_detalle != 'undefined'){
                                    obj_detalle.fnTablaDocumentos();
                                }
                                break;
                       }
                   });
                }
                
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
                inicio.registroNoOk();
            }
   });
}

function armadoAlert(clase, texto){
    $("#frm").append('<div id="alertFile" class="alert alert-'+clase+' alert-dismissible fade show" role="alert">'
                +'  '+texto
                +'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                +'<span aria-hidden="true">&times;</span>'
                +'</button>'
                +'</div>');

    setTimeout(function(){ 
        $("#alertFile").alert("close"); 
    }, 6000);
}

function resetFormSubir(){
    $("#xBtnSubir").attr("disabled", true);
    $("#xLblArchivo").text("Escoge un archivo");
}

$(document).ready(function () {
    objArchivo = new ProcesoArchivo();

    console.log("proceso: " + cve_proceso_documento);
    $("#xBtnSubir").attr("disabled", true);    
    
    // CARGA DE ARCHIVOS

    $("#frm").on("submit", (function(e){
        e.preventDefault();
        $.ajax({
            url: "vista/procesos/upload.php",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend : function()
            {

            },
            success: function(data)
            {
                var estado;
                estado = data.split(",");
                console.log(estado[1] + " - " + estado[2]);
                switch(estado[0])
                {
                    case "\r\n    1":
                        armadoAlert("danger", "Ya existe un archivo con el mismo nombre.");
                        resetFormSubir();
                        break;
                    case "\r\n    2":
                        armadoAlert("danger", "El archivo debe tener un peso menor a 10MB.");
                        resetFormSubir();
                        break;
                    case "\r\n    3":
                        armadoAlert("danger", "Sólo se admiten archivos con extensión JPG, JPEG, PNG, GIF, PDF, WORD y EXCEL.");
                        resetFormSubir();
                        break;
                    case "\r\n    succ":
                        //$("#modalSubirArchivo").modal('hide');
                        objArchivo.fnSubirArchivo(estado[1], estado[2]);
                        //armadoAlert("success", "El archivo se subio con éxito.");
                        
                        resetFormSubir();
                        break;
                    case "\r\n    error":
                        armadoAlert("danger", "Inténtalo de nuevo más tarde.");
                        resetFormSubir();
                        break;
                }
            },
            error: function(e) 
            {
                console.log(e)
            }          
        });      
    }));
    
     $("#xFile").change(function(e){
         console.log(e.target.files[0].name);
         $("#xLblArchivo").text(e.target.files[0].name);
         if($("#xLblArchivo").text()!="Escoge un archivo")
         {
            $("#xBtnSubir").attr("disabled", false);
         }
    });

    $("#btnModal").click(function(e){
        $("#modalSubirArchivo").modal("show");
    });
});