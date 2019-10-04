<?php

/**
* Exemplo métodos e classes finais
*///
class ExemploFinal
{
	public function metodoComum() {
   	}

	final public function metodoFinal() {
	}
}

//
class ClasseFinal extends ExemploFinal
{
	/*/tentativa de override
	public function metodoFinal() {
	}
	/*/
}

//
class OutraClasse extends ExemploFinal {
}
//

?>
