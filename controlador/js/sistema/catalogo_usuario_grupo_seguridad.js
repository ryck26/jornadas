new Vue({
    el: "#app2",
    vuetify: vuetify,
    data: {
        ctr: 'controlador/sistema/controladorUsuarioGrupoSeguridad.php',
        search: '',
        headers: [
          {
            text: 'Perfil',
            align: 'start',
            sortable: true,
            value: 'perfil',
          },
          {
            text: 'Nombre',
            align: 'start',
            sortable: true,
            value: 'nombre',
          },
          { text: 'Eliminar', value: 'eliminar' }
        ],
        guardar:1,
        tabla: [],
        loading: false,
        snackbar: false,
        mensaje: '',
        color_mensaje:'',
        guardar: 0,
        cve_grupo_seguridad: '',
        cve_persona:'',
        combo_grupo:[],
        combo_usuario:[]
    },
    created() {
        this.fnGrupoSeguridad();
    },
    methods: {
        fnGrupoSeguridad(){
            this.loading = true;
            let parametros = new URLSearchParams();
            parametros.append("accion", 4 );

            //Peticion ajax al controlador y envio de parametros
            axios.post(this.ctr, parametros)
                .then(function(response) {
                    this.combo_grupo = response.data;

                }.bind(this))
                .catch(function(error) {
                    console.log(error);
                })
                .then(function() {
                    this.loading = false;
                }.bind(this));
        },
        fnUsuarios(){
            this.loading = true;
            let parametros = new URLSearchParams();
            parametros.append("accion", 5 );
            parametros.append("cve_grupo_seguridad", this.cve_grupo_seguridad );

            //Peticion ajax al controlador y envio de parametros
            axios.post(this.ctr, parametros)
                .then(function(response) {
                    this.combo_usuario = response.data.filter(usuario => usuario.existe == 0);

                }.bind(this))
                .catch(function(error) {
                    console.log(error);
                })
                .then(function() {
                    this.loading = false;
                }.bind(this));
        },
        fnListaTabla(){
            this.loading = true;
            let parametros = new URLSearchParams();
            parametros.append("accion", 2 );
            parametros.append("cve_grupo_seguridad", this.cve_grupo_seguridad );

            //Peticion ajax al controlador y envio de parametros
            axios.post(this.ctr, parametros)
                .then(function(response) {
                    this.tabla = response.data;

                }.bind(this))
                .catch(function(error) {
                    console.log(error);
                })
                .then(function() {
                    this.loading = false;
                }.bind(this));
        },
        fnGuardar(){

            if(this.cve_persona.existe <= 0){
                this.loading = true;
                
                let parametros = new URLSearchParams();
                parametros.append("accion", 1 );
                parametros.append("cve_persona", this.cve_persona.cve_persona );
                parametros.append("cve_grupo_seguridad", this.cve_grupo_seguridad );

                //Peticion ajax al controlador y envio de parametros
                axios.post(this.ctr, parametros)
                    .then(function(response) {
                        if( response.data == 1){
                            
                            this.mensaje = 'Registro guardado';
                            this.color_mensaje = 'success';
                            this.snackbar = true;
                            this.fnListaTabla();
                            this.fnUsuarios();
                        }else{
                            
                            this.mensaje = 'Hubó un error, no se realizó el registro';
                            this.color_mensaje = 'error';
                            this.snackbar = true;
                        }

                    }.bind(this))
                    .catch(function(error) {
                        console.log(error); 
                    })
                    .then(function() {
                        this.loading = false;
                        this.cve_persona = '';
                        this.guardar = 0;
                    }.bind(this));
            }else{
                this.mensaje = 'El usuario ya cuenta con éste perfil';
                this.color_mensaje = 'warning';
                this.snackbar = true;
            }
            
        },
        fnLimpiar(){
            this.loading = true
            this.cve_grupo_seguridad = 0;
            this.cve_persona = '';
            this.guardar = 0;
            this.loading = false;
            this.combo_usuario = [];
            this.tabla = [];
            this.fnGrupoSeguridad();
        },
        fnEliminar(item){
            this.loading = true;
            
            let parametros = new URLSearchParams();
            parametros.append("accion", 3 );
            parametros.append("cve_grupo_seguridad", item.cve_grupo_seguridad );
            parametros.append("cve_persona", item.cve_persona );

            //Peticion ajax al controlador y envio de parametros
            axios.post(this.ctr, parametros)
                .then(function(response) {
                    if( response.data == 1){
                        
                        this.mensaje = 'Registro elimnado';
                        this.color_mensaje = 'success';
                        this.snackbar = true;
                        this.fnListaTabla();
                        this.fnUsuarios();
                        
                    }else{
                        
                        this.mensaje = 'Hubó un error, no se eliminó el registro';
                        this.color_mensaje = 'error';
                        this.snackbar = true;
                    }

                }.bind(this))
                .catch(function(error) {
                    console.log(error); 
                })
                .then(function() {
                    this.loading = false;
                    this.cve_persona = '';
                    this.guardar = 0;
                   
                }.bind(this));
        },
    },
});