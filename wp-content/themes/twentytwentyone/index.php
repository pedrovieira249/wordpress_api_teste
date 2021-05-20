<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header(); ?>
<div class="container">
    <div class="row">
		<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
			<h1 class="text-center mt-3">Simulação de Empréstimo</h1>
			<form action="#" id="formSimularEmprestimo" method="POST" class="border border-dark p-3 mt-4">
				<div class="mb-3">
					<label for="valor_emprestimo" class="form-label">Valor do emprestimo<span style="color:red;">*<span></label>
					<input type="text" step="0.01" class="form-control" id="valor_emprestimo" name="valor_emprestimo" onKeyPress="return(maskValor(this,'.',',',event))">
					<!-- <input type="text" step="0.01" class="form-control" id="valor_emprestimo" name="valor_emprestimo"> -->
					<div id="ve_messagem"></div>
				</div><hr>
				<div class="mb-3">
					<label for="instituicoes" class="form-label">Instituições</label>
					<?php 
						if ($instituicao = getInstituicao()) { ?>
							<select class="form-select border border-dark rounded-0 border-3" name="instituicoes" id="instituicoes" multiple aria-label="multiple select example">
								<?php foreach ($instituicao as $insValue) { ?>
									<option value="<?php echo $insValue->chave; ?>"><?php echo $insValue->chave; ?></option>
								<?php } ?>
							</select>
					<?php } else { ?>
						<p>Nenhuma instituição cadastrada</p>
					<?php } ?>
					<span class="mt-1" style="display:block;font-size:12px;">OBS: Para selecionar mais de uma opção, pressione e mantenha pressionado a tecla SHIFT ou CTRL</span>
				</div><hr>
				<div class="mb-3">
					<label for="conenio" class="form-label">Conênio</label>
					<?php 
						if ($conenio = getConvenios()) { ?>
							<select class="form-select border border-dark rounded-0 border-3" name="conenio" id="conenio" multiple aria-label="multiple select example">
								<?php foreach ($conenio as $conValue) { ?>
									<option value="<?php echo $conValue->chave; ?>"><?php echo $conValue->chave; ?></option>
								<?php } ?>
							</select>
					<?php } else { ?>
						<p>Nenhum conênio cadastrado</p>
					<?php } ?>
					<span class="mt-1" style="display:block;font-size:12px;">OBS: Para selecionar mais de uma opção, pressione e mantenha pressionado a tecla SHIFT ou CTRL</span>
				</div><hr>
				<div class="mb-3">
					<label for="parcelas" class="form-label">Parcelas</label>
					<?php
						if ($parcela = getParcelas()) { ?>
							<select class="form-select border border-dark rounded-0 border-3" id="parcelas" name="parcelas">
								<?php foreach ($parcela as $parValue) { ?>
									<option value="<?php echo $parValue; ?>"><?php echo (empty($parValue) ? 'Infomer número de parcelas' : $parValue); ?></option>
								<?php } ?>
							</select>
					<?php } else { ?>
						<input type="number" class="form-control" id="parcelas" name="parcelas">
					<?php } ?>
				</div>
				<button type="submit" class="btn btn-primary">Simular Crédito</button>
			</form>
		</div>
		<div id="resultado" class="row"></div>
	</div>
</div>

