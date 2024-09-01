DROP TABLE IF EXISTS Payment;
DROP TABLE IF EXISTS Reservation;
DROP TABLE IF EXISTS Room;
DROP TABLE IF EXISTS Customer;

-- Tables
-- Table: Customer
CREATE TABLE Customer (
    customer_id int NOT NULL AUTO_INCREMENT,
    first_name varchar(255) NOT NULL,
    last_name varchar(255) NOT NULL,
    login_email varchar(255) NOT NULL,
    login_password varchar(255) NOT NULL,
    phone_number varchar(255) NOT NULL,
    CONSTRAINT unique_email UNIQUE (login_email),
    CONSTRAINT Customer_PK PRIMARY KEY (customer_id)
);

-- Table: Room
CREATE TABLE Room (
    room_id int NOT NULL AUTO_INCREMENT,
    room_type varchar(255) NOT NULL,
    low_price_per_night float NOT NULL,
    high_price_per_night float NOT NULL,
    max_guests int NOT NULL,
    CONSTRAINT Room_PK PRIMARY KEY (room_id)
);

-- Table: Reservation
CREATE TABLE Reservation (
    reservation_id int NOT NULL AUTO_INCREMENT,
    customer_id int NOT NULL,
    room_id int NOT NULL,
    check_in_date DATE NOT NULL,
    check_out_date DATE NOT NULL,
    num_guests int NOT NULL,
    reservation_status varchar(255),
    CONSTRAINT Reservation_PK PRIMARY KEY (reservation_id),
    CONSTRAINT Customer_FK FOREIGN KEY (customer_id) REFERENCES Customer (customer_id),
    CONSTRAINT Room_FK FOREIGN KEY (room_id) REFERENCES Room (room_id)
);

-- Table: Payment
CREATE TABLE Payment (
    payment_id int NOT NULL AUTO_INCREMENT,
    reservation_id int NOT NULL,
    amount_paid float,
    payment_date DATE,
    payment_status varchar(255),
    CONSTRAINT Payment_PK PRIMARY KEY (payment_id),
    CONSTRAINT Reservation_FK FOREIGN KEY (reservation_id) REFERENCES Reservation (reservation_id)
);

-- populating data
-- rooms
INSERT INTO Room VALUES (1, "Double Full", 115.00, 150.00, 5);
INSERT INTO Room VALUES (2, "Queen", 115.00, 150.00, 3);
INSERT INTO Room VALUES (3, "Double Queen", 115.00, 150.00, 5);
INSERT INTO Room VALUES (4, "King", 115.00, 150.00, 3);
-- customers
INSERT INTO Customer VALUES (NULL, "Debbie", "Reynolds", "dreynolds@gmail.com", "b829676fa652dc43f086bc6b62c8d0cc87eaeaa258fa4fa1a76417e4e1d6ae30", "6052734567");
INSERT INTO Customer VALUES (NULL, "Jesse", "Pinkman", "breaknbad@gmail.com", "32e4b9a5a802d56666f94d345524c5a9cb97a3ddc45c7bf087430d443dc998b4", "8005556624");
INSERT INTO Customer VALUES (NULL, "Walter", "White", "chemprof24@gmail.com", "401c02267ca12cd99003dddb95aa7f915b66920a249f72be41ddf87cba76a97c", "7554668877");
INSERT INTO Customer VALUES (NULL, "Miss", "Information", "missinfodesk@gmail.com", "db988b66a9e7958850a07dd8a3f280d869f34e32187dc1bd0b890e12af172714", "4062213565");
-- reservations
INSERT INTO Reservation VALUES (NULL, 1, 4, '2025-01-24', '2025-01-28', 2, "Confirmed");
INSERT INTO Reservation VALUES (NULL, 2, 2, '2025-02-05', '2025-02-12', 2, "Confirmed");
INSERT INTO Reservation VALUES (NULL, 3, 1, '2025-01-20', '2025-01-23', 4, "Confirmed");
INSERT INTO Reservation VALUES (NULL, 4, 3, '2025-01-27', '2025-02-01', 4, "Confirmed");
-- payments
INSERT INTO Payment VALUES (NULL, 1, 460.00, '2024-09-01', "Complete");
INSERT INTO Payment VALUES (NULL, 2, 805.00, '2024-08-25', "Pending");
INSERT INTO Payment VALUES (NULL, 3, 450.00, '2024-08-16', "Complete");
INSERT INTO Payment VALUES (NULL, 4, 750.00, '2024-08-05', "Complete");


