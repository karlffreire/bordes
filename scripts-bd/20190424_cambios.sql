ALTER TABLE datos.mercanciasybienes
  DROP CONSTRAINT viajes_fkey;
ALTER TABLE datos.mercanciasybienes
  ADD CONSTRAINT viajes_fkey FOREIGN KEY (idviajes)
      REFERENCES datos.viajes (idviajes) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;


ALTER TABLE datos.recorrido
  DROP CONSTRAINT recorrido_idviajes_fkey;
ALTER TABLE datos.recorrido
  ADD CONSTRAINT recorrido_idviajes_fkey FOREIGN KEY (idviajes)
      REFERENCES datos.viajes (idviajes) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE datos.cartasviajes
  DROP CONSTRAINT viajes_fkey;
ALTER TABLE datos.cartasviajes
  ADD CONSTRAINT viajes_fkey FOREIGN KEY (idviajes)
      REFERENCES datos.viajes (idviajes) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;
