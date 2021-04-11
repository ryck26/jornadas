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
<div id="app2" data-script="../../controlador/js/sistema/catalogo_grupo_seguridad.js">
    <v-app>
        <v-container fluid>
            <v-card raised >
                <v-toolbar dark color="primary">
                   <h2>Perfiles</h2> 
                </v-toolbar>
                <v-card flat>
                        <v-card-actions>
                                <v-container>
                                    <v-row>

                                        <v-col>
                                        <v-text-field
                                        label="Nombre del perfil" 
                                        v-model="nombre"
                                        :loading="loading"
                                        >
                                        </v-text-field>
                                        </v-col>
                                    </v-row>
                                   
                                    <v-row aling="center" justify="center">
                                        <v-btn  
                                        v-if="guardar==1"
                                        @click="fnGuardar"
                                        :loading="loading"
                                        color="primary">
                                        Agregar
                                        </v-btn>
                                        <v-btn 
                                        v-if="guardar==0"
                                        @click="fnModificar"
                                        :loading="loading"
                                        dark color="indigo">
                                        Modificar
                                        </v-btn>
                                        &nbsp;
                                        <v-btn 
                                        @click="fnLimpiar"
                                        :loading="loading"
                                        color="warning">
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
                                                    <v-text-field
                                                        v-model="search"
                                                        append-icon="mdi-filter"
                                                        label="Buscar"
                                                        single-line
                                                        hide-details
                                                    ></v-text-field>
                                                </v-card-title>
                                                <v-data-table
                                                :headers="headers"
                                                :items="tabla"
                                                :search="search"
                                                :loading="loading"
                                                >
                                                    <template v-slot:item.activo="{ item }">
                                                        <v-switch
                                                        color="primary"
                                                        v-model="item.activo"
                                                        :loading="loading"
                                                        @change="CambioEstatus(item)"
                                                        >
                                                        </v-switch>
                                                    </template>
                                                    <template v-slot:item.editar="{ item }">
                                                        <v-btn dark
                                                        @click="fnEditar(item)"
                                                        color="info"
                                                        :loading="loading"
                                                         >Editar</v-btn>
                                                    </template>
                                                    <template v-slot:item.eliminar="{ item }">
                                                    <v-btn v-if="item.no==0"
                                                    @click="fnEliminar(item,1)"
                                                    :loading="loading"
                                                     color="error"
                                                      >
                                                     Eliminar
                                                    </v-btn>
                                                    <v-btn v-if="item.no>0" disabled color="error" >
                                                     No se puede eliminar
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
        <v-snackbar
            v-model="snackbar"
            timeout="3000"
            :color="color_mensaje"
            shaped
            bottom
            
        >
           {{mensaje}}
            
            <template v-slot:action="{ attrs }">
                <v-btn
                color="white"
                text
                v-bind="attrs"
                @click="snackbar = false"
                >
                Cerrar
                </v-btn>
            </template>
        </v-snackbar>
    </v-app>
</div>