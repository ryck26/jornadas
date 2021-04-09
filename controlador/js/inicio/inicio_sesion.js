/*
 * Titulo                 : inicio_sesion.js
 * Descripción            : Metodos para dar funcionalidad a la pagina de inicio de sesion
 * Descripción            : 
 * Compañía               : 
 * Fecha de creación      : 05-mayo-2017
 * Desarrollador          : Oscar, Alias Dios Fáres
 * Versión                : 1.0
 * ID Requerimiento       : 
 * Fecha de creación      : 25-mayo-2020
 * Desarrollador          : Rick Franco
 * Versión                : 2.0
 * Descripción            : remodelado VueJS
 */

 // Vuetify Object (as described in the Vuetify 2 documentation)
 const vuetify = new Vuetify();
 new Vue({
    el: "#app",
    vuetify: vuetify,
    data: {
        ctr: "controlador/inicio/controlador_inicio_sesion.php",
        show1: false,
        show2: false,
        color_mensaje: 'success',
        mensaje_alerta: '',
        snackbar: false,
        folio: '',
        curp: '',
        loader: false
    },
    methods: {
        fnLogin(){
            this.loader = true;
            location.reload();
            //Variable para poder mandar parametros por post en axios
            // let parametros = new URLSearchParams();
            // parametros.append("accion", 1 );
            // parametros.append("yFolio", this.folio );
            // parametros.append("yCurp", this.curp );

            // //Peticion ajax al controlador y envio de parametros
            // axios.post(this.ctr, parametros)
            //     .then(function(response) {
                    
            //         if (Object.keys(response.data).length > 0) {
            //             location.reload();
            //         }else{
            //             this.color_mensaje = 'error';
            //             this.mensaje_alerta = 'Usuario o contraseña incorrectos';
            //             this.snackbar = true;
            //         }
            //     }.bind(this))
            //     .catch(function(error) {
            //       console.log(error);
            //     })
            //     .then(function() {
            //         this.loader = false;
            //     }.bind(this));
        }
    },
 });