/*
* Title: Scripts
* Author: Aldasoro
* Template: Aldasoro
* Version: 1.0
* Copyright 2021 Aldasoro Inc.
* Url: https://www.aldasoro.ml


Taula de continguts
-------------------
1. Mostrar o amagar en funció d'interruptor
*/

// 1. Mostrar o amagar en funció d'interruptor
$("#customSwitch1").change(function() {
    $("#horaFinal").hasClass("hidden") ? $("#horaFinal").removeClass("hidden") : $("#horaFinal").addClass("hidden");
    $("#projecteManual").hasClass("hidden") ? $("#projecteManual").removeClass("hidden") : $("#projecteManual").addClass("hidden");
    $("#ciutatManual").hasClass("hidden") ? $("#ciutatManual").removeClass("hidden") : $("#ciutatManual").addClass("hidden");
    $("#clientManual").hasClass("hidden") ? $("#clientManual").removeClass("hidden") : $("#clientManual").addClass("hidden");
    $("#crearClientManual").hasClass("hidden") ? $("#crearClientManual").removeClass("hidden") : $("#crearClientManual").addClass("hidden");
    $("#projecteSelect").hasClass("hidden") ? $("#projecteSelect").removeClass("hidden") : $("#projecteSelect").addClass("hidden");
});

// 2. Modificar valor al introduir en input (factures)
function calculPreu(){
	var preu = document.getElementById('facturaImport').value;
	var pIVA = document.getElementById('facturaIVA').value;
	var pIRPF = document.getElementById('facturaIRPF').value;

	var iva = parseFloat(preu*(pIVA/100)).toFixed(2);
	var irpf = parseFloat(preu*(-pIRPF/100)).toFixed(2);
	var total = parseFloat(preu*(1+(pIVA-pIRPF)/100)).toFixed(2);

	document.getElementById('valorIVA').innerHTML=iva+' &euro;';
	document.getElementById('valorIRPF').innerHTML=irpf+' &euro;';
	document.getElementById('valorTOTAL').innerHTML=total+' &euro;';
}

// 3. Mostrar i amagar impostos
function showImpost(){
    $(".impMod").hasClass("hidden") ? $(".impMod").removeClass("hidden") : $(".impMod").addClass("hidden");
    $(".impAma").hasClass("hidden") ? $(".impAma").removeClass("hidden") : $(".impAma").addClass("hidden");
};

// 4. Parte. Data on value
function dataOnValue(a){
	document.getElementById("parteData").value = a;
}

// 5. Activar i desactivar botó registre
$(".input-settings").on('change', function() {
	$(".btn-cancel").removeClass("disabled");
	$(".btn-save").removeClass("disabled");
});
function termsChanged(){
	$(".btn-access").hasClass("disabled") ? $(".btn-access").removeClass("disabled") : $(".btn-access").addClass("disabled");
}	

//6. Encendre i apagar plans de suscripció
$("div.plaEA").on('click', function() {
	$("div.plaEA").hasClass("active") ? $("div.plaEA").removeClass("") : $("div.plaEA").addClass("active");
	$("div.plaMO").removeClass("active");
	$("div.plaPR").removeClass("active");
    document.getElementById("subscr_plan").value = 0;
});
$("div.plaMO").on('click', function() {
	$("div.plaMO").hasClass("active") ? $("div.plaMO").removeClass("") : $("div.plaMO").addClass("active");
	$("div.plaEA").removeClass("active");
	$("div.plaPR").removeClass("active");
    document.getElementById("subscr_plan").value = 1;
});
$("div.plaPR").on('click', function() {
	$("div.plaPR").hasClass("active") ? $("div.plaPR").removeClass("") : $("div.plaPR").addClass("active");
	$("div.plaEA").removeClass("active");
	$("div.plaMO").removeClass("active");
    document.getElementById("subscr_plan").value = 2;
});

// 7. Actualitzar data fitxatges
function actData(){
	let mesos = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
	var data = document.getElementById('inputActData').value;
	var res = data.split(' ');
	var mes = mesos.indexOf(res[0])+1;
	window.location.replace('http://app.cuantime.es/fitxatges.php?date='+mes+'-'+res[1]);
}

// 8. Amagar notifiació
$(document).ready(function(){
	setTimeout(function() {
		$("div.alert").removeClass("show");
	}, 5000);	
});

// 9. Mostrar i amagar stats en expedients
function showStats(){
    $("#stats").hasClass("hidden") ? $("#stats").removeClass("hidden") : $("#stats").addClass("hidden");
	$("#button-show").addClass("hidden");
	$("#button-hidden").removeClass("hidden");
};
function hideStats(){
    $("#stats").hasClass("hidden") ? $("#stats").removeClass("hidden") : $("#stats").addClass("hidden");
	$("#button-hidden").addClass("hidden");
	$("#button-show").removeClass("hidden");
};