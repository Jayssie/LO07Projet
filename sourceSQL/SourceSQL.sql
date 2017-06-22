Create table messagerie(
    m_id integer AUTO_INCREMENT,
    send_id integer NOT NULL,
    receive_id integer NOT NULL,
    message varchar(400) NOT NULL,
    time varchar(30) NOT NULL,
    PRIMARY KEY(m_id)
);
Create table appreciation(
    a_id integer AUTO_INCREMENT,
    trajet_id integer NOT NULL,
    passager_id integer NOT NULL,
    conducteur_id integer NOT NULL,
    appreciation varchar(400) NOT NULL,
    note integer NOT NULL,
    etat integer NOT NULL,
    PRIMARY KEY(a_id)
);
create table trajet (
    t_id integer not null auto_increment,
    user_id integer not null,
    choix_1 varchar(60) not null,
    ville_depart varchar(20) not null,
    ville_arrive varchar(20) not null,
    depart_date date not null,
    depart_time varchar(20) not null,
    nombre_place integer not null,
    prix integer not null,
    nb_passager integer not null,
    nb_place_reste integer not null,
    statut varchar(20) not null,
    primary key(t_id)
);
create table conducteur (
    user_id INTEGER NOT NULL,
    nom varchar(20) NOT NULL,
    prenom varchar(20) NOT NULL,
    sexe varchar(10) NOT NULL,
    email varchar(30) NOT NULL,
    annee_de_naissance INTEGER NOT NULL,
    PRIMARY KEY(user_id)
);
create table passager (
    user_id INTEGER NOT NULL,
    nom varchar(20) NOT NULL,
    prenom varchar(20) NOT NULL,
    sexe varchar(10) NOT NULL,
    email varchar(30) NOT NULL,
    annee_de_naissance INTEGER NOT NULL,
    PRIMARY KEY(user_id)
);
create table photo (
    id INTEGER NOT NULL AUTO_INCREMENT,
    user_id INTEGER NOT NULL,
    url varchar(20) NOT NULL,
    PRIMARY KEY(id)
);
create table reservation (
    r_id INTEGER NOT NULL AUTO_INCREMENT,
    trajet_id integer not null,
    passager_id integer not null,
    nb_passager integer not null,
    conducteur_id integer not null,
    status varchar(30) not null,
    PRIMARY KEY(r_id)
);
create table utilisateur (
    id INTEGER NOT NULL AUTO_INCREMENT,
    login varchar(20) NOT NULL,
    mot_de_password varchar(30) NOT NULL,
    is_conducteur INTEGER NOT NULL,
    is_passager INTEGER NOT NULL,
    compte INTEGER DEFAULT 1000,
    PRIMARY KEY(id)
);
create table vehicule (
    vehicule_id INTEGER NOT NULL AUTO_INCREMENT,
    proprietaire_id INTEGER NOT NULL,
    marque varchar(20) NOT NULL,
    modele varchar(20) NOT NULL,
    confort varchar(20) NOT NULL,
    nb_de_place INTEGER NOT NULL,
    couleur varchar(20) NOT NULL,
    anne_de_mise_en_service INTEGER NOT NULL,
    categorie varchar(20) NOT NULL,
    PRIMARY KEY(vehicule_id)
);
alter table trajet add constraint foreign key(user_id) references conducteur(user_id);
alter table messagerie add constraint foreign key(send_id) references utilisateur(id);
alter table messagerie add constraint foreign key(receive_id) references utilisateur(id);
alter table photo add constraint foreign key(user_id) references passager(user_id);
alter table vehicule add constraint foreign key(proprietaire_id) references conducteur(user_id);
alter table reservation add constraint foreign key(conducteur_id) references conducteur(user_id);
alter table reservation add constraint foreign key(passager_id) references passager(user_id);
alter table appreciation add constraint foreign key(passager_id) references passager(user_id);
alter table appreciation add constraint foreign key(conducteur_id) references conducteur(user_id);
alter table appreciation add constraint foreign key(trajet_id) references trajet(t_id);
alter table reservation add constraint foreign key(trajet_id) references trajet(t_id);