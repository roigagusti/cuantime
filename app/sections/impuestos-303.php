<?php 
$ejercicio = $_GET['ejercicio'];
$periodo = $_GET['periodo'][0];
$diesMes = [31,28,31,30,31,30,31,31,30,31,30,31];
$diesLastPeriodo=$diesMes[$periodo*3-1];

$mesIniciPeriodo=$periodo*3-2;
$mesFinalPeriodo=$periodo*3;

$dataInici = date("d-m-Y",strtotime('01-'.$mesIniciPeriodo.'-'.$ejercicio));
$dataFinal = date("d-m-Y",strtotime($diesLastPeriodo.'-'.$mesFinalPeriodo.'-'.$ejercicio));

$ivaDevengadoBase = $database->sum("factures","import",["AND"=>["idUser"=>$userAdminEmpresa,"data[<>]"=>[date("Y-m-d", mktime(0, 0, 0, date("n",strtotime($dataInici)),date("d",strtotime($dataInici)),date("Y",strtotime($dataInici)))), date("Y-m-d", mktime(0, 0, 0, date("n",strtotime($dataFinal)),date("d",strtotime($dataFinal)),date("Y",strtotime($dataFinal))))]]]);
$ivaDevengadoCuota = $ivaDevengadoBase*0.21;

$ivaDeducidos = $database->select("despeses",["import","iva"],["AND"=>["idUser"=>$userAdminEmpresa,"data[<>]"=>[date("Y-m-d", mktime(0, 0, 0, date("n",strtotime($dataInici)),date("d",strtotime($dataInici)),date("Y",strtotime($dataInici)))), date("Y-m-d", mktime(0, 0, 0, date("n",strtotime($dataFinal)),date("d",strtotime($dataFinal)),date("Y",strtotime($dataFinal))))]]]);
$ivaDeducidoBase=0;
$ivaDeducidoCuota=0;
foreach($ivaDeducidos as $ivaDeducido){
	$ivaDeducidoBase += $ivaDeducido['import'];
	$ivaDeducidoCuota += ($ivaDeducido['iva']/100)*$ivaDeducido['import'];
}
$resultadoIva = max(0,$ivaDevengadoCuota-$ivaDeducidoCuota);

