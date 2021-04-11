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
<div id="app2" data-script="../../controlador/js/sistema/catalogo_modulo.js">
    <v-app>
        
        <v-container fluid>
            <v-card raised >
                <v-toolbar dark color="primary">
                   <h1>Módulos</h1>  
                </v-toolbar>
                <v-tabs v-model="tabs" fixed-tabs>
                    <v-tabs-slider></v-tabs-slider>
                    <v-tab href="#nuevo" class="primary--text">
                        Nuevo módulo padre
                    </v-tab>

                    <v-tab href="#exists" class="primary--text">
                        Nuevo Submodulo
                    </v-tab>

                </v-tabs>

                <v-tabs-items v-model="tabs">
                    <v-tab-item value="nuevo">
                        <v-card flat>
                            <v-card-actions>
                                <v-container>
                                    <v-row>
                                        <v-col>
                                            <v-text-field 
                                                label="Nombre del módulo"
                                                v-model="m_nombre"
                                                :loading="loading"
                                            >
                                            </v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row aling="center" justify="center">
                                        <v-btn v-if="guardar==1"
                                        @click="fnGuardarMod" 
                                        color="primary"
                                        :loading="loading"
                                        >
                                        Agregar
                                        </v-btn>
                                        <v-btn v-if="guardar==0"
                                        @click="fnModificarMod" 
                                        dark
                                        color="indigo"
                                        :loading="loading"
                                        >
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
                                                    Módulos
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
                                                    <v-btn v-if="item.sub==0"
                                                    @click="fnEliminarMod(item,1)"
                                                    :loading="loading"
                                                     color="error"
                                                      >
                                                     Eliminar
                                                    </v-btn>
                                                    <v-btn v-if="item.sub>0" disabled color="error" >
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
                    </v-tab-item>
                    <v-tab-item value="exists">
                        <v-card flat>
                        <v-card-actions>
                                <v-container>
                                    <v-row>
                                        <v-col>
                                            <v-select
                                            label="Seleccionar"
                                            :items="array_sub_menu"
                                            item-text="nombre"
                                            item-value="cve_menu"
                                            v-model="cve_menu_superior"
                                            solo
                                            @change="fnListaSubMenu"
                                            :loading="loading"
                                            >
                                            </v-select>
                                            
                                        </v-col>
                                        <v-col>
                                        <v-text-field
                                        label="Nombre del sub módulo" 
                                        v-model="s_nombre"
                                        :loading="loading"
                                        >
                                        </v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col>
                                                <v-text-field 
                                                label="Ruta del archivo (vista/...)"
                                                v-model="s_ruta"
                                                :loading="loading"
                                                >
                                            </v-text-field>

                                        </v-col>
                                    </v-row>
                                    <v-row aling="center" justify="center">
                                        <v-btn  
                                        v-if="guardar_sub==1"
                                        @click="fnGuardarSub"
                                        :loading="loading"
                                        color="primary">
                                        Agregar
                                        </v-btn>
                                        <v-btn 
                                        v-if="guardar_sub==0"
                                        @click="fnModificarSub"
                                        :loading="loading"
                                        dark color="indigo">
                                        Modificar
                                        </v-btn>
                                        &nbsp;
                                        <v-btn 
                                        @click="fnLimpiarSub"
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
                                                    Módulos
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
                                                :headers="headers_sub"
                                                :items="tabla_sub"
                                                :search="search_sub"
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
                                                        @click="fnEditarSub(item)"
                                                        color="info"
                                                        :loading="loading"
                                                         >Editar</v-btn>
                                                    </template>
                                                    <template v-slot:item.eliminar="{ item }">
                                                    <v-btn 
                                                    @click="fnEliminarMod(item,2)"
                                                    :loading="loading"
                                                     color="error"
                                                      >
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
                    </v-tab-item>
                </v-tabs-items>
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