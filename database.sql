CREATE TABLE users {
    userID INT(11) unsigned NOT NULL AUTO_INCREMENT,
    email VARCHAR(100) NOt NULL,
    password VARCHAR(120) NOT NULL, 
    fullname varchar(150) DEFAULT NULL,
    ip varchar(45) NOT NULL DEFAULT '127.0.0.1',
    UNIQUE KEY (email),
    PRIMARY KEY (userId)
}ENGINE=InnoDb CHARSET=utf8mb4

CREATE TABLE payments (
    paymentId int(11) unsigned NOT NULL AUTO_INCREMENT,
    userId int(11) unsigned NOT NULL,
    paypalEmail varchar(100) DEFAULT NULL,
    stripePublishablekey varchar(40) DEFAULT NULL,
    stripePrivatekey varchar(100) DEFAULT NULL,
    currency char(3) NOT NULL DEFAULT 'USD',
    PRIMARY KEY (paymentId),
    UNIQUE KEY (userId),
    FOREIGN KEY (userId) REFERENCES users(userId)
) ENGINE=InnoDb CHARSET=utf8mb4

CREATE TABLE items (
    itemId int(11) unsigned NOT NULL AUTO_INCREMENT,
    userId int(11) unsigned NOT NULL,
    idName VARCHAR(50) NOt NULL,
    itemName VARCHAR(100) NOt NULL,
    businessName VARCHAR(100) DEFAULT NULL,
    summary text DEFAULT NULL,
    price decimal(8, 2) NOT NULL DEFAULT '0.00',
    PRIMARY KEY (itemId),
    UNIQUE KEY (idName)
    FOREIGN KEY (userId) REFERENCES users(userID)
 ) ENGINE=InnoDb CHARSET=utf8mb4
