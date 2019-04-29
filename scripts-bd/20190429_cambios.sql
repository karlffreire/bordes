ALTER TABLE datos.cartas
   ALTER COLUMN numeroregistro SET NOT NULL;

ALTER TABLE datos.cartas
  ALTER COLUMN pagina DROP NOT NULL;

ALTER TABLE datos.personasobjetos
DROP CONSTRAINT personasobjetos_idpersonas_fkey;
ALTER TABLE datos.personasobjetos
ADD CONSTRAINT personasobjetos_idpersonas_fkey FOREIGN KEY (idpersonas)
      REFERENCES datos.personas (idpersonas) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE datos.parentesco
DROP CONSTRAINT parentesco_idobjeto_fkey;
ALTER TABLE datos.parentesco
DROP CONSTRAINT parentesco_idtiporel_fkey;

ALTER TABLE datos.parentesco
ADD CONSTRAINT parentesco_idobjeto_fkey FOREIGN KEY (idobjeto)
     REFERENCES datos.personas (idpersonas) MATCH SIMPLE
     ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE datos.parentesco
ADD CONSTRAINT parentesco_idtiporel_fkey FOREIGN KEY (idtiporel)
    REFERENCES datos.tiporelacion (idtiporel) MATCH SIMPLE
    ON UPDATE CASCADE ON DELETE NO ACTION;
