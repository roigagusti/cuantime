<?php 
switch($_GET['event']){
    // OFERTES
    case 'oferta-success':
        switch($lang){
            case 'es':
                $alertText="La oferta se ha creado correctamente.";
                break;
            case 'ca':
                $alertText="L'oferta s'ha creat correctament.";
                break;
            case 'en':
                $alertText="The offer has been created successfully.";
                break;
            case 'fr':
                $alertText="L'offre a été créée avec succès.";
                break;
            default:
                break;
        }
        $alertBadge='success';
        break;
    case 'edit-oferta-success':
        switch($lang){
            case 'es':
                $alertText="La oferta se ha modificado correctamente.";
                break;
            case 'ca':
                $alertText="L'oferta s'ha modificat correctament.";
                break;
            case 'en':
                $alertText="The offer has been modified successfully.";
                break;
            case 'fr':
                $alertText="L'offre a été modifiée avec succès.";
                break;
            default:
                break;
        }
        $alertBadge='success';
        break;
    case 'edit-estat-oferta-success':
        switch($lang){
            case 'es':
                $alertText="El estado de la oferta se ha modificado correctamente.";
                break;
            case 'ca':
                $alertText="L'estat de l'oferta s'ha modificat correctament.";
                break;
            case 'en':
                $alertText="The status of the offer has been modified successfully.";
                break;
            case 'fr':
                $alertText="L'état de l'offre a été modifié avec succès.";
                break;
            default:
                break;
        }
        $alertBadge='success';
        break;
    case 'oferta-deleted':
        switch($lang){
            case 'es':
                $alertText="La oferta se ha borrado correctamente.";
                break;
            case 'ca':
                $alertText="L'oferta s'ha eliminat correctament.";
                break;
            case 'en':
                $alertText="The offer has been deleted successfully.";
                break;
            case 'fr':
                $alertText="L'offre a été supprimée avec succès.";
                break;
            default:
                break;
        }
        $alertBadge='success';
        break;
    case 'oferta-not-deleted':
        switch($lang){
            case 'es':
                $alertText="La oferta no se ha borrado. Hay que escribir 'borrar' para confirmar.";
                break;
            case 'ca':
                $alertText="L'oferta no s'ha eliminat. Cal escriure 'esborrar' per confirmar.";
                break;
            case 'en':
                $alertText="The offer has not been deleted. You must type 'delete' to confirm.";
                break;
            case 'fr':
                $alertText="L'offre n'a pas été supprimée. Vous devez taper 'supprimer' pour confirmer.";
                break;
            default:
                break;
        }
        $alertBadge='danger';
        break;

    // EXPEDIENTS
    case 'exp-success':
        switch($lang){
            case 'es':
                $alertText="El expediente se ha creado correctamente.";
                break;
            case 'ca':
                $alertText="L'expedient s'ha creat correctament.";
                break;
            case 'en':
                $alertText="The case has been created successfully.";
                break;
            case 'fr':
                $alertText="L'expédition a été créée avec succès.";
                break;
            default:
                break;
        }
        $alertBadge='success';
        break;
    case 'edit-num-exp-success':
        switch($lang){
            case 'es':
                $alertText="El número de expediente se ha modificado correctamente.";
                break;
            case 'ca':
                $alertText="El número d'expedient s'ha modificat correctament.";
                break;
            case 'en':
                $alertText="The case number has been modified successfully.";
                break;
            case 'fr':
                $alertText="Le numéro de l'expédition a été modifié avec succès.";
                break;
            default:
                break;
        }
        $alertBadge='success';
        break;
    case 'edit-estat-exp-success':
        switch($lang){
            case 'es':
                $alertText="El estado del expediente se ha modificado correctamente.";
                break;
            case 'ca':
                $alertText="L'estat de l'expedient s'ha modificat correctament.";
                break;
            case 'en':
                $alertText="The status of the case has been modified successfully.";
                break;
            case 'fr':
                $alertText="L'état de l'expédition a été modifié avec succès.";
                break;
            default:
                break;
        }
        $alertBadge='success';
        break;
    case 'exp-deleted':
        switch($lang){
            case 'es':
                $alertText="El expediente se ha borrado correctamente.";
                break;
            case 'ca':
                $alertText="L'expedient s'ha eliminat correctament.";
                break;
            case 'en':
                $alertText="The case has been deleted successfully.";
                break;
            case 'fr':
                $alertText="L'expédition a été supprimée avec succès.";
                break;
            default:
                break;
        }
        $alertBadge='success';
        break;

    // FACTURES
    case 'factura-success':
        switch($lang){
            case 'es':
                $alertText="La factura se ha creado correctamente.";
                break;
            case 'ca':
                $alertText="La factura s'ha creat correctament.";
                break;
            case 'en':
                $alertText="The invoice has been created successfully.";
                break;
            case 'fr':
                $alertText="La facture a été créée avec succès.";
                break;
            default:
                break;
        }
        $alertBadge='success';
        break;
    case 'edit-estat-factura-success':
        switch($lang){
            case 'es':
                $alertText="El estado de la factura se ha modificado correctamente.";
                break;
            case 'ca':
                $alertText="L'estat de la factura s'ha modificat correctament.";
                break;
            case 'en':
                $alertText="The status of the invoice has been modified successfully.";
                break;
            case 'fr':
                $alertText="L'état de la facture a été modifié avec succès.";
                break;
            default:
                break;
        }
        $alertBadge='success';
        break;
    case 'edit-factura-success':
        switch($lang){
            case 'es':
                $alertText="La factura se ha modificado correctamente.";
                break;
            case 'ca':
                $alertText="La factura s'ha modificat correctament.";
                break;
            case 'en':
                $alertText="The invoice has been modified successfully.";
                break;
            case 'fr':
                $alertText="La facture a été modifiée avec succès.";
                break;
            default:
                break;
        }
        $alertBadge='success';
        break;
    case 'factura-deleted':
        switch($lang){
            case 'es':
                $alertText="La factura se ha borrado correctamente.";
                break;
            case 'ca':
                $alertText="La factura s'ha eliminat correctament.";
                break;
            case 'en':
                $alertText="The invoice has been deleted successfully.";
                break;
            case 'fr':
                $alertText="La facture a été supprimée avec succès.";
                break;
            default:
                break;
        }
        $alertBadge='success';
        break;

    // DESPESES
    case 'despesa-success':
        switch($lang){
            case 'es':
                $alertText="El gasto se ha creado correctamente.";
                break;
            case 'ca':
                $alertText="La despesa s'ha creat correctament.";
                break;
            case 'en':
                $alertText="The expense has been created successfully.";
                break;
            case 'fr':
                $alertText="La dépense a été créée avec succès.";
                break;
            default:
                break;
        }
        $alertBadge='success';
        break;
    case 'edit-despesa-success':
        switch($lang){
            case 'es':
                $alertText="El gasto se ha modificado correctamente.";
                break;
            case 'ca':
                $alertText="La despesa s'ha modificat correctament.";
                break;
            case 'en':
                $alertText="The expense has been modified successfully.";
                break;
            case 'fr':
                $alertText="La dépense a été modifiée avec succès.";
                break;
            default:
                break;
        }
        $alertBadge='success';
        break;
    case 'despesa-deleted':
        switch($lang){
            case 'es':
                $alertText="El gasto se ha borrado correctamente.";
                break;
            case 'ca':
                $alertText="La despesa s'ha eliminat correctament.";
                break;
            case 'en':
                $alertText="The expense has been deleted successfully.";
                break;
            case 'fr':
                $alertText="La dépense a été supprimée avec succès.";
                break;
            default:
                break;
        }
        $alertBadge='success';
        break;

    // CLIENT
    case 'client-success':
        switch($lang){
            case 'es':
                $alertText="El cliente se ha creado correctamente.";
                break;
            case 'ca':
                $alertText="El client s'ha creat correctament.";
                break;
            case 'en':
                $alertText="The client has been created successfully.";
                break;
            case 'fr':
                $alertText="Le client a été créé avec succès.";
                break;
            default:
                break;
        }
        $alertBadge='success';
        break;
    case 'edit-client-success':
        switch($lang){
            case 'es':
                $alertText="El cliente se ha modificado correctamente.";
                break;
            case 'ca':
                $alertText="El client s'ha modificat correctament.";
                break;
            case 'en':
                $alertText="The client has been modified successfully.";
                break;
            case 'fr':
                $alertText="Le client a été modifié avec succès.";
                break;
            default:
                break;
        }
        $alertBadge='success';
        break;
    case 'client-deleted':
        switch($lang){
            case 'es':
                $alertText="El cliente se ha borrado correctamente.";
                break;
            case 'ca':
                $alertText="El client s'ha eliminat correctament.";
                break;
            case 'en':
                $alertText="The client has been deleted successfully.";
                break;
            case 'fr':
                $alertText="Le client a été supprimé avec succès.";
                break;
            default:
                break;
        }
        $alertBadge='success';
        break;

    // EMPRESA
    case 'edit-empresa-success':
        switch($lang){
            case 'es':
                $alertText="La empresa se ha modificado correctamente.";
                break;
            case 'ca':
                $alertText="L'empresa s'ha modificat correctament.";
                break;
            case 'en':
                $alertText="The company has been modified successfully.";
                break;
            case 'fr':
                $alertText="L'entreprise a été modifiée avec succès.";
                break;
            default:
                break;
        }
        $alertBadge='success';
        break;

    // CALENDARI
    case 'event-success':
        switch($lang){
            case 'es':
                $alertText="El evento se ha creado correctamente.";
                break;
            case 'ca':
                $alertText="L'esdeveniment s'ha creat correctament.";
                break;
            case 'en':
                $alertText="The event has been created successfully.";
                break;
            case 'fr':
                $alertText="L'événement a été créé avec succès.";
                break;
            default:
                break;
        }
        $alertBadge='success';
        break;

    // TASQUES
    case 'task-success':
        switch($lang){
            case 'es':
                $alertText="La tarea se ha creado correctamente.";
                break;
            case 'ca':
                $alertText="La tasca s'ha creat correctament.";
                break;
            case 'en':
                $alertText="The task has been created successfully.";
                break;
            case 'fr':
                $alertText="La tâche a été créée avec succès.";
                break;
            default:
                break;
        }
        $alertBadge='success';
        break;
    case 'task-deleted':
        switch($lang){
            case 'es':
                $alertText="La tarea se ha borrado correctamente.";
                break;
            case 'ca':
                $alertText="La tasca s'ha eliminat correctament.";
                break;
            case 'en':
                $alertText="The task has been deleted successfully.";
                break;
            case 'fr':
                $alertText="La tâche a été supprimée avec succès.";
                break;
            default:
                break;
        }
        $alertBadge='success';
        break;

    // USUARIS
    case 'user-success':
        switch($lang){
            case 'es':
                $alertText="El usuario se ha modificado correctamente.";
                break;
            case 'ca':
                $alertText="L'usuari s'ha modificat correctament.";
                break;
            case 'en':
                $alertText="The user has been modified successfully.";
                break;
            case 'fr':
                $alertText="L'utilisateur a été modifié avec succès.";
                break;
            default:
                break;
        }
        $alertBadge='success';
        break;
    case 'pass-error':
        switch($lang){
            case 'es':
                $alertText="Ha habido un problema con la contraseña.";
                break;
            case 'ca':
                $alertText="Hi ha hagut un problema amb la contrasenya.";
                break;
            case 'en':
                $alertText="There has been an issue with the password.";
                break;
            case 'fr':
                $alertText="Il y a eu un problème avec le mot de passe.";
                break;
            default:
                break;
        }
        $alertBadge='danger';
        break;
    case 'profile-success':
        switch($lang){
            case 'es':
                $alertText="El perfil de usuario se ha modificado correctamente.";
                break;
            case 'ca':
                $alertText="El perfil d'usuari s'ha modificat correctament.";
                break;
            case 'en':
                $alertText="The user profile has been modified successfully.";
                break;
            case 'fr':
                $alertText="Le profil de l'utilisateur a été modifié avec succès.";
                break;
            default:
                break;
        }
        $alertBadge='success';
        break;
    case 'user-deleted':
        switch($lang){
            case 'es':
                $alertText="El usuario se ha borrado correctamente.";
                break;
            case 'ca':
                $alertText="L'usuari s'ha eliminat correctament.";
                break;
            case 'en':
                $alertText="The user has been deleted successfully.";
                break;
            case 'fr':
                $alertText="L'utilisateur a été supprimé avec succès.";
                break;
            default:
                break;
        }
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