if($ivaDevengadoBase==0 && $ivaDeducidoBase==0){
	echo '<span style="color:#999">Aun no hay datos para cumplimentar automáticamente el modelo.</span>';
}else{
?>
<div class="row">
	<span class="pantallaNoDispo" style="color:#999">El modelo no está disponible para este tamaño de pantalla. Trabajamos para tenerlo disponible pronto.</span>
	<div class="ivaTable titol">
		<div class="row">
			<h6>Modelo 303. IVA trimestral</h6>
			<p>Debe presentarse <strong>todos</strong> los trimestres, aunque no haya habido actividad. La presentación se realiza del 01 al 20 de cada inicio de trimestre.</p>
		</div>
	</div>
	<div class="ivaTable">
		<div class="row" id="ivaDevengado">
			<div class="col-iva-6">
				<div class="title">IVA Devengado</div>
				<ul>
					<li>Régimen general</li>
					<li></li>
					<li></li>
					<li>Adquisiciones intracomunitarias de bienes y servicios</li>
					<li>Otras operaciones con inversión del sujeto pasivo</li>
					<li>Modificación bases y cuotas</li>
					<li>Recargo equivalencia</li>
					<li></li>
					<li></li>
					<li>Modificaciones bases y cuotas del recargo de equivalencia</li>
					<li>Total cuota devengada</li>
				</ul>
			</div>
			<div class="col-iva-2 ivaInline">
				<div class="col-casellaNumero">
					<div class="title"></div>
					<ul>
						<li>01</li>
						<li>04</li>
						<li>07</li>
						<li>10</li>
						<li>12</li>
						<li>14</li>
						<li>16</li>
						<li>19</li>
						<li>22</li>
						<li>25</li>
						<li class="noData"></li>
					</ul>
				</div>
				<div class="col-casellaValue">
					<div class="title">Base</div>
					<ul>
						<li></li>
						<li></li>
						<li><?php echo number_format($ivaDevengadoBase,2,",",".");?></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li class="noData"></li>
					</ul>
				</div>
			</div>
			<div class="col-iva-2 ivaInline">
				<div class="col-casellaNumero">
					<div class="title"></div>
					<ul>
						<li>02</li>
						<li>05</li>
						<li>08</li>
						<li class="noData"></li>
						<li class="noData"></li>
						<li class="noData"></li>
						<li>17</li>
						<li>20</li>
						<li>23</li>
						<li class="noData"></li>
						<li class="noData"></li>
					</ul>
				</div>
				<div class="col-casellaValue">
					<div class="title">Tipo %</div>
					<ul>
						<li>4.00</li>
						<li>10.00</li>
						<li>21.00</li>
						<li class="noData"></li>
						<li class="noData"></li>
						<li class="noData"></li>
						<li>5.20</li>
						<li>1.40</li>
						<li></li>
						<li class="noData"></li>
						<li class="noData"></li>
					</ul>
				</div>
			</div>
			<div class="col-iva-2 ivaInline">
				<div class="col-casellaNumero">
					<div class="title"></div>
					<ul>
						<li>03</li>
						<li>06</li>
						<li>09</li>
						<li>11</li>
						<li>13</li>
						<li>15</li>
						<li>18</li>
						<li>21</li>
						<li>24</li>
						<li>26</li>
						<li>27</li>
					</ul>
				</div>
				<div class="col-casellaValue">
					<div class="title">Cuota</div>
					<ul>
						<li></li>
						<li></li>
						<li><?php echo number_format($ivaDevengadoCuota,2,",",".");?></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li><?php echo number_format($ivaDevengadoCuota,2,",",".");?></li>
					</ul>
				</div>
			</div>
		</div>

		<div class="row" id="ivaDeducible">
			<div class="col-iva-8">
				<div class="title">IVA Deducible</div>
				<ul>
					<li>Por cuotas soportadas en operaciones interiores corrientes</li>
					<li>Por cuotas soportadas en operaciones interiores con bienes de inversión</li>
					<li>Por cuotas soportadas en las importaciones de bienes corrientes</li>
					<li>Por cuotas soportadas en las importaciones de bienes de inversión</li>
					<li>En adquisiciones intracomunitarias de bienes y servicios corrientes</li>
					<li>En adquisiciones intracomunitarias de bienes de inversión</li>
					<li>Rectificación de deducciones</li>
					<li>Compensaciones Régimen Especial A.G. y P.</li>
					<li>Regularización bienes de inversión</li>
					<li>Regularización por aplicación del porcentaje definitivo de prorrata</li>
					<li>Total a deducir</li>
				</ul>
			</div>
			<div class="col-iva-2 ivaInline">
				<div class="col-casellaNumero">
					<div class="title"></div>
					<ul>
						<li>28</li>
						<li>30</li>
						<li>32</li>
						<li>34</li>
						<li>36</li>
						<li>38</li>
						<li>40</li>
						<li class="noData"></li>
						<li class="noData"></li>
						<li class="noData"></li>
						<li class="noData"></li>
					</ul>
				</div>
				<div class="col-casellaValue">
					<div class="title">Base</div>
					<ul>
						<li><?php echo number_format($ivaDeducidoBase,2,",",".");?></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li class="noData"></li>
						<li class="noData"></li>
						<li class="noData"></li>
						<li class="noData"></li>
					</ul>
				</div>
			</div>
			<div class="col-iva-2 ivaInline">
				<div class="col-casellaNumero">
					<div class="title"></div>
					<ul>
						<li>29</li>
						<li>31</li>
						<li>33</li>
						<li>35</li>
						<li>37</li>
						<li>39</li>
						<li>41</li>
						<li>42</li>
						<li>43</li>
						<li>44</li>
						<li>45</li>
					</ul>
				</div>
				<div class="col-casellaValue">
					<div class="title">Cuota</div>
					<ul>
						<li><?php echo number_format($ivaDeducidoCuota,2,",",".");?></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li><?php echo number_format($ivaDeducidoCuota,2,",",".");?></li>
					</ul>
				</div>
			</div>
		</div>

		<div class="row" id="ivaTotal">
			<div class="col-iva-10">
				<div class="title">Resultado régimen general</div>
			</div>
			<div class="col-iva-2 ivaInline">
				<div class="col-casellaNumero">
					<ul>
						<li>46</li>
					</ul>
				</div>
				<div class="col-casellaValue">
					<div class="title"><?php echo number_format($resultadoIva,2,",",".");?></div>
				</div>
			</div>
		</div>

	</div>
</div>
<?php } ?>