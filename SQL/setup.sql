DROP DATABASE IF EXISTS pickup;

CREATE DATABASE pickup;

USE pickup;

CREATE TABLE user(
name VARCHAR(100),
id INT auto_increment PRIMARY KEY,
salt VARCHAR(256),
hash VARCHAR(64)
);

CREATE TABLE sportPreference(
username VARCHAR(100),
sport VARCHAR(100)
);

CREATE TABLE game(
id INT PRIMARY KEY auto_increment,
sport VARCHAR(100),
time TIME,
playerCount INT,
location VARCHAR(100)
);

CREATE TABLE enlist(
playerName VARCHAR(100),
gameID INT,
PRIMARY KEY(playerName, gameID)
);

INSERT INTO user(name, salt, hash) values("ianjohnson", "1jo5OFAVDpC6xaEgt8sSuHcOSzo1SnkEVF5jHwD39SJegUlvz8nBLNeJBK6StVPCKzNNxUpOToQojUW304fW5gjniSqWejeBxo6Xtlgb0qIWW4vYoRYIIPRph8YwiW1mSxZ6sahYlfruDA52wtwPw82I9EVnEul7jRMbbFGFD2NDNW3AinEFt5sqMa84tKK0V9JJyRe4FY7yFTOVjSMV41WF2srbI3k0QVGoEaQ7r0tijCBnXil4QVwQ0ya1FW3g", "e48856bbdbbb68291a2059fd540961ca213ee5b20b91a7a26bb8b59ae4b052b5");
INSERT INTO user(name, salt, hash) values("iqbalkhan", "NqXpTZAb6McBvLGf1V3LeBqmlcH16lRpC2xnyefHj5sM3cH2QggKIxXIMKjmVVJNgesAWvCRIGC0Iuxr2uCvqBWMGiEkyrg4puXQ7DBjrqthquNmEzzN9OVWFX257hI1M2CZYUwwPOtqEnku3G3IzSBv9YbcCArb2sUzRxvo1BeAGikPCM8YHysSXZVRQ35wHifpczfp7xoi9ImorJlTIlWoVagaG3fITe93mijTEHwN1w6LURp7Fxr7U78CSHeP", "7b0115f26b32e84008c7f0b4ff973e5529fae472590afd5862b48c85b9b41831");
INSERT INTO user(name, salt, hash) values("ljbrown", "fUFqiFM8lbnzj7ZFV2bCUzG0TUNQeR3bcc2vO430J14VmEWfjruqMusm3TjWjQ3cq0zLVrbwKEFVjUKJlJnwXtujUqYjxObLxrZwUG6gsCSeCOYDNiEV8XqAqgcXf6c71BumYBquzKVXinLvrcsZNI4Jfv3aSyrItz3ugaan2ZtnieV1jDHsXQs05r52kyqByfHMgE71QR9xXU2cYhYyO3UxgOvMoaGmBlDOwPVc3JsPIomOkGH3fh7o3hqjFlkp", "e5b3e63a86512dfd05271fdcfcc72a4dee8c63670dbf2c66b0d9cb6885aa926f");

INSERT INTO game(sport, time, playerCount, location) values('basketball', '12:30:00',  8, 'Dedman');
INSERT INTO game(sport, time, playerCount, location) values('soccer', 20, '03:00:00', 'Intramural Fields');
INSERT INTO game(sport, time, playerCount, location) values('racquetball', '05:30:00', 2, 'Dedman');
INSERT INTO game(sport, time, playerCount, location) values('basketball', '08:00:00', 6, 'Dedman');

INSERT INTO sportPreference(username, sport) values('ianjohnson', "Soccer");
INSERT INTO sportPreference(username, sport) values('ianjohnson', "Basketball");

INSERT INTO sportPreference(username, sport) values('iqbalkhan', "Tennis");
INSERT INTO sportPreference(username, sport) values('iqbalkhan', "Football");


INSERT INTO enlist values('ianjohnson', 1);
INSERT INTO enlist values('ianjohnson', 2);

INSERT INTO enlist values('iqbalkhan', 2);
INSERT INTO enlist values('iqbalkhan', 3);

INSERT INTO enlist values('ljbrown', 1);
INSERT INTO enlist values('ljbrown', 3);
