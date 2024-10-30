-- USER TABLE
CREATE TABLE users(
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(60) NOT NULL,
    lastname VARCHAR(60) NOT NULL,
    email VARCHAR(40) NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(10) NOT NULL UNIQUE,
    admin BOOLEAN DEFAULT FALSE,
    verified BOOLEAN DEFAULT FALSE,
    token VARCHAR(30),
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

DESCRIBE users;
INSERT INTO users(name, lastname, email, phone) VALUES ("diego", "perez", "dfperez2001@gmail.com", "3222204468");
INSERT INTO users(name, lastname, email, phone) VALUES ("toni", "baron", "soytoni@gmail.com", "3232874467");
-- SERVICE TABLE
CREATE TABLE services(
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(60) NOT NULL,
    price DECIMAL(5,2),
    PRIMARY KEY (id)
);
-- DECIMAL (5,1). 5: THE TOTAL MAX NUMBER OF DIGITS, 2: FOR PRECISSION AFTER THE DECIMAL POINT.
INSERT INTO `services` (`nombre`, `precio`) VALUES
( 'Corte de Cabello Mujer', 90.00),
( 'Corte de Cabello Hombre', 80.00),
( 'Corte de Cabello Niño', 60.00),
( 'Peinado Mujer', 80.00),
( 'Peinado Hombre', 60.00),
( 'Peinado Niño', 60.00),
( 'Tinte Mujer', 300.00),
( 'Uñas', 400.00),
( 'Lavado de Cabello', 50.00),
( 'Tratamiento Capilar', 150.00);

-- APPONTMENT TABLE
CREATE TABLE appointments(
    id INT NOT NULL AUTO_INCREMENT,
    date DATE NOT NULL,
    hour TIME NOT NULL,
    PRIMARY KEY (id),
    userId INT NOT NULL,
    KEY userId(userId),
    CONSTRAINT userId FOREIGN KEY(userId) REFERENCES users(id)
);

ALTER TABLE appointments DROP FOREIGN KEY `userId`;
ALTER TABLE appointments ADD FOREIGN KEY (`userId`) REFERENCES users(`id`) ON UPDATE CASCADE ON DELETE CASCADE;


INSERT INTO appointments(date, hour, userId) VALUES ("2024-11-06", "09:10:00", 1 );
INSERT INTO appointments(date, hour, userId) VALUES ("2024-11-09", "07:15:00", 2 );

-- APPOINTMENTS-SERVICES TABLE
CREATE TABLE appointments_services(
    id INT NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (id),
    appointmentId INT NOT NULL,
    serviceId INT NOT NULL,
    KEY appointmentId(appointmentId),
    KEY serviceId(serviceId),
    CONSTRAINT appointment_fk FOREIGN KEY (appointmentId) REFERENCES appointments(id),
    CONSTRAINT service_fk FOREIGN KEY (serviceId) REFERENCES services(id) 
);
DESCRIBE appointments_services;
INSERT INTO appointments_services(appointmentId, serviceId) VALUES (2, 1);
INSERT INTO appointments_services(appointmentId, serviceId) VALUES (2, 2);
INSERT INTO appointments_services(appointmentId, serviceId) VALUES (4, 2);
