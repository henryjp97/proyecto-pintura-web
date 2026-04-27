CREATE DATABASE IF NOT EXISTS finishline_db;
USE finishline_db;

CREATE TABLE IF NOT EXISTS Autenticacion (
  id_autenticacion INT AUTO_INCREMENT PRIMARY KEY,
  password_hash VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS Usuario (
  id_usuario INT AUTO_INCREMENT PRIMARY KEY,
  id_autenticacion INT,
  Nombre VARCHAR(100) NOT NULL,
  Apellido VARCHAR(100) NOT NULL,
  Telefono VARCHAR(20),
  Correo VARCHAR(150) NOT NULL,
  Rol VARCHAR(50) DEFAULT 'cliente',
  FOREIGN KEY (id_autenticacion) REFERENCES Autenticacion(id_autenticacion)
);

CREATE TABLE IF NOT EXISTS Servicios (
  ID_servicio INT AUTO_INCREMENT PRIMARY KEY,
  Nombre VARCHAR(100) NOT NULL,
  Descripcion TEXT,
  disponible BOOLEAN DEFAULT TRUE,
  categoria_vehiculo VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS Ticket (
  id_ticket INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT,
  id_servicio INT,
  descripcion TEXT,
  matricula VARCHAR(20),
  fecha_inicio DATE,
  fecha_fin DATE,
  presupuesto DECIMAL(10,2),
  estado VARCHAR(50) DEFAULT 'pendiente',
  fecha_cita DATETIME,
  FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario),
  FOREIGN KEY (id_servicio) REFERENCES Servicios(ID_servicio)
);
CREATE TABLE IF NOT EXISTS Solicitudes (
    id_solicitud INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(150) NOT NULL,
    DNI VARCHAR(9) NOT NULL,
    asunto VARCHAR(100) NOT NULL,
    mensaje TEXT NOT NULL,
    fecha_envio DATETIME DEFAULT CURRENT_TIMESTAMP
);



CREATE TABLE IF NOT EXISTS password_reset (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT         NOT NULL,
  token      VARCHAR(64) NOT NULL UNIQUE,
  expira_en  DATETIME    NOT NULL,
  creado_en  DATETIME    DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario) ON DELETE CASCADE
);

INSERT INTO Servicios (Nombre, Descripcion, disponible, categoria_vehiculo) VALUES
('Pintura completa', 'Pintura de toda la carrocería', TRUE, 'Turismo'),
('Reparación de arañazos', 'Eliminación de arañazos superficiales', TRUE, 'Todos'),
('Pintura de paragolpes', 'Pintura y reparación de paragolpes', TRUE, 'Todos');

CREATE user admin IDENTIFIED BY "admin";

GRANT ALL ON finishline_db.* to admin;