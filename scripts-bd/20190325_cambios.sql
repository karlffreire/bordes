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
