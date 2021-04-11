<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>

<head>
    <meta charset="UTF-8">
    <!-- <title>Colonia</title> -->
</head>

<body>
    <!--Contenedor principal(Fondo blanco)-->
    <div class="contenedorA" id="contenedorA">
        <div class="row mt-3 ">
            <div class="col">

                <!--Contenedor Secundario (Contenedor con sombra)-->
                <div class="card contenedorB" id="contenedorB">

                    <div class="card-header bg-info ">
                        <h3 class="text-light"><b>Reporte de Compromisos</b></h3>
                    </div>
                    <div class="container-fluid">  
                        <br>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label for="xCmbConsejo"><b>Lista de consejos: <span class="text-danger">*</span> </b></label>
                                <!-- optionsValue asigna el valor, pero para acceder a el se debe usar la propiedad value, y asignarle un nombre de variable(selectConsejo) -->
                                <select class="custom-select" data-bind="options: opcionesConsejo, 
                                optionsCaption: 'Selecciona un consejo',
                                optionsText: 'nombre',
                                optionsValue: 'id',
                                value: Modelo.cve_consejo,
                                css:{'is-invalid': Modelo.cve_consejo.hasError}" name="xCmbConsejo" id="xCmbConsejo" class="form-control">
                                    <!-- <option value=""></option> -->
                                </select>
                                <div data-bind="text: Modelo.cve_consejo.errorMessage" class="invalid-tooltip">error</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label for="xCmbSesion"><b>Lista de sesiones: <span class="text-danger">*</span> </b></label>
                                <!-- optionsValue asigna el valor, pero para acceder a el se debe usar la propiedad value, y asignarle un nombre de variable(selectConsejo) -->
                                <select class="custom-select" data-bind="options: opcionesSesion, 
                                optionsCaption: '',
                                optionsText: 'nombre',
                                optionsValue: 'cve_sesion',
                                value: Modelo.cve_sesion,
                                css:{'is-invalid': Modelo.cve_sesion.hasError}" title="responsable" name="xCmbSesion" id="xCmbSesion" class="form-control">
                                    <!-- <option value=""></option> -->
                                </select>
                                <div data-bind="text: Modelo.cve_sesion.errorMessage" class="invalid-tooltip">error</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label for="xCmbResponsable"><b>Participante: <span class="text-danger">*</span> </b></label>
                                <!-- optionsValue asigna el valor, pero para acceder a el se debe usar la propiedad value, y asignarle un nombre de variable(selectConsejo) -->
                                <select class="custom-select" data-bind="options: opcionesParticipante, 
                                optionsCaption: '',
                                optionsText: 'nombre',
                                optionsValue: 'cve_participante',
                                value: Modelo.cve_participante,
                                css:{'is-invalid': Modelo.cve_participante.hasError}" title="responsable" name="xCmbParticipante" id="xCmbParticipante" class="form-control">
                                    <!-- <option value=""></option> -->
                                </select>
                                <div data-bind="text: Modelo.cve_participante.errorMessage" class="invalid-tooltip">error</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">&nbsp;
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">&nbsp;
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h3>Compromisos</h3>
                                <hr>
                            </div>
                        </div>
                        <br>

                        <!-- Tabla -->

                        <div class="row">
                            <div class="col-12">
                                <table id="xTablaCompromisos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="display: none"></th>
                                            <th class="col-1">No.</th>
                                            <th class="col-md-10">Titulo</th>
                                            <th class="col-md-1">Detalles</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td  class="dataTables_empty">&nbsp;</td>
											<td></td>
											<td></td>
											
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--Fin container-->
                    </div>

                    <!--Fin Contenedor Secundario (Contenedor con sombra)-->
                </div>
            </div>
        </div>
        <!--Fin Contenedor principal(Fondo blanco)-->

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document" style=" max-width:90%">
                <div class="modal-content">
                    <div class="modal-header text-white bg-primary">
                        <h4 class="modal-title" id="exampleModalLabel">Detalles del compromiso</h4>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <div class="modal-body">
                    <div class="row"> 
                        <div class="col-3">
                            <h6><b>Consejo:</b></h6>
                        </div>
                        <!-- <div class="col-9"> -->
                            <h6><span data-bind='text: modNombreConsejo'></span></h6>
                        <!-- </div> -->
                    </div>
                    <div class="row"> 
                        <div class="col-3">
                            <h6><b>Compromiso:</b></h6>
                        </div>
                        <h6><span data-bind='text: modTituloCompromiso'></span></h6>
                    </div>
                    <div class="row"> 
                        <div class="col-3"><h6><b>Descripcion:</b></h6></div>
                        <div class="col-9"><h6><span data-bind='html: modDescripcionCompromiso'></span></h6></div>
                    </div>
                    <div class="row"> 
                        <div class="col-3">
                            <h6><b>Fecha de registro:</b></h6>
                        </div>
                        <h6><span data-bind='text: modFechaRegistro'></span></h6>                    
                    </div>
                    <div class="row"> 
                        <div class="col-3">
                            <h6><b>Fecha de cumplimiento:</b></h6>
                        </div>
                        <span data-bind='text: modFechaCumplimiento'></span></h6>
                    </div>
                    <div class="row"> 
                        <div class="col-3">
                            <h6><b>Porcentaje de avance:</b></h6>
                        </div>
                    </div>
                    <div class="progress" style="height: 20px;">
                        <div id="barraProgreso" class="progress-bar bg-success" role="progressbar" style="width: 25%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><span data-bind='text: modPorcentaje'></span></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <table id="xTablaAvances" class="table table-striped table-bordered" cellspacing="0" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="display: none"></th>
                                        <th class="col-10">Nota</th>
                                        <th class="col-1">Avance</th>
                                        <th class="col-1">Estatus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="5" class="dataTables_empty">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    
                    </div>
                    
                    <!-- <span data-bind='text: modPorcentaje'></span><br> -->
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Desarrollo -->
        <script type="text/javascript" src="controlador/js/reportes/reporte_compromisos.js"></script>
    </div>
    <div id="contenedorModal"></div>

</body>

</html>