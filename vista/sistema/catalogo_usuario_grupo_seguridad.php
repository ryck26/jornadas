<?php
/*
 * Titulo			            : catalogo_modulo.php
 * Descripción                  : CRUD  de modulos para el sistema
 * Compañía			            :  UTL  
 * Fecha de creación            : 10-07-2020
 * Desarrollador                : Ricardo FRanco
 * Versión			            : 1.0
 */
?>
<div id="app2" data-script="../../controlador/js/sistema/catalogo_usuario_grupo_seguridad.js">
    <v-app>
        <v-container fluid>
            <v-card raised>
                <v-toolbar dark color="primary">
                    <h2>Asignar usuario a perfil</h2>
                </v-toolbar>
                <v-card flat>
                    <v-card-actions>
                        <v-container>
                            <v-row>
                                <v-col>
                                    <v-select label="Nombre del perfil" 
                                    v-model="cve_grupo_seguridad"
                                    :items="combo_grupo" 
                                    item-value="cve_grupo_seguridad"
                                    item-text="nombre"
                                    :loading="loading" @change="combo_menu= [], fnUsuarios(),fnListaTabla()" >
                                    </v-select>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <v-combobox label="Usuario" 
                                    v-model="cve_persona" 
                                    :items="combo_usuario" 
                                    item-value="cve_persona"
                                    item-text="nombre"
                                    @change="guardar=1"
                                    :loading="loading">
                                    </v-combobox>
                                </v-col>
                            </v-row>

                            <v-row aling="center" justify="center">
                                <v-btn v-if="guardar==1" @click="fnGuardar" :loading="loading" color="primary">
                                    Agregar
                                </v-btn>

                                &nbsp;
                                <v-btn @click="fnLimpiar" :loading="loading" color="warning">
                                    Limpiar
                                </v-btn>
                            </v-row>
                            <v-row>
                                <v-col>
                                    &nbsp;
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <v-card>
                                        <v-card-title>
                                            Perfiles
                                            <v-spacer></v-spacer>
                                            <v-text-field v-model="search" append-icon="mdi-filter" label="Buscar" single-line hide-details></v-text-field>
                                        </v-card-title>
                                        <v-data-table :headers="headers" :items="tabla" :search="search" :loading="loading">
                                            <template v-slot:item.nombre="{ item }">
                                                {{item.nombre}} {{item.paterno}} {{item.materno}}
                                            </template>
                                            <template v-slot:item.eliminar="{ item }">
                                                <v-btn @click="fnEliminar(item)" :loading="loading" color="error">
                                                    Eliminar
                                                </v-btn>
                                            </template>
                                        </v-data-table>
                                    </v-card>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-actions>
                </v-card>
                </v-card-actions>

            </v-card>
        </v-container>
        <!-- COMPONENETE PARA ALERTAS -->
        <v-snackbar v-model="snackbar" timeout="3000" :color="color_mensaje" shaped bottom>
            {{mensaje}}

            <template v-slot:action="{ attrs }">
                <v-btn color="white" text v-bind="attrs" @click="snackbar = false">
                    Cerrar
                </v-btn>
            </template>
        </v-snackbar>
    </v-app>
</div>