ALTER TABLE datos.cartasacontecimiento
  DROP CONSTRAINT cartas_fkey;
ALTER TABLE datos.cartasacontecimiento
  ADD CONSTRAINT cartas_fkey FOREIGN KEY (idcartas) REFERENCES datos.cartas (idcartas) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE datos.objetoscartas
  DROP CONSTRAINT objetoscartas_idcartas_fkey;
ALTER TABLE datos.objetoscartas
  ADD CONSTRAINT cartas_fkey FOREIGN KEY (idcartas) REFERENCES datos.cartas (idcartas) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE datos.mencion
  DROP CONSTRAINT idcartas_fkey;
ALTER TABLE datos.mencion
  ADD CONSTRAINT cartas_fkey FOREIGN KEY (idcartas) REFERENCES datos.cartas (idcartas) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE datos.mercanciasybienes
  DROP CONSTRAINT cartas_fkey;
ALTER TABLE datos.mercanciasybienes
  ADD CONSTRAINT cartas_fkey FOREIGN KEY (idcartas) REFERENCES datos.cartas (idcartas) ON UPDATE CASCADE ON DELETE CASCADE;
