DROP DATABASE IF EXISTS pickup;

CREATE DATABASE pickup;

USE pickup;

CREATE TABLE user(
name VARCHAR(100),
id INT PRIMARY KEY auto_increment
);

CREATE TABLE game(
id INT PRIMARY KEY auto_increment,
sport VARCHAR(20),
time TIME,
playerCount INT,
location VARCHAR(100)
);

CREATE TABLE enlist(
playerID INT,
gameID INT,
PRIMARY KEY(playerID, gameID)
);

INSERT INTO user(name) values("ianjohnson");
INSERT INTO user(name) values("iqbalkhan");
INSERT INTO user(name) values("ljbrown");

INSERT INTO game(sport, time, playerCount, location) values('basketball', '12:30:00',  8, 'Dedman');
INSERT INTO game(sport, time, playerCount, location) values('soccer', 20, '03:00:00', 'Intramural Fields');
INSERT INTO game(sport, time, playerCount, location) values('racquetball', '05:30:00', 2, 'Dedman');
INSERT INTO game(sport, time, playerCount, location) values('basketball', '08:00:00', 6, 'Dedman');

INSERT INTO enlist values(1, 1);
INSERT INTO enlist values(1, 2);

INSERT INTO enlist values(2, 2);
INSERT INTO enlist values(2, 3);

INSERT INTO enlist values(3, 1);
INSERT INTO enlist values(3, 3);
