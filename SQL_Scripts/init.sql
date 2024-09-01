--Tables
--Table: Customer
CREATE TABLE Customer (
    customer_id int NOT NULL IDENTITY(1, 1),
    first_name varchar(255) NOT NULL,
    last_name varchar(255) NOT NULL,
    login_email varchar(255) NOT NULL,
    login_password varchar(255) NOT NULL,
    phone_number varchar(255) NOT NULL,
    CONSTRAINT unique_email UNIQUE (login_email),
    CONSTRAINT Customer_PK PRIMARY KEY (customer_id)
);

--Table: Room
CREATE TABLE Room (
    room_id int NOT NULL IDENTITY(1, 1),
    room_type varchar(255) NOT NULL,
    1_2_price_per_night float NOT NULL,
    3_5_price_per_night float NOT NULL,
    max_guests int NOT NULL,
    CONSTRAINT Room_PK PRIMARY KEY (room_id)
);

--Table: Reservation
CREATE TABLE Reservation (
    reservation_id int NOT NULL IDENTITY(1, 1),
    customer_id int NOT NULL,
    room_id int NOT NULL,
    check_in_date varchar(255) NOT NULL,
    check_out_date varchar(255) NOT NULL,
    num_guests int NOT NULL,
    reservation_status varchar(255),
    CONSTRAINT Reservation_PK PRIMARY KEY (reservation_id),
    CONSTRAINT Customer_FK FOREIGN KEY (customer_id) REFERENCES Customer (customer_id),
    CONSTRAINT Room_FK FOREIGN KEY (room_id) REFERENCES Room (room_id)
);

--Table: Payment
CREATE TABLE Payment (
    payment_id int NOT NULL IDENTITY(1, 1),
    reservation_id int NOT NULL,
    amount_paid float,
    payment_date varchar(255),
    payment_status varchar(255),
    CONSTRAINT Payment_PK PRIMARY KEY (payment_id),
    CONSTRAINT Reservation_FK FOREIGN KEY (reservation_id) REFERENCES Reservation (reservation_id)
);