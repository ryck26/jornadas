
 new Vue({
    el: "#app2",
    vuetify: vuetify,
    data: {
        ctr: 'controlador/sistema/controladorModulo.php',
        tabs:null,
        search: '',
        headers: [
          {
            text: 'Módulo',
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
        m_nombre:'',
        cve_menu: 0,
        guardar: 1,
        search_sub: '',
        headers_sub: [
          {
            text: 'Sub módulo',
            align: 'start',
            sortable: true,
            value: 'nombre',
          },
          { text: 'Ruta', value: 'ruta' },
          { text: 'Estatus', value: 'activo' },
          { text: 'Editar', value: 'editar' },
          { text: 'Eliminar', value: 'eliminar' }
        ],
        tabla_sub: [],
        array_sub_menu: [],
        cve_menu_superior: '',
        s_nombre:'',
        s_ruta:'',
        guardar_sub: 1
    },
    created() {
       this.fnListaMenu();
    },
    methods: {
        fnListaMenu(){
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
        fnGuardarMod(){
            this.loading = true;
            
            let parametros = new URLSearchParams();
            parametros.append("accion", 1 );
            parametros.append("nombre", this.m_nombre );

            //Peticion ajax al controlador y envio de parametros
            axios.post(this.ctr, parametros)
                .then(function(response) {
                    if( response.data == 1){
                        
                        this.mensaje = 'Registro guardado';
                        this.color_mensaje = 'success';
                        this.snackbar = true;
                        this.fnListaMenu();
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
            
            parametros.append("cve_menu", item.cve_menu );

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
            this.m_nombre = item.nombre;
            this.cve_menu = item.cve_menu  ;
            this.guardar = 0;
        },
        fnModificarMod(){
            this.loading = true;
            
            let parametros = new URLSearchParams();
            parametros.append("accion", 3 );
            parametros.append("nombre", this.m_nombre );
            parametros.append("cve_menu", this.cve_menu );

            //Peticion ajax al controlador y envio de parametros
            axios.post(this.ctr, parametros)
                .then(function(response) {
                    if( response.data == 1){
                        
                        this.mensaje = 'Registro modificado';
                        this.color_mensaje = 'success';
                        this.snackbar = true;
                        this.fnListaMenu();
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
            this.cve_menu = 0;
            this.m_nombre = '';
            this.guardar = 1;
            this.loading = false;
        },
        
        fnEliminarMod(item, opcion){
            this.loading = true;
            
            let parametros = new URLSearchParams();
            parametros.append("accion", 5 );
            parametros.append("cve_menu", item.cve_menu );

            //Peticion ajax al controlador y envio de parametros
            axios.post(this.ctr, parametros)
                .then(function(response) {
                    if( response.data == 1){
                        
                        this.mensaje = 'Registro elimnado';
                        this.color_mensaje = 'success';
                        this.snackbar = true;
                        if(opcion==1){
                            this.fnListaMenu();
                        }else if(opcion==2){
                            this.fnListaSubMenu();
                        }
                        
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
                    
                    if(opcion==1){
                        this.fnLimpiar();
                    }else if(opcion==2){
                        this.fnLimpiarSub();
                    }
                   
                }.bind(this));
        },
        //Submenu inicio
        fnListaSubMenu(){
            this.loading = true;
            let parametros = new URLSearchParams();
            parametros.append("accion", 6 );
            parametros.append("cve_menu_superior", this.cve_menu_superior );

            //Peticion ajax al controlador y envio de parametros
            axios.post(this.ctr, parametros)
                .then(function(response) {
                    this.tabla_sub = response.data;

                }.bind(this))
                .catch(function(error) {
                    console.log(error);
                })
                .then(function() {
                    this.loading = false;
                }.bind(this));
        },
        fnGuardarSub(){
            this.loading = true;
            
            let parametros = new URLSearchParams();
            parametros.append("accion", 7 );
            parametros.append("cve_menu_superior", this.cve_menu_superior );
            parametros.append("nombre", this.s_nombre );
            parametros.append("ruta", this.s_ruta );

            //Peticion ajax al controlador y envio de parametros
            axios.post(this.ctr, parametros)
                .then(function(response) {
                    if( response.data == 1){
                        
                        this.mensaje = 'Registro guardado';
                        this.color_mensaje = 'success';
                        this.snackbar = true;
                        this.fnListaSubMenu();
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
                    this.fnLimpiarSub();
                }.bind(this));
        },
        fnModificarSub(){
            this.loading = true;
            
            let parametros = new URLSearchParams();
            parametros.append("accion", 8 );
            parametros.append("nombre", this.s_nombre );
            parametros.append("ruta", this.s_ruta );
            parametros.append("cve_menu", this.cve_menu );

            //Peticion ajax al controlador y envio de parametros
            axios.post(this.ctr, parametros)
                .then(function(response) {
                    if( response.data == 1){
                        
                        this.mensaje = 'Registro modificado';
                        this.color_mensaje = 'success';
                        this.snackbar = true;
                        this.fnListaSubMenu();
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
                    this.fnLimpiarSub();
                }.bind(this));
        },
        fnLimpiarSub(){
            this.loading = true
            this.cve_menu = 0;
            this.s_nombre = '';
            this.s_ruta = '';
            this.guardar_sub = 1;
            this.loading = false;
        },
        fnEditarSub(item){
            this.s_nombre = item.nombre;
            this.s_ruta = item.ruta;
            this.cve_menu = item.cve_menu  ;
            this.guardar_sub = 0;
        },
    },
    watch:{
        tabs: function(valor){
            if(!_.isUndefined(valor)){
              
                switch(valor){
                    case 'nuevo':
                        this.fnListaMenu();
                    break;
                    case 'exists':
                        this.fnListaMenu();
                        this.array_sub_menu = this.tabla;
                       
                    break;    
                }
            }
        }
    }
 });