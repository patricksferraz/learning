<?php

/**
* Exemplo propriedades e métodos estáticos
* e propriedades constantes
*///
class ExemploConstanteEstatica
{
	//propriedade constante
	const CONST_VALUE = 'Um valor constante';

	//propriedade estática
	public static $estatica = 'variável estática';

	//metodo estático
    public static function acessoPropriedades() {
        echo self::CONST_VALUE . "<br>";
        echo self::$estatica . "<br>";
    }
}

//Acesso instanciando a classe
$obj = new ExemploConstanteEstatica();
//echo $obj->CONST_VALUE;
//echo $obj->estatica;
//echo $obj::CONST_VALUE . "<br>";
//echo $obj::$estatica . "<br>";
//$obj->acessoPropriedades();

//Acesso sem instanciar
//
//$classname = "ExemploConstanteEstatica";
//echo $classname::CONST_VALUE . "<br>";
//echo $classname::$estatica . "<br>";
//ExemploConstanteEstatica::acessoPropriedades();
//
?>
