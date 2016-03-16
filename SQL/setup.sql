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
playerCount INT
);

CREATE TABLE enlist(
playerID INT,
gameID INT,
PRIMARY KEY(playerID, gameID)
);
