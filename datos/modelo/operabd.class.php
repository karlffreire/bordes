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
    $sentencia = $mbd->prepare($sql);
    foreach ($arrprop as $key => $value) {
      $sentencia->bindValue(':'.$key,$value);
    }
    $sentencia->execute();
    $mbd = null;
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
