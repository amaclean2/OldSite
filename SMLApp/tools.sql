CREATE TABLE tools (
	id int(11) NOT NULL AUTO_INCREMENT,
	tool_number int(2) NOT NULL,
	type varchar(255) NOT NULL,
	diameter decimal(8, 5) NOT NULL,
	radius decimal(6, 5) NOT NULL,
	material varchar(255) NOT NULL,
	flutes int(2) NOT NULL,
	length decimal(8, 5) NOT NULL,
	angle varchar(255) NOT NULL,
	dateadded date NOT NULL,
	notes varchar(255) NOT NULL,
	part_number varchar(255) NOT NULL,
	operation varchar(255) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE purchases (
	id int(11) NOT NULL AUTO_INCREMENT,
	dateadded date NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE priority (
	id int(11) NOT NULL AUTO_INCREMENT,
	dateadded date NOT NULL,
	datedue date NOT NULL,
	priority int(11) NOT NULL,
	partID int(11) NOT NULL,
	current enum('0', '1') NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE photos (
	id int(11) NOT NULL AUTO_INCREMENT,
	file_name varchar(255) NOT NULL UNIQUE,
	caption varchar(255) NOT NULL,
	photo mediumblob NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE requests (
	id int(11) NOT NULL AUTO_INCREMENT,
	type varchar(255) NOT NULL,
	diameter decimal(8, 5) NOT NULL,
	material varchar(255) NOT NULL,
	seen int(2) NOT NULL,
	edp varchar(255) NOT NULL,
	dateadded date NOT NULL,
	notes varchar(255) NOT NULL,
	quantity int(11) NOT NULL,
	part_number varchar(255) NOT NULL,
	operation varchar(255) NOT NULL,
	bought int(11) NOT NULL,
	source varchar(255) NOT NULL,
	price decimal(15, 3) NOT NULL,
	priority_id int(11) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE lrequests(
	id int(11) NOT NULL AUTO_INCREMENT,
	type varchar(255) NOT NULL,
	seen int(2) NOT NULL,
	description varchar(255) NOT NULL,
	insert_code varchar(255) NOT NULL,
	notes varchar(255) NOT NULL,
	lquantity int(11) NOT NULL,
	part_number varchar(255) NOT NULL,
	operation varchar(255) NOT NULL,
	dateadded date NOT NULL,
	bought int(11) NOT NULL,
	price decimal(15, 3) NOT NULL,
	source varchar(255) NOT NULL,
	priority_id int(11) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE orequests(
	id int(11) NOT NULL AUTO_INCREMENT,
	description varchar(255) NOT NULL,
	seen int(11) NOT NULL,
	notes varchar(255) NOT NULL,
	quantity int(11) NOT NULL,
	part_number varchar(255) NOT NULL,
	operation varchar(255) NOT NULL,
	bought int(11) NOT NULL,
	dateadded date NOT NULL,
	source varchar(255) NOT NULL,
	price decimal(15, 3) NOT NULL,
	priority_id int(11) NOT NULL,
	PRIMARY KEY(id)
);

CREATE TABLE users (
	id int(11) NOT NULL AUTO_INCREMENT, 
	username varchar(255) NOT NULL, 
	first_name varchar(255) NOT NULL, 
	last_name varchar(255) NOT NULL,
	password varchar(255) NOT NULL, 
	sign_up_date date NOT NULL, 
	email varchar(255) NOT NULL,
	reqNot int(11) NOT NULL,
	user_level varchar(255) NOT NULL,
	psoition varchar(255) NOT NULL,
	display_info int(11) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE parts (
	id int(11) NOT NULL AUTO_INCREMENT,
	seen int(2) NOT NULL,
	part_number varchar(255) NOT NULL,
	revision varchar(255) NOT NULL,
	customer varchar(255) NOT NULL,
	operation int(11) NOT NULL,
	toolbox varchar(255) NOT NULL,
	dateadded date NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE fixtures (
	id int(11) NOT NULL AUTO_INCREMENT,
	part_number varchar(255) NOT NULL,
	operation varchar(255) NOT NULL,
	fixture varchar(255) NOT NULL,
	x_zero varchar(255) NOT NULL,
	y_zero varchar(255) NOT NULL,
	z_zero varchar(255) NOT NULL,
	a_zero varchar(255) NOT NULL,
	notes varchar(255) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE ltools (
	id int(11) NOT NULL AUTO_INCREMENT,
	part_number varchar(255) NOT NULL,
	operation varchar(255) NOT NULL,
	tool_number int(2) NOT NULL,
	type varchar(255) NOT NULL,
	description varchar(255) NOT NULL,
	insert_code varchar(255) NOT NULL,
	notes varchar(255) NOT NULL,
	dateadded date NOT NULL,
	PRIMARY KEY (id)
);