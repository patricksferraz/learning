<?php
//-----------------------------------------------------------------------------------
//***********************************PROPRIEDADES************************************
//-----------------------------------------------------------------------------------

/**
* Exemplo visibilidade de propriedades - CLASSE PAI
*///
class ExemploVisibilidadePropriedades
{
	public $publica = "public PAI";
	protected $protegida = "protected PAI";
	private $privada = "private PAI";
	
	function acessarPropriedades(){
		echo "Acesso prop. publica classe pai por metodo: " . $this->publica . "<br>";
		echo "Acesso prop. protegida classe pai por metodo: " . $this->protegida . "<br>";
		echo "Acesso prop. privada classe pai por metodo: " . $this->privada . "<br>";
	}
}

//Instanciando a classe 1
//$obj = new ExemploVisibilidadePropriedades();
//echo "Acesso direto prop. publica classe pai: " . $obj->publica . "<br>";
//echo "Acesso direto prop. protegida classe pai: " . $obj->protegida;
//echo "Acesso direto prop. privada classe pai: " . $obj->privada;
//$obj->acessarPropriedades();
//

/**
* Exemplo visibilidade de propriedades - CLASSE FILHA
*///
class ExemploVisibilidadePropriedades2 extends ExemploVisibilidadePropriedades
{
	//É possível redeclarar as propriedades públicas e protegidas, mas não as privadas
	//public $publica = "public FILHA";
	//protected $protegida = "protected FILHA";
	//private $privada = "private FILHA";
	
	/*/Override
	function acessarPropriedades(){
		echo "Acesso prop. publica classe filha por metodo: " . $this->publica . "<br>";
		echo "Acesso prop. protegida classe filha por metodo: " . $this->protegida . "<br>";
		echo "Acesso prop. privada classe filha por metodo: " . $this->privada . "<br>";
	}
	/*/
}

//Instanciando a classe 2
//$obj2 = new ExemploVisibilidadePropriedades2();
//echo "Acesso direto prop. publica classe filha: " . $obj2->publica . "<br>";
//echo "Acesso direto prop. protegida classe filha: " . $obj2->protegida;
//echo "Acesso direto prop. privada classe filha: " . $obj2->privada;
//$obj2->acessarPropriedades();
//













//-----------------------------------------------------------------------------------
//***********************************MÉTODOS*****************************************
//-----------------------------------------------------------------------------------

/**
* Exemplo visibilidade de métodos
* CLASSE PAI
*///
class ExemploVisibilidadeMetodos
{
	public function publico(){
		echo "Metodo publico pai: " . __FUNCTION__ . "<br>";
	}
	protected function protegido(){
		echo "Metodo protegido pai: " . __FUNCTION__ . "<br>";
	}
	private function privado(){
		echo "Metodo privado pai: " . __FUNCTION__ . "<br>";
	}
	function acesso(){
		$this->publico();
		$this->protegido();
		$this->privado();
	}
}

/*/Instanciando a classe
$obj = new ExemploVisibilidadeMetodos();
$obj->publico();
//$obj->protegido();
//$obj->privado();
//$obj->acesso();
/*/

/**
* Exemplo visibilidade de métodos
* CLASSE FILHA
*///
class ExemploVisibilidadeMetodos2 extends ExemploVisibilidadeMetodos
{
	function acesso(){
		$this->publico();
		$this->protegido();
		$this->privado();
	}
}

/*/Instanciando a classe 2
$obj2 = new ExemploVisibilidadeMetodos2();
$obj2->publico();
//$obj2->protegido();
//$obj2->privado();
//$obj2->acesso();
/*/
?>
