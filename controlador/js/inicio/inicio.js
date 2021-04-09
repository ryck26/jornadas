
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
        overlay: false,
        menu1: false,
        menu2: false,
        ctr: 'controlador/inicio/controlador_inicio.php',
        items: [
            {
              action: 'cargarPlantilla(1)',
              title: 'Asistencia a cursos',
            },
            {
              action: 'restaurant',
              title: 'Registro a cursos',
              active: true,
            },
          ],
    },
    created() {
        //this.Menu();
      this.cargarPlantilla(1)
      
    },
    methods: {
      mobileCheck(){
        let check = false;
        (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
          return check;
      },
      cargarPlantilla(val){
        this.menu1=false;
        this.menu2=false;
        this.drawer = false;
        switch(val)
        {
          case 1:
            this.overlay = true;
            e = document.createElement("object");
            e.data = "../vista/procesos/proceso_clarificacion.php";
            e.type="text/html";
            // e.width="100%"; 
            if(this.mobileCheck())
            {
              e.width=screen.width;
              e.height=screen.height;
            }
            else
            {
              e.width="100%";
              e.width="100%";
            }
            document.getElementById("contenido").innerHTML="";
            document.getElementById("contenido").appendChild(e);
            
            e.addEventListener('load', function()
            {
              //this.menu1=true;
              this.overlay = false;
            }.bind(this));
            break;
          case 2:
            this.overlay = true;
            e = document.createElement("object");
            e.data = "../../vista/reportes/reporte_usuariosa.php";
            e.type="text/html";
            e.width="100%"; 
            e.height="100%";
            document.getElementById("contenido").innerHTML="";
            document.getElementById("contenido").appendChild(e);
            e.addEventListener('load', function()
            {
              this.menu2=true;
              this.overlay = false;
            }.bind(this));
            break;
        }

      },
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
                  console.log(response.data)

              }.bind(this))
              .catch(function(error) {
                console.log(error);
              })
              .then(function() {
                  
              }.bind(this));
      }
    },
 });


// function Inicio() {
//     this.chkMenu = "chk-menu";
//     this.dvOpacar = "opacar";
//     this.dvMenuToggle = "menu-toggle";
//     this.dvMenu = "#menu-items";
//     this.dvContenidoSitio = "#contenido-sitio";
//     this.ctr = "controlador/inicio/controlador_inicio.php";
//     this.arrMenu = [];
// }


/**********************************************
 * Metodos para construir el menu
 **********************************************/

/*
 *
 * @param {type} in_arr
 * @returns {Array|Object.prototype.acomodarArregloMenu.source}
 */
// Inicio.prototype.acomodarArregloMenu = function (in_arr) {
//     let source = [];
//     let items = [];

//     for (let val in in_arr) {
//         let nombre = in_arr[val]["nombre"];
//         let cve_menu_superior = in_arr[val]["cve_menu_superior"];
//         let cve_menu = in_arr[val]["cve_menu"];
//         let ruta = in_arr[val]["ruta"];

//         if (items[cve_menu_superior]) {
//             in_arr[val] = {"cve_menu": cve_menu, "cve_menu_superior": cve_menu_superior, "nombre": nombre, "item": in_arr[val], "ruta": ruta};
// //            in_arr[val] = {"cve_menu": cve_menu, "cve_menu_superior": cve_menu_superior, "nombre": nombre, "item": in_arr[val]};
//             if (!items[cve_menu_superior].items) {
//                 items[cve_menu_superior].items = [];
//             }
//             items[cve_menu_superior].items[items[cve_menu_superior].items.length] = in_arr[val];
//             items[cve_menu] = in_arr[val];
//         } else {
//             items[cve_menu] = {"cve_menu": cve_menu, "cve_menu_superior": cve_menu_superior, "nombre": nombre, "item": in_arr[val], "ruta": ruta};
// //            items[cve_menu] = {"cve_menu": cve_menu, "cve_menu_superior": cve_menu_superior, "nombre": nombre, "item": in_arr[val]};
//             source["c_" + cve_menu] = items[cve_menu];
//         }
//     }
//     return source;
// };

/*
 *
 * @param {type} parent
 * @param {type} items
 * @returns {undefined}
 */
