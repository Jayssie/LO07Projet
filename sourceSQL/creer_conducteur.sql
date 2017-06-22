create table conducteur (
    user_id INTEGER NOT NULL,
    nom varchar(20) NOT NULL,
    prenom varchar(20) NOT NULL,
    sexe varchar(10) NOT NULL,
    email varchar(30) NOT NULL,
    annee_de_naissance INTEGER NOT NULL,
    PRIMARY KEY(user_id)
);

