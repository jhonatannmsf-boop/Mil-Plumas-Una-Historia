CREATE TABLE genero (
id_genero INT AUTO_INCREMENT PRIMARY KEY,
nombre VARCHAR(20) NOT NULL
);

CREATE TABLE participacion(
id_participacion INT AUTO_INCREMENT PRIMARY KEY,
id_usuario INT,
FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
id_historia INT,
FOREIGN KEY (id_historia) REFERENCES historia(id_historia)
fecha_union DATE NOT NULL
);

CREATE TABLE historia(
id_historia INT AUTO_INCREMENT PRIMARY KEY,
titulo VARCHAR(20) NOT NULL,
descripcion VARCHAR(300) NOT NULL,
id_genero INT, 
FOREIGN KEY (id_genero) REFERENCES genero (id_genero)
tiempo_turno TIME(00:30:00), 
limite_palabra VARCHAR(300), 
fecha_creacion TIME,
estado BOOLEAN,
ia_resumen VARCHAR(200) NOT NULL
);

CREATE TABLE capitulo(
id_capitulo INT AUTO_INCREMENT PRIMARY KEY,
id_historia INT,
FOREIGN KEY (id_historia) REFERENCES historia(id_historia)
id_usuario INT,
FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
numero_turno INT AUTO_INCREMENT NOT NULL,
fecha_publicacion NOT NULL
); 

CREATE TABLE usuario(
id_usuario INT AUTO_INCREMENT PRIMARY KEY,
nombre VARCHAR(20) NOT NULL,
correo VARCHAR(50) NOT NULL,
contraseña VARCHAR(40) NOT NULL,
me_gusta BOOLEAN 
);
