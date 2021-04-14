<?php
/*
 * Titulo			            : inicio.php
 * Descripción                  : Componentes de la interfaz grafica de inicio
 * Compañía			            : 
 * Fecha de creación            : 02-mayo-2017
 * Desarrollador                : Oscar
 * Versión			            : 1.0
 * ID Requerimiento             : 
 */
//var_dump($_SESSION["USUARIO"][0]);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Jornada de Clarificación UTL 2021</title>
        
    </head>
    <body>
        <div id="app2"  data-script="../../controlador/js/procesos/proceso_clarificacion.js" 
            data-pdf="../../resource/jsPDF/jspdf.min.js"
           
        >
            <v-app >
            <v-main >
                <!-- <v-container style="padding-top: 5px !important;" > -->
                <v-row  v-if="!continuar" >
                        <v-col>
                            <v-card
                                class="rounded-xl"
                                height="350"
                                max-width="100%"
                                raised 
                                color="#F7903B"
                                >
                                <!-- ENCABEZADO INTERFAZ-->
                                <br>
                                <br>
                                <v-card-title  style=" color:#ffffff; " >
                                    Verifica que tus datos sean correctos   
                                </v-card-title>
                                <v-container  >
                                <br>
                                    <!--   contenido-->
                                    <v-row justify="center">
                                        <v-avatar color="secondary">
                                            <span class="white--text headline"><?=$_SESSION["USUARIO"][0]["nombre"][0]?><?=$_SESSION["USUARIO"][0]["apellido_paterno"][0]?></span>
                                        </v-avatar>
                                    </v-row>
                                    <br>
                                    <v-row justify="left"  >
                                      <h3 style="color:#ffffff;">Nombre:  <?=$_SESSION["USUARIO"][0]["nombre"]?> <?=$_SESSION["USUARIO"][0]["apellido_paterno"]?> <?=$_SESSION["USUARIO"][0]["apellido_materno"]?> </h2>
                                    </v-row>
                                    <v-row justify="left">
                                        <h3 style="color:#ffffff;">Carrera: <?=$_SESSION["USUARIO"][0]["titulo_carrera"]?></h2> 
                                    </v-row>
                                    <br>
                                    <br>
                                    <v-row justify="center" >
                                       <span    style="color:#ffffff;" >De no ser los correctos por favor envía un correo a:</span> 
                                    </v-row>
                                    <br>
                                    <v-row justify="center" >
                                        <v-btn  color="#00185F" dark @click="continuar=true">Continuar</v-btn> &nbsp; 
                                        <v-btn color="error" @click="fnRegresar">Regresar</v-btn>
                                    </v-row>
                                </v-container>
                                <br>
                            </v-card>
                        </v-col>
                    </v-row>
                    <v-row v-else>
                        <v-col  >
                            <v-card
                                class="mx-auto"
                                max-width="100%"
                                raised 
                                >

                                <v-container fluid >
                                <br>
                                    <!--   contenido-->
                                    <v-row justify="center">
                                        <v-avatar color="secondary">
                                        <span class="white--text headline"><?=$_SESSION["USUARIO"][0]["nombre"][0]?><?=$_SESSION["USUARIO"][0]["apellido_paterno"][0]?></span>
                                        </v-avatar>
                                    </v-row>
                                    <v-row>
                                        <v-col>
                                           <h3 style="color:#00185f" > En que consiste la jornada de clarificación:</h3>
                                        </v-col>
                                    </v-row>
                                    <v-row  >
                                        <v-col>
                                           <p>
                                           Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                           </p>
                                        </v-col> 
                                    </v-row>
                                    <v-row>
                                        <v-col>
                                            <h3 style="color:#00185f" > Objetivo: </h3>
                                        </v-col>
                                    </v-row> 
                                    <v-row>    
                                        <v-col>
                                            <p>
                                            It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here'
                                            </p>
                                        </v-col>
                                    </v-row>
    
                                    <v-row  >
                                        <v-col>
                                            
                                        </v-col>
                                    </v-row>
                                    <!--STEPPER PARA TSU-->
                                        <v-row justify="center"   >
                                            <v-col md="12" lg="12">
                                            <v-stepper v-model="tsu">
                                                <v-stepper-header>
                                                  <v-stepper-step :complete="tsu > 1" step="1">ACTIVIDAD 1</v-stepper-step>

                                                  <v-divider></v-divider>
                                                  
                                                  <v-stepper-step :complete="tsu > 2" step="2">ACTIVIDAD 2</v-stepper-step>

                                                  <v-divider></v-divider>

                                                  <v-stepper-step step="3">ACTIVIDAD 3</v-stepper-step>
                                                </v-stepper-header>

                                                <v-stepper-items>
                                                  <v-stepper-content step="1">
                                                    <v-card
                                                      class="mb-12"
                                                      color="grey lighten-4"
                                                      height="420px"
                                                      >
                                                        <v-container>
                                                           
                                                            <v-row justify="center" align="center">
                                                                <br>
                                                                <iframe width="560" height="415" 
                                                                src="https://www.youtube-nocookie.com/embed/LQuzt9k1kSY" 
                                                                title="YouTube video player" 
                                                                frameborder="0" 
                                                                allow="accelerometer;  clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                                allowfullscreen></iframe>
                                                               
                                                            </v-row>
                                                            
                                                        </v-container>
                                                    </v-card>
                                                      <v-container>
                                                          <v-row  class="d-flex justify-space-between" >
                                                            <!-- <v-btn color="error" @click="fnRegresar" >Cerrar sesión</v-btn> -->
                                                            <v-btn color="success" @click="tsu=2" >Continuar</v-btn>
                                                        </v-row>
                                                      </v-container>
                                                      
                                                    
                                                  </v-stepper-content>

                                                  <v-stepper-content step="2">
                                                    <v-card
                                                      class="mb-12"
                                                      color="green lighten-4"
                                                      height="420px"
                                                      >
                                                        <v-container>
                                                            
                                                            <v-row justify="center" align="center">
                                                            <iframe width="560" height="415" src="https://www.youtube-nocookie.com/embed/lOV2WDsNfo8" 
                                                            title="YouTube video player" 
                                                            frameborder="0" 
                                                            allow="accelerometer;  clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                            allowfullscreen></iframe>
                                                            </v-row>
                                                            
                                                        </v-container>
                                                          
                                                    </v-card>
                                                      <v-container>
                                                          <v-row class="d-flex justify-space-between" >
                                                          <v-btn color="error" @click="tsu=1" >REGRESAR</v-btn>
                                                            <v-btn color="success" @click="tsu=3" >CONTINUAR</v-btn>
                                                        </v-row>
                                                      </v-container>
                                                  </v-stepper-content>

                                                  <v-stepper-content step="3">
                                                        <v-row>
                                                            <v-col>
                                                                <!-- <v-card>
                                                                    <v-card-title>
                                                                        DOCUMENTOS PERSONALES: 
                                                                    </v-card-title>
                                                                    <v-card-subtitle>
                                                                        Estimado aspirante, es importante, para realizar tu inscripción, ingreses al sistema cada uno de los documentos que a continuación se listan, en caso de faltar algún documento, no pondrás completar la entrega
                                                                    </v-card-subtitle>
                                                                    <v-card-text>
                                                                        <ul>
                                                                            <li>CURP actualizado (consúltalo aquí: <a target="_blank" href="https://www.gob.mx/curp/">CURP</a>)</li>
                                                                            <li>Acta de Nacimiento</li>
                                                                            <li>Certificado de preparatoria original o Constancia de estudios emitida por la institución o boleta de calificaciones emitida por la institución (Si no cuentas con tu certificado, éste deberás presentarlo en original a más tardar en el mes de noviembre de 2020).</li>
                                                                            <li>Referencias de pago y comprobantes de los tres pagos generados.
                                                                                <span style="color:red"><b>Nota:</b> integra en un solo archivo las tres referencias seguidas de cada uno de sus pagos</span></li>
                                                                            <li>Fotografía de cuello y cara del interesado a color.</li>
                                                                            <li>Comprobante de Seguridad Social Publica.</li>
                                                                            <li>Comprobante de encuesta SUREDSU.</li>

                                                                        </ul>
                                                                        <v-row>
                                                                            <v-col>
                                                                               <b> Recuerde que debes de resguardar tus documentos originales, ya que te serán solicitados posteriormente. </b>
                                                                            </v-col>
                                                                        </v-row>
                                                                        <v-row>
                                                                            <v-col>
                                                                                A continuación, deberás subir cada documento, cerciórate de que cada imagen este clara y entendible, además de que este ubicada en el apartado correspondiente, ya que encaso de presentar una inconsistentica en la revisión, te la haremos saber por medio del correo que tenemos registrado, por lo que te pedimos estar pendiente de el, debido a que sólo se procederá a la inscripción una vez que este tu documentación completa y clara.
                                                                            </v-col>
                                                                        </v-row>
                                                                    </v-card-text>
                                                                </v-card>-->
                                                            </v-col>
                                                        </v-row> 
                                                    <v-row>
                                                        <v-col>

                                                        </v-col>
                                                    </v-row>   
                                                    <v-row>
                                                        <v-col>
                                                            <v-container>
                                                            <v-row class="d-flex justify-space-between" >
                                                              <v-btn color="secondary" >
                                                                    
                                                                  Encuesta
                                                              </v-btn> &nbsp; 
                                                              <v-btn color="error" @click="fnRegresar" >Cerrar sesión</v-btn>
                                                          </v-row>
                                                        </v-container>
                                                        </v-col>
                                                    </v-row>  
                                                      
                                                  </v-stepper-content>
                                                </v-stepper-items>
                                              </v-stepper>
                                            </v-col>    
                                        </v-row>
 
                       
                                    
                                     <v-row justify="center">
                                        <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
                                          <v-card>
                                            <v-toolbar dark color="secondary">
                                              <v-btn icon dark @click="dialog = false">
                                                <v-icon>mdi-close</v-icon>
                                              </v-btn>
                                              <v-toolbar-title>Carreras</v-toolbar-title>
                                              <v-spacer></v-spacer>
                                              
                                            </v-toolbar>
                                            <v-divider></v-divider>
                                            <v-container fluid>

                                
                                            </v-container>
                                          </v-card>
                                        </v-dialog>
                                      </v-row>
                                </v-container>
                            </v-card>
                        </v-col>
                    </v-row>

                    <!-- TODO: ALERTAS DE SISTEMA-->
                    <v-snackbar v-model="snackbar" top="top" :bottom="true" :multi-line="true" :color="color_mensaje">
                        {{mensaje_alerta}}
                        <v-icon color="white" @click="snackbar=false">mdi-close-circle</v-icon>
                    </v-snackbar>
                <!-- </v-container> -->
                </v-main>
            </v-app>
        </div>    
    </body>

    <!-- Desarrollo -->
    <!-- <script src="../../controlador/js/procesos/proceso_clarificacion.js"></script> -->
</html>