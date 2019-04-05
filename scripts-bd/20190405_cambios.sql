--CAMBIO DE FOREIGN KEYS A CASCADE:
ALTER TABLE datos.parentesco
DROP CONSTRAINT parentesco_idsujeto_fkey;
ALTER TABLE datos.parentesco
DROP CONSTRAINT parentesco_idtiporel_fkey;
ALTER TABLE datos.parentesco ADD
CONSTRAINT parentesco_idsujeto_fkey FOREIGN KEY (idsujeto)
      REFERENCES datos.personas (idpersonas) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE datos.parentesco ADD
  CONSTRAINT parentesco_idtiporel_fkey FOREIGN KEY (idtiporel)
      REFERENCES datos.tiporelacion (idtiporel) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE datos.cargos DROP
  CONSTRAINT cargos_idpersonas_fkey;
ALTER TABLE datos.cargos ADD
CONSTRAINT cargos_idpersonas_fkey FOREIGN KEY (idpersonas)
      REFERENCES datos.personas (idpersonas) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE datos.homonimias DROP
  CONSTRAINT homonimias_idpersonas_fkey;
ALTER TABLE datos.homonimias ADD
  CONSTRAINT homonimias_idpersonas_fkey FOREIGN KEY (idpersonas)
     REFERENCES datos.personas (idpersonas) MATCH SIMPLE
     ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE datos.mencion DROP
 CONSTRAINT idpersonas_fkey;
ALTER TABLE datos.mencion ADD
CONSTRAINT idpersonas_fkey FOREIGN KEY (idpersonas)
   REFERENCES datos.personas (idpersonas) MATCH SIMPLE
   ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE datos.oficio DROP
CONSTRAINT oficio_idpersonas_fkey;
ALTER TABLE datos.oficio ADD
CONSTRAINT oficio_idpersonas_fkey FOREIGN KEY (idpersonas)
    REFERENCES datos.personas (idpersonas) MATCH SIMPLE
    ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE datos.personasobjetos DROP
CONSTRAINT personasobjetos_idobjetos_fkey;
ALTER TABLE datos.personasobjetos ADD
CONSTRAINT personasobjetos_idobjetos_fkey FOREIGN KEY (idpersonas)
    REFERENCES datos.personas (idpersonas) MATCH SIMPLE
    ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE datos.titulos DROP
CONSTRAINT titulos_idpersonas_fkey;
ALTER TABLE datos.titulos ADD
CONSTRAINT titulos_idpersonas_fkey FOREIGN KEY (idpersonas)
    REFERENCES datos.personas (idpersonas) MATCH SIMPLE
    ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE datos.viajeros DROP
CONSTRAINT idpersonas_fkey;
ALTER TABLE datos.viajeros ADD
CONSTRAINT idpersonas_fkey FOREIGN KEY (idpersonas)
    REFERENCES datos.personas (idpersonas) MATCH SIMPLE
    ON UPDATE CASCADE ON DELETE CASCADE;

--DEJO AQUÍ EL CÓDIGO DEL TRIGGER, AUNQUE NO FUNCIONA, PORQUE LUEGO NO BORRA EL REGISTRO DE PERSONA
-- CREATE OR REPLACE FUNCTION datos.borradopersona()
--   RETURNS trigger AS
-- $BODY$
-- DECLARE
--
-- BEGIN
--
--     DELETE FROM datos.homonimias WHERE idpersonas=old.idpersonas;
--     DELETE FROM datos.personasobjetos WHERE idpersonas=old.idpersonas;
--     DELETE FROM datos.oficio WHERE idpersonas=old.idpersonas;
--     DELETE FROM datos.cargos WHERE idpersonas=old.idpersonas;
--     DELETE FROM datos.titulos WHERE idpersonas=old.idpersonas;
--     DELETE FROM datos.parentesco WHERE idsujeto=old.idpersonas OR idobjeto=old.idpersonas;
--     DELETE FROM datos.mencion WHERE idpersonas=old.idpersonas;
--     DELETE FROM datos.viajeros WHERE idpersonas=old.idpersonas;
--     RETURN NULL;
--
--
--
-- END;$BODY$
--   LANGUAGE plpgsql VOLATILE
--   COST 100;
-- ALTER FUNCTION datos.borradopersona()
--   OWNER TO postgres;
-- GRANT EXECUTE ON FUNCTION datos.borradopersona() TO editor_bordes;
--
-- CREATE TRIGGER borradototal AFTER DELETE
--    ON datos.personas FOR EACH ROW
--    EXECUTE PROCEDURE datos.borradopersona();



CREATE OR REPLACE FUNCTION datos.fecha_cierta(
    fech date,
    conf integer)
  RETURNS character varying AS
$BODY$
	declare
		ano varchar (4);
		mes varchar (10);
		dia varchar (2);
		fech_conf varchar (25);
	begin
		if fech is null or conf is null then
			return '';
		else
			if conf = 1 then
				ano := (select extract (year from (date_trunc ('year', fech))));
				 fech_conf := ano;
			elsif conf = 2 then
				ano := (select extract (year from (date_trunc ('year', fech))));
				mes := (select extract (month from (date_trunc ('month', fech))));
					case mes
						when '1' then mes := 'enero';
						when '2' then mes := 'febrero';
						when '3' then mes := 'marzo';
						when '4' then mes := 'abril';
						when '5' then mes := 'mayo';
						when '6' then mes := 'junio';
						when '7' then mes := 'julio';
						when '8' then mes := 'agosto';
						when '9' then mes := 'septiembre';
						when '10' then mes := 'octubre';
						when '11' then mes := 'noviembre';
						when '12' then mes := 'diciembre';
					end case;
				fech_conf := mes || ' de ' || ano;
			else -- conf = 3
				ano := (select extract (year from (date_trunc ('year', fech))));
				mes := (select extract (month from (date_trunc ('month', fech))));
				dia := (select extract (day from (date_trunc ('day', fech))));
					case mes
						when '1' then mes := 'enero';
						when '2' then mes := 'febrero';
						when '3' then mes := 'marzo';
						when '4' then mes := 'abril';
						when '5' then mes := 'mayo';
						when '6' then mes := 'junio';
						when '7' then mes := 'julio';
						when '8' then mes := 'agosto';
						when '9' then mes := 'septiembre';
						when '10' then mes := 'octubre';
						when '11' then mes := 'noviembre';
						when '12' then mes := 'diciembre';
					end case;
				fech_conf := dia || ' de ' || mes || ' de ' || ano;
			end if;
		return fech_conf;
	end if;
	end;
	$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION datos.fecha_cierta(date, integer)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION datos.fecha_cierta(date, integer) TO postgres;
GRANT EXECUTE ON FUNCTION datos.fecha_cierta(date, integer) TO public;
GRANT EXECUTE ON FUNCTION datos.fecha_cierta(date, integer) TO editor_bordes WITH GRANT OPTION;
GRANT EXECUTE ON FUNCTION datos.fecha_cierta(date, integer) TO lector_bordes WITH GRANT OPTION;
