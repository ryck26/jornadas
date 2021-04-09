
 const vue= new Vue({
   el: "#app",
   vuetify: new Vuetify(),
   data: {
    ctr: '../../../login_recepcion_documentos.jsp',
    accion: 0,
    loader: false,
    color_mensaje: 'success',
    mensaje_alerta: '',
    snackbar: false,
    confirm_mensaje: '',
    continuar: true,
    dialog: false,
    dialog2: false,
    
      
   },
   created() {
    Vue.config.devtools= true;
    this.overlay=false;
   },
   methods: {

        
        
    },
    watch: {
      
    }
    
 });

 console.log(vue);

