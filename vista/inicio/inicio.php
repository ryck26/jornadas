<?php

/*
 * Titulo			            : inicio.php
 * Descripción                  : Componentes de la interfaz grafica de inicio
 * Compañía			            : 
 * Fecha de creación            : 02-mayo-2017
 * Desarrollador                : Oscar
 * Versión			            : 1.0
 * ID Requerimiento             : 
 * ACTUALIZACIÓN
 * Desarrolador                 : Ricardo Franco
 * Versión                      : 2.0
 * Descripción                  : restructuración, creado en base a componentes de vuetify y con vueJS
 */

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Jornada de Clarificación UTL 2021</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <script type="" src="resource/lib/vue/vue.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <title>Jornada de Clarificación UTL 2021</title>
    <link href="resource/icon/mdi/css/materialdesignicons.min.css" rel="stylesheet" />
    <link href="resource/lib/vuetify/vuetify.min.css" rel="stylesheet" />
    <script src="resource/lib/vuetify/vuetify.min.js"></script>
    <script src="resource/lib/axios/axios.js"></script>
    <script src="resource/lib/lodash/lodash.js"></script>

    <style>
    .activar{
        color: red !important;
    }
    </style>
</head>

<body>
    <div id="app">
        <v-app>
            <!-- <v-navigation-drawer v-model="drawer" app  temporary>
                <v-layout mt-4 mb-2 column align-center>
                <v-flex>
                        <v-avatar color="indigo">
                            <v-icon dark>mdi-account-circle</v-icon>
                        </v-avatar>
                    </v-flex>
                    <v-flex>
                        <p class=""><?= $_SESSION["USUARIO"]["nombre"] . " " . $_SESSION["USUARIO"]["paterno"] ?></p>
                    </v-flex>
                </v-layout>
                <v-divider></v-divider>
              
                
                <!-- menu -->
                <v-list  dense >
                <template 
                 v-for="item in items" 
                 :key="item.title"
                >
                   
                
                <v-list-item 
               
                active-class="activar"
                v-if="_.isEmpty(item.items)"  
                
                @click="cargarHtml(item), drawer = !drawer"  >
                    <v-list-item-icon>
                    <v-icon>mdi-menu-right</v-icon>
                    </v-list-item-icon>

                    <v-list-item-title    >{{item.nombre}}</v-list-item-title>
                </v-list-item>
            
                <v-list-group v-if="!_.isEmpty(item.items)"   no-action sub-group active-class >
                    <template v-slot:activator>
                        <v-list-item-title v-text="item.nombre"></v-list-item-title>
                    </template>
                    
                    <v-list-item  v-for="subItem in item.items" :key="subItem.cve_menu" @click="cargarHtml(subItem), drawer = !drawer" link>
                        <v-list-item-title> {{subItem.nombre}} </v-list-item-title>
                        
                    </v-list-item>
                </v-list-group>
                </template>
            <!-- </v-list> -->
           
                <!-- fin menú -->
            <!-- </v-navigation-drawer> --> -->

            <v-app-bar app color="#00185F" dark>
                <!-- <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon> -->
                <v-toolbar-title> Jornada de Clarificación UTL 2021</v-toolbar-title>
                <v-spacer></v-spacer><?=$_SESSION["USUARIO"][0]["nombre"]?> <?=$_SESSION["USUARIO"][0]["apellido_paterno"]?>
                <v-btn fab icon @click="logout">
                    <v-icon>mdi-logout-variant</v-icon>
                </v-btn>
            </v-app-bar>
            <v-main>
                <v-container fluid>
                    <v-row>
                        <v-col lg="12" md="12"  >
                            <section id="contenido-sitio" >
                            
                            </section>
                        </v-col>
                    </v-row>
                </v-container>
            </v-main>
            
            
            <v-overlay :value="overlay">
                <v-progress-circular indeterminate size="64"></v-progress-circular>
            </v-overlay>
        </v-app>
        
</body>
<!--Scripts del sitio-->
<script src="controlador/js/inicio/inicio.js"></script>

</html>