//  Inicio.prototype.armarMenu = function (parent, items) {
//     let li, ul;
//     for (let val in items) {
//         if (items[val] && items[val].nombre) {
//             if (items[val].items && items[val].items.length > 0) {
//                 li = $('<input titulo="' + items[val].nombre + '" type="radio" name="nivel-' + items[val].cve_menu_superior + '" id="menu-it-' + items[val].cve_menu + '" onmousedown="inicio.on_mouse_down_radio(this)" onclick="inicio.on_click_radio(this)"/>'
//                         + '<label class="fl-it" for="menu-it-' + items[val].cve_menu + '" onmousedown="inicio.on_mouse_down_radio(this)" onclick="inicio.on_click_radio(this)"><span></span><span>' + items[val].nombre + '</span><span></span></label>');

//                 li.appendTo(parent);
//                 ul = $("<ul class=\"fl-co\"></ul>");
//                 ul.appendTo(li.parent());
//                 inicio.armarMenu(ul, items[val].items);
//             } else {
//                 if (items[val].ruta) {
//                     li = $('<input type="radio" name="ultimo-nivel" id="menu-it-' + items[val].cve_menu + '" onclick="inicio.ponerContenido(' + items[val].cve_menu + ');" />'
//                             + '<label class="fl-it fin-it" for="menu-it-' + items[val].cve_menu + '" ><span></span><span>' + items[val].nombre + '</span><span></span></label>');
//                     li.appendTo(parent);
//                 }
//             }
//         }
//     }
// };

/*
 *
 * @param {type} items
 * @param {type} text
 * @param {type} xdd
 * @returns {unresolved}
 */
// Inicio.prototype.buscarEnArreglo = function (items, text, xdd) {
//     for (let val in items) {
//         if (items[val] && items[val].nombre) {
//             if (items[val].items && items[val].items.length > 0) {
//                 if (inicio.normalizarTexto(items[val].nombre).indexOf(inicio.normalizarTexto(text)) > -1) {
//                     xdd.push(items[val]);
//                 }
//                 inicio.buscarEnArreglo(items[val].items, text, xdd);
//             } else {
//                 if (inicio.normalizarTexto(items[val].nombre).indexOf(inicio.normalizarTexto(text)) > -1) {
//                     xdd.push(items[val]);
//                 }
//             }
//         }
//     }
//     return xdd;
// };

/*
 *
 * @param {type} text
 * @returns {undefined}
 */
// Inicio.prototype.buscarMenu = function (text) {
//     let element = $(inicio.dvMenu + " .menu-contenedor-default");
//     element.html("");
//     if (text.length > 0) {
//         inicio.armarMenu(element, inicio.buscarEnArreglo(inicio.acomodarArregloMenu(inicio.arrMenu), text, []));
//     } else {
//         inicio.armarMenu(element, inicio.acomodarArregloMenu(inicio.arrMenu));
//     }
// };

/*
 *
 * @param {type} element
 * @returns {undefined}
 */
// Inicio.prototype.toggleMenu = function (element) {
//     if (element.checked) {
//         document.getElementById(inicio.dvMenuToggle).classList.add("mostrar-menu");
//         document.getElementById(inicio.dvOpacar).classList.add("opacar");
//     } else {
//         document.getElementById(inicio.dvMenuToggle).classList.remove("mostrar-menu");
//         document.getElementById(inicio.dvOpacar).classList.remove("opacar");
//     }
// };

/*
 *
 * @returns {undefined}
 */
// Inicio.prototype.closeMenu = function () {
//     document.getElementById(inicio.dvMenuToggle).classList.remove("mostrar-menu");
//     document.getElementById(inicio.dvOpacar).classList.remove("opacar");
//     document.getElementById(inicio.chkMenu).checked = false;
// };


/*
 * Metodo para normalizar un String
 * elimina acentos y espacios
 * @param {type} str
 * @returns {String}
 */
// Inicio.prototype.normalizarTexto = function (str) {
//     let from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç ",
//             to = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc-",
//             mapping = {};
//     let ret = [];
//     for (let i = 0; i < from.length; i++) {
//         mapping[ from.charAt(i) ] = to.charAt(i);
//     }

