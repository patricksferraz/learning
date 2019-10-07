<?php

/**
* Exemplo de herança com EXTENDS
*///
class ClassePai
{
	public function exibiString($string) {
		echo "ClassePai: " . $string . "<br>";
   	}

	public function exibiMensagem() {
		echo "Sou uma mensagem<br>";
	}
}

class ClasseFilha extends ClassePai
{
	//override
	public function exibiString($string) {
		echo "ClasseFilha: " . $string . "<br>";
   	}
}
//

$pai = new ClassePai();
$filha = new ClasseFilha();
$pai->exibiString("pai");
$pai->exibiMensagem();
$filha->exibiString("filha");
$filha->exibiMensagem();
//

//-----------------------------------------------------------------------------------
//************************************ABSTRACT***************************************
//-----------------------------------------------------------------------------------

/**
* Exemplo de herança com ABSTRACT
* fonte: https://secure.php.net/manual/pt_BR/language.oop5.abstract.php
*//*/
abstract class ClasseAbstrata
{
    // Esse método abstrato apenas define os argumentos requeridos
    abstract protected function prefixName($name);

    // Método comum
    public function imprimir($name) {
        echo $this->prefixName($name);
    }

}

class ClasseConcreta extends ClasseAbstrata
{

    // O método filho pode definir argumentos opcionais não presentes na assinatura abstrata
    public function prefixName($name, $separator = ".") {
        if ($name == "Pacman") {
            $prefix = "Mr";
        } elseif ($name == "Pacwoman") {
            $prefix = "Mrs";
        } else {
            $prefix = "";
        }
        return "{$prefix}{$separator} {$name}";
    }
}

$class = new ClasseConcreta;
echo $class->prefixName("Pacman")."<br>";
echo $class->prefixName("Pacwoman")."<br>";
$class->imprimir("Pacman")."<br>";
/*/

//-----------------------------------------------------------------------------------
//************************************INTERFACE**************************************
//-----------------------------------------------------------------------------------

/**
* Exemplo de herança com INTERFACE
*//*/
interface a
{
	//public function imprimir($name);
	//protected function protegido();
    public function foo();
}

interface b
{
    public function bar();
}

interface c extends a, b
{
    public function baz();
}

class d implements c
{
	public function imprimir($nome){
		echo $nome;
	}

    public function foo()
    {
    }

    public function bar()
    {
    }

    public function baz()
    {
    }
}
/*/

?>