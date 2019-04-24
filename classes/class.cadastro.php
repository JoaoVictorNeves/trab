<?php
class Cadastros {

	private $_db;

	public function __construct(Database $db)
    {
    	$db = $db->getConnection();
    	$this->_db = $db;
    }
 
	function getAllCadastros() 
	{
		$query = 'SELECT * FROM cadastro';
		$result = $this->_db->query($query);
		return $result;
	}

	function getCadastro($id) 
	{
		$query = 'SELECT * FROM cadastro WHERE id = ' . $id;
		$result = $this->_db->query($query);
		return $result;
	}

	function editCadastro($id, $nome, $dataNasc, $salario) 
	{
		$query = '
			UPDATE cadastro
			SET nome = "'. $nome .'", dataNasc = "'. $dataNasc .'", salario = '. $salario .'
			WHERE id = '. intval($id) .'';

		return $this->_db->query($query);
	}

	function createCadastro($nome, $dataNasc, $salario) 
	{
		$errors = [];

		if (empty($nome)) { 
			array_push($errors, "Nome é obrigatório"); 
		}
		if (empty($dataNasc)) { 
			array_push($errors, "Data de nascimento é obrigatório"); 
		}
		if (empty($salario)) { 
			array_push($errors, "Salário é obrigatório"); 
		}

		if (count($errors) == 0) {
			$query = 'INSERT INTO cadastro (nome, dataNasc, salario) VALUES("' . $nome . '", "' . $dataNasc .'", ' . floatval($salario) .')';
			return $this->_db->query($query);
		}else{
			return $errors;
		}
	}

	function deleteCadastro($id) 
	{
		$query = 'DELETE FROM cadastro WHERE id = '. intval($id) .'';
		return $this->_db->query($query);
	}
 
}