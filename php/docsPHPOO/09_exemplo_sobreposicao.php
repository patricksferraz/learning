<?php

/**
* Exemplo de sobreposição
*///
class ClassePai
{
  public function __construct()
  {
      echo 'A classe "' . __CLASS__ . '" foi instanciada!<br>';
  }
}
 
class ClasseFilha extends ClassePai
{
  public function __construct()
  {
      parent::__construct(); // Invoca o construtor da classe pai
      echo "Um novo construtor em " . __CLASS__ . ".<br>";
  }
 
  public function novoMetodo()
  {
      echo "De um novo método na classe " . __CLASS__ . ".<br>";
  }
}
 
// Cria um novo objeto
$obj = new ClasseFilha;
 
// Usa o método da nova classe
$obj->novoMetodo();
//

?>