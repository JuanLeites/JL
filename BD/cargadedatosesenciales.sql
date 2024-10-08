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


INSERT INTO Categoría (Título, Descripción) VALUES
('Bebidas', 'Todo tipo de bebidas, desde refrescos hasta jugos y agua mineral.'),
('Snacks', 'Botanas saladas y dulces, como papas fritas, galletas y nueces.'),
('Confites', 'Caramelos, chocolates y golosinas diversas.'),
('Lácteos', 'Productos lácteos como leche, yogur y quesos.'),
('Panadería', 'Productos de panadería, incluyendo panes y pasteles.'),
('Comestibles', 'Alimentos enlatados, envasados y otros comestibles no perecederos.'),
('Helados', 'Variedades de helados y postres congelados.'),
('Cigarrillos', 'Diferentes marcas y tipos de cigarrillos.'),
('Revistas', 'Revistas de distintos géneros, incluyendo entretenimiento, deportes y moda.'),
('Papelería', 'Artículos de papelería como cuadernos, bolígrafos y lápices.'),
('Higiene', 'Productos de higiene personal, como jabones y champús.'),
('Baterías', 'Baterías para distintos dispositivos, desde controles remotos hasta cámaras.'),
('Comida rápida', 'Productos listos para consumir, como hamburguesas y empanadas.'),
('Sándwiches', 'Sándwiches variados, preparados en el momento.'),
('Alimentos orgánicos', 'Productos alimenticios orgánicos y naturales.'),
('Bebidas energéticas', 'Bebidas con altos niveles de cafeína y otros energizantes.'),
('Productos para mascotas', 'Alimentos y accesorios para mascotas.'),
('Cuidado del hogar', 'Productos para la limpieza y mantenimiento del hogar.'),
('Bebidas alcohólicas', 'Cervezas, vinos y otras bebidas alcohólicas.'),
('Juguetes', 'Juguetes para niños de todas las edades.'),
('Acondicionadores y cremas', 'Productos para el cuidado del cabello y la piel.'),
('Cereales', 'Cereales y productos relacionados para el desayuno.'),
('Condimentos', 'Especias, salsas y otros condimentos para cocinar.'),
('Pan integral', 'Pan y productos de pan integral y saludables.'),
('Productos sin gluten', 'Alimentos y productos libres de gluten.'),
('Vitaminas y suplementos', 'Suplementos vitamínicos y nutricionales.'),
('Ropa y accesorios', 'Ropa básica y accesorios como gorros y guantes.'),
('Bebidas sin alcohol', 'Alternativas sin alcohol como sodas y tés.'),
('Productos gourmet', 'Productos alimenticios de alta gama y especialidades.'),
('Artículos de fiesta', 'Decoraciones y suministros para fiestas y eventos.'),
('Productos de estación', 'Artículos estacionales como regalos navideños o útiles para el verano.'),
('Cuidado bucal', 'Pastas dentales, enjuagues bucales y cepillos de dientes.'),
('Cuidado de bebés', 'Productos para el cuidado de bebés, como pañales y fórmulas.'),
('Libros', 'Libros de distintos géneros y temáticas.'),
('Accesorios tecnológicos', 'Auriculares, cables y otros accesorios electrónicos.'),
('Equipos deportivos', 'Artículos básicos para practicar deportes, como pelotas y raquetas.');


INSERT INTO IVA (Tipo, Valor) VALUES
('Exento', 0.00),
('Tasa Básica', 22.00),
('Tasa Reducida', 10.00);

INSERT INTO Configuración (Precio_por_Tickets,Clave_Maestra) VALUES
('200','JL2024');
