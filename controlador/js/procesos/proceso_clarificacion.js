
 const vue= new Vue({
   el: "#app2",
   vuetify: new Vuetify(),
   data: {
    ctr: '../../../login_recepcion_documentos.jsp',
    accion: 0,
    loader: false,
    color_mensaje: 'success',
    mensaje_alerta: '',
    snackbar: false,
    confirm_mensaje: '',
    continuar: false,
    dialog: false,
    dialog2: false,
    tsu:1
    
      
   },
   created() {
    Vue.config.devtools= true;
    this.overlay=false;
   },
   methods: {
    fnRegresar(){

    }
        
        
    },
    watch: {
      
    }
    
 });

 console.log(vue);

