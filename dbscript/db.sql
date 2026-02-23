create database dbinventory;
use dbinventory;

create table tconfiguracion
(
codigoConfiguracion char(13) not null,
tituloSistema varchar(700) not null,
extensionLogoSistema varchar(10) not null,
created_at datetime not null,
updated_at datetime not null,
primary key(codigoConfiguracion)
) engine=innodb;

create table tusuario
(
codigoUsuario char(13) not null,
dni char(8) not null,
nombre varchar (70) not null,
apellido varchar(40) not null,
correoElectronico varchar(700) not null,
contrasenia text not null,
rol varchar(700) not null,/*Súper usuario,Administrador,Usuario normal*/
estado varchar(20) not null,/*Pendiente, Activo, Bloqueado*/
created_at datetime not null,
updated_at datetime not null,
primary key(codigoUsuario)
) engine=innodb;

create table toficina
(
codigoOficina char(13) not null,
nombre varchar(700) not null,
created_at datetime not null,
updated_at datetime not null,
primary key(codigoOficina)
) engine=innodb;

create table tusuariotoficina
(
codigoUsuarioTOficina char(15) not null,
codigoUsuario char(15) not null,
codigoOficina char(15) not null,/*oficinas a las que tiene acceso*/
created_at datetime not null,
updated_at datetime not null,
foreign key(codigoUsuario) references tusuario(codigoUsuario)
on update cascade on delete cascade,
foreign key(codigoOficina) references toficina(codigoOficina)
on update cascade on delete cascade,
primary key(codigoUsuarioTOficina)
) engine=innodb;

create table texcepcion
(
codigoExcepcion char(13) not null,
codigoUsuario char(13) null,
controlador varchar(70) not null,
accion varchar(70) not null,
error text not null,
estado varchar(20) not null,/*Pendiente, Atendido*/
created_at datetime not null,
updated_at datetime not null,
foreign key(codigoUsuario) references tusuario(codigoUsuario)
on delete cascade on update cascade,
primary key(codigoExcepcion)
) engine=innodb;

create table tprovincia
(
codigoProvincia char(13) not null,
codigo char(2) not null,
nombre varchar(70) not null,
created_at datetime not null,
updated_at datetime not null,
primary key(codigoProvincia)
) engine=innodb;

create table tdistrito
(
codigoDistrito char(13) not null,
codigoProvincia char(13) not null,
codigo char(2) not null,
nombre varchar(70) not null,
created_at datetime not null,
updated_at datetime not null,
foreign key(codigoProvincia) references tprovincia(codigoProvincia)
on delete cascade on update cascade,
primary key(codigoDistrito)
) engine=innodb;

create table tlocal
(
codigoLocal char(13) not null,
codigoDistrito char(13) not null,
nombre varchar(700) not null,
direccion varchar(700) not null,
created_at datetime not null,
updated_at datetime not null,
foreign key(codigoDistrito) references tdistrito(codigoDistrito)
on delete cascade on update cascade,
primary key(codigoLocal)
) engine=innodb;

create table tdependencia
(
codigoDependencia char(13) not null,
codigoLocal char(13) not null,
nombre varchar(700) not null,
created_at datetime not null,
updated_at datetime not null,
foreign key(codigoLocal) references tlocal(codigoLocal)
on delete cascade on update cascade,
primary key(codigoDependencia)
) engine=innodb;

create table tarea
(
codigoArea char(13) not null,
nombre varchar(700) not null,
created_at datetime not null,
updated_at datetime not null,
primary key(codigoArea)
) engine=innodb;

create table tcargo
(
codigoCargo char(13) not null,
nombre varchar(700) not null,
created_at datetime not null,
updated_at datetime not null,
primary key(codigoCargo)
) engine=innodb;

create table tsituacion
(
codigoSituacion char(13) not null,
nombre varchar(70) not null,
created_at datetime not null,
updated_at datetime not null,
primary key(codigoSituacion)
) engine=innodb;

create table tpersonal
(
codigoPersonal char(13) not null,
codigoDependencia char(13) not null,
codigoArea char(13) not null,
codigoCargo char(13) not null,
codigoSituacion char(13) not null,
dni char(8) not null,
nombre varchar(70) not null,
apellido varchar(40) not null,
correoElectronico varchar(700) not null,
celular varchar(20) not null,
created_at datetime not null,
updated_at datetime not null,
foreign key(codigoDependencia) references tdependencia(codigoDependencia)
on delete cascade on update cascade,
foreign key(codigoArea) references tarea(codigoArea)
on delete cascade on update cascade,
foreign key(codigoCargo) references tcargo(codigoCargo)
on delete cascade on update cascade,
foreign key(codigoSituacion) references tsituacion(codigoSituacion)
on delete cascade on update cascade,
primary key(codigoPersonal)
) engine=innodb;

create table tbien
(
codigoBien char(13) not null,
descripcion varchar(700) not null,
codigoPatrimonial varchar(70) not null,
codigoInterno varchar(70) not null,
codigoM varchar(70) not null,
serie varchar(100) not null,
marca varchar(70) not null,
modelo varchar(70) not null,
tipo varchar(100) not null,
color varchar(70) not null,
observacion varchar(700) not null,
estado varchar(20) not null,/*Bueno, Regular, Malo, Inservible, Desechado, Perdido*/
created_at datetime not null,
updated_at datetime not null,
primary key(codigoBien)
) engine=innodb;

create table tasignacion
(
codigoAsignacion char(13) not null,
codigoUsuario char(13) not null,
codigoPersonal char(13) not null,
descripcion varchar(700) not null,
observacion varchar(700) not null,
created_at datetime not null,
updated_at datetime not null,
foreign key(codigoUsuario) references tusuario(codigoUsuario)
on delete cascade on update cascade,
foreign key(codigoPersonal) references tpersonal(codigoPersonal)
on delete cascade on update cascade,
primary key(codigoAsignacion)
) engine=innodb;

create table tasignaciondetalle
(
codigoAsignacionDetalle char(13) not null,
codigoAsignacion char(13) not null,
codigoBien char(13) not null,
codigoUsuario char(13) null,/*Usuario que aplica la devolución*/
colorBien varchar(70) not null,
estadoBien varchar(20) not null,
posesion boolean not null,
fechaAsignacion datetime not null,
fechaDevolucion datetime null,
observacion varchar(700) not null,
created_at datetime not null,
updated_at datetime not null,
foreign key(codigoAsignacion) references tasignacion(codigoAsignacion)
on delete cascade on update cascade,
foreign key(codigoBien) references tbien(codigoBien)
on delete cascade on update cascade,
foreign key(codigoUsuario) references tusuario(codigoUsuario)
on delete cascade on update cascade,
primary key(codigoAsignacionDetalle)
) engine=innodb;