
create database moocher;
use moocher;

create table user
(
	id int(24) not null auto_increment unique,
	username varchar(30) not null,
	password varchar(30) not null,
	time_created datetime not null,
	primary key(id)
);

create table location
(
	id int(24) not null auto_increment unique,
	user_id int(24) not null,
	longitude real not null,
	latitude real not null,
	time_created datetime not null,
	expires datetime not null,
	additional_instructions text,
	primary key(id),
	foreign key(user_id) references user(id)
);

create table tag
(
	location_id int(24) not null,
	tag_name varchar(20) not null,
	foreign key(location_id) references location(id)
);

create user "moocher_admin"@"localhost" identified by "michaeljacksonsbleachedasshole";
grant select, insert, update, delete on moocher.* to "moocher_admin"@"localhost";