<script language="javascript">
	$(document).ready(function(){
		$("#formSimularEmprestimo").submit(function(event) {
			var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
			var valorEmprestimo = $("#valor_emprestimo").val();
			var valorSolicitado = valorEmprestimo;

			valorEmprestimo = valorEmprestimo.replace(".", "");
			valorEmprestimo = valorEmprestimo.replace(",", ".");

			var instituicoes    = $("#instituicoes").val();
			var conenio         = $("#conenio").val();
			var parcelas        = $("#parcelas").val();

			if (valorEmprestimo == '') {
				$("#valor_emprestimo").addClass('border-danger');
				$("#valor_emprestimo").css("border-style", "dashed");
				$("#ve_messagem").html('Esse campo é obrigatorio');
				$("#valor_emprestimo").focus();
			} else {
				$("#valor_emprestimo").removeClass('border-danger');
				$("#valor_emprestimo").css("border-style", "groove");
				$("#ve_messagem").html('');
			}

			$("#resultado").html('');

			$.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {
					action: 'simulacaoEmprestiomo',
					valor_emprestimo: valorEmprestimo,
					instituicoes: instituicoes,
					conenio: conenio,
					parcelas: parcelas
				},
				success: function(response) {
					// console.log(response);
					let data = JSON.parse(response);
					let i = 0;
					$("#resultado").append('<h2 class="mt-3 text-center">Resultado da simulação<h2>');
					Object.keys(data).forEach(key => {
						if($.inArray(key, instituicoes) >= 0) {
							data[key].forEach(value => {
								if($.inArray(value.convenio, conenio) >= 0) {					
									if (parcelas == value.parcelas) {
										validParcelas(value, key, i, valorSolicitado, valorEmprestimo);
										// console.log(value);
										i++;
									} else if (parcelas == 0) {
										validParcelas(value, key, i, valorSolicitado, valorEmprestimo);
										// console.log(value);
										i++;
									}
								} else if (conenio.length == 0) {
									if (parcelas == value.parcelas) {
										validParcelas(value, key, i, valorSolicitado, valorEmprestimo);
										// console.log(value);
										i++;
									} else if (parcelas == 0) {
										validParcelas(value, key, i, valorSolicitado, valorEmprestimo);
										// console.log(value);
										i++;
									}
								}
							});
						} else if (instituicoes.length == 0){
							data[key].forEach(value => {						
								if($.inArray(value.convenio, conenio) >= 0) {					
									if (parcelas == value.parcelas) {
										validParcelas(value, key, i, valorSolicitado, valorEmprestimo);
										// console.log(value);
										i++;
									} else if (parcelas == 0) {
										validParcelas(value, key, i, valorSolicitado, valorEmprestimo);
										// console.log(value);
										i++;
									}
								} else if (conenio.length == 0) {
									if (parcelas == value.parcelas) {
										validParcelas(value, key, i, valorSolicitado, valorEmprestimo);
										// console.log(value);
										i++;
									} else if (parcelas == 0) {
										validParcelas(value, key, i, valorSolicitado, valorEmprestimo);
										// console.log(value);
										i++;
									}
								}
							});
						}
						// console.log(key, data[key]);
					});

				},
				error: function(errorThrown) {
					console.log(errorThrown);
				}
			});
			event.preventDefault();
		});
	});

	function validParcelas(data, key, i, valorSolicitado, valorEmprestimo) {
		let valorTotal = (data.parcelas * data.valor_parcela);
		let jurosTotal = ((((data.parcelas * data.valor_parcela) * 100) / valorEmprestimo) - 100);
		let jurosMes   = (jurosTotal / data.parcelas);
		$("#resultado").append('<div class="col-1 col-sm-2 col-md-3 col-lg-3 col-xl-3 col-xxl-3"><div class="card mt-5" style="width: 18rem; display:inline-block;"><div class="card-header">' + key + '</div><ul id="' + key + i + '" class="list-group list-group-flush"></ul></div></div>');
		$("#"+key + i).append('<li class="list-group-item"> Valor Solicitado: '+ valorSolicitado +'</li>');
		$("#"+key + i).append('<li class="list-group-item"> Parcela: '+ data.parcelas +'</li>');
		// $("#"+key + i).append('<li class="list-group-item"> Valor da Parcela: <b> R$ '+ data.valor_parcela +'</b></li>');
		$("#"+key + i).append('<li class="list-group-item"> Valor total a ser pago: <b> R$ '+ valorTotal.toFixed(2) +'</b></li>');
		// $("#"+key + i).append('<li class="list-group-item"> Juros Tatal: '+ jurosTotal.toFixed(2) +'%</b></li>');
		$("#"+key + i).append('<li class="list-group-item"> Juros Mensal: '+ jurosMes.toFixed(2) +'%</b></li>');
		$("#"+key + i).append('<li class="list-group-item"> Conênio: '+ data.convenio +'</li>');							
	}

	function maskValor(a, e, r, t) {
			let n = ""
			, h = j = 0
			, u = tamanho2 = 0
			, l = ajd2 = ""
			, o = window.Event ? t.which : t.keyCode;
			if (13 == o || 8 == o)
				return !0;
			if (n = String.fromCharCode(o),
			-1 == "0123456789".indexOf(n))
				return !1;
			for (u = a.value.length,
			h = 0; h < u && ("0" == a.value.charAt(h) || a.value.charAt(h) == r); h++)
				;
			for (l = ""; h < u; h++)
				-1 != "0123456789".indexOf(a.value.charAt(h)) && (l += a.value.charAt(h));
			if (l += n,
			0 == (u = l.length) && (a.value = ""),
			1 == u && (a.value = "0" + r + "0" + l),
			2 == u && (a.value = "0" + r + l),
			u > 2) {
				for (ajd2 = "",
				j = 0,
				h = u - 3; h >= 0; h--)
					3 == j && (ajd2 += e,
					j = 0),
					ajd2 += l.charAt(h),
					j++;
				for (a.value = "",
				tamanho2 = ajd2.length,
				h = tamanho2 - 1; h >= 0; h--)
					a.value += ajd2.charAt(h);
				a.value += r + l.substr(u - 2, u)
			}
			return !1
	}
</script>
<?php get_footer(); ?>
