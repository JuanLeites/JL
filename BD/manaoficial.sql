GRANT ALL PRIVILEGES ON mana.* TO administrador IDENTIFIED BY 'lupf2024';

GRANT SELECT ON mana.* TO funcionario IDENTIFIED BY "funcionario2024";
GRANT INSERT ON mana.* TO funcionario;
GRANT UPDATE ON mana.* TO funcionario;
GRANT DELETE ON mana.* TO funcionario;


CREATE DATABASE mana;

USE mana;

CREATE TABLE cliente (`ID_cliente` INT AUTO_INCREMENT PRIMARY KEY, `cedula` INT(9), `nombre` VARCHAR(35), `deuda` INT(6) DEFAULT '0' , `fecha_de_nacimiento` DATE , `tickets_de_sorteo` INT DEFAULT '0',`contacto` INT(12) );

CREATE TABLE categoria (`id_categoria` INT  AUTO_INCREMENT PRIMARY KEY  , `titulo` VARCHAR(20), `descripcion` INT(40));

CREATE TABLE iva (`id_iva` INT  AUTO_INCREMENT PRIMARY KEY  , `tipo` VARCHAR(20), `valor` INT(5));

CREATE TABLE producto (`ID_producto` INT PRIMARY KEY AUTO_INCREMENT, `nombre` VARCHAR(20), `codigo_de_barras` INT(20), `descripcion` VARCHAR (30), `marca` VARCHAR(20), `cantidad` INT, `id_categoria` INT,`id_iva` INT, FOREIGN KEY (`id_categoria`) REFERENCES categoria (`id_categoria`),FOREIGN KEY (`id_iva`) REFERENCES iva (`id_iva`));

CREATE TABLE proveedor ( `id_proveedor` INT AUTO_INCREMENT PRIMARY KEY, `razon_social` VARCHAR(20), `RUT` INT(20), `telefono` INT(14));

CREATE TABLE venta ( `id_venta` INT AUTO_INCREMENT PRIMARY KEY, `precio_final` INT(10), `fecha_venta` DATE, `id_cliente` INT,FOREIGN KEY(`id_cliente`) REFERENCES cliente (`id_cliente`));

CREATE TABLE compra ( `id_compra` INT AUTO_INCREMENT PRIMARY KEY, `precio_final` INT(10), `fecha_compra` DATE, `id_proveedor` INT,FOREIGN KEY(`id_proveedor`) REFERENCES proveedor (`id_proveedor`));

CREATE TABLE sorteo ( `id_sorteo` INT AUTO_INCREMENT PRIMARY KEY, `premio` VARCHAR(30), `fecha_limite` DATE, `id_cliente_ganador` INT,FOREIGN KEY(`id_cliente_ganador`) REFERENCES cliente (`id_cliente`));

CREATE TABLE usuario (`usuario` VARCHAR(20) PRIMARY KEY  , `contraseña` VARCHAR(50), `correo` VARCHAR(30),`nombre` VARCHAR(20));

CREATE TABLE compra_de_productos ( `id_compra` INT,`id_producto` INT ,`cantidad_de_compra` INT(5),FOREIGN KEY(`id_compra`) REFERENCES compra (`id_compra`),FOREIGN KEY(`id_producto`) REFERENCES producto(`id_producto`));

CREATE TABLE venta_de_productos ( `id_venta` INT,`id_producto` INT ,`cantidad_de_venta` INT(5),FOREIGN KEY(`id_venta`) REFERENCES venta (`id_venta`),FOREIGN KEY(`id_producto`) REFERENCES producto(`id_producto`));