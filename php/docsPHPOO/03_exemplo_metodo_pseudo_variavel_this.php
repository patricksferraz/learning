<?php

/**
* Classe teste para apresentação de PHP OO, demostrando
* a utilização da pseudo-variável this
* 
* @author Patrick Ferraz <patrick.ferraz@outlook.com>
*/
class ExemploMetodo
{
	//Propriedades
	public $var = "sou uma string";

	//Métodos
	public function getVar(){
		return $this->var;
	}
	public function setVar($novaString){
		$this->var = $novaString;
	}
	//
}

//Instanciando a classe
$obj = new ExemploMetodo();

echo $obj->var;

//Exibindo valor atual
echo "Primeiro valor: " . $obj->getVar() . "<br>";

//Alterando e exibindo novo valor
$obj->setVar("sou a nova string");
echo "Novo valor: " . $obj->getVar() . "<br>";

?>
