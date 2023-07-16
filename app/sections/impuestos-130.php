<?php 
$ejercicio = $_GET['ejercicio'];
$periodo = $_GET['periodo'][0];
$diesMes = [31,28,31,30,31,30,31,31,30,31,30,31];
$diesLastPeriodo=$diesMes[$periodo*3-1];

$mesFinalPeriodo=$periodo*3;

$dataInici = date("d-m-Y",strtotime('01-01-'.$ejercicio));
$dataFinal = date("d-m-Y",strtotime($diesLastPeriodo.'-'.$mesFinalPeriodo.'-'.$ejercicio));

// Declaració actual
$ingresosComputables = $database->sum("factures","import",["AND"=>["idUser"=>$userAdminEmpresa,"data[<>]"=>[date("Y-m-d", mktime(0, 0, 0, date("n",strtotime($dataInici)),date("d",strtotime($dataInici)),date("Y",strtotime($dataInici)))), date("Y-m-d", mktime(0, 0, 0, date("n",strtotime($dataFinal)),date("d",strtotime($dataFinal)),date("Y",strtotime($dataFinal))))]]]);
$gastosDeduciblesDirectos = $database->sum("despeses","import",["AND"=>["idUser"=>$userAdminEmpresa,"data[<>]"=>[date("Y-m-d", mktime(0, 0, 0, date("n",strtotime($dataInici)),date("d",strtotime($dataInici)),date("Y",strtotime($dataInici)))), date("Y-m-d", mktime(0, 0, 0, date("n",strtotime($dataFinal)),date("d",strtotime($dataFinal)),date("Y",strtotime($dataFinal))))]]]);
$gastosDeduciblesIndirectos = max(0,$ingresosComputables-$gastosDeduciblesDirectos)*0.05;
$gastosDeducibles = $gastosDeduciblesDirectos + $gastosDeduciblesIndirectos;
$rendimentoNeto = $ingresosComputables-$gastosDeducibles;
$iprfValue = max(0,$rendimentoNeto*0.20);
$retencionsRealitzades = $ingresosComputables*0.15;
$pagamentFraccionat = $iprfValue-$retencionsRealitzades;

// Declaracions anteriors
if($periodo>1){
	$diesLastAnteriorPeriodo=$diesMes[$periodo*3-4];
	$mesFinalAnteriorPeriodo=($periodo-1)*3;
	$dataFinalTrimestreAnterior = date("d-m-Y",strtotime($diesLastAnteriorPeriodo.'-'.$mesFinalAnteriorPeriodo.'-'.$ejercicio));

	$ingresosComputablesAP = $database->sum("factures","import",["AND"=>["idUser"=>$userAdminEmpresa,"data[<>]"=>[date("Y-m-d", mktime(0, 0, 0, date("n",strtotime($dataInici)),date("d",strtotime($dataInici)),date("Y",strtotime($dataFinalTrimestreAnterior)))), date("Y-m-d", mktime(0, 0, 0, date("n",strtotime($dataFinalTrimestreAnterior)),date("d",strtotime($dataFinalTrimestreAnterior)),date("Y",strtotime($dataFinalTrimestreAnterior))))]]]);
	$gastosDeduciblesDirectosAP = $database->sum("despeses","import",["AND"=>["idUser"=>$userAdminEmpresa,"data[<>]"=>[date("Y-m-d", mktime(0, 0, 0, date("n",strtotime($dataInici)),date("d",strtotime($dataInici)),date("Y",strtotime($dataInici)))), date("Y-m-d", mktime(0, 0, 0, date("n",strtotime($dataFinalTrimestreAnterior)),date("d",strtotime($dataFinalTrimestreAnterior)),date("Y",strtotime($dataFinalTrimestreAnterior))))]]]);
	$gastosDeduciblesIndirectosAP = max(0,$ingresosComputablesAP-$gastosDeduciblesDirectosAP)*0.05;
	$gastosDeduciblesAP = $gastosDeduciblesDirectosAP + $gastosDeduciblesIndirectosAP;
	$rendimentoNetoAP = $ingresosComputablesAP-$gastosDeduciblesAP;
	$iprfValueAP = max(0,$rendimentoNetoAP*0.20);
	$retencionsRealitzadesAP = $ingresosComputablesAP*0.15;
	$pagamentFraccionatAnual = $iprfValueAP-$retencionsRealitzadesAP;
}else{
	$pagamentFraccionatAnual = '';
}

