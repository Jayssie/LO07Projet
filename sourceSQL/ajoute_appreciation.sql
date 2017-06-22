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
