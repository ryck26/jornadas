<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- FavIcon (icono que se muestra en la pestaña del navegador) -->
        <link rel="shortcut icon" href="css_login/img/icons/favico.ico" />
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
        <script type="" src="../../resource/lib/vue/vue.min.js" ></script>

        <title>Jornada de Clarificación UTL 2021</title>
        <link href="../../resource/icon/mdi/css/materialdesignicons.min.css" rel="stylesheet" />
        <link href="../../resource/lib/vuetify/vuetify.min.css" rel="stylesheet" />
        <script src="../../resource/lib/vuetify/vuetify.min.js" ></script>
        <script src="../../resource/lib/axios/axios.js" ></script>
        <script src="../../resource/lib/lodash/lodash.min.js" ></script>
        <title>Jornada de Clarificación UTL 2021</title>
        <style>
            .bgwrap{
                background-color: rgb(0, 59, 119);
                background-position-x: 0%;
                background-position-y: 0%;
                background-repeat: repeat;
                background: url('images/login-bg.jpeg') #003b77;
                
                background-size: auto;
                background-origin: padding-box;
                background-clip: border-box;
            }
            /**/
        </style>
    </head>
    <body  >
        <div  id="app">
            <v-app style="background-color: rgb(0, 59, 119);
                background-position-x: 0%;
                background-position-y: 0%;
                background-repeat: repeat;
                background: url('resource/img/login-bg.jpeg') #003b77;
                
                background-size: auto;
                background-origin: padding-box;
                background-clip: border-box;">
                <v-container
                   class="fill-height"
                    fluid
                    
                    >
                    <v-row
                        align="center"
                        justify="center"
                        >
                        <v-col
                            cols="12"
                            sm="8"
                            md="4"
                            >
                            <v-card class="elevation-12">
                                <v-card-title>
                                    <v-img
                                        height="70"
                                        widht="120"
                                        contain
                                        src="resource/img/logo_app.png"
                                        >
                                        
                                    </v-img>
                                </v-card-title>
                                <v-toolbar
                                    flat
                                    >
                                    <v-row justify="center">
                                        <v-toolbar-title>Jornada de Clarificación UTL 2021</v-toolbar-title>
                                    </v-row>
                                    
                                </v-toolbar>
                                <v-card-text>
                                    <v-form>
                                        <v-text-field 
                                            v-model="folio"
                                            label="Folio Admisión"
                                            :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                            :type="show1 ? 'text' : 'password'"
                                            
                                            @click:append="show1 = !show1"
                                            ></v-text-field>

                                        <v-text-field 
                                            v-model="curp"
                                            :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
                                            :type="show2 ? 'text' : 'password'"
                                            label="CURP"
                                            
                                            @click:append="show2 = !show2"
                                            ></v-text-field>
                                    </v-form>
                                </v-card-text>
                                <v-card-actions>
                                    <v-container fluid>
                                    <v-row justify="center">
                                        <v-btn  :loading="loader" block @click="fnLogin" color="secondary">Iniciar Sesión</v-btn>
                                    </v-row>
                                    </v-container>
                                </v-card-actions>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-container>
            </v-app>
        </div>
    </body>

    <!-- Desarrollo -->
    <script src="controlador/js/inicio/inicio_sesion.js"></script>
</html>