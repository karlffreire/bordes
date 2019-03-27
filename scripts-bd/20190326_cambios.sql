ALTER DOMAIN datos.d_tipomercancias
  DROP CONSTRAINT d_tipomercancias_check;
ALTER DOMAIN datos.d_tipomercancias
    ADD CONSTRAINT d_tipomercancias_check CHECK (VALUE::text = ANY (ARRAY['Especias'::character varying, 'Alimentos'::character varying, 'Bebidas'::character varying, 'Vestidos'::character varying, 'Mobiliario'::character varying]::text[]));

ALTER TABLE datos.oficio
    ADD COLUMN nombre character varying (255);

ALTER TABLE datos.tiporelacion DROP COLUMN tipoprimario;
ALTER TABLE datos.tiporelacion
        ADD COLUMN tipoprimario boolean;

INSERT INTO datos.esquemarelaciones (idesqrel,esquema) values
  (1,'Parentesco'),
  (2,'Institucional')
;

INSERT INTO datos.tiporelacion (idtiporel,categoria,tipoprimario,idesqrel) VALUES
  (2,'consanguinidad','f',1),
  (3,'padres','f',1),
  (4,'hijos','f',1),
  (5,'afinidad','f',1),
  (7,'suegros','f',1),
  (8,'yerno','f',1),
  (9,'nuera','f',1),
  (12,'abuelo','f',1),
  (13,'hermano','f',1),
  (14,'cuñado','f',1),
  (15,'nietos','f',1),
  (21,'bisabuelo','f',1),
  (22,'tio','f',1),
  (23,'sobrino','f',1),
  (25,'bisabuelo','f',1),
  (11,'consanguinidad','f',1),
  (16,'afinidad','f',1),
  (17,'abuelo','f',1),
  (18,'hermano','f',1),
  (20,'consanguinidad','f',1),
  (24,'afinidad','f',1),
  (26,'tio','f',1),
  (27,'cuñado','f',1),
  (29,'sobrino','f',1),
  (19,'3er grado','f',1),
  (51,'Pariente','t',1),
  (10,'2 grado','f',1),
  (1,'1er grado','f',1)
;

INSERT INTO datos.jerarquiarel (orden1,orden2) VALUES
  (1,2),
  (1,5),
  (2,3),
  (2,4),
  (5,7),
  (5,8),
  (5,9),
  (10,11),
  (10,16),
  (11,12),
  (11,13),
  (11,14),
  (11,15),
  (16,17),
  (16,18),
  (19,20),
  (19,24),
  (20,21),
  (20,22),
  (20,23),
  (24,25),
  (24,26),
  (24,27),
  (24,29),
  (51,1),
  (51,10),
  (51,19)
;

-- FUNCTION: datos.id_relaciones(integer)
-- DROP FUNCTION datos.id_relaciones(integer);
CREATE OR REPLACE FUNCTION datos.id_relaciones(
	id_relacion integer)
RETURNS integer[]
    LANGUAGE 'plpgsql'
    COST 100
    IMMUTABLE STRICT
AS $BODY$

/* funcion que devuelve un array con los identificadores de los tipo_relacion de los que cuelga el que introducimos
el array tambien incluye el identificador que introducimos
*/

DECLARE
relaciones integer [] := '{}';
primario boolean := FALSE;
padres integer;

BEGIN
--insertamos el primer valor del array, que es el id por el que preguntamos
relaciones :=array_fill(id_relacion,ARRAY[1]);
--vemos si es directamente un tipo primario
select tipoprimario into primario from datos.tiporelacion where idtiporel=id_relacion;
IF primario =FALSE THEN
	--si no es directamente primario buscamos el primer padre
	SELECT orden1 INTO padres FROM datos.jerarquiarel
	where orden2= id_relacion;
	--mientras no sea primario entramos en el bucle
	WHILE primario=FALSE LOOP
		select tipoprimario into primario from datos.tiporelacion where idtiporel=padres;
		--vamos insertando el resto de valores
		relaciones := array_prepend(padres,relaciones);
		SELECT padre.idtiporel INTO padres
		FROM datos.tiporelacion as padre INNER JOIN datos.jerarquiarel
						ON padre.idtiporel=jerarquiarel.orden1
					INNER JOIN  datos.tiporelacion as hijo
						ON jerarquiarel.orden2=hijo.idtiporel
		where hijo.idtiporel = padres;
		---NOTA: parece que la consulta se podria hacer sin los JOIN, pero no es  asi, porque hay que recurrir a la columna tipoprimario para saber cuando salir del bucle
	END LOOP;
	--devuelve el array
	RETURN relaciones;
ELSE
	--devuelve el array
	RETURN relaciones;
END IF;
END;
$BODY$;

ALTER FUNCTION datos.id_relaciones(integer)
    OWNER TO postgres;
