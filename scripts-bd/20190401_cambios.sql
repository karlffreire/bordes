ALTER TABLE datos.cartas
  ADD COLUMN idemisor integer;
ALTER TABLE datos.cartas
  ADD COLUMN idreceptor integer;
ALTER TABLE datos.cartas
  ADD CONSTRAINT emisor_fkey FOREIGN KEY (idemisor) REFERENCES datos.personas (idpersonas) MATCH SIMPLE ON UPDATE CASCADE ON DELETE NO ACTION;
ALTER TABLE datos.cartas
  ADD CONSTRAINT receptor_fkey FOREIGN KEY (idreceptor) REFERENCES datos.personas (idpersonas) MATCH SIMPLE ON UPDATE CASCADE ON DELETE NO ACTION;
DROP TABLE datos.cartaspersonas;

CREATE TABLE datos.mencion
(
    idcartas integer NOT NULL,
    idpersonas integer NOT NULL,
    CONSTRAINT mencion_pkey PRIMARY KEY (idcartas, idpersonas),
    CONSTRAINT idcartas_fkey FOREIGN KEY (idcartas)
        REFERENCES datos.cartas (idcartas) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE NO ACTION,
    CONSTRAINT idpersonas_fkey FOREIGN KEY (idpersonas)
        REFERENCES datos.personas (idpersonas) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE datos.mencion
    OWNER to postgres;

GRANT ALL ON TABLE datos.mencion TO postgres;

GRANT SELECT ON TABLE datos.mencion TO lector_bordes;

GRANT ALL ON TABLE datos.mencion TO editor_bordes;

-- Trigger: registra_modif_filas

-- DROP TRIGGER registra_modif_filas ON datos.cartaspersonas;

CREATE TRIGGER registra_modif_filas
    AFTER INSERT OR DELETE OR UPDATE
    ON datos.mencion
    FOR EACH ROW
    EXECUTE PROCEDURE public.modificar_fila();
