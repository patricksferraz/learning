<?php

/**
* Classe teste para apresentação de PHP OO, demostrando
* estrutura, instacia e acesso aos métodos
* 
* @author Patrick Ferraz <patrick.ferraz@outlook.com>
*/
class ExemploMetodo
{
	public $prop = "sou uma propriedade";

	public function primeiroMetodo()
	{
		echo "primeiro metodo<br>";
	}
}

$obj = new ExemploMetodo();
$obj->primeiroMetodo();
echo $obj->prop;
//var_dump($obj);

?>
