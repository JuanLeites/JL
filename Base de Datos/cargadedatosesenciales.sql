USE mana;

INSERT INTO Medida (Unidad, Símbolo) VALUES
('Mililitro', 'ml'),
('Litro', 'L'),
('Gramo', 'g'),
('Kilogramo', 'kg'),
('Unidad', 'u'),
('Caja', 'cja'),
('Paquete', 'paq'),
('Botella', 'bot'),
('Lata', 'lat'),
('Metro', 'm'),
('Centímetro', 'cm'),
('Pieza', 'pz'),
('Botón', 'btn'),
('Rollo', 'rol'),
('Tarro', 'tar'),
('Sobre', 'sob');


INSERT INTO `Categoría` (`ID_CATEGORIA`, `Título`, `Descripción`) VALUES
(1, 'Bebidas', 'Todo tipo de bebidas, desde refrescos hasta jugos y agua mineral.'),
(2, 'Snacks', 'Botanas saladas y dulces, como papas fritas, galletas y nueces.'),
(3, 'Confites', 'Caramelos, chocolates y golosinas diversas.'),
(4, 'Lácteos', 'Productos lácteos como leche, yogur y quesos.'),
(5, 'Panadería', 'Productos de panadería, incluyendo panes y pasteles.'),
(6, 'Comestibles', 'Alimentos enlatados, envasados y otros comestibles no perecederos.'),
(7, 'Helados', 'Variedades de helados y postres congelados.'),
(8, 'Cigarrillos', 'Diferentes marcas y tipos de cigarrillos.'),
(9, 'Revistas', 'Revistas de distintos géneros, incluyendo entretenimiento, deportes y moda.'),
(10, 'Papelería', 'Artículos de papelería como cuadernos, bolígrafos y lápices.'),
(11, 'Higiene', 'Productos de higiene personal, como jabones y champús.'),
(12, 'Baterías', 'Baterías para distintos dispositivos, desde controles remotos hasta cámaras.'),
(13, 'Comida rápida', 'Productos listos para consumir, como hamburguesas y empanadas.'),
(14, 'Sándwiches', 'Sándwiches variados, preparados en el momento.'),
(15, 'Alimentos orgánicos', 'Productos alimenticios orgánicos y naturales.'),
(16, 'Bebidas energéticas', 'Bebidas con altos niveles de cafeína y otros energizantes.'),
(17, 'Productos para mascotas', 'Alimentos y accesorios para mascotas.'),
(18, 'Cuidado del hogar', 'Productos para la limpieza y mantenimiento del hogar.'),
(19, 'Bebidas alcohólicas', 'Cervezas, vinos y otras bebidas alcohólicas.'),
(20, 'Juguetes', 'Juguetes para niños de todas las edades.'),
(21, 'Acondicionadores y cremas', 'Productos para el cuidado del cabello y la piel.'),
(22, 'Cereales', 'Cereales y productos relacionados para el desayuno.'),
(23, 'Condimentos', 'Especias, salsas y otros condimentos para cocinar.'),
(24, 'Pan integral', 'Pan y productos de pan integral y saludables.'),
(25, 'Productos sin gluten', 'Alimentos y productos libres de gluten.'),
(26, 'Vitaminas y suplementos', 'Suplementos vitamínicos y nutricionales.'),
(27, 'Ropa y accesorios', 'Ropa básica y accesorios como gorros y guantes.'),
(28, 'Bebidas sin alcohol', 'Alternativas sin alcohol como sodas y tés.'),
(29, 'Productos gourmet', 'Productos alimenticios de alta gama y especialidades.'),
(30, 'Artículos de fiesta', 'Decoraciones y suministros para fiestas y eventos.'),
(31, 'Productos de estación', 'Artículos estacionales como regalos navideños o útiles para el verano.'),
(32, 'Cuidado bucal', 'Pastas dentales, enjuagues bucales y cepillos de dientes.'),
(33, 'Cuidado de bebés', 'Productos para el cuidado de bebés, como pañales y fórmulas.'),
(34, 'Libros', 'Libros de distintos géneros y temáticas.'),
(35, 'Accesorios tecnológicos', 'Auriculares, cables y otros accesorios electrónicos.'),
(36, 'Equipos deportivos', 'Artículos básicos para practicar deportes, como pelotas y raquetas.'),
(37, 'Sin Categoría','Sin Descripción');


    
INSERT INTO IVA (Tipo, Valor) VALUES
('Exento', 0.00),
('Tasa Básica', 22.00),
('Tasa Reducida', 10.00);

INSERT INTO Configuración (Precio_por_Tickets,Clave_Maestra,Color_Principal,Color_Secundario,Color_Fondo) VALUES
('200','JL2024','#4DBF38','#80D12A','#001F47');

INSERT INTO Usuario (Usuario,Contraseña,Nombre,Correo,Tipo_Usuario) VALUES ("usuarioadmin","$2y$10$zaKVdU1VwHFU8e1raW76yehs4LtpZ9HqgzSaUlQ9aJ6SAhnf3dV2a","Usuario Administrador","correousuarioadministrador@gmail.com","administrador");#--contraseña encriptada: usuarioadmin 