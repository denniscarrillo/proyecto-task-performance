SELECT * FROM cocinas_y_equipos.tbl_vendedores_tarea;
SELECT t.id_Tarea, vt.id_usuario_vendedor From tbl_Tarea AS t
INNER JOIN tbl_vendedores_tarea AS vt ON t.id_Tarea  = vt.id_Tarea
WHERE t.id_Tarea  = 6;

INSERT INTO `tbl_tarea` (`id_EstadoAvance`, `titulo`, `fecha_Inicio`, `Creado_Por`, `Fecha_Creacion`) 
                            VALUES (4,'titulo Venta', 
                                    '2023-08-02', 'SUPERADMIN', '2023-08-02');
                                    SELECT LAST_INSERT_ID() AS id_Tarea;

INSERT INTO `tbl_vendedores_tarea` (`id_Tarea`, `id_usuario_vendedor`) 
                                    VALUES ('21', '1');

SELECT id_Tarea FROM tbl_AdjuntoEvidencia WHERE evidencia = 2;

SELECT vt.id_usuario_vendedor, u.Usuario FROM tbl_vendedores_tarea AS vt
INNER JOIN tbl_ms_Usuario AS u ON u.id_Usuario = vt.id_usuario_vendedor WHERE vt.id_Tarea = 5;


SELECT t.titulo, t.fecha_Inicio, e.descripcion  FROM tbl_vendedores_tarea AS vt
                INNER JOIN tbl_tarea AS t ON t.id_Tarea = vt.id_Tarea
                INNER JOIN tbl_estadoavance AS e ON t.id_EstadoAvance = e.id_EstadoAvance
                WHERE vt.id_usuario_vendedor = 1;



SELECT t.titulo, t.fecha_Inicio, e.descripcion FROM tbl_Tarea AS t
                INNER JOIN tbl_estadoavance AS e ON t.id_EstadoAvance = e.id_EstadoAvance
                WHERE t.id_Usuario = $idUser;