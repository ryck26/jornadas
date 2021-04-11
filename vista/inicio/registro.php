<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script type="" src="../../resource/lib/vue/vue.min.js" ></script>

    <title>Curso Dual</title>
    <link href="../../resource/css/icon_material_design_4495/css/materialdesignicons.min.css" rel="stylesheet" />
    <link href="../../resource/lib/vuetify/vuetify.css" rel="stylesheet" />
    <script src="../../resource/lib/vuetify/vuetify.js" ></script>
	<script src="../../resource/lib/vue-the-mask/vue-the-mask.min.js" ></script>
    <script src="../../resource/lib/axios/axios.js" ></script>
    <!--[if lt IE 9]>
        <script src="src/js/html5shiv.js"></script>
        <script src="src/js/respond.min.js"></script>
        <![endif]-->
</head>
<body >
    <div id="app">
        <v-app>
                <v-container fluid>
                    <v-card
                        class="mx-auto"
                        max-width="100%"
                        raised 
                        >
                        <!-- ENCABEZADO INTERFAZ-->
                            <v-card-title  style="background-color: #00b293; color:#ffffff; headline" >
                               Registro Curso Dual
                           </v-card-title>                            
                          <v-divider></v-divider>
                        <v-container fluid >
                           
                        <v-row>
                          <v-col lg="4">
                             <v-text-field
                              label="Nombre"
							  prepend-icon="mdi-account-card-details-outline"
                              v-model="nombre"
                              v-validate="'required|max:200'"
                              data-vv-name="nombre"
                              :error="errors.has('nombre')"
                              :error-messages="errors.first('nombre')"
                              >
                            </v-text-field>
                          </v-col>
						  <v-col lg="4">
                             <v-text-field
                              label="Apellido Paterno"
							  prepend-icon="mdi-account-card-details-outline"
                              v-model="paterno"
                              v-validate="'required|max:200'"
                              data-vv-name="paterno"
                              :error="errors.has('paterno')"
                              :error-messages="errors.first('paterno')"
                              >
                            </v-text-field>
                          </v-col>
						  <v-col lg="4">
                             <v-text-field
                              label="Apellido Materno"
							  prepend-icon="mdi-account-card-details-outline"
                              v-model="materno"
                              v-validate="'required|max:200'"
                              data-vv-name="materno"
                              :error="errors.has('materno')"
                              :error-messages="errors.first('materno')"
                              >
                            </v-text-field>
                          </v-col>
                        </v-row>
						<v-row>
                          <v-col lg="4">
                             <v-text-field
                              label="Curp"
							  prepend-icon="mdi-alphabetical-variant"
							  v-mask="'AAAA######SSSSSS##'"
                              v-model="curp"
                              v-validate="'required|max:18'"
                              data-vv-name="curp"
                              :error="errors.has('curp')"
                              :error-messages="errors.first('curp')"
                              >
                            </v-text-field>
                          </v-col>
						  <v-col lg="4">
                             <v-text-field
                              label="Institución"
							  prepend-icon="mdi-office-building"
                              v-model="institucion"
                              v-validate="'required|max:200'"
                              data-vv-name="institucion"
                              :error="errors.has('institucion')"
                              :error-messages="errors.first('institucion')"
                              >
                            </v-text-field>
                          </v-col>
						  <v-col lg="4">
                             <v-text-field
                              label="Cargo"
							  prepend-icon="mdi-account-supervisor-outline"
                              v-model="cargo"
                              v-validate="'required|max:200'"
                              data-vv-name="cargo"
                              :error="errors.has('cargo')"
                              :error-messages="errors.first('cargo')"
                              >
                            </v-text-field>
                          </v-col>
                        </v-row>
						<v-row>
                          <v-col lg="6">
                             <v-text-field
                              label="Correo Electronico"
							  prepend-icon="mdi-mail-ru"
                              v-model="correo"
                              v-validate="'required|max:100'"
                              data-vv-name="correo"
                              :error="errors.has('correo')"
                              :error-messages="errors.first('correo')"
                              >
                            </v-text-field>
                          </v-col>
						  <v-col lg="6">
                             <v-text-field
                              label="Correo Electronico Alternativo"
							  prepend-icon="mdi-mail-ru"
                              v-model="correoA"
                              v-validate="'required|max:200'"
                              data-vv-name="correoA"
                              :error="errors.has('correoA')"
                              :error-messages="errors.first('CorreoA')"
                              >
                            </v-text-field>
                          </v-col>
                        </v-row>
						<v-row>
                          <v-col lg="6">
                             <v-text-field
                              label="Telefono"
							  v-mask="'(###)-###-####'"
							  prepend-icon="mdi-phone-in-talk-outline"
                              v-model="telefono"
                              v-validate="'required|max:14'"
                              data-vv-name="telefono"
                              :error="errors.has('telefono')"
                              :error-messages="errors.first('telefono')"
                              >
                            </v-text-field>
                          </v-col>
						  <v-col lg="6">
                             <v-text-field
                              label="Celular"
							  v-mask="'(###)-###-####'"
							  prepend-icon="mdi-cellphone-basic"
                              v-model="celular"
                              v-validate="'required|max:14'"
                              data-vv-name="celular"
                              :error="errors.has('celular')"
                              :error-messages="errors.first('celular')"
                              >
                            </v-text-field>
                          </v-col>
                        </v-row>
						<v-row justify="center">
                          <v-btn v-if="!actualizar" @click="validar(1)" color="success">
                            <v-icon>mdi-content-save</v-icon>
                            &nbsp;Guardar
                          </v-btn> 
                          <v-btn v-else="actualizar" @click="validar(2)" color="primary">
                            <v-icon>mdi-update</v-icon>
                            &nbsp;Actualizar
                          </v-btn> 
                          &nbsp;&nbsp; 
                          <v-btn color="warning" @click="fnLimpiar" >
                            <v-icon>mdi-broom</v-icon>
                            Limpiar
                          </v-btn>
                        </v-row>
						<v-row>
                            <v-col lg="12">
                                &nbsp;
                <!--TODO: LOADER PARA ANIMACI�N DE CARGA-->
                                <v-overlay :value="loader" z-index="1000">
                                    <v-img
                                        aspect-ratio="2"
                                        class="white--text align-end"
                                        height="212px"
                                        width="292px"
                                        src="../../resource/img/Logo_utl_animado.gif"
                                    > </v-img>
                                </v-overlay>
                            </v-col>
                        </v-row>
                    </v-card>
					 <v-snackbar v-model="snackbar" top="top" :bottom="true" :multi-line="true" :color="color_mensaje">
                    {{mensaje_alerta}}
                    <v-icon color="white" @click="snackbar=false">mdi-close-circle</v-icon>
                </v-snackbar>
                </v-container>
				
            </v-app>
    </div>        
</body>
    

    <!--Scripts del sitio-->
	<script src="../../resource/lib/vuetify/vee-validate/vee-validate.js"></script>
	<script src="../../resource/lib/vuetify/vee-validate/es.js"></script>
    <script src="../../controlador/js/inicio/registro.js"></script>
</html>