GRANT EXECUTE ON FUNCTION datos.id_relaciones(integer) TO editor_bordes WITH GRANT OPTION;
GRANT EXECUTE ON FUNCTION datos.id_relaciones(integer) TO postgres;
GRANT EXECUTE ON FUNCTION datos.id_relaciones(integer) TO PUBLIC;
GRANT EXECUTE ON FUNCTION datos.id_relaciones(integer) TO lector_bordes WITH GRANT OPTION;


-- FUNCTION: datos.txt_relaciones(integer)
-- DROP FUNCTION datos.txt_relaciones(integer);
CREATE OR REPLACE FUNCTION datos.txt_relaciones(
	id_relacion integer)
RETURNS character varying[]
    LANGUAGE 'plpgsql'
    COST 100
    IMMUTABLE STRICT
AS $BODY$
/* funcion que devuelve un array con las categorias de los tiporelacion de los que cuelga el que introducimos
el array tambien incluye la categoría del identificador que introducimos
*/

DECLARE
relaciones integer [] := '{}';
txt_rel character varying;
array_txt_rel character varying [] := '{}';
primario boolean := FALSE;
padres integer;
i integer;

BEGIN
--insertamos el primer valor del array, que es el id por el que preguntamos
relaciones :=array_fill(id_relacion,ARRAY[1]);
--vemos si es directamente un tipo primario
select tipoprimario into primario from datos.tiporelacion where idtiporel=id_relacion;
IF primario =FALSE THEN
	--si no es directamente primario buscamos el primer padre
	SELECT orden1 INTO padres FROM datos.jerarquiarel
	where orden2= id_relacion;
	--mientras no sea primario entramos en el bucle
	WHILE primario=FALSE LOOP
		select tipoprimario into primario from datos.tiporelacion where idtiporel=padres;
		--vamos insertando el resto de valores
		relaciones := array_prepend(padres,relaciones);
		SELECT padre.idtiporel INTO padres
		FROM datos.tiporelacion as padre INNER JOIN datos.jerarquiarel
						ON padre.idtiporel=jerarquiarel.orden1
					INNER JOIN  datos.tiporelacion as hijo
						ON jerarquiarel.orden2=hijo.idtiporel
		where hijo.idtiporel = padres;
		---NOTA: parece que la consulta se podria hacer sin los JOIN, pero no es  asi, porque hay que recurrir a la columna tipoprimario para saber cuando salir del bucle
	END LOOP;
		FOREACH i IN ARRAY relaciones
			LOOP
				SELECT categoria INTO txt_rel from datos.tiporelacion where idtiporel = i;
				array_txt_rel := array_append(array_txt_rel,txt_rel);
				txt_rel := '';
				--RAISE NOTICE '%', i;
			END LOOP;
	--devuelve el array
	RETURN array_txt_rel;
ELSE
	--devuelve el array
	SELECT categoria INTO txt_rel from datos.tiporelacion where idtiporel = relaciones[1];
	array_txt_rel :=array_fill(txt_rel,ARRAY[1]);
	RETURN array_txt_rel;
END IF;
END;
$BODY$;

ALTER FUNCTION datos.txt_relaciones(integer)
    OWNER TO postgres;
GRANT EXECUTE ON FUNCTION datos.txt_relaciones(integer) TO editor_bordes WITH GRANT OPTION;
GRANT EXECUTE ON FUNCTION datos.txt_relaciones(integer) TO postgres;
GRANT EXECUTE ON FUNCTION datos.txt_relaciones(integer) TO PUBLIC;
GRANT EXECUTE ON FUNCTION datos.txt_relaciones(integer) TO lector_bordes WITH GRANT OPTION;

ALTER TABLE datos.acontecimiento
    DROP CONSTRAINT acontecimiento_idcartas_fkey;

ALTER TABLE datos.acontecimiento
    DROP COLUMN idcartas;

CREATE TABLE datos.cartasacontecimiento  (
  idacontecimiento integer NOT NULL,
  idcartas integer NOT NULL,
  CONSTRAINT cartasacontecimiento_pkey PRIMARY KEY (idacontecimiento,idcartas),
  CONSTRAINT cartas_fkey FOREIGN KEY (idcartas) REFERENCES datos.cartas (idcartas) MATCH SIMPLE ON UPDATE CASCADE ON DELETE NO ACTION,
  CONSTRAINT acontecimiento_fkey FOREIGN KEY (idacontecimiento) REFERENCES datos.acontecimiento (idacontecimiento) MATCH SIMPLE ON UPDATE CASCADE ON DELETE NO ACTION
);
ALTER TABLE datos.cartasacontecimiento
  OWNER TO postgres;
GRANT ALL ON TABLE datos.cartasacontecimiento TO postgres;
GRANT ALL ON TABLE datos.cartasacontecimiento TO editor_bordes;
GRANT SELECT ON TABLE datos.cartasacontecimiento TO lector_bordes;
