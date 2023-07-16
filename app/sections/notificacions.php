<?php 
switch($_GET['event']){
    // OFERTES
    case 'oferta-success':
        $alertText="La oferta se ha creado correctamente.";
        $alertBadge='success';
        break;
    case 'edit-oferta-success':
        $alertText="La oferta se ha modificado correctamente.";
        $alertBadge='success';
        break;
    case 'edit-estat-oferta-success':
        $alertText="El estat de la oferta se ha modificado correctamente.";
        $alertBadge='success';
        break;
    case 'oferta-deleted':
        $alertText="La oferta se ha borrado correctamente.";
        $alertBadge='success';
        break;
    case 'oferta-not-deleted':
        $alertText="La oferta no se ha borrado. Ha que escribir 'esborrar' para confirmar.";
        $alertBadge='danger';
        break;

    // EXPEDIENTS
    case 'exp-success':
        $alertText="El expediente se ha creado correctamente.";
        $alertBadge='success';
        break;
    case 'edit-num-exp-success':
        $alertText="El número de expediente se ha modificado correctamente.";
        $alertBadge='success';
        break;
    case 'edit-estat-exp-success':
        $alertText="El estado del expediente se ha modificado correctamente.";
        $alertBadge='success';
        break;
    case 'exp-deleted':
        $alertText="El expediente se ha borrado correctamente.";
        $alertBadge='success';
        break;

    // FACTURES
    case 'factura-success':
        $alertText="La factura se ha creado correctamente.";
        $alertBadge='success';
        break;
    case 'edit-estat-factura-success':
        $alertText="El estdo de la factura se ha modificado correctamente.";
        $alertBadge='success';
        break;
    case 'edit-factura-success':
        $alertText="La factura se ha modificado correctamente.";
        $alertBadge='success';
        break;
    case 'factura-deleted':
        $alertText="La factura se ha borrado correctamente.";
        $alertBadge='success';
        break;

    // DESPESES
    case 'despesa-success':
        $alertText="El gasto se ha creado correctamente.";
        $alertBadge='success';
        break;
    case 'edit-despesa-success':
        $alertText="El gasto se ha modificado correctamente.";
        $alertBadge='success';
        break;
    case 'despesa-deleted':
        $alertText="El gasto se ha borrado correctamente.";
        $alertBadge='success';
        break;

    // CLIENT
    case 'client-success':
        $alertText="El cliente se ha creado correctamente.";
        $alertBadge='success';
        break;
    case 'edit-client-success':
        $alertText="El cliente se ha modificado correctamente.";
        $alertBadge='success';
        break;
    case 'client-deleted':
        $alertText="El cliente se ha borrado correctamente.";
        $alertBadge='success';
        break;

    // EMPRESA
    case 'edit-empresa-success':
        $alertText="La empresa se ha modificado correctamente.";
        $alertBadge='success';
        break;

    // CALENDARI
    case 'event-success':
        $alertText="El evento se ha creado correctamente.";
        $alertBadge='success';
        break;

    // TASQUES
    case 'task-success':
        $alertText="La tarea se ha creado correctamente.";
        $alertBadge='success';
        break;
    case 'task-deleted':
        $alertText="La tarea se ha borrado correctamente.";
        $alertBadge='success';
        break;

    // USUARIS
    case 'user-success':
        $alertText="El usuario se ha modificado correctamente.";
        $alertBadge='success';
        break;
    case 'pass-error':
        $alertText="Ha habido un problema con la contraseña.";
        $alertBadge='danger';
        break;
    case 'profile-success':
        $alertText="El perfil de usuario se ha modificado correctamente.";
        $alertBadge='success';
        break;
    case 'user-deleted':
        $alertText="El usuario se ha borrado correctamente.";
        $alertBadge='success';
        break;

    default:
        break;
}
if(isset($_GET['event'])){$alertShow='show';}
?>

<div class="alert alert-<?php echo $alertBadge;?> alert-dismissible fade <?php echo $alertShow;?> mb-0 notificacio" role="alert">
    <?php echo $alertText;?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>