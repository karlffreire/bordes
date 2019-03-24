<?php

class OperaBD {
  /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
   * inserta()
   * inserta un registro en una tabla
   *
   * @param  string $tabla Nombre de la tabla. Debe incluir el esquema
   * @param  array $arrprop Array asociativo. Las claves son el nombre del campo y el valor el valor a insertar
   */
  static function inserta ($tabla,$arrprop){
    $lstcamp;
    $params;
    foreach ($arrprop as $key => $value) {
      $lstcamp[] = $key;
      $params[] = ':'.$key;
    }
    $sql = "INSERT INTO $tabla (".implode(',',$lstcamp).") VALUES (".implode(',',$params).");";
    $mbd = ConBD::conectaBD();
    try{
      $sentencia = $mbd->prepare($sql);
      foreach ($arrprop as $key => $value) {
        $sentencia->bindValue(':'.$key,$value);
      }
      $sentencia->execute();
      $mbd = null;
    }
    catch (PDOException $e){
      echo $e->getMessage();//HACER FUNCION PARA MANEJAR ERRORES
    }
  }
  /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
   * modifica()
   * inserta un registro en una tabla
   *
   * @param  string $tabla Nombre de la tabla. Debe incluir el esquema
   * @param  array $arrprop Array asociativo. Las claves son el nombre del campo y el valor el valor a insertar
   * @param  array $id ID de la fila a modificar. Array asociativo: nombre campo en clave, valor en valor
   */
  static function modifica ($tabla,$arrprop,$id){
    $lstcamp;
    $params;
    foreach ($arrprop as $key => $value) {
      $lstcamp[] = $key .' = '.':'.$key;
    }
    $sql = "UPDATE $tabla SET ".implode(',',$lstcamp)." WHERE ".key($id)." = :id;";
    $mbd = ConBD::conectaBD();
    try{
      $sentencia = $mbd->prepare($sql);
      foreach ($arrprop as $key => $value) {
        $sentencia->bindValue(':'.$key,$value);
      }
      foreach ($id as $key => $value) {
        $sentencia->bindValue(':id',$value);
      }
      $sentencia->execute();
      $mbd = null;
    }
    catch (PDOException $e){
      echo $e->getMessage(); //HACER FUNCION PARA MANEJAR ERRORES
    }
  }
  /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
   * borra()
   * borra registros de una tabla
   *
   * @param  string $tabla Nombre de la tabla. Debe incluir el esquema
   * @param  array $where Array asociativo de columna y condicion. Cláusula de filtro.
   */
  static function borra ($tabla,$where){
    $sql = "DELETE FROM $tabla WHERE ";
    foreach ($where as $key => $value) {
      $sql .= $key .' = :'.$key .' AND ';
    }
    $sql = substr($sql, 0, -4).';';
    $mbd = ConBD::conectaBD();
    try{
      $sentencia = $mbd->prepare($sql);
      foreach ($where as $key => $value) {
        $sentencia->bindValue(':'.$key,$value);
      }
      $sentencia->execute();
      $mbd = null;
    }
    catch (PDOException $e){
      echo $e->getMessage(); //HACER FUNCION PARA MANEJAR ERRORES
    }
  }
  /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
   * selecObjeto()
   * selecciona un registro de la base de datos en un objeto de la clase indicada
   *
   * @param  string $tabla Nombre de la tabla. Debe incluir el esquema
   * @param  array $arrprop Array de campos a solicitar
   * @param  string $clase Nombre de la clase a instanciar. Si no se proporciona, se devolverá un array normal, en lugar de un array de objetos
   * @param  array $where Array asociativo de columna y condicion. Cláusula de filtro. Si no está presente,se seleccionará todo. Siempre utiliza el operador AND para unir las claúsulas
   * @param  array $orden Array de campos para ordenar
   * @return array Array de objetos encontrados
   */
  static function selec ($tabla,$arrprop,$clase = null,$where = null, $orden = null){
    $lstcamp;
    foreach ($arrprop as $key => $value) {
      $lstcamp[] = $value;
    }
    $sql = "SELECT ".implode(',',$lstcamp)." FROM $tabla";
    if ($where) {
      $sql .= ' WHERE ';
      foreach ($where as $key => $value) {
        $sql .= $key .' = :'.$key .' AND ';
      }
      $sql = substr($sql, 0, -4).';';
    }
    $mbd = ConBD::conectaBD();
    try{
      $sentencia = $mbd->prepare($sql);
      if ($where) {
        foreach ($where as $key => $value) {
          $sentencia->bindValue(':'.$key,$value);
        }
      }
      $sentencia->execute();
      if ($clase) {
        $datos = $sentencia->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,$clase);
      }
      else{
        $datos = $sentencia->fetchAll(PDO::FETCH_NAMED);
      }
      $mbd = null;
    }
    catch (PDOException $e){
      echo 'Error en Base de Datos: '.$e->getMessage(); //HACER FUNCION PARA MANEJAR ERRORES
    }
    return $datos;
  }
}
//http://php.net/manual/es/pdostatement.bindvalue.php
// http://php.net/manual/es/pdo.transactions.php
// http://php.net/manual/es/pdo.connections.php
// http://php.net/manual/es/pdo.prepared-statements.php

//
// try {
//TRABAJO CON TRANSACCIONES:
//   $mbd->beginTransaction();
//   $mbd->exec("insert into staff (id, first, last) values (23, 'Joe', 'Bloggs')");
//   $mbd->exec("insert into salarychange (id, amount, changedate)
//       values (23, 50000, NOW())");
//   $mbd->commit();
//
// } catch (Exception $e) {
//   $mbd->rollBack();
//   echo "Fallo: " . $e->getMessage();
// }

?>
