GRANT ALL PRIVILEGES ON mana.* TO administrador IDENTIFIED BY 'lupf2024';

GRANT SELECT,UPDATE,INSERT,DELETE ON mana.* TO funcionario IDENTIFIED BY "funcionario2024";

GRANT SELECT ON mana.* TO consultor_datos IDENTIFIED BY "consultor2024";

GRANT SELECT, INSERT, UPDATE ON mana.Venta TO contador IDENTIFIED BY "contadordemana"; 
GRANT SELECT, INSERT, UPDATE ON mana.Cobro TO contador;
GRANT SELECT ON mana.Cliente TO contador; 
GRANT SELECT ON mana.Producto TO contador;

GRANT SELECT, INSERT, UPDATE ON mana.Producto TO controlador_stock  IDENTIFIED BY "controlador_stock_mana";

GRANT SELECT, INSERT, UPDATE ON mana.Cliente TO compras_ventas  IDENTIFIED BY "compraventasmana";
GRANT SELECT, INSERT, UPDATE ON mana.Venta TO compras_ventas;
GRANT SELECT, INSERT, UPDATE ON mana.Productos_Vendidos TO compras_ventas;
GRANT SELECT, INSERT, UPDATE ON mana.Cobro TO compras_ventas;
GRANT SELECT, INSERT, UPDATE ON mana.Compra TO compras_ventas;
GRANT SELECT, INSERT, UPDATE ON mana.Productos_Comprados TO compras_ventas;
GRANT SELECT, INSERT, UPDATE ON mana.Pago TO compras_ventas;