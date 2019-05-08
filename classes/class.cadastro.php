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

	function editCadastro($id, $nome, $data_nascimento, $salario) 
	{

		$salario = str_replace(array('.',','), array('',''), $salario);
		$salario = number_format($salario,2,'.','');

		$query = '
			UPDATE cadastro
			SET nome = "'. $nome .'", data_nascimento = "'. $data_nascimento .'", salario = '. $salario .'
			WHERE id = '. intval($id) .'';

		return $this->_db->query($query);
	}

	function createCadastro($nome, $data_nascimento, $salario) 
	{
		$errors = [];

		if (empty($nome)) { 
			array_push($errors, "Nome é obrigatório"); 
		}
		if (empty($data_nascimento)) { 
			array_push($errors, "Data de nascimento é obrigatório"); 
		}
		if (empty($salario)) { 
			array_push($errors, "Salário é obrigatório"); 
		}

		$salario = str_replace(array('.',','), array('',''), $salario);
		$salario = number_format($salario,2,'.','');

		if (count($errors) == 0) {
			$query = 'INSERT INTO cadastro (nome, data_nascimento, salario) VALUES("' . $nome . '", "' . $data_nascimento .'", ' . $salario .')';
			var_dump($query);
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