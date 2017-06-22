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
