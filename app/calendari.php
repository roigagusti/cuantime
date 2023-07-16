<?php
// Redirecció a HTTPS
if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on"){
  header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
  exit;
}
include_once("conexiones/conexion.php");
session_start();
include_once("sections/sessionStart.php");

function telefon($a){
    if(strlen($a)==9){
      return substr($a,0,3).' '.substr($a,3,3).' '.substr($a,6,3);
    }else if(substr($a,0,3)=='+34'||substr($a,0,3)=='+33'){
      return '+'.substr($a,1,2).' '.substr($a,3,3).' '.substr($a,6,3).' '.substr($a,9,3);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
    <!-- Meta data -->
    <?php include_once("sections/meta.php") ?>

    <!-- Títol i Favicons -->
    <title>Cuantime. Equipo</title>

    <!-- CSS Libraries -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    
    <link href="assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="assets/libs/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
    <link href="assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">

    <link href="assets/libs/%40fullcalendar/core/main.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/%40fullcalendar/daygrid/main.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/%40fullcalendar/bootstrap/main.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/%40fullcalendar/timegrid/main.min.css" rel="stylesheet" type="text/css" />
    <!-- CSS Custom -->
    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen">
    <link rel="stylesheet" type="text/css" href="css/responsive.css" media="screen">

    <!-- Scripts Libraries -->
    <!-- Scripts custom -->
</head>

<body>
    <div id="layout-wrapper">
        <?php include_once("sections/header.php") ?>
        <?php include_once("sections/sidebar-menu.php") ?>
    
        <!-- ============================================================== -->
        <!-- PÀGINA INICIAL -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- Zona superior de títol -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0">Calendario</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="index.php">Cuantime</a></li>
                                    <li class="breadcrumb-item active">Calendario</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- ZONA NOTIFIACIONS -->
                    <?php include_once("sections/notificacions.php") ?>

                    <div class="row">
                        <div class="col-12">

                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div id="external-events" class="m-t-20">
                                                <!--<p class="text-muted">Etiquetes disponibles per arrastrar</p>
                                                <div class="external-event fc-event bg-info" data-class="bg-info" style="text-align:center!important">Recuperable</div>
                                                <div class="external-event fc-event bg-warning" data-class="bg-warning" style="text-align:center!important">Malalt</div>
                                                <div class="external-event fc-event bg-success" data-class="bg-success" style="text-align:center!important">Festiu</div>
                                                <div class="external-event fc-event bg-danger" data-class="bg-danger" style="text-align:center!important">Vacances</div>
                                                <div class="external-event fc-event bg-danger" data-class="bg-danger" style="text-align:center!important">Vacances any anterior</div>-->
                                            </div>
                                            <?php 
                                            //CALCUL LABORABLES
                                            $calendariLaborables=$database->count("calendari",["AND"=>['idUser'=>$userId,"data[<>]"=>[date("Y-m-d H:i:s", mktime(0, 0, 0, 1, 1, date('Y'))), date("Y-m-d H:i:s", mktime(0, 0, 0, 12, 31, date('Y')))]]]);
                                            $capsDeSetmana=52*2;
                                            $laborables=365-$calendariLaborables-$capsDeSetmana;
                                            if(date('L')==1){$laborables+=1;}
                                            echo 'Laborables: '.$laborables.'<br>';

                                            //CALCUL VACANCES PENDENTS
                                            $calendariVacances=$database->count("calendari",["AND"=>['type'=>4,'idUser'=>$userId,"data[<>]"=>[date("Y-m-d H:i:s", mktime(0, 0, 0, 1, 1, date('Y'))), date("Y-m-d H:i:s", mktime(0, 0, 0, 12, 31, date('Y')))]]]);
                                            $diesVacances=21;
                                            $vacancesDispo=$diesVacances-$calendariVacances;
                                            echo 'Vacaciones pendientes: '.$vacancesDispo.'/'.$diesVacances.'<br>';

                                            //CALCUL DIES MALALT
                                            $diesMalalt=$database->count("calendari",["AND"=>['type'=>3,'idUser'=>$userId,"data[<>]"=>[date("Y-m-d H:i:s", mktime(0, 0, 0, 1, 1, date('Y'))), date("Y-m-d H:i:s", mktime(0, 0, 0, date('n'), date('j'), date('Y')))]]]);
                                            echo 'Enfermedad: '.$diesMalalt.'<br>';

                                            //CALCUL DIES RECUPERABLES
                                            $diesRecuperables=$database->count("calendari",["AND"=>['type'=>2,'idUser'=>$userId,"data[<>]"=>[date("Y-m-d H:i:s", mktime(0, 0, 0, 1, 1, date('Y'))), date("Y-m-d H:i:s", mktime(0, 0, 0, date('n'), date('j'), date('Y')))]]]);
                                            echo 'Recuperables: '.$diesRecuperables;
                                            ?>
                                        </div>
                                    </div>
                                    <div class="d-print-none mt-4">
                                        <a href="equip.php" class="btn btn-link text-muted">
                                            <i class="uil uil-arrow-left mr-1"></i> Volver a equipo
                                        </a>
                                    </div>
                                </div> <!-- end col-->
                            
                                

                                <div class="col-lg-9">
                                    <div class="card">
                                        <div class="card-body">
                                            <style>.fc-dayGridMonth-button,.fc-timeGridWeek-button,.fc-timeGridDay-button,.fc-today-button{display:none}</style>
                                            <div id="calendar"></div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->

                            </div> 
                        </div>
                    </div>
                    <!-- end row -->
                    <div class="modal fade" id="event-modal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header py-3 px-4 border-bottom-0 d-block">
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                    <h5 class="modal-title" id="modal-title">Añadir etiqueta</h5>
                                </div>
                                <div class="modal-body p-4">
                                    <form method="POST" class="needs-validation" name="event-form" id="form-event" action="conexiones/calendari.php?action=addEvent">
                                        <input type="hidden" class="form-control" value="<?php echo $userId;?>" name="userId">
                                        <div id="dataCalendariAdd"></div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="control-label">Categoria</label>
                                                    <select class="form-control custom-select" name="category"
                                                        id="event-category" required>
                                                        <option value="0">Laborable</option>
                                                        <option value="3">Enfermo</option>
                                                        <option value="4">Vacaciones</option>
                                                        <option value="5">Vacaciones año anterior</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-6">
                                                <!--<a href="conexiones/calendari.php?action=removeEvent&id=" class="btn btn-danger" id="btn-delete-event">Borrar</a>-->
                                            </div>
                                            <div class="col-6 text-right">
                                                <button type="submit" class="btn btn-success">Guardar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div> <!-- end modal-content-->
                        </div> <!-- end modal dialog-->
                    </div>

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            <?php include_once("sections/footer.php") ?>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

<!-- JavaScripts basics -->
<script src="assets/libs/jquery/jquery.min.js"></script>
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/metismenu/metisMenu.min.js"></script>
<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/libs/node-waves/waves.min.js"></script>
<script src="assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
<script src="assets/libs/jquery.counterup/jquery.counterup.min.js"></script>

<script src="assets/libs/apexcharts/apexcharts.min.js"></script>
<script src="assets/js/pages/dashboard.init.js"></script>
<script src="assets/libs/apexcharts/apexcharts.min.js"></script>
<script src="assets/js/pages/dashboard.init.js"></script>
<script src="assets/js/pages/form-advanced.init.js"></script>
<script src="assets/libs/select2/js/select2.min.js"></script>
<script src="assets/libs/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>

<script src="assets/libs/moment/min/moment.min.js"></script>
<script src="assets/libs/jquery-ui-dist/jquery-ui.min.js"></script>
<script src="assets/libs/%40fullcalendar/core/main.min.js"></script>
<script src="assets/libs/%40fullcalendar/bootstrap/main.min.js"></script>
<script src="assets/libs/%40fullcalendar/daygrid/main.min.js"></script>
<script src="assets/libs/%40fullcalendar/timegrid/main.min.js"></script>
<script src="assets/libs/%40fullcalendar/interaction/main.min.js"></script>
<!-- JavaScripts custom -->
<script src="assets/js/app.js"></script>
<!--<script src="assets/js/pages/calendar.init.js"></script>-->
<script>
! function(g) {
    "use strict";

    function e() {}
    e.prototype.init = function() {
        var l = g("#event-modal"),
            t = g("#modal-title"),
            a = g("#form-event"),
            j = g("#dataCalendariAdd"),
            i = null,
            r = null,
            s = document.getElementsByClassName("needs-validation"),
            i = null,
            r = null,
            e = new Date,
            n = e.getDate(),
            d = e.getMonth(),
            o = e.getFullYear();
        new FullCalendarInteraction.Draggable(document.getElementById("external-events"), {
            itemSelector: ".external-event",
            eventData: function(e) {
                return {
                    title: e.innerText,
                    className: g(e).data("class")
                }
            }
        });
        /*var c = []*/
        var c = [
            /*{
                title: "Vacances",
                start: new Date(2021, 2, 1),
                allDay: 1,
                className: "bg-warning"
            },*/
            <?php
            $calendaris = $database->select("calendari", [
                "id",
                "idUser",
                "type",
                "data"
                ],["idUser"=>$userId]);
            $entradesCalendari = '';
            foreach ($calendaris as $calendari){
                switch ($calendari['type']){
                    case 1:
                        $calendariTitle="Festivo";
                        $calendariClass="bg-success";
                        break;
                    case 2:
                        $calendariTitle="Recuperable";
                        $calendariClass="bg-info";
                        break;
                    case 3:
                        $calendariTitle="Enfermo";
                        $calendariClass="bg-warning";
                        break;
                    case 4:
                        $calendariTitle="Vacaciones";
                        $calendariClass="bg-danger";
                        break;
                    case 5:
                        $calendariTitle="Vacaciones AA";
                        $calendariClass="bg-danger";
                        break;
                    default:
                        $calendariTitle="";
                        $calendariClass="";
                        break;
                }
                $entradaDia=date('j',strtotime($calendari['data']));
                $entradaMes=date('n',strtotime($calendari['data']))-1;
                $entradaAny=date('Y',strtotime($calendari['data']));
                if($calendari['type']!=0){
                    $entradesCalendari.= '{title:"'.$calendariTitle.'",start:new Date('.$entradaAny.','.$entradaMes.','.$entradaDia.'),allDay:1,className:"'.$calendariClass.'"},';
                }
            }
            echo substr($entradesCalendari,0,-1);
            ?>

            ],
            v = (document.getElementById("external-events"), document.getElementById("calendar"));

        function u(e) {
            l.modal("show"),
            a.removeClass("was-validated"),
            a[0].reset(),
            g("#event-title").val(),
            g("#event-category").val(),
            t.text("Etiquetar dia"),
            j.text(''),            
            j.append('<input type="hidden" value="'+e.date+'" name="dataCalendari">'),
            r = e
        }
        var m = new FullCalendar.Calendar(v, {
            plugins: ["bootstrap", "interaction", "dayGrid", "timeGrid"],
            editable: !0,
            droppable: !0,
            selectable: !0,
            defaultView: "dayGridMonth",
            themeSystem: "bootstrap",
            header: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth"
            },
            eventClick: function(e) {
                l.modal("show"), a[0].reset(), i = e.event, g("#event-title").val(i.title), g("#event-category").val(i.classNames[0]), r = null, t.text("Editar dia"), r = null
            },
            dateClick: function(e) {
                u(e)
            },
            events: c
        });
        m.render(), g(a).on("", function(e) {
            e.preventDefault();
            g("#form-event :input");
            var t, a = g("#event-title").val(),
                n = g("#event-category").val();
            !1 === s[0].checkValidity() ? (event.preventDefault(), event.stopPropagation(), s[0].classList.add("was-validated")) : (i ? (i.setProp("title", a), i.setProp("classNames", [n])) : (t = {
                title: a,
                start: r.date,
                allDay: r.allDay,
                className: n
            }, m.addEvent(t)), l.modal("hide"))
        }), g("#btn-delete-event").on("click", function(e) {
            i && (i.remove(), i = null, l.modal("hide"))
        }), g("#btn-new-event").on("click", function(e) {
            u({
                date: new Date,
                allDay: !0
            })
        })
    }, g.CalendarPage = new e, g.CalendarPage.Constructor = e
}(window.jQuery),
function() {
    "use strict";
    window.jQuery.CalendarPage.init()
}();

/*
TRADUCCIÓ
$(function () {
    $span = $('#calendar h2').find('MARCH');
    $('#calendar h2').append("MARÇ");
    $('#calendar h2').append($span);
});*/
</script>
<!-- Scripts custom -->

</body>
</html>