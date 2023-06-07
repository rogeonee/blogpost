CREATE TABLE users (
    userId int NOT NULL AUTO_INCREMENT,
    email varchar(255) NOT NULL,
    name varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    gender varchar(255),
    joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    PRIMARY KEY (userId)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO users (email, name, password, gender) VALUES ('vader@dark.force', 'darth vader', '12345', 'male');