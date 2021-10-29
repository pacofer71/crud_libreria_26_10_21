drop table if exists libros;
drop table if exists autores;

-- Tabla autores
create table autores(
    id int AUTO_INCREMENT primary key,
    nombre varchar(80) not null,
    apellidos varchar(100) not null,
    pais varchar(80) not null
);

-- Tabla libros
create table libros(
    id int AUTO_INCREMENT primary key,
    titulo varchar(100) not null,
    sinopsis text not null,
    isbn varchar(13) unique not null,
    autor_id int,
    constraint fk_libro_autor foreign key(autor_id) references autores(id)
     on delete cascade on update cascade

);