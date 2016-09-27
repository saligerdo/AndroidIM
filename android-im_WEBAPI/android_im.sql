CREATE TABLE friends (
Id int(10) NOT NULL AUTO_INCREMENT,
providerid int(10) NOT NULL ,
requestid int(10) NOT NULL ,
status binary(1) NOT NULL DEFAULT '0',
PRIMARY KEY (Id)
);

CREATE TABLE messages (
Id int(10) NOT NULL AUTO_INCREMENT,
fromuid int(255) NOT NULL,
touid int(255) NOT NULL,
sentdt datetime NOT NULL,
readmsg tinyint(1) NOT NULL DEFAULT '0',
readdt datetime DEFAULT NULL,
messagetext longtext CHARACTER SET utf8 NOT NULL,
PRIMARY KEY (Id)
);

CREATE TABLE users (
Id int(10) unsigned NOT NULL AUTO_INCREMENT,
username varchar(45) NOT NULL DEFAULT '',
password varchar(32) NOT NULL DEFAULT '',
email varchar(45) NOT NULL DEFAULT '',
datemsg datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
status tinyint(3) unsigned NOT NULL DEFAULT '0',
authenticationTime datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
userKey varchar(32) NOT NULL DEFAULT '',
Ip varchar(45) NOT NULL DEFAULT '',
port int(10) unsigned NOT NULL DEFAULT '0',
PRIMARY KEY (Id)
);
