Create table messagerie(
    m_id integer AUTO_INCREMENT,
    send_id integer NOT NULL,
    receive_id integer NOT NULL,
    message varchar(400) NOT NULL,
    time varchar(30) NOT NULL,
    PRIMARY KEY(m_id)
);
