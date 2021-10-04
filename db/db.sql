CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    firstname VARCHAR(255),
    lastname VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    salt VARCHAR(255),
    enabled BIT(1)
);
INSERT INTO users (
        firstname,
        lastname,
        email,
        password,
        salt,
        enabled
    )
VALUES (
        'Dwight',
        'Chrute',
        'chrute@dundermifflin.com',
        'password',
        'salt',
        1
    );
