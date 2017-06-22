create table reservation (
    r_id INTEGER NOT NULL AUTO_INCREMENT,
    trajet_id integer not null,
    passager_id integer not null,
    nb_passager integer not null,
    conducteur_id integer not null,
    status varchar(30) not null,
    PRIMARY KEY(r_id)
);
