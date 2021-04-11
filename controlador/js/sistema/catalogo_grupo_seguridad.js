new Vue({
    el: "#app2",
    vuetify: vuetify,
    data: {
        ctr: 'controlador/sistema/controladorGrupoSeguridad.php',
        search: '',
        headers: [
          {
            text: 'Perfil',
            align: 'start',
            sortable: true,
            value: 'nombre',
          },
          { text: 'Estatus', value: 'activo' },
          { text: 'Editar', value: 'editar' },
          { text: 'Eliminar', value: 'eliminar' }
        ],
        tabla: [],
        loading: false,
        snackbar: false,
        mensaje: '',
        color_mensaje:'',
        guardar: 1,
        cve_grupo_seguridad: '',
        nombre: ''
    },
    created() {
        this.fnListaGrupoSeguridad()
    },
    methods: {
        fnListaGrupoSeguridad(){
            this.loading = true;
            let parametros = new URLSearchParams();
            parametros.append("accion", 2 );

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
            this.loading = true;
            
            let parametros = new URLSearchParams();
            parametros.append("accion", 1 );
            parametros.append("nombre", this.nombre );

            //Peticion ajax al controlador y envio de parametros
            axios.post(this.ctr, parametros)
                .then(function(response) {
                    if( response.data == 1){
                        
                        this.mensaje = 'Registro guardado';
                        this.color_mensaje = 'success';
                        this.snackbar = true;
                        this.fnListaGrupoSeguridad();
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
                    this.fnLimpiar();
                }.bind(this));
        },
        CambioEstatus(item){
            this.loading = true;

            let parametros = new URLSearchParams();
            parametros.append("accion", 4 );
            if(item.activo){
                parametros.append("activo", 1 );
            }else{
                parametros.append("activo", 0 );
            }
            
            parametros.append("cve_grupo_seguridad", item.cve_grupo_seguridad );

            //Peticion ajax al controlador y envio de parametros
            axios.post(this.ctr, parametros)
                .then(function(response) {
                    if( response.data == 1){
                        
                        this.mensaje = 'Cambio de estatus realizado';
                        this.color_mensaje = 'success';
                        this.snackbar = true;
                    }else{
                        
                        this.mensaje = 'Hubó un error, no se realizó la acción';
                        this.color_mensaje = 'error';
                        this.snackbar = true;
                    }

                }.bind(this))
                .catch(function(error) {
                    console.log(error);
                })
                .then(function() {
                    this.loading = false;
                }.bind(this));
        },
        fnEditar(item){
            this.nombre = item.nombre;
            this.cve_grupo_seguridad = item.cve_grupo_seguridad  ;
            this.guardar = 0;
        },
        fnModificar(){
            this.loading = true;
            
            let parametros = new URLSearchParams();
            parametros.append("accion", 3 );
            parametros.append("nombre", this.nombre );
            parametros.append("cve_grupo_seguridad", this.cve_grupo_seguridad );

            //Peticion ajax al controlador y envio de parametros
            axios.post(this.ctr, parametros)
                .then(function(response) {
                    if( response.data == 1){
                        
                        this.mensaje = 'Registro modificado';
                        this.color_mensaje = 'success';
                        this.snackbar = true;
                        this.fnListaGrupoSeguridad();
                    }else{
                        
                        this.mensaje = 'Hubó un error, no se modificó el registro';
                        this.color_mensaje = 'error';
                        this.snackbar = true;
                    }

                }.bind(this))
                .catch(function(error) {
                    console.log(error); 
                })
                .then(function() {
                    
                    this.fnLimpiar();
                   
                }.bind(this));
        },
        fnLimpiar(){
            this.loading = true
            this.cve_grupo_seguridad = 0;
            this.nombre = '';
            this.guardar = 1;
            this.loading = false;
        },
        fnEliminar(item){
            this.loading = true;
            
            let parametros = new URLSearchParams();
            parametros.append("accion", 5 );
            parametros.append("cve_grupo_seguridad", item.cve_grupo_seguridad );

            //Peticion ajax al controlador y envio de parametros
            axios.post(this.ctr, parametros)
                .then(function(response) {
                    if( response.data == 1){
                        
                        this.mensaje = 'Registro elimnado';
                        this.color_mensaje = 'success';
                        this.snackbar = true;
                        this.fnListaGrupoSeguridad();
                        
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
                    this.fnLimpiar();
                   
                }.bind(this));
        },
    },
});