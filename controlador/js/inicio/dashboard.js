var arraySesiones;
var arrayCompromisos;

function FormularioDashboard(){
    this.crt="controlador/inicio/Controlador_dashboard.php";
    this.Modelo = {
        accion: 0
    };
    this.post = null;
}

FormularioDashboard.prototype.fnSesiones = function(){
    this.Modelo.accion=1;
    inicio.preloader();
    this.post = $.post(this.crt,this.Modelo);
    this.post.done(function(data){
        if(!$.isEmptyObject(data)){
            data = JSON.parse(data);
            arraySesiones = data;
                // events.push({title:data[i].nombre, start: new Date(y, m, 1)})
        }
        swal.close();
    }.bind(this));
};

FormularioDashboard.prototype.fnCompromisos = function(){
    this.Modelo.accion=2;
    inicio.preloader();
    this.post = $.post(this.crt,this.Modelo);
    this.post.done(function(data){
        if(!$.isEmptyObject(data)){
            data = JSON.parse(data);
            arrayCompromisos = data;
                // events.push({title:data[i].nombre, start: new Date(y, m, 1)})
        }
        swal.close();
    }.bind(this));
};


$(document).ready(function() {
    objDashboard=new FormularioDashboard();
    objDashboard.fnSesiones();
    objDashboard.fnCompromisos();

    var calendarEl = document.getElementById('calendar');
    var hoy = new Date().toISOString();
    
    var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: [ 'interaction', 'dayGrid', 'timeGrid' ],
        defaultView: 'dayGridMonth',
        locale:'es',
        defaultDate: hoy,
        header: {
            left: 'prev, next, today',
            center: 'title',
            right: 'timeGridWeek, timeGridDay'
        },

        eventClick: function(info){
            console.log(info.event.id);
            if(info.event.id == 1)
            {
                if(cve_grupo_seguridad == 1 || cve_grupo_seguridad == 2)
                    $(inicio.dvContenidoSitio).load('vista/catalogos/catalogo_sesion.php');
            }
            else
                $(inicio.dvContenidoSitio).load('vista/reportes/reporte_compromisos.php');
        },

        eventMouseEnter: function(mouseEnterInfo){
            $('.'+mouseEnterInfo.event.classNames[0]).css( 'cursor', 'pointer' );
        }
    });

    setTimeout(() => {
        //Eventos de sesiones
        for(var i = 0; i < arraySesiones.length; i++)
        {
            calendar.addEvent({
                id : 1,
                title:arraySesiones[i].nombre,
                start:arraySesiones[i].fecha,
                // color: '#992100',
                color: '#00B792',
                classNames: 'evSesion'
            });
        }
        //Eventos de compromisos
        for(var i = 0; i < arrayCompromisos.length; i++)
        {
            calendar.addEvent({
                id : 2,
                title:arrayCompromisos[i].titulo,
                start:arrayCompromisos[i].fecha_cumplimiento,
                // color: '#FF6A00',
                color: '#FFAD00',
                classNames: 'evCompromiso'
            });
        } 
        
    }, 400);
  
    calendar.render();

    // $('.evSesion').css('cursor', 'pointer');
    // $(".evSesion").mouseenter(function() {
    //     console.log("e");
        
    // });
  });