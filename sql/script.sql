
CREATE TABLE usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) NOT NULL UNIQUE,
    nombre_completo VARCHAR(100) NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    biografia VARCHAR(255) DEFAULT 'Amante de las buenas historias',
    avatar VARCHAR(255) NULL,
    fecha_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE genero (
    id_genero INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE historia (
    id_historia INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    sinopsis TEXT NOT NULL,
    id_usuario_creador INT NOT NULL,
    id_genero_principal INT NULL,
    tiempo_horas_turno INT NOT NULL DEFAULT 3,       
    limite_palabras INT NOT NULL DEFAULT 300,          
    estado ENUM('activa', 'completada', 'pausada') NOT NULL DEFAULT 'activa',
    ia_resumen TEXT NULL,                              
    portada VARCHAR(255) NULL,
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_historia_creador FOREIGN KEY (id_usuario_creador) 
        REFERENCES usuario(id_usuario) ON DELETE CASCADE,
    CONSTRAINT fk_historia_genero FOREIGN KEY (id_genero_principal) 
        REFERENCES genero(id_genero) ON DELETE SET NULL
);


CREATE TABLE historia_genero (
    id_historia INT NOT NULL,
    id_genero INT NOT NULL,
    PRIMARY KEY (id_historia, id_genero),
    CONSTRAINT fk_hg_historia FOREIGN KEY (id_historia) 
        REFERENCES historia(id_historia) ON DELETE CASCADE,
    CONSTRAINT fk_hg_genero FOREIGN KEY (id_genero) 
        REFERENCES genero(id_genero) ON DELETE CASCADE
);

CREATE TABLE capitulo (
    id_capitulo INT AUTO_INCREMENT PRIMARY KEY,
    id_historia INT NOT NULL,
    id_usuario INT NOT NULL,
    numero_turno INT NOT NULL,                        
    contenido TEXT NOT NULL,                          
    cantidad_palabras INT NOT NULL DEFAULT 0,
    fecha_publicacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_capitulo_historia FOREIGN KEY (id_historia) 
        REFERENCES historia(id_historia) ON DELETE CASCADE,
    CONSTRAINT fk_capitulo_usuario FOREIGN KEY (id_usuario) 
        REFERENCES usuario(id_usuario) ON DELETE CASCADE,
    UNIQUE KEY uq_historia_turno (id_historia, numero_turno)
);

CREATE TABLE participacion (
    id_participacion INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_historia INT NOT NULL,
    orden_turno INT NOT NULL DEFAULT 1,               
    es_turno_actual BOOLEAN NOT NULL DEFAULT FALSE,   
    fecha_union DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_part_usuario FOREIGN KEY (id_usuario) 
        REFERENCES usuario(id_usuario) ON DELETE CASCADE,
    CONSTRAINT fk_part_historia FOREIGN KEY (id_historia) 
        REFERENCES historia(id_historia) ON DELETE CASCADE,
    UNIQUE KEY uq_usuario_historia (id_usuario, id_historia)
);


CREATE TABLE me_gusta (
    id_usuario INT NOT NULL,
    id_historia INT NOT NULL,
    fecha_like DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_usuario, id_historia),
    CONSTRAINT fk_like_usuario FOREIGN KEY (id_usuario) 
        REFERENCES usuario(id_usuario) ON DELETE CASCADE,
    CONSTRAINT fk_like_historia FOREIGN KEY (id_historia) 
        REFERENCES historia(id_historia) ON DELETE CASCADE
);

CREATE TABLE guardado (
    id_usuario INT NOT NULL,
    id_historia INT NOT NULL,
    fecha_guardado DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_usuario, id_historia),
    CONSTRAINT fk_guardado_usuario FOREIGN KEY (id_usuario) 
        REFERENCES usuario(id_usuario) ON DELETE CASCADE,
    CONSTRAINT fk_guardado_historia FOREIGN KEY (id_historia) 
        REFERENCES historia(id_historia) ON DELETE CASCADE
);
