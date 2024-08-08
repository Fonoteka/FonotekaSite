create database db_fonoteka;
use db_fonoteka;

create table tb_cadastroMentor(
IdMentor int auto_increment primary key,
Nome varchar (50),
Email varchar (150),
Telefone varchar (15),
Senha varchar (255),
Usuario varchar (50),
DataNascimento date,
Genero varchar (20)
);

create table tb_cadastroAluno(
IdAluno int auto_increment primary key,
Nome varchar (100),
Usuario varchar (100),
Email varchar (100),
Genero varchar (20),
IdMentor int,
FOREIGN KEY (IdMentor) REFERENCES tb_cadastroMentor(IdMentor)
);

create table tb_atividades(
	idAtividade int auto_increment primary key,
    nomeAtividade varchar (60) not null,
    IdMentor int not null,
    dataPostagem date not null,
    dataEntrega datetime not null,
    IdAluno int not null,
    FOREIGN KEY (IdAluno) REFERENCES tb_cadastroAluno(IdAluno),
    FOREIGN KEY (IdMentor) REFERENCES tb_cadastroMentor(IdMentor)
);

create table tb_guias(
	idGuia int auto_increment primary key,
    nomeGuia varchar (80) not null,
    descricao varchar(80) not null,
    nomeArquivo varchar (255) not null,
    nomeAutor varchar (100) not null,
    dataPostagem date not null
);

create table tb_imagens(
  `idGuia` int(11) NOT NULL,
  `nomeImagem` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `data_upload` datetime NOT NULL DEFAULT current_timestamp()
);

insert into tb_guias
(nomeGuia, descricao, nomeArquivo, nomeAutor, dataPostagem)
values
('TEA', 'GUIA SOBRE TEA', 'EDEDDE.JPG', 'RUAN', '2001-02-02'),
('LUCAS', 'LINDO', 'TESTE.JPG', 'RAFAEL', '2001-02-02');

truncate tb_guias;

SELECT * FROM tb_guias;
SELECT * FROM tb_cadastroMentor;