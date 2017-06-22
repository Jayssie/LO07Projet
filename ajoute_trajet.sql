create table trajet (
    t_id integer not null auto_increment,
    choix_1 varchar(40) not null,
    depart varchar(20) not null,
    arrivee varchar(20) not null,   
    primary key(t_id)
);
