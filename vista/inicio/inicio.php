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
<html lang="es">

<head>
    <title>Formación Dual</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <script type="" src="../../resource/lib/vue/vue.min.js" ></script>

    <title>Jornada de Clarificación UTL 2021o</title>
    <link href="../../resource/icon/mdi/css/materialdesignicons.min.css" rel="stylesheet" />
    <link href="../../resource/lib/vuetify/vuetify.min.css" rel="stylesheet" />
    <script src="../../resource/lib/vuetify/vuetify.min.js" ></script>
    <script src="../../resource/lib/axios/axios.js" ></script>

</head>

<body>
    <div  id="app">
    <v-app>
            <v-navigation-drawer
                v-model="drawer"
                app
                dense
                temporary
                >
                <v-layout mt-4 mb-2 column align-center> 
                    <v-flex>
                        <v-avatar color="primary">
                            <v-icon dark>mdi-account-circle</v-icon>
                        </v-avatar>
                    </v-flex>
                    <v-flex>
                        <p class=""><?//= $_SESSION["USUARIO"]["nombre"] . " " . $_SESSION["USUARIO"]["paterno"] ?></p>
                    </v-flex>
                </v-layout>
                <v-divider  ></v-divider>
                <!-- menu -->
                <!-- <v-list>
                    <v-list-item
                        v-model="menu1"
                        
                        color="indigo"
                        no-action
                        sub-group
                        active-class="pink--text"
                        @click="cargarPlantilla(1)"
                    >
                        <v-list-item-icon>
                            <v-icon>mdi-clipboard-list</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Asistencia a cursos</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item
                        v-model="menu2"
                        v-if="false"
                        color="indigo"
                        no-action
                        sub-group
                        active-class="pink--text"
                        @click="cargarPlantilla(2)"
                    >
                        <v-list-item-icon>
                            <v-icon>mdi-table-large-plus</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Constancias</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    
                </v-list> -->
            
                <!-- fin menú -->
                </v-navigation-drawer>

                <v-app-bar
                app
                color="primary"
                dark
                >
                    <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
                    <v-toolbar-title>Jornada de Clarificación UTL 2021</v-toolbar-title>
                    <v-spacer></v-spacer>
                    
                    <v-btn fab icon @click="logout">
                        <v-icon>mdi-logout-variant</v-icon>
                    </v-btn>
                </v-app-bar>

                <v-main id="contenido">
                <!-- <v-container
                    class="fill-height"
                    fluid
                >
                    <v-row
                    align="center"
                    justify="center"
                    >
                    <v-col class="text-center">
                        
                    </v-col>
                    </v-row>
                </v-container> -->
                </v-main>
                <v-overlay :value="overlay">
                    <v-progress-circular indeterminate size="64"></v-progress-circular>
                </v-overlay>
    </v-app>
</body>
<!--Scripts del sitio-->
    <script src="controlador/js/inicio/inicio.js"></script>
</html>