new Vue({
    el: "#app2",
    vuetify: vuetify,
    data: {
        ctr: 'controlador/sistema/controladorModuloGrupoSeguridad.php',
        search: '',
        headers: [
          {
            text: 'Módulo',
            align: 'start',
            sortable: true,
            value: 'menu',
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
        cve_menu:'',
        combo_grupo:[],
        combo_menu:[]
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
        fnMenu(){
            this.loading = true;
            let parametros = new URLSearchParams();
            parametros.append("accion", 5 );
            parametros.append("cve_grupo_seguridad", this.cve_grupo_seguridad );

            //Peticion ajax al controlador y envio de parametros
            axios.post(this.ctr, parametros)
                .then(function(response) {
                    this.combo_menu = response.data;

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
            this.loading = true;
            
            let parametros = new URLSearchParams();
            parametros.append("accion", 1 );
            parametros.append("cve_menu", this.cve_menu );
            parametros.append("cve_grupo_seguridad", this.cve_grupo_seguridad );

            //Peticion ajax al controlador y envio de parametros
            axios.post(this.ctr, parametros)
                .then(function(response) {
                    if( response.data == 1){
                        
                        this.mensaje = 'Registro guardado';
                        this.color_mensaje = 'success';
                        this.snackbar = true;
                        this.fnListaTabla();
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
        fnLimpiar(){
            this.loading = true
            this.cve_grupo_seguridad = 0;
            this.cve_menu = '';
            this.guardar = 0;
            this.loading = false;
        },
        fnEliminar(item){
            this.loading = true;
            
            let parametros = new URLSearchParams();
            parametros.append("accion", 3 );
            parametros.append("cve_grupo_seguridad", item.cve_grupo_seguridad );
            parametros.append("cve_menu", item.cve_menu );

            //Peticion ajax al controlador y envio de parametros
            axios.post(this.ctr, parametros)
                .then(function(response) {
                    if( response.data == 1){
                        
                        this.mensaje = 'Registro elimnado';
                        this.color_mensaje = 'success';
                        this.snackbar = true;
                        this.fnListaTabla();
                        
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