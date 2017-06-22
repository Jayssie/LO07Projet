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

