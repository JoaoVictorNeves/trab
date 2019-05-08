<?php 

	require 'classes/class.database.php';
	require 'classes/class.cadastro.php';

	$db = Database::getInstance();
	$cadastro = new Cadastros($db);
	$cadastros = $cadastro->getAllCadastros();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Trabalho</title>
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">

		<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
		<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">

	</head>

	<script>
		jQuery(document).ready(function($) {
			$('.money').mask("#.##0,00", {reverse: true});
		});
	</script>
	<body>

		<style>
			*{
				margin: 0px;
				box-sizing: border-box;
				padding: 0px;
				font-size: 16px;
				font-family: 'Montserrat', sans-serif;
			}
			body{
				background-color: #f5f5f5;
			}
			.content-box{
				width: 100%;
				height: 100vh;
				display: flex;
				align-items: center;
				justify-content: center;
			}

			.box-form{
				padding: 50px;
				border-radius: 30px !important;
			}

			.box-form h1{
				font-size: 50px;
				padding: 15px 0px 30px;
			}
			.required-box{
				margin-bottom: 15px;
			}

			.required-box span{
				border-radius: 100%;
				width: 10px;
				height: 10px;
				background-color: #117a8b;
				display: inline-block;
				margin-right: 10px;

			}

			input.required{
				border-left: 10px solid #117a8b;
			}
		</style>

		<script>
			$(document).ready( function () {
			    $('#example').DataTable();
			});
		</script>

		<div class="content-box">
			<div class="container justify-content-center d-flex align-items-center">

				<div id="form-1" class="box-form shadow mb-5 bg-white rounded col-10">
					<?php 
						if (isset($_POST['id']) == false && isset($_GET['create_user']) == false): 
					?>
							<h1 class="text-uppercase text-center">Cadastros</h1>
							<table id="example" class="table table-striped" style="width:100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>Nome</th>
										<th>Data de nascimento</th>
										<th>Salário</th>
										<th style="text-align: center;">Ações</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($cadastros as $cadastro) { ?>
										<tr>
											<td><?php echo $cadastro['id']; ?></td>
											<td><?php echo $cadastro['nome']; ?></td>
											<td><?php echo $cadastro['data_nascimento']; ?></td>
											<td><span class="money"><?php echo $cadastro['salario']; ?></span></td>
											<td  style="text-align: center;">
												<form action="index.php?edit_user" method="post" class="d-inline">
													<input type="hidden" name="id" value="<?php echo $cadastro['id']; ?>">
													<button class="btn btn-warning">Editar</button>
												</form>
												<form action="index.php?remove_user" method="post" class="d-inline">
													<input type="hidden" name="id" value="<?php echo $cadastro['id']; ?>">
													<button class="btn btn-danger">Deletar</button>
												</form>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
							<a href="index.php?create_user" class="btn btn-success btn-block mt-5"> Criar novo</a>
					<?php
						elseif (isset($_GET['edit_user'])) :

							if (!isset($_POST['hash'])) :
								$user_id = $_POST['id'];
								$objUser = $cadastro->getCadastro($user_id);
					?>
								<h1 class="text-uppercase text-center">Editar</h1>
								<div class="row justify-content-center">
									<form action="index.php?edit_user" class="col-8" method="post">
										<?php 
											foreach ($objUser as $user ) :
										?>	
												<div class="form-group">
													<label for="">Nome</label>
													<input type="text" name="nome" class="form-control" value="<?php echo $user['nome']; ?>">
												</div>
												<div class="form-group">
													<label for="">Data de nascimento</label>
													<input type="date" name="data_nascimento" class="form-control" value="<?php echo $user['data_nascimento']; ?>">
												</div>
												<div class="form-group">
													<label for="">Salário</label>
													<input type="text" name="salario" class="form-control money"  value="<?php echo $user['salario']; ?>">
												</div>
												<div class="form-group">
													<button type="submit" class="btn btn-success btn-block"> Editar </button>
												</div>
												<input type="hidden" name="hash" value="ef4643a7d6c4af78c08eb2bed79a0eac">
												<input type="hidden" name="id" value="<?php echo $user['id']; ?>">
										<?php	
											endforeach; 
										?>
									</form>
								</div>
					<?php
							else:
								if (isset($_POST['hash']) && $_POST['hash'] == 'ef4643a7d6c4af78c08eb2bed79a0eac'):

									$id = $_POST['id'];
									$nome = $_POST['nome'];
									$data_nascimento = $_POST['data_nascimento'];
									$salario = $_POST['salario'];

									$objUser = $cadastro->editCadastro($id, $nome, $data_nascimento, $salario);

									if ($objUser == true) {
										echo '<h1 class="text-uppercase text-center">Usuário atualizado com sucesso</h1>';
										echo '<a href="index.php" class="btn btn-success btn-block"> Voltar </a>';
									}
								endif;	
							endif;

						elseif (isset($_GET['create_user'])):

							if (!isset($_POST['hash'])) :
					?>
								<h1 class="text-uppercase text-center">Criar</h1>
								<div class="row justify-content-center">
									<form action="index.php?create_user" class="col-8" method="post">
										<div class="form-group">
											<label for="">Nome</label>
											<input type="text" name="nome" class="form-control">
										</div>
										<div class="form-group">
											<label for="">Data de nascimento</label>
											<input type="date" name="data_nascimento" class="form-control">
										</div>
										<div class="form-group">
											<label for="">Salário</label>
											<input type="text" name="salario" class="form-control money">
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-success btn-block"> Criar </button>
											<a href="index.php" class="btn btn-info btn-block"> Voltar </a>
										</div>
										<input type="hidden" name="hash" value="ef4643a7d6c4af78c08eb2bed79a0eac">
									</form>
								</div>
					<?php
							else:
								if (isset($_POST['hash']) && $_POST['hash'] == 'ef4643a7d6c4af78c08eb2bed79a0eac'):

										$nome = $_POST['nome'];
										$data_nascimento = $_POST['data_nascimento'];
										$salario = $_POST['salario'];

										$objUser = $cadastro->createCadastro($nome, $data_nascimento, $salario);

										if (is_bool($objUser) == true && $objUser == true):
											echo '<h1 class="text-uppercase text-center">Usuário criado com sucesso</h1>';
											echo '<a href="index.php" class="btn btn-success btn-block"> Voltar </a>';
										else:
											echo '<h1 class="text-uppercase text-center">Os campos abaixo são obrigatórios</h1>';
											foreach ($objUser as $error) {
												echo "<p class='text-center' style='color: red; font-weight: bold; margin-bottom: 0px;'> $error </p>";
											}
											echo '<a href="index.php?create_user" class="btn btn-success btn-block mt-5"> Voltar </a>';
										endif;
								endif;
							endif;

						else:
							if (isset($_GET['remove_user'])) :

								$id = $_POST['id'];
								$objUser = $cadastro->deleteCadastro($id);

								if ($objUser == true) :
									echo '<h1 class="text-uppercase text-center">Usuário deletado com sucesso</h1>';
									echo '<a href="index.php" class="btn btn-success btn-block"> Voltar </a>';
								endif;

							endif;
					?>

					<?php
						endif;
					?>
				</div>

			</div>
		</div>

	</body>
</html>