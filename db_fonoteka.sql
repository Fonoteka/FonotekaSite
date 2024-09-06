create database db_fonoteka;
use db_fonoteka;

create table tb_imagens(
  `IdImagem` int(11) auto_increment not null,
  `nomeImagem` varchar(255) not null,
  `path` varchar(255) not null,
  PRIMARY KEY (IdImagem)
);

create table tb_cadastro(
IdMentor int auto_increment primary key,
Nome varchar (50) not null,
Email varchar (150) not null,
Telefone varchar (15) not null,
Senha varchar (255) not null,
Usuario varchar (50) not null,
DataNascimento date not null,
Genero varchar (20) not null,
Funcao boolean not null,
IdImagem int,
recuperarSenha varchar(220),
FOREIGN KEY (IdImagem) REFERENCES tb_imagens (IdImagem)
);

create table tb_cadastroAluno(
IdAluno int auto_increment primary key,
Nome varchar (100),
Usuario varchar (100),
Email varchar (100),
Genero varchar (20),
IdMentor int,
FOREIGN KEY (IdMentor) REFERENCES tb_cadastro(IdMentor)
);


create table tb_atividades(
idAtividade int auto_increment primary key,
nomeAtividade varchar (60) not null,
IdMentor int not null,
dataPostagem date not null,
dataEntrega datetime not null,
IdAluno int not null,
FOREIGN KEY (IdAluno) REFERENCES tb_cadastroAluno(IdAluno),
FOREIGN KEY (IdMentor) REFERENCES tb_cadastro(IdMentor)
);

create table tb_guias(
idGuia int auto_increment primary key,
nomeGuia varchar (80) not null,
descricao varchar(80) not null,
nomeArquivo varchar (255),
nomeAutor varchar (100) not null,
dataPostagem date default (CURRENT_DATE),
IdImagem int not null,
FOREIGN KEY (IdImagem) REFERENCES tb_imagens(IdImagem)
);

insert into tb_cadastro
values
(1,'Lucas', 'Lucas@gmail.com', '12981438361', '$2y$10$HBlfDki6pAqpOHuKi0dkpOPrXaSlfieR04aY.rnA.lte4e9Mtg9CW','lucas', '2001-02-02', 'Homem', 1, null, null);

insert into tb_guias
(nomeGuia, descricao, nomeArquivo, nomeAutor, dataPostagem, IdImagem)
values
('TEA', 'GUIA SOBRE TEA', 'EDEDDE.JPG', 'RUAN', '2001-02-02', 1),
('LUCAS', 'LINDO', 'TESTE.JPG', 'RAFAEL', '2001-02-02', 2);

truncate tb_guias;
SET FOREIGN_KEY_CHECKS = 0; 
TRUNCATE table tb_Imagens;
SET FOREIGN_KEY_CHECKS = 1;

SELECT * FROM tb_guias;
SELECT * FROM tb_Imagens;
SELECT * FROM tb_cadastro;


truncate tb_cadastro;
describe tb_guias