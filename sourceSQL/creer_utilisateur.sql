create table utilisateur (
    id INTEGER NOT NULL AUTO_INCREMENT,
    login varchar(20) NOT NULL,
    mot_de_password varchar(30) NOT NULL,
    is_conducteur INTEGER NOT NULL,
    is_passager INTEGER NOT NULL,
    compte INTEGER DEFAULT 1000,
    PRIMARY KEY(id)
);
