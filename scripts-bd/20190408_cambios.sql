ALTER TABLE datos.parentesco
  ADD COLUMN idparentesco serial;
ALTER TABLE datos.parentesco
  DROP CONSTRAINT parentesco_pkey;
ALTER TABLE datos.parentesco
  ADD CONSTRAINT parentesco_pkey PRIMARY KEY (idparentesco);

  GRANT ALL ON SEQUENCE datos.parentesco_idparentesco_seq TO postgres;
GRANT SELECT, USAGE ON SEQUENCE datos.parentesco_idparentesco_seq TO editor_bordes;
GRANT UPDATE ON SEQUENCE datos.parentesco_idparentesco_seq TO editor_bordes;
GRANT SELECT, USAGE ON SEQUENCE datos.parentesco_idparentesco_seq TO lector_bordes;
