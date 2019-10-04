<?php

/**
* Classe teste para apresentação de PHP OO, demostrando
* utilização do método construct
* 
* @author Patrick Ferraz <patrick.ferraz@outlook.com>
*/
class ExemploMetodo
{
	public $nome;
	public $idade;
	public $sexo;
	//
	function __construct($nome, $idade, $sexo){
		$this->nome = $nome;
		$this->idade = $idade;
		$this->sexo = $sexo;
		echo "A classe '" . __CLASS__ . "' foi instanciada<br>";
	}
	//
	function __destruct(){
		echo "A classe '" . __CLASS__ . "' foi destruida<br>";
	}
	//
	function __toString(){
		return "Nome: $this->nome<br>Idade: $this->idade<br>Sexo: $this->sexo<br>";
	}
	//
}

//Instanciando a classe
$obj = new ExemploMetodo("Maria", 34, "F");
//$obj = null;
//unset($obj);
//echo $obj;
?>
