DROP DATABASE IF EXISTS pickup;

CREATE DATABASE pickup;

USE pickup;

CREATE TABLE user(
name VARCHAR(100),
id INT auto_increment PRIMARY KEY,
sport1 VARCHAR(20),
sport2 VARCHAR(20),
sport3 VARCHAR(20)
);

CREATE TABLE game(
id INT PRIMARY KEY auto_increment,
sport VARCHAR(20),
time TIME,
playerCount INT,
location VARCHAR(100)
);

CREATE TABLE enlist(
playerName VARCHAR(100),
gameID INT,
PRIMARY KEY(playerName, gameID)
);

INSERT INTO user(name) values("ianjohnson");
INSERT INTO user(name) values("iqbalkhan");
INSERT INTO user(name) values("ljbrown");

INSERT INTO game(sport, time, playerCount, location) values('basketball', '12:30:00',  8, 'Dedman');
INSERT INTO game(sport, time, playerCount, location) values('soccer', 20, '03:00:00', 'Intramural Fields');
INSERT INTO game(sport, time, playerCount, location) values('racquetball', '05:30:00', 2, 'Dedman');
INSERT INTO game(sport, time, playerCount, location) values('basketball', '08:00:00', 6, 'Dedman');

INSERT INTO enlist values('ianjohnson', 1);
INSERT INTO enlist values('ianjohnson', 2);

INSERT INTO enlist values('iqbalkhan', 2);
INSERT INTO enlist values('iqbalkhan', 3);

INSERT INTO enlist values('ljbrown', 1);
INSERT INTO enlist values('ljbrown', 3);