if($ingresosComputables==0 && $gastosDeduciblesDirectos==0){
	echo '<span style="color:#999">Aun no hay datos para cumplimentar automáticamente el modelo.</span>';
}else{
?>

<div class="row">
	<span class="pantallaNoDispo" style="color:#999">El modelo no está disponible para este tamaño de pantalla. Trabajamos para tenerlo disponible pronto.</span>
	<div class="ivaTable titol">
		<div class="row">
			<h6>Modelo 130. IRPF trimestral</h6>
			<p>Debe presentarse <strong>todos</strong> los trimestres, aunque no haya habido actividad. La presentación se realiza del 01 al 20 de cada inicio de trimestre.</p>
		</div>
	</div>
	<div class="ivaTable">
		<p style="margin-left:-10px;font-weight:700;font-style: 1.1em">I. Actividades económicas en estimación directa, modalidad normal o simplificada, distintas de las agrícolas, ganaderas, forestales y pesqueras.<br><span style="font-weight:300">(Datos acumulados del período comprendido entre el primer día del año y el último día del trimestre).</span></p>
		<div class="row">
			<div class="col-iva-10">
				<ul>
					<li>Ingresos computables</li>
					<li>Gastos fiscalmente deducibles</li>
					<li>Rendimiento neto</li>
					<li>20% del importe del rendimiento neto</li>
					<li>A deducir. Pagos fraccionados de los trimestres anteriores</li>
					<li>A deducir. Retenciones e ingresos a cuenta realizados durante este trimestre</li>
					<li>Pago fraccionado previo del trimestre</li>
				</ul>
			</div>
			<div class="col-iva-2 ivaInline">
				<div class="col-casellaNumero">
					<ul>
						<li>01</li>
						<li>02</li>
						<li>03</li>
						<li>04</li>
						<li>05</li>
						<li>06</li>
						<li>07</li>
					</ul>
				</div>
				<div class="col-casellaValue">
					<ul>
						<li><?php echo number_format($ingresosComputables,2,",",".");?></li>
						<li><?php echo number_format($gastosDeducibles,2,",",".");?></li>
						<li><?php echo number_format($rendimentoNeto,2,",",".");?></li>
						<li><?php echo number_format($iprfValue,2,",",".");?></li>
						<li><?php echo number_format($pagamentFraccionatAnual,2,",",".");?></li>
						<li><?php echo number_format($retencionsRealitzades,2,",",".");?></li>
						<li><?php echo number_format($pagamentFraccionat,2,",",".");?></li>
					</ul>
				</div>
			</div>
		</div>

		<p style="margin-left:-10px;font-weight:700;font-style: 1.1em;margin-top:30px">II. Actividades agrícolas, ganaderas, forestales y pesqueras en estimación directa, modalidad normal o simplificada</p>
		<div class="row">
			<div class="col-iva-10">
				<ul>
					<li>Volumen de ingresos del trimestre</li>
					<li>2% del volumen de ingresos</li>
					<li>A deducir. Retenciones e ingresos a cuenta realizados durante este trimestre</li>
					<li>Pago fraccionado previo del trimestre</li>
				</ul>
			</div>
			<div class="col-iva-2 ivaInline">
				<div class="col-casellaNumero">
					<ul>
						<li>08</li>
						<li>09</li>
						<li>10</li>
						<li>11</li>
					</ul>
				</div>
				<div class="col-casellaValue">
					<ul>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
					</ul>
				</div>
			</div>
		</div>

		<p style="margin-left:-10px;font-weight:700;font-style: 1.1em;margin-top:30px">III. Total liquidación.</p>
		<div class="row">
			<div class="col-iva-10">
				<ul>
					<li>Suma de pagos fraccionados previos del trimestre</li>
					<li>A deducir. Minoración por aplicación de deducción*</li>
					<li>Diferencia de los anteriores</li>
					<li>A deducir. Resultados negativos de trimestres anteriores</li>
					<li>A deducir. Adquisición o rehabilitación de vivienda habitual</li>
					<li>Total</li>
					<li>A deducir. Resultado a ingresar de anteriores autoliquidaciones</li>
				</ul>
			</div>
			<div class="col-iva-2 ivaInline">
				<div class="col-casellaNumero">
					<ul>
						<li>12</li>
						<li>13</li>
						<li>14</li>
						<li>15</li>
						<li>16</li>
						<li>17</li>
						<li>18</li>
					</ul>
				</div>
				<div class="col-casellaValue">
					<ul>
						<li><?php echo number_format(max(0,$pagamentFraccionat),2,",",".");?></li>
						<li></li>
						<li><?php echo number_format(max(0,$pagamentFraccionat),2,",",".");?></li>
						<li></li>
						<li></li>
						<li><?php echo number_format(max(0,$pagamentFraccionat),2,",",".");?></li>
						<li></li>
					</ul>
				</div>
			</div>
		</div>

		<div class="row" id="ivaTotal">
			<div class="col-iva-10">
				<div class="title">Resultado de la autoliquidación</div>
			</div>
			<div class="col-iva-2 ivaInline">
				<div class="col-casellaNumero">
					<ul>
						<li>19</li>
					</ul>
				</div>
				<div class="col-casellaValue">
					<div class="title"><?php echo number_format(max(0,$pagamentFraccionat),2,",",".");?></div>
				</div>
			</div>
		</div>

	</div>
</div>
<?php } ?>