//     for (let i = 0; i < str.length; i++) {
//         let c = str.toLowerCase().trim().charAt(i);
//         if (mapping.hasOwnProperty(str.charAt(i))) {
//             ret.push(mapping[ c ]);
//         } else {
//             ret.push(c);
//         }
//     }
//     return ret.join("");
// };

/*
 * Metodo para poner funcionalidad de checkbox a un radio button
 * @param {type} element
 * @returns {undefined}
 */
// Inicio.prototype.on_mouse_down_radio = function (element) {
//     let radioId = element.getAttribute("for");
//     if (radioId !== null) {
//         document.getElementById(radioId).__chk = document.getElementById(radioId).checked;
//     } else {
//         element.__chk = element.checked;
//     }
// };

/*
 * Metodo para poner funcionalidad de checkbox a un radio button
 * @param {type} element
 * @returns {undefined}
 */
// Inicio.prototype.on_click_radio = function (element) {
//     let radioId = element.getAttribute("for");
//     if (radioId !== null) {
//         if (document.getElementById(radioId).__chk) {
//             document.getElementById(radioId).checked = false;
//         }
//     } else {
//         if (element.__chk) {
//             element.checked = false;
//         }
//     }
// };

/**********************************************
 * Metodos mensajes
 **********************************************/


//     swal.fire({
//         title: 'Cargando...',
//         html:img,
//         //imageUrl: 'resource/img/loader.svg',
//         showConfirmButton: false
        
//     });
// };

// Inicio.prototype.registroOk = function () {
//     return swal.fire({
//         type: 'success',
//         title: 'Registro correcto',
//         html: 'Se registró correctamene',
//         confirmButtonText: 'Ok',
//         showLoaderOnConfirm: true,
//         allowOutsideClick: false
//     });
// };

// Inicio.prototype.registroNoOk = function () {
//     return swal.fire({
//         type: 'info',
//         title: 'Registro incorrecto',
//         html: 'No se registró correctamene',
//         confirmButtonText: 'Ok',
//         showLoaderOnConfirm: true,
//         allowOutsideClick: false
//     });
// };

// Inicio.prototype.modificacionOk = function () {
//     return swal.fire({
//         type: 'success',
//         title: 'Modificación correcta',
//         html: 'Se modificó correctamene',
//         confirmButtonText: 'Ok',
//         showLoaderOnConfirm: true,
//         allowOutsideClick: false
//     });
// };

// Inicio.prototype.modificacionNoOk = function () {
//     return swal.fire({
//         type: 'info',
//         title: 'Modificación incorrecta',
//         html: 'No se modificó correctamene',
//         confirmButtonText: 'Ok',
//         showLoaderOnConfirm: true,
//         allowOutsideClick: false
//     });
// };

// Inicio.prototype.eliminacionOk = function () {
//     return swal.fire({
//         type: 'success',
//         title: 'Eliminación correcta',
//         html: 'Se eliminó correctamene',
//         confirmButtonText: 'Ok',
//         showLoaderOnConfirm: true,
//         allowOutsideClick: false
//     });
// };

// Inicio.prototype.eliminacionNoOk = function () {
//     return swal.fire({
//         type: 'info',
//         title: 'Eliminación incorrecta',
//         html: 'No se eliminó correctamene',
//         confirmButtonText: 'Ok',
//         showLoaderOnConfirm: true,
//         allowOutsideClick: false
//     });
// };

// Inicio.prototype.activacionOk = function () {
//     return swal.fire({
//         type: 'success',
//         title: 'Activación correcta',
//         html: 'Se activó correctamene',
//         confirmButtonText: 'Ok',
//         showLoaderOnConfirm: true,
//         allowOutsideClick: false
//     });
// };

// Inicio.prototype.activacionNoOk = function () {
//     return swal.fire({
//         type: 'info',
//         title: 'Activación incorrecta',
//         html: 'No se activó correctamene',
//         confirmButtonText: 'Ok',
//         showLoaderOnConfirm: true,
//         allowOutsideClick: false
//     });
// };

// Inicio.prototype.aviso = function (texto) {
//     return swal.fire({
//         type: 'info',
//         title: 'Aviso',
//         html: texto,
//         confirmButtonText: 'Ok',
//         showLoaderOnConfirm: true,
//         allowOutsideClick: false
//     });
// };

