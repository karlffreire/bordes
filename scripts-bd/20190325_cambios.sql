ALTER DOMAIN datos.d_tipomercancias
  DROP CONSTRAINT d_tipomercancias_check;
ALTER DOMAIN datos.d_tipomercancias
    ADD CONSTRAINT d_tipomercancias_check CHECK (VALUE::text = ANY (ARRAY['Especias'::character varying, 'Alimentos'::character varying, 'Bebidas'::character varying, 'Vestidos'::character varying, 'Mobiliario'::character varying]::text[]));

ALTER TABLE datos.oficio
    ADD COLUMN nombre character varying (255);
