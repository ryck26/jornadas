<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>


    <link href='resource/fullcalendar/core/main.css' rel='stylesheet' />
    <link href='resource/fullcalendar/daygrid/main.css' rel='stylesheet' />

    <script src='resource/fullcalendar/core/main.js'></script>
    <script src='resource/fullcalendar/daygrid/main.js'></script>
    <script src='resource/fullcalendar/core/locales/es.js'></script>

    <script>
      var cve_grupo_seguridad = <?php echo $_SESSION["USUARIO"]["cve_grupo_seguridad"];?>;

      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
          plugins: [ 'dayGrid' ]
        });

        calendar.render();
      });

    </script>
    
</head>

<body>
    <br>
    <div class="row">
    
        <div class="col-md-2"></div>
        <div class="col-md-8">
            Sesiones <span class="badge badge-success">&nbsp&nbsp</span>
            Compromisos <span class="badge badge-warning">&nbsp&nbsp</span>
        </div>
        <div class="col-md-2"></div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div id='calendar'></div>    
        </div>
        <div class="col-md-2"></div>
    </div>
    
    <script type="text/javascript" src="controlador/js/inicio/dashboard.js"></script>
</body>
</html>