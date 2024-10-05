GRANT ALL PRIVILEGES ON mana.* TO administrador IDENTIFIED BY 'lupf2024';


GRANT SELECT,UPDATE,INSERT,DELETE ON mana.* TO funcionario IDENTIFIED BY "funcionario2024";



GRANT SELECT ON mana.* TO consultor_datos IDENTIFIED BY "consultor2024";



GRANT SELECT, INSERT, UPDATE ON mana.Venta TO contador IDENTIFIED BY "contadordemana";
GRANT SELECT, INSERT, UPDATE ON mana.Cobro TO contador;
GRANT SELECT ON mana.Productos_Vendidos TO contador;

GRANT SELECT, INSERT, UPDATE ON mana.Pago TO contador;
GRANT SELECT, INSERT, UPDATE ON mana.Compra TO contador;
GRANT SELECT ON mana.Productos_Comprados TO contador;

GRANT SELECT ON mana.Proveedor TO contador;
GRANT SELECT ON mana.Cliente TO contador;
GRANT SELECT ON mana.Producto TO contador;



GRANT SELECT, INSERT, UPDATE ON mana.Producto TO controlador_stock  IDENTIFIED BY "controlador_stock_mana";
GRANT SELECT ON mana.Productos_Vendidos TO controlador_stock;
GRANT SELECT ON mana.Productos_Comprados TO controlador_stock;

GRANT SELECT, INSERT, UPDATE ON mana.Proveedor TO compra  IDENTIFIED BY "compramana";
GRANT SELECT, INSERT, UPDATE ON mana.Compra TO compra;
GRANT SELECT, INSERT, UPDATE ON mana.Producto TO compra;
GRANT SELECT, INSERT, UPDATE ON mana.Productos_Comprados TO compra;
GRANT SELECT, INSERT, UPDATE ON mana.Pago TO compra;

GRANT SELECT, INSERT, UPDATE ON mana.Cliente TO ventas  IDENTIFIED BY "ventasmana";
GRANT SELECT, INSERT, UPDATE ON mana.Venta TO ventas;
GRANT SELECT, INSERT, UPDATE ON mana.Productos_Vendidos TO ventas;
GRANT SELECT, INSERT, UPDATE ON mana.Cobro TO ventas;
GRANT SELECT, INSERT, UPDATE ON mana.Producto TO ventas;



