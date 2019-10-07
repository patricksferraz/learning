<?php
//
namespace MyProject;

const CONNECT_OK = 1;
class Connection {  }
function connect() {
  return "Conexão realizada em MyProject";
}

namespace MyProject2;

const CONNECT_OK = 1;
class Connection {  }
function connect() {
  return "Conexão realizada em MyProject2";
}
/*/

namespace MyProject2 {
  
  const CONNECT_OK = 1;
  class Connection {  }
  function connect() { 
    return "Conexão realizada em MyProject";
  }
}

namespace AnotherProject2 {

  const CONNECT_OK = 1;
  class Connection {  }
  function connect() {  
    return "Conexão realizada em MyProject2";
  }
}
/*/
?>