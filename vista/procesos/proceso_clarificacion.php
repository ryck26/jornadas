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
                                    <v-row justify="left" >
                                       <span    style="color:#ffffff;" >De no ser los correctos por favor envía un correo a:</span>
                                    </v-row>
                                    <v-row justify="left" >
                                       <span    style="color:#ffffff;" ><b>Correo@utleo.edu.mx</b></span>
                                    </v-row>
                                    <v-row justify="center" >
                                        <v-btn  color="#00185F" dark @click="continuar=true">Continuar</v-btn> &nbsp; 
                                        <v-btn color="error" @click="fnRegresar">Regresar</v-btn>
                                    </v-row>
                                </v-container>
                                
                                
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
                                            <v-img src="../../resource/img/Screenshot_11.png" contain ></v-img>
                                        </v-col>
                                    </v-row>
                                    <!--STEPPER PARA TSU-->
                                        <v-row justify="center"   >
                                            <v-col md="12" lg="12">
                                            <v-stepper v-model="tsu">
                                                <v-stepper-header>
                                                  <v-stepper-step :complete="tsu > 1" step="1">VIDEO SENSIBILIZADOR</v-stepper-step>

                                                  <v-divider></v-divider>
                                                  
                                                  <v-stepper-step :complete="tsu > 2" step="2">VIDEOS DE PROMOCIÓN E INSTRUMENTO DE AUTOCONOCIMIENTO</v-stepper-step>

                                                  <v-divider></v-divider>

                                                  <v-stepper-step step="3">CONSTANCIA</v-stepper-step>
                                                </v-stepper-header>

                                                <v-stepper-items>
                                                  <v-stepper-content step="1">
                                                    <v-card
                                                      class="mb-12"
                                                     
                                                      height="620px"
                                                      >
                                                        <v-container>
                                                            <v-row justify="center" align="center">
                                                                <v-col col="12">
                                                                    <h2 style="color:#00185f" >Video sensibilizador</h2>
                                                                </v-col>    
                                                            </v-row>
                                                            <v-row >
                                                                <v-col col="12">
                                                                <h3 style="color:#00185f" >Bienvenido</h3>
                                                                </v-col>    
                                                            </v-row>
                                                            <v-row >
                                                                <v-col col="12">
                                                                    <span style="color:#00185f" >
                                                                        Te solicitamos veas el siguiente video con atención...
                                                                    </span>
                                                                </v-col>
                                                            </v-row>
                                                            <v-row justify="center" align="center" >
                                                                <!-- <v-col  > -->
                                                                    <iframe width="760" height="355" 
                                                                        src="https://www.youtube-nocookie.com/embed/LQuzt9k1kSY" 
                                                                        title="Video sensibilizador" 
                                                                        frameborder="0" 
                                                                        allow="accelerometer;  clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                                        allowfullscreen></iframe>
                                                                <!-- </v-col>     -->
                                                            </v-row>
                                                            <v-row  class="d-flex justify-space-between" >
                                                             <v-btn color="error" @click="fnRegresar" >Cerrar sesión</v-btn> 
                                                            <v-btn dark color="#00185f" @click="tsu=2" >Actividad 2</v-btn>
                                                        </v-row>
                                                        </v-container>
                                                    </v-card>
                                                  </v-stepper-content>
                                                  <v-stepper-content step="2">
                                                    <v-card
                                                      class="mb-12"
                                                     
                                                      height="1120px"
                                                      >
                                                        <v-container>
                                                            <v-row justify="center" align="center">
                                                                <h2 style="color:#00185f" >Video profesor</h2>
                                                            </v-row>
                                                            <v-row justify="center" align="center">
                                                                    <iframe width="760" height="415" src="https://www.youtube-nocookie.com/embed/lOV2WDsNfo8" 
                                                                    title="Video profesor" 
                                                                    frameborder="0" 
                                                                    allow="accelerometer;  clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                                    allowfullscreen></iframe>
                                                            </v-row>
                                                            <br>
                                                            <v-row justify="center" align="center">
                                                                <h2 style="color:#00185f" >Video egresado</h2>
                                                            </v-row>
                                                            <v-row justify="center" align="center">
                                                                    <iframe width="760" height="415" src="https://www.youtube-nocookie.com/embed/lOV2WDsNfo8" 
                                                                    title="Video egresado" 
                                                                    frameborder="0" 
                                                                    allow="accelerometer;  clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                                    allowfullscreen></iframe>
                                                            </v-row>
                                                            <v-row justify="center" align="center">
                                                                <h3 style="color:#00185f" >Instrumento</h3>
                                                            </v-row>
                                                            <v-row justify="center" align="center">
                                                                <v-col>
                                                                        Te solicitamos llenar el siguiente formulario de la forma más atenta  y sincera...
                                                                </v-col>
                                                            </v-row>
                                                            <v-row justify="center" align="center">
                                                                <v-btn dark color="#00185f"  >Encuesta</v-btn>
                                                            </v-row>
                                                            <v-row class="d-flex justify-space-between" >
                                                                <v-btn color="error" @click="tsu=1" >REGRESAR</v-btn>
                                                                <v-btn dark color="#00185f" @click="tsu=3" >Actividad 3</v-btn>   
                                                            </v-row>
                                                        </v-container>
                                                    </v-card>
                                                  </v-stepper-content>
                                                  <v-stepper-content step="3">
                                                  <v-card
                                                      class="mb-12"
                                                     
                                                      height="120px"
                                                      >
                                                     <v-container>
                                                        <v-row justify="center" align="center">
                                                                <v-btn dark  color="#00185f"  >Constancia</v-btn>
                                                        </v-row>   
                                                        <v-row class="d-flex justify-space-between" >
                                                            &nbsp; 
                                                            <v-btn color="error" @click="fnRegresar" >Cerrar sesión</v-btn>
                                                          </v-row>
                                                        </v-container>
                                                    <v-card>    
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