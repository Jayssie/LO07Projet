create table utilisateur (
    id INTEGER NOT NULL AUTO_INCREMENT,
    sexe varchar(5) NOT NULL,
    nom varchar(20) NOT NULL,
    prenom varchar(20) NOT NULL,
    email varchar(30) NOT NULL,
    mdp varchar(20) NOT NULL,
    annee INTEGER NOT NULL,
    PRIMARY KEY(id)
);
