<?php
$urlReporte = base_url('index.php/ReporteCTR');
$eleccion = eleccion_model::eleccion_x_Activo();
if(count($eleccion) > 0){
	$eleccion = $eleccion[0];
}


?>
<div class="container-fluid">
	<div class="row">
	<div class="col-xs-10 col-sm-10 col-md-8 text-justify lead">
		Bienvenido al área de Reportes, aquí puedes ver las diferentes estadísticas de los Candidatos y votos.
	</div>
	<div class="col-xs-2 col-sm-2 col-md-offset-2 text-justify lead">
	<button type="button" style="margin-bottom: 10px; " class="btn btn-warning pull-right"
		onclick="imprimir()" ><i class="fa fa-edit"></i> Imprimir Reporte</button>
	</div>
	</div>
</div>
<div class="container-fluid">
	<div class="page-header">
		<h2 class="all-tittles">Votos de Eleccion <?=$eleccion['Nombre']?></small></h2>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<h3 class="text-center all-tittles">Total de Votos Por Candidatos </h3>
			<div class="table-responsive">
				<table class="table table-hover text-center">
					<thead>
						<tr class="success">
							<th class="text-center">Candidatos</th>
							<th class="text-center">Nivel Aspirado</th>
							<th class="text-center">Partido</th>
							<th class="text-center">No. Votos</th>
							<th class="text-center">porcetanje</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$votos = filtros_model::votos_x_candidatos($eleccion['IdEleccion']);
							$mensaje = "En Las Elecciones ".$eleccion['Nombre'].";";
							if(count($votos) > 0){
								foreach ($votos as $key => $voto) {
									$mensaje = $mensaje." El Candidato a ".$voto['Nivel'].
									" por parte del partido ".$voto['Partido']."; ".$voto['Candidato']
									." tiene un total de ".$voto['votos']." votos acumulados, teniendo asi un"
									." ".$voto['porcentaje']." de los votos generados";
									echo <<<ROW
									<tr>
									<td>{$voto['Candidato']}</td>
									<td>{$voto['Nivel']}</td>
									<td>{$voto['Partido']}</td>
									<td>{$voto['votos']}</td>
									<td>{$voto['porcentaje']}</td>
								</tr>	
ROW;									
								}
							}
							sendReport($mensaje);
						?>
					</tbody>
					<tfoot>
					<?php
						$total = filtros_model::total_votos_x_candidatos($eleccion['IdEleccion']);
						if(count($total) > 0){
							$total = $total[0];
						}
					?>
						<tr class="info">
							<th class="text-center">Total</th>
							<th></th>
							<th></th>
							<th class="text-center"><?=$total['votos']?></th>
							<th class="text-center"><?=$total['porcentaje']?></th>
						</tr>
					</tfoot>
				</table>
			</div>

			<div class="row">
				<div class="col-xs-12">
					<h3 class="text-center all-tittles">Votos  de usuarios por Partidos</h3>
					<div class="table-responsive">
						<table class="table table-hover text-center">
							<thead>
								<tr class="success">
									<th class="text-center">Partido</th>
									<th class="text-center">No. Votos</th>
									<th class="text-center">Porcentaje</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$votos = filtros_model::votos_x_partidos($eleccion['IdEleccion']);
							if(count($votos) > 0){
								foreach ($votos as $key => $voto) {
									echo <<<ROW
									<tr>
									<td>{$voto['Partido']}</td>
									<td>{$voto['votos']}</td>
									<td>{$voto['porcentaje']}</td>
								</tr>	
ROW;									
								}
							}
						?>
							</tbody>
							<tfoot>
								<tr class="info">
									<th class="text-center">Total</th>
									<th class="text-center"><?=$total['votos']?></th>
							<th class="text-center"><?=$total['porcentaje']?></th>
								</tr>
							</tfoot>
						</table>
					</div>
				
				</div>
			</div>
		</div>
	</div>
</div>
<iframe id="if_print" style="display:none"></iframe>
<script>
function imprimir(){
	document.getElementById('if_print').src = '<?= $urlReporte."/ImprimirReporte"?>';
}
</script>
