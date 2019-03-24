DROP TABLE datos.mercanciasybienesviajes;
ALTER TABLE datos.mercanciasybienes ADD COLUMN mercancia character varying (255);
ALTER TABLE datos.mercanciasybienes ADD COLUMN idviajes integer;
ALTER TABLE datos.mercanciasybienes ADD COLUMN idcartas integer;
ALTER TABLE datos.mercanciasybienes ADD CONSTRAINT viajes_fkey FOREIGN KEY (idviajes) REFERENCES datos.viajes (idviajes) MATCH SIMPLE ON UPDATE CASCADE ON DELETE NO ACTION;
ALTER TABLE datos.mercanciasybienes ADD CONSTRAINT cartas_fkey FOREIGN KEY (idcartas) REFERENCES datos.cartas (idcartas) MATCH SIMPLE ON UPDATE CASCADE ON DELETE NO ACTION;

ALTER TABLE datos.viajes DROP CONSTRAINT viajes_idcartas_fkey;
ALTER TABLE datos.viajes DROP COLUMN idcartas;

CREATE TABLE datos.cartasviajes (
  idviajes integer NOT NULL,
  idcartas integer NOT NULL,
  CONSTRAINT cartasviajes_pkey PRIMARY KEY (idviajes,idcartas),
  CONSTRAINT cartas_fkey FOREIGN KEY (idcartas) REFERENCES datos.cartas (idcartas) MATCH SIMPLE ON UPDATE CASCADE ON DELETE NO ACTION,
  CONSTRAINT viajes_fkey FOREIGN KEY (idviajes) REFERENCES datos.viajes (idviajes) MATCH SIMPLE ON UPDATE CASCADE ON DELETE NO ACTION
);
ALTER TABLE datos.cartasviajes
  OWNER TO postgres;
GRANT ALL ON TABLE datos.cartasviajes TO postgres;
GRANT ALL ON TABLE datos.cartasviajes TO editor_bordes;
GRANT SELECT ON TABLE datos.cartasviajes TO lector_bordes;

CREATE TABLE datos.nomenclator (
  idnomenclator serial NOT NULL,
  nombre character varying (255) NOT NULL,
  descripcion text,
  CONSTRAINT nomenclator_pkey PRIMARY KEY (idnomenclator)
);
ALTER TABLE datos.nomenclator
  OWNER TO postgres;
GRANT ALL ON TABLE datos.nomenclator TO postgres;
GRANT ALL ON TABLE datos.nomenclator TO editor_bordes;
GRANT SELECT ON TABLE datos.nomenclator TO lector_bordes;

CREATE TABLE datos.geometrias
(
  gid serial NOT NULL,
  nombre character varying(255),
  geom geometry(Point,4326),
  idpaises integer,
  idexterno integer,
  idnomenclator integer,
  CONSTRAINT geometrias_pkey PRIMARY KEY (gid),
  CONSTRAINT paises_fkey FOREIGN KEY (idpaises) REFERENCES datos.paises (idpaises) MATCH SIMPLE ON UPDATE CASCADE ON DELETE NO ACTION,
  CONSTRAINT nomenclator_fkey FOREIGN KEY (idnomenclator) REFERENCES datos.nomenclator (idnomenclator) MATCH SIMPLE ON UPDATE CASCADE ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);
ALTER TABLE datos.geometrias
  OWNER TO postgres;
GRANT ALL ON TABLE datos.geometrias TO postgres;
GRANT ALL ON TABLE datos.geometrias TO editor_bordes;
GRANT SELECT ON TABLE datos.geometrias TO lector_bordes;

ALTER TABLE datos.lugares DROP CONSTRAINT fk_paisespg_ciudadesgn;
ALTER TABLE datos.lugares DROP COLUMN idpaises;
ALTER TABLE datos.lugares DROP COLUMN pais;
ALTER TABLE datos.lugares DROP COLUMN geonamesid;
