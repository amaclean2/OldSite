CREATE TABLE users ( 
id int(11) NOT NULL AUTO_INCREMENT, 
username varchar(255) NOT NULL, 
first_name varchar(255) NOT NULL, 
last_name varchar(255) NOT NULL, 
email varchar(255) NOT NULL, 
password varchar(255) NOT NULL, 
sign_up_date date NOT NULL, 
activated enum('0', '1') NOT NULL, 
PRIMARY KEY (id)
);

CREATE TABLE exchanges ( 
id int(11) NOT NULL AUTO_INCREMENT,
accountNo int(15) NOT NULL,
new_balance decimal(19,4) NOT NULL,
amount decimal(19,4) NOT NULL, 
date_added datetime NOT NULL,
PRIMARY KEY (id)
);

CREATE TABLE accounts (
id int(11) NOT NULL AUTO_INCREMENT,
userId int(11) NOT NULL,
accountNo int(15) NOT NULL,
accountType varchar(255) NOT NULL,
balance decimal(19, 4) NOT NULL,
PRIMARY KEY (id)
);