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

INSERT INTO game(sport, playerCount, location) values('basketball', 8, 'Dedman');
INSERT INTO game(sport, playerCount, location) values('soccer', 20, 'Intramural Fields');
INSERT INTO game(sport, playerCount, location) values('racquetball', 2, 'Dedman');