// Inicio.prototype.error = function () {
//     return swal.fire({
//         type: 'error',
//         title: 'Ha ocurrido un error',
//         html: 'No se pudo realizar la acción, vuelva a intentarlo, si el error persiste comuniquese con el administrador del sistema',
//         confirmButtonText: 'Ok',
//         showLoaderOnConfirm: true,
//         allowOutsideClick: false
//     });
// };

// /**********************************************
//  * Metodos generales
//  **********************************************/

// /*
//  * Metodo para cambiar de pagina a mostrar
//  * @param {type} element
//  * @param {type} text
//  * @returns {undefined}
//  */
// Inicio.prototype.ponerContenido = function (cve) {
// //    console.log(element.checked);
//     $.ajax({
//         type: "POST",
// //        dataType: "json",
//         url: inicio.ctr,
//         data: {"cve": cve, "accion": 3},
//         beforeSend: function (xhr) {
//             inicio.preloader();
//         },
//         success: function (data, textStatus, jqXHR) {
// //            console.log(data);
//             $(inicio.dvContenidoSitio).html(data);
//             swal.close();
//         },
//         error: function (jqXHR, textStatus, errorThrown) {
// //            console.log(errorThrown);
//             inicio.error();
//         }
//     });
//     inicio.closeMenu();
// };

// Inicio.prototype.listarOpcionesMenu = function () {
//     $.ajax({
//         type: "POST",
//         url: inicio.ctr,
//         dataType: "json",
//         data: {"accion": 1},
//         beforeSend: function (xhr) {

//         },
//         success: function (data, textStatus, jqXHR) {
// //            console.log(data);
//             inicio.arrMenu = data;
//             inicio.armarMenu($(inicio.dvMenu + " .menu-contenedor-default"), inicio.acomodarArregloMenu(inicio.arrMenu));
//         },
//         error: function (jqXHR, textStatus, errorThrown) {
// //            console.log(errorThrown);
//         }
//     });
// };

// Inicio.prototype.cerrarUsuario = function () {
//     $.ajax({
//         type: "POST",
// //        dataType: "json",
//         url: inicio.ctr,
//         data: {"accion": 2},
//         beforeSend: function (xhr) {
//         },
//         success: function (data, textStatus, jqXHR) {
// //            console.log(data);
//             location.reload();
//         },
//         error: function (jqXHR, textStatus, errorThrown) {
// //            console.log("jqXHR: " + jqXHR + " || textStatus: " + textStatus + " || errorThrown: " + errorThrown + " || ");
//         }
//     });
// };


// /**********************************************
//  * Inicializar
//  **********************************************/

// let inicio = new Inicio();
// inicio.preloader();

//  $.fn.datepicker.dates['en'] = {
//         days: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Vierdes", "Sabado"],
//         daysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
//         daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
//         months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
//         monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
//         today: "Hoy",
//         clear: "Limpiar",
//         format: "yyyy-mm-dd",
//         titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
//         weekStart: 0,
//         startDate: new Date()
//     };

//     Inicio.prototype.tDataTable = function(){
//         //Traducci󮠤e la tabla a espa񯬍
//       return {
//           "sProcessing": "Procesando...",
//           "sLengthMenu": "Mostrar _MENU_ registros",
//           "sZeroRecords": "No se encontraron resultados",
//           "sEmptyTable": "No hay datos disponibles",
//           "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
//           "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
//           "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
//           "sInfoPostFix": "",
//           "sSearch": "Buscar:",
//           "sUrl": "",
//           "sInfoThousands": ",",
//           "sLoadingRecords": "Cargando...",
//           "oPaginate": {
//               "sFirst": "Primero",
//               "sLast": "Último",
//               "sNext": "Siguiente",
//               "sPrevious": "Anterior"
//           },
//           "oAria": {
//               "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
//               "sSortDescending": ": Activar para ordenar la columna de manera descendente"
//           }
//       };
//   };

// //Llamada al metodo para armar el menu
// inicio.listarOpcionesMenu();

// //inicio.ponerContenido($("#yPagAct").val());
// inicio.ponerContenido(5);

// swal.close();
