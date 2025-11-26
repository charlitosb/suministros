-- =====================================================
-- BASE DE DATOS: SISTEMA DE SUMINISTROS
-- Autor: Carlos Barrios 202408075
-- Programación WEB
-- =====================================================

-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS suministros_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE suministros_db;

-- =====================================================
-- TABLAS INDEPENDIENTES (Sin FK)
-- =====================================================

-- Tabla: usuarios
CREATE TABLE usuarios (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(100) NOT NULL UNIQUE,
    nombre VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabla: marcas
CREATE TABLE marcas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    descripcion VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabla: categorias
CREATE TABLE categorias (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre_categoria VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabla: tipos_equipo
CREATE TABLE tipos_equipo (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    descripcion VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =====================================================
-- TABLAS CON DEPENDENCIAS (Con FK)
-- =====================================================

-- Tabla: equipos (depende de tipos_equipo)
CREATE TABLE equipos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    numero_serie VARCHAR(100) NOT NULL UNIQUE,
    descripcion VARCHAR(255) NOT NULL,
    id_tipo BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_equipos_tipo FOREIGN KEY (id_tipo) 
        REFERENCES tipos_equipo(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Tabla: suministros (depende de marcas, categorias, tipos_equipo)
CREATE TABLE suministros (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    descripcion VARCHAR(255) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    id_marca BIGINT UNSIGNED NOT NULL,
    id_categoria BIGINT UNSIGNED NOT NULL,
    id_tipo_equipo BIGINT UNSIGNED NOT NULL,
    stock INT UNSIGNED NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_suministros_marca FOREIGN KEY (id_marca) 
        REFERENCES marcas(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_suministros_categoria FOREIGN KEY (id_categoria) 
        REFERENCES categorias(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_suministros_tipo_equipo FOREIGN KEY (id_tipo_equipo) 
        REFERENCES tipos_equipo(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Tabla: ingresos_suministro (depende de suministros)
CREATE TABLE ingresos_suministro (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_suministro BIGINT UNSIGNED NOT NULL,
    fecha_ingreso DATE NOT NULL,
    cantidad INT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_ingresos_suministro FOREIGN KEY (id_suministro) 
        REFERENCES suministros(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Tabla: instalaciones_suministro (depende de suministros y equipos)
CREATE TABLE instalaciones_suministro (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fecha_instalacion DATE NOT NULL,
    id_suministro BIGINT UNSIGNED NOT NULL,
    id_equipo BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_instalaciones_suministro FOREIGN KEY (id_suministro) 
        REFERENCES suministros(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_instalaciones_equipo FOREIGN KEY (id_equipo) 
        REFERENCES equipos(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- ÍNDICES ADICIONALES PARA OPTIMIZACIÓN
-- =====================================================
CREATE INDEX idx_suministros_stock ON suministros(stock);
CREATE INDEX idx_ingresos_fecha ON ingresos_suministro(fecha_ingreso);
CREATE INDEX idx_instalaciones_fecha ON instalaciones_suministro(fecha_instalacion);

-- =====================================================
-- DATOS DE PRUEBA (5 registros por tabla)
-- =====================================================

-- Usuarios (password: "password" - hash bcrypt)
-- El hash corresponde a 'password' generado con bcrypt
INSERT INTO usuarios (usuario, nombre, password) VALUES
('admin', 'Administrador del Sistema', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('carlos', 'Carlos Barrios', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('maria', 'María García', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('juan', 'Juan Pérez', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('ana', 'Ana López', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Marcas
INSERT INTO marcas (descripcion) VALUES
('HP'),
('Epson'),
('Logitech'),
('Dell'),
('Canon');

-- Categorías
INSERT INTO categorias (nombre_categoria) VALUES
('Toner'),
('Mouse'),
('Teclado'),
('Cartucho de Tinta'),
('Cable USB');

-- Tipos de Equipo
INSERT INTO tipos_equipo (descripcion) VALUES
('Laptop'),
('PC de Escritorio'),
('Impresora'),
('Monitor'),
('Scanner');

-- Equipos
INSERT INTO equipos (numero_serie, descripcion, id_tipo) VALUES
('LAP-HP-2024-001', 'Laptop HP ProBook 450 G8', 1),
('PC-DELL-2024-001', 'PC Dell OptiPlex 7090', 2),
('IMP-EPS-2024-001', 'Impresora Epson L3250', 3),
('MON-DELL-2024-001', 'Monitor Dell 24 pulgadas', 4),
('LAP-DELL-2024-002', 'Laptop Dell Latitude 5520', 1);

-- Suministros (stock inicia en 0)
INSERT INTO suministros (descripcion, precio, id_marca, id_categoria, id_tipo_equipo, stock) VALUES
('Toner HP 107A Negro', 450.00, 1, 1, 3, 0),
('Mouse Logitech M185 Inalámbrico', 125.00, 3, 2, 2, 0),
('Teclado Logitech K120 USB', 95.00, 3, 3, 2, 0),
('Cartucho Epson T544 Negro', 85.00, 2, 4, 3, 0),
('Toner Canon 121 Negro', 520.00, 5, 1, 3, 0);

-- Ingresos de Suministro (estos aumentarán el stock)
INSERT INTO ingresos_suministro (id_suministro, fecha_ingreso, cantidad) VALUES
(1, '2024-01-15', 10),
(2, '2024-01-20', 15),
(3, '2024-02-01', 20),
(4, '2024-02-10', 25),
(5, '2024-02-15', 8);

-- Actualizar stock después de los ingresos
UPDATE suministros SET stock = 10 WHERE id = 1;
UPDATE suministros SET stock = 15 WHERE id = 2;
UPDATE suministros SET stock = 20 WHERE id = 3;
UPDATE suministros SET stock = 25 WHERE id = 4;
UPDATE suministros SET stock = 8 WHERE id = 5;

-- Instalaciones de Suministro (estas reducirán el stock)
INSERT INTO instalaciones_suministro (fecha_instalacion, id_suministro, id_equipo) VALUES
('2024-01-25', 1, 3),
('2024-01-28', 2, 2),
('2024-02-05', 3, 2),
('2024-02-12', 4, 3),
('2024-02-20', 2, 5);

-- Actualizar stock después de las instalaciones
UPDATE suministros SET stock = stock - 1 WHERE id = 1;
UPDATE suministros SET stock = stock - 1 WHERE id = 2;
UPDATE suministros SET stock = stock - 1 WHERE id = 3;
UPDATE suministros SET stock = stock - 1 WHERE id = 4;
UPDATE suministros SET stock = stock - 1 WHERE id = 2;

-- =====================================================
-- VERIFICACIÓN DE DATOS
-- =====================================================
SELECT 'RESUMEN DE TABLAS' as info;
SELECT 'Usuarios:' as tabla, COUNT(*) as registros FROM usuarios
UNION ALL SELECT 'Marcas:', COUNT(*) FROM marcas
UNION ALL SELECT 'Categorías:', COUNT(*) FROM categorias
UNION ALL SELECT 'Tipos Equipo:', COUNT(*) FROM tipos_equipo
UNION ALL SELECT 'Equipos:', COUNT(*) FROM equipos
UNION ALL SELECT 'Suministros:', COUNT(*) FROM suministros
UNION ALL SELECT 'Ingresos:', COUNT(*) FROM ingresos_suministro
UNION ALL SELECT 'Instalaciones:', COUNT(*) FROM instalaciones_suministro;

-- Ver stock actual
SELECT 'STOCK ACTUAL DE SUMINISTROS' as info;
SELECT s.id, s.descripcion, m.descripcion as marca, c.nombre_categoria as categoria, s.stock
FROM suministros s
JOIN marcas m ON s.id_marca = m.id
JOIN categorias c ON s.id_categoria = c.id;
