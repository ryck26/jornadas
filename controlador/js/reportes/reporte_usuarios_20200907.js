// Vue.use(VeeValidate, {
//   classes: true
// });

//Lenguaje de VeeValidate
// VeeValidate.Validator.localize("es");

new Vue({
  el: "#app",
  vuetify: new Vuetify(),

  data: {
    ctr: "../../../controlador/reportes/Reporte_usuarios.php",
    accion: 0,
    anio: 0,
    curso: 0,
    fecha: 0,
    arrayCursos: [],
    arrayFechas: [],
    search: '',
    //SNACKBAR
    loader: false,
    snackbar: false,
    mensaje_alerta: '',
    color_mensaje: '',
    //
    textoSwitchAsistencias: 'Seleccionar todos',
    seleccionarTodos: true,
    colorIcono: "green",
    nombreIcono: " mdi-playlist-check",
    cargandoExportar: false,
    loadingGuardarAsistencias: false,
    //
    dataExportar:[],
    //----------- TABLA------------------------
    //nombres de las columnas de la tabla, estos deben de estar ligados a los arreglos de "headings" y "sortable"
    data:[],
    headings: [
      {text: 'Nombre', align: 'left', sortable: true, value: 'nombre'},
      {text: 'CURP', align: 'left', sortable: true, value: 'curp'},
      {text: 'Institucion', align: 'left', sortable: true, value: 'institucion'},
      {text: 'Cargo', align: 'left', sortable: true, value: 'cargo'},
      {text: 'Correo', align: 'left', sortable: true, value: 'correo'},
      {text: 'Correo Alternativo', align: 'left', sortable: true, value: 'correo_alternativo'},
      {text: 'Telefono', align: 'left', sortable: true, value: 'telefono'},
      {text: 'Celular', align: 'left', sortable: true, value: 'celular'}
    ],
    search:''
  },
  created() {
    //llenando el arreglo de años desde 2005 hasta el año actual
    // for(var i = new Date().getFullYear(); i >= 2007; i--)
    //   this.arrayAnios.push(i);
    this.overlay = false;
    this.fnCursos();
    this.fnFechas();
  },
  methods: {
    fnCursos(){
      // this.loader = true;
      //Variable para poder mandar parametros por post en axios
      let parametros = new URLSearchParams();
      parametros.append("accion", 1);
      //Petici�n ajax al controlador y envio de parametros
      axios
      .post(this.ctr, parametros)
      .then(
        function(response) {
          this.arrayCursos = response.data;
        }.bind(this)
      )
      .catch(function(error) {
        console.log(error);
      })
      .then(function() {this.loader = false;}.bind(this));
    },
    fnFechas(){
      // this.loader = true;
      //Variable para poder mandar parametros por post en axios
      let parametros = new URLSearchParams();
      parametros.append("accion", 2);
      //Petici�n ajax al controlador y envio de parametros
      axios
      .post(this.ctr, parametros)
      .then(
        function(response) {
          this.arrayFechas = response.data;
        }.bind(this)
      )
      .catch(function(error) {
        console.log(error);
      })
      .then(function() {this.loader = false;}.bind(this));
    },
    fnConsultarTabla() {
      this.dataExportar = [];
      this.data = [];
      this.seleccionarTodos = true;
      this.textoSwitchAsistencias = "Seleccionar todos";
      this.colorIcono = "green";
      this.nombreIcono = "mdi-playlist-check"
      // if(this.anio != 0 && this.tipoConsulta != 0)
      // {
        this.loader = true;
        //Variable para poder mandar parametros por post en axios
        let parametros = new URLSearchParams();
        parametros.append("curso", this.curso);
        parametros.append("fecha", this.fecha);
        parametros.append("accion", 4);
        //Petici�n ajax al controlador y envio de parametros
        axios
        .post(this.ctr, parametros)
        .then(
          function(response) {
            this.data = response.data;

            this.data.forEach(element => {
              if(element.asistencia == 1)
                element.asistencia = true;
              if(element.asistencia == 0)
                element.asistencia = false;
            });
          }.bind(this)
        )
        .catch(function(error) {
          console.log(error);
        })
        .then(function() {this.loader = false;}.bind(this));
      // }
    },
    fnCargarFuncionesAsistencia(){
      //Se agrega la columna de checkbox a la tabla
      if(this.headings.length == 8 && this.fecha != 0)
        this.headings.unshift({text: 'Asistencia', value: 'asistencia', align: "center"});
    },
    fnCambiarEstatusAsistencia(item){
      //Variable para poder mandar parametros por post en axios
      let parametros = new URLSearchParams();
      parametros.append("accion", 5);
      parametros.append("curso", this.curso);
      parametros.append("fecha", this.fecha);
      parametros.append("cve_persona", item.cve_persona);
      parametros.append("asistencia", item.asistencia);
      //Petici�n ajax al controlador y envio de parametros
      axios
      .post(this.ctr, parametros)
      .then(
        function(response) {
          console.log(response.data);
          
          if(response.data)
          {
            this.snackbar=true;
            this.mensaje_alerta="Asistencia registrada correctamente";
            this.color_mensaje="success";
          }
        }.bind(this)
      )
      .catch(function(error) {
        console.log(error);
      })
      .then(function() {this.loader = false;}.bind(this));
    },
    fnGuardarAsistencias(){
      //Variable para poder mandar parametros por post en axios
      this.loadingGuardarAsistencias = true;
      let parametros = new URLSearchParams();
      parametros.append("accion", 6);
      parametros.append("curso", this.curso);
      parametros.append("fecha", this.fecha);
      parametros.append("arrayPersonas", JSON.stringify(this.data));
      //Petici�n ajax al controlador y envio de parametros
      axios
      .post(this.ctr, parametros)
      .then(
        function(response) {
          if(response.data)
          {
            this.snackbar=true;
            this.mensaje_alerta="Asistencia registrada correctamente";
            this.color_mensaje="success";
          }
          this.fnConsultarTabla();
        }.bind(this)
      )
      .catch(function(error) {
        console.log(error);
      })
      .then(function() {this.loadingGuardarAsistencias = false;}.bind(this));
    },
    fnSwitchAsistencias(){
      
      if(this.seleccionarTodos)
      {
        this.seleccionarTodos = false;
        this.textoSwitchAsistencias = "Deseleccionar todos";
        this.colorIcono = "red";
        this.nombreIcono = "mdi-playlist-remove"
        
        this.data.forEach(element => {
          element.asistencia = true;
        });
      }
      else
      {
        this.seleccionarTodos = true;
        this.textoSwitchAsistencias = "Seleccionar todos";
        this.colorIcono = "green";
        this.nombreIcono = "mdi-playlist-check"

        this.data.forEach(element => {
          element.asistencia = false;
        });
      }
    },
    fnLimpiar(){
      if(this.fecha != 0 && this.curso != 0)
        this.headings.shift();

      this.curso = 0;
      this.fecha = 0;
      this.search = ''
      this.data = [];
    },
    fnSeleccionarExportar(){
      if(this.curso != 0 && this.fecha == 0)
        this.exportarE();//Exportacion de excel sin las asisntencias al curso
      else
        this.exportarEAsistencias();
    },
    exportarE() {
      this.dataExportar = [];
      this.cargandoExportar = true;
      var cursoSeleccionado;

      this.arrayCursos.forEach(element => {
        if(element.cve_curso == this.curso)
          cursoSeleccionado = element.nombre
      });
      
      this.dataExportar.push(
        [ 
          {text: ""},
          {text: ""},
          {text: "Cursos dual"}
        ],
        [ 
          {text: ""}
        ],
        [ 
          {text: ""},
          {text: ""},
          {text: "REPORTE DE PARTICIPANTES"}
        ],
        [
          {text:""}
        ],
        [
          {text:""}
        ],
        [
          {text:"Participantes del curso " + cursoSeleccionado}
        ],
        [
          {text:""}
        ]
      );
      this.dataExportar.push([
        {text: 'Nombre'},
        {text: 'CURP'},
        {text: 'Institucion'},
        {text: 'Cargo'},
        {text: 'Correo'},
        {text: 'Correo Alternativo'},
        {text: 'Telefono'},
        {text: 'Celular'}
       ]);
      //Se recorre el JSON y se van agregando al objeto dataExport los resultados del JSON
      this.data.forEach(function (index, item) {
        this.dataExportar.push([
          {text: "" + index.nombre},
          {text: "" + index.curp},
          {text: "" + index.institucion},
          {text: "" + index.cargo},
          {text: "" + index.correo},
          {text: "" + index.correo_alternativo},
          {text: "" + index.telefono},
          {text: "" + index.celular}
        ]);
      }.bind(this));

     

      //Se declara el nombre del archivo y de la hoja de excel, as� mismo se manda llamar el data = dataExport
      var tableData = [
        {
          sheetName: "Reporte de asistentes",
          data: this.dataExportar
        }
      ];
      var options = {
        fileName: "Reporte_asistentes",
        header:true,
      };
      this.cargandoExportar = false;
      //Libreria que realiza el exportar a Excel
      Jhxlsx.export(tableData, options);
    },
    exportarEAsistencias() {
      this.dataExportar = [];
      this.cargandoExportar = true;
      var cursoSeleccionado, fechaSeleccionada;

      this.arrayCursos.forEach(element => {
        if(element.cve_curso == this.curso)
          cursoSeleccionado = element.nombre
      });
      this.arrayFechas.forEach(element => {
        if(element.cve_fecha_curso == this.fecha)
          fechaSeleccionada = element.fecha
      });
      
      this.dataExportar.push(
        [ 
          {text: ""},
          {text: ""},
          {text: "Cursos dual"}
        ],
        [ 
          {text: ""}
        ],
        [ 
          {text: ""},
          {text: ""},
          {text: "REPORTE DE ASISTENCIAS"}
        ],
        [
          {text:""}
        ],
        [
          {text:""}
        ],
        [
          {text:"Asistencias del curso " + cursoSeleccionado + " con fecha de " + fechaSeleccionada}
        ],
        [
          {text:""}
        ]
      );
      this.dataExportar.push([
        {text: 'Asistió'},
        {text: 'Nombre'},
        {text: 'CURP'},
        {text: 'Institucion'},
        {text: 'Cargo'},
        {text: 'Correo'},
        {text: 'Correo Alternativo'},
        {text: 'Telefono'},
        {text: 'Celular'}
       ]);
      //Se recorre el JSON y se van agregando al objeto dataExport los resultados del JSON
      this.data.forEach(function (index, item) {
        if(!index.asistencia)
        {
          this.dataExportar.push([
            {text: "No"},
            {text: "" + index.nombre},
            {text: "" + index.curp},
            {text: "" + index.institucion},
            {text: "" + index.cargo},
            {text: "" + index.correo},
            {text: "" + index.correo_alternativo},
            {text: "" + index.telefono},
            {text: "" + index.celular}
          ]);
        }
        else
        {
          this.dataExportar.push([
            {text: "Si"},
            {text: "" + index.nombre},
            {text: "" + index.curp},
            {text: "" + index.institucion},
            {text: "" + index.cargo},
            {text: "" + index.correo},
            {text: "" + index.correo_alternativo},
            {text: "" + index.telefono},
            {text: "" + index.celular}
          ]);
        }
      }.bind(this));

     

      //Se declara el nombre del archivo y de la hoja de excel, as� mismo se manda llamar el data = dataExport
      var tableData = [
        {
          sheetName: "Reporte de asistencias",
          data: this.dataExportar
        }
      ];
      var options = {
        fileName: "Reporte_asistencias",
        header:true,
      };
      this.cargandoExportar = false;
      //Libreria que realiza el exportar a Excel
      Jhxlsx.export(tableData, options);
    },
  },
  watch: 
  {
    fecha: function(val) {
      if(val != 0)
        this.fnCargarFuncionesAsistencia();
    }
  }
});
