
/*
 * Titulo                 : inicio.js
 * Descripción            : Metodos para dar forma al menu principal
 * Descripción            :
 * Compañía               :
 * Fecha de creación      : 02-mayo-2017
 * Desarrollador          : Oscar
 * Versión                : 1.0
 * ID Requerimiento       :
 */

 // Vuetify Object (as described in the Vuetify 2 documentation)
 const vuetify = new Vuetify();
 new Vue({
    el: "#app",
    vuetify: vuetify,
    data: {
        drawer: null,
        ctr: 'controlador/inicio/controlador_inicio.php',
        items: [],
          html_pagina: '',
          overlay: false,
          menu_superior:[],
          isActive: false
    },
    created() {
        this.Menu()
    },
    methods: {
        logout(){
            let parametros = new URLSearchParams();
            parametros.append("accion", 2 );

            //Peticion ajax al controlador y envio de parametros
            axios.post(this.ctr, parametros)
                .then(function(response) {
                    location.reload();

                }.bind(this))
                .catch(function(error) {
                  console.log(error);
                })
                .then(function() {
                    
                }.bind(this));
        },
        Menu(){
            let parametros = new URLSearchParams();
            parametros.append("accion", 1 );

            //Peticion ajax al controlador y envio de parametros
            axios.post(this.ctr, parametros)
                .then(function(response) {
                   
                //   this.items = response.data.filter(menu => menu.cve_menu_superior == 0);
                //   this.items.forEach(function(elemento , index){
                        
                //       elemento.items = response.data.filter(menu => menu.cve_menu_superior == elemento.cve_menu);
                //   });

                  this.items= [{ruta:'vista/procesos/proceso_clarificacion.php'}]
                 this.cargarHtml(this.items);
                }.bind(this))
                .catch(function(error) {
                  console.log(error);
                })
                .then(function() {
                   
                }.bind(this));
        },
        cargarHtml(item){
            this.overlay = true;
            console.log(item);
            let parametros = new URLSearchParams();
            parametros.append("accion", 3 );
            parametros.append("ruta", item[0].ruta );
            //Peticion ajax al controlador y envio de parametros
            axios.post(this.ctr , parametros  )
            .then(function(response) {
                e = document.createElement("article");
                e.innerHTML = response.data;
                e.addEventListener('load', function(){
                this.overlay = false;
                }.bind(this));
                document.getElementById("contenido-sitio").innerHTML="";
                document.getElementById("contenido-sitio").appendChild(e);

                var nuevo_script = document.createElement("script");
                nuevo_script.src = document.getElementById('app2').dataset.script;
                e.appendChild(nuevo_script);

                var nuevo_pdf = document.createElement("script");
                nuevo_pdf.src = document.getElementById('app2').dataset.pdf;
               // console.log(document.getElementById('app2').dataset.pdf);
                e.appendChild(nuevo_pdf);
                    
            }.bind(this))
            .catch(function(error) {
              console.log(error);
            })
            .then(function() {
                this.overlay = false;
                
                
            }.bind(this));
        }
    },
 });