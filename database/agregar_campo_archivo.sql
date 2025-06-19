-- Agregar campo archivo a la tabla pedidos
ALTER TABLE pedidos ADD COLUMN archivo VARCHAR(255) NULL AFTER id_estado;

-- Comentario sobre el campo
-- Este campo almacenará el nombre del archivo PDF de la factura generada 