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

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Jornada de Clarificación UTL 2021</title>
        
    </head>
    <body>
    <script type="" src="../../resource/lib/vue/vue.min.js" ></script>
    <link href="../../resource/lib/vuetify/vuetify.min.css" rel="stylesheet" />
    <script src="../../resource/lib/vuetify/vuetify.min.js" ></script>
    <script src="../../resource/lib/axios/axios.js" ></script>
        <div id="app" >
            <v-app>
                <v-container fluid >
                    <v-row v-if="!continuar">
                        <v-col>
                            <v-card
                                class="mx-auto"
                                max-width="100%"
                                raised 
                                >
                                <!-- ENCABEZADO INTERFAZ-->
                                <v-card-title  style="background-color: #FF0000; color:#ffffff; " >
                                    Información interesado
                                </v-card-title>
                                <v-container fluid >
                                    <!--   contenido-->
                                    <v-row justify="center">
                                        <v-avatar color="secondary">
                                            <span class="white--text headline">RF</span>
                                        </v-avatar>
                                    </v-row>
                                    <v-row justify="center" >
                                        Nombre Paterno Materno
                                    </v-row>
                                    <v-row justify="center">
                                        Carrera
                                        
                                    </v-row>
                                    <v-row justify="center" >
                                        ¿Eres tú?
                                    </v-row>
                                    <v-row justify="center" >
                                        <v-btn  color="success" @click="continuar=true">Continuar</v-btn> &nbsp; 
                                        
                                        <v-btn color="error" @click="fnRegresar">Regresar</v-btn>
                                    </v-row>
                                </v-container>
                            </v-card>
                        </v-col>
                    </v-row>
                    <v-row v-if="continuar">
                        <v-col  >
                            <v-card
                                class="mx-auto"
                                max-width="100%"
                                raised 
                                >
                                <!-- ENCABEZADO INTERFAZ-->
                                <v-card-title  style="background-color: #00b293; color:#ffffff; " >
                                    Información Aspirante
                                    
                                </v-card-title>
                                <v-container fluid >
                                    
                                    <!--   contenido-->
                                    <v-row justify="center">
                                        <v-avatar color="secondary">
                                            <span class="white--text headline">
                                               RF
                                            </span>
                                        </v-avatar>
                                    </v-row>
                                    <v-row  >
                                        <v-col>
                                            <v-banner  >
                                                <h4>En que consiste la Jornada de Clarificación:</h4>

                                            </v-banner>
                                            <v-divider></v-divider>
                                            <p>Objetivo:</p>
                                            <p>Dinámica a seguir:</p>
    
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col>
                                            DATOS DEL INTERESADO :
                                        </v-col>
                                    </v-row>
                                    <v-row  >
                                        <v-col>
                                            Folio: <b>000002</b>
                                        </v-col> 
                                    </v-row>
                                    <v-row  >
                                        <v-col>
                                            Nombre: <b>Nombre paterno Materno</b>
                                        </v-col> 
                                    </v-row>
                                    <v-row  >
                                        <v-col>
                                            Correo: <b>correo@correo.com </b>
                                        </v-col> 
                                    </v-row>
                                    <v-row  >
                                        <v-col>
                                            Carrera: <b>carrera</b>
                                        </v-col>
                                    </v-row>
                                    <v-row  >
                                        <v-col>
                                            Unidad académica: <b>unidad académica</b>
                                        </v-col> 
                                    </v-row>    
                                    <v-row  >
                                        <v-col>
                                            
                                        </v-col>
                                    </v-row>
                                    <!--STEPPER PARA TSU-->
                                        <v-row justify="center" v-if="<%=cve_nivel_estudio%> == 1 "  >
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
                                                      height="200px"
                                                      >
                                                        <v-container>
                                                           
                                                            <v-row justify="center" align="center">
                                                                
                                                               <v-btn  
                                                                      color="warning"
                                                                      
                                                                      fab large dark>
                                                                <v-icon>mdi-cached</v-icon>
                                                              </v-btn> 
                                                            </v-row>
                                                            
                                                        </v-container>
                                                    </v-card>
                                                      <v-container>
                                                          <v-row  class="d-flex justify-space-between" >
                                                            <v-btn color="error" @click="fnRegresar" >Cerrar sesión</v-btn>
                                                        </v-row>
                                                      </v-container>
                                                      
                                                    
                                                  </v-stepper-content>

                                                  <v-stepper-content step="2">
                                                    <v-card
                                                      class="mb-12"
                                                      color="green lighten-4"
                                                      height="100px"
                                                      >
                                                        <v-container>
                                                            
                                                            <v-row justify="center" align="center">
                                                                <v-btn  
                                                                       color="warning" 
                                                                       
                                                                       fab large dark>
                                                                <v-icon>mdi-cached</v-icon>
                                                              </v-btn>
                                                            </v-row>
                                                            
                                                        </v-container>
                                                          
                                                    </v-card>
                                                      <v-container>
                                                          <v-row class="d-flex justify-space-between" >

                                                            <v-btn color="error" @click="fnRegresar" >Cerrar sesión</v-btn>
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
                                                                </v-card>
                                                            </v-col>
                                                        </v-row> -->
                                                    <v-row>
                                                        <v-col>

                                                        </v-col>
                                                    </v-row>   
                                                    <v-row>
                                                        <v-col>
                                                            <v-container>
                                                            <v-row class="d-flex justify-space-between" >
                                                              <v-btn color="secondary" 
                                                                    
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
                </v-container>
            </v-app>
        </div>    
    </body>

    <!-- Desarrollo -->
    <script src="../../controlador/js/procesos/proceso_clarificacion.js"></script>
</html>