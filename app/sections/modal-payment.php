<?php
$plans = array( 
    '1' => array( 
        'name' => 'Manos a la obra', 
        'price' => 9.99, 
        'interval' => 'month' 
    ), 
    '2' => array( 
        'name' => 'Profesional', 
        'price' => 19.99, 
        'interval' => 'month' 
    )
); 
$currency = "EUR";  

define('STRIPE_API_KEY', 'sk_test_51IQ79SDzY9AsmTJ8r9YX3CqYBNtjd06LLO3TUyrLdHZRKXViP7CZIDCWE834Qtkhuaf0Xit7vKjo7tVZBt6uk3gJ002Yj4eKvJ'); 
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_51IQ79SDzY9AsmTJ8Bq56HQ3XoV8axtwcgs73TsppvSDlKjW3UBVahw8Z1gaHDCWdgjK1eZaMoBskAb8kcNlnGaMM00nTudY0dg');
?>


<div id="payment" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Actualizar suscripción</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form id="paymentFrm" method="POST" action="stripe/payment.php">
                            <div class="row plansSuscripcio"> 
                                <?php switch($planUsuari){
                                    case 1: $plan0='';$plan1='active';$plan2='';
                                        break;
                                    case 2: $plan0='';$plan1='';$plan2='active';
                                        break;
                                    default: $plan0='active';$plan1='';$plan2='';
                                        break;
                                }?>
                                <div class="col-md offset-1 col-md-10 plaEA plan <?php echo $plan0;?>">
                                    <a href="#"><div class="planTitle"><i class="uil uil-heart text-primary"></i><br><strong>Entre amigos.</strong> Plan inicial (0.00€/mes)</div></a>
                                </div>
                                <div class="col-md offset-1 col-md-10 plaMO plan <?php echo $plan1;?>">
                                    <a href="#"><div class="planTitle"><i class="uil uil-laptop text-primary"></i><br><strong>Manos a la obra.</strong> Plan expansión (9.99€/mes)</div></a>
                                </div>
                                <div class="col-md offset-1 col-md-10 plaPR plan <?php echo $plan2;?>">
                                    <a href="#"><div class="planTitle"><i class="uil uil-plane-fly text-primary"></i><br><strong>Profesional.</strong> Plan profesional (19.99€/mes)</div></a>
                                </div>
                            </div>
                            <input type="hidden" name="subscr_plan" id="subscr_plan" value="0">

                            <div class="panellBilling row">
                                <div class="col-md offset-1 col-md-10">
                                    <!-- Display errors returned by createToken -->
                                    <div id="paymentResponse"></div>
                                    <!-- Payment form -->
                                    <div class="form-group">
                                        <label>Nombre de tarjeta</label><br>
                                        <input type="text" name="name" id="name" class="field" placeholder="Gavin Belson" required="" autofocus="">
                                    </div>
                                    <input type="hidden" name="email" id="email" value="<?php echo $userEmail;?>">
                                    <div class="form-group">
                                        <label>Número de tarjeta</label>
                                        <div id="card_number" class="field"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Fecha de caducidad</label>
                                                <div id="card_expiry" class="field"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Código CVC</label>
                                                <div id="card_cvc" class="field"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                    </div>
                </div>                    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cancelar</button>
                <button type="submit" id="payBtn" class="payment-button btn btn-primary waves-effect waves-light">Pagar</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

