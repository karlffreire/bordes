<?php

function conectaBD(){
	$credenciales = explode('#',$_COOKIE["bordes"]);
	return pg_connect("host=".$_SESSION['host']." port=".$_SESSION['port']." dbname=".$_SESSION['dbname']." user=".$credenciales[0]." password=".$credenciales[1]);
}

function miembroDe($usuario){
	$con = conectaBD();
	$prp = pg_prepare($con,"grupos","WITH RECURSIVE cte AS (SELECT oid FROM pg_roles WHERE rolname = $1 UNION ALL SELECT m.roleid FROM cte JOIN pg_auth_members m ON m.member = cte.oid) SELECT pg_get_userbyid(oid) as grupo FROM cte;");
	$prp = pg_execute($con,"grupos",array($usuario));
	while($row=pg_fetch_assoc($prp)){
		$grupos[]=$row["grupo"];
	}
	pg_close($con);
	return $grupos;
}
