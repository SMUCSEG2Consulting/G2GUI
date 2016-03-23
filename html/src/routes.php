<?php
// Routes

/*
Random bitstring generation for hash salting
*/
function randomBitString($length = 256) {
    $chars = '0123456789abcdef';
    $len = strlen($chars);
    $str = '';

    for ($i = 0; $i < $len; $i++) {
        $str .= $chars[rand(0, $len - 1)];
    }
    return $str;
}

$app->get('/json',
	function ($request, $response, $args) {
		return $response->write(json_encode(array('field' => 'value')));
	}
);

$app->get('/json/{id}',
	function ($request, $response, $args){
		return $response->write(json_encode(array('id' => $args['id'])));
	}
);


$app->get('/games',
	function($request, $response, $args) {
		$db = $this->dbConn;
		$statement = $db->prepare('SELECT * FROM game WHERE date >= CURDATE()');
		$statement->execute();
		$arr = $statement->fetchAll(PDO::FETCH_ASSOC);
		return $response->write(json_encode($arr));
	}
);

$app->get('/game/{id}',
	function ($request, $response, $args){
		$db = $this->dbConn;

		$statement = $db->prepare('SELECT * FROM game WHERE id=:id');
		$statement->execute(array('id' => $args['id']));
		$arr = $statement->fetch(PDO::FETCH_ASSOC);

		$statement = $db->prepare('SELECT playerName FROM enlist WHERE gameID=:id');
		$statement->execute(array('id' => $args['id']));
		$temp = array_values($statement->fetchAll(PDO::FETCH_ASSOC));
		
		$ids = array();
		foreach($temp as $player){
			$ids[] = $player['playerName'];
		}

		$arr['playerNames'] = $ids;
		
		return $response->write(json_encode($arr));
	}
);

$app->get('/newUser/{name}/{pwd}',
	function($request, $response, $args){
		$db = $this->dbConn;

		$statement = $db->prepare('SELECT * FROM user WHERE name=:usr');
		$statement->execute(array('usr'=>$args['name']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		if(!empty($result)){
			return $response->write('Error - name already taken');
		}

		$salt = randomBitString();
		$hash = hash('sha256', $args['pwd'] . $salt);

		$statement = $db->prepare('INSERT INTO user(name, salt, hash) values(:usr, :sl, :hs)');
		$statement->execute(array(
			'usr' => $args['name'],
			'sl' => $salt,
			'hs' => $hash
		));

		return $response->write($args['name']);
	}
);

$app->get('/users',
	function($request, $response, $args){
		$db = $this->dbConn;
		$statement = $db->prepare('SELECT name, id FROM user');
		$statement->execute();
		$arr = $statement->fetchAll(PDO::FETCH_ASSOC);
		return $response->write(json_encode($arr));
	}
);

$app->get('/addSportForUser/{username}/{sport}',
	function($request, $response, $args){
		$db = $this->dbConn;
		
		$statement = $db->prepare('INSERT INTO sportPreference(username, sport) values(:usr, :spr)');
		$statement->execute(array(
			'usr' => $args['username'],
			'spr' => $args['sport']
		));

		return $response->write('success');
	}
);

$app->get('/removeSportForUser/{username}/{sport}',
	function($request, $response, $args){
		$db = $this->dbConn;
		
		$statement = $db->prepare('DELETE FROM sportPreference WHERE username=:usr AND sport =:spr');
		$statement->execute(array(
			'usr' => $args['username'],
			'spr' => $args['sport']
		));

		return $response->write('success');
	}
);


$app->get('/user/{username}',
	function($request, $response, $args){
		$db = $this->dbConn;
		$statement = $db->prepare('SELECT sport FROM sportPreference WHERE username = :usr');
		$statement->execute(array(
				'usr' => $args['username']
			));
		$arr = $statement->fetchAll(PDO::FETCH_ASSOC);
		return $response->write(json_encode($arr));
	}
);

$app->get('/deleteUser/{username}/{password}', 
	function($request, $response, $args){
		
		$db = $this->dbConn;

		$statement = $db->prepare('SELECT * FROM user WHERE name=:usr');
		$statement->execute(array('usr'=>$args['username']));
		
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		if(empty($result)){
			return $response->write('No such user');
		}

		$statement = $db->prepare('SELECT salt, hash FROM user WHERE name = :nm');
		$statement->execute(array(
			'nm' => $args['username'],
		));

		$item = $statement->fetch(PDO::FETCH_ASSOC);
		$salt = $item['salt'];

		$hash = hash('sha256', $args['password'] . $salt);

		if($hash == $item['hash']){
			$statement = $db->prepare('DELETE FROM user WHERE name=:name');
			$statement->execute(array('name' => $args['username']));
			return $response->write('Deleted!');
		} else {
			return $response->write('wrong pass');
		}


			
	}
);

$app->get('/deleteGame/{id}',
	function($request, $response, $args){
		
		$db = $this->dbConn;
		$statement = $db->prepare('DELETE FROM game WHERE id=:id');
		$statement->execute(array('id' => $args['id']));
		return $response->write('Deleted.'); 

	}

);


$app->get('/createGame/{hostName}/{time}/{sport}/{location}/{playerCount}',
	function($request, $response, $args){
		$db = $this->dbConn;
		$statement = $db->prepare('INSERT INTO game(sport, time, playerCount, location, date) values (:sport, :time, :count, :loc, CURDATE())');
		$statement->execute(array(
				'sport' => $args['sport'],
				'time' => $args['time'],
				'loc' => $args['location'],
				'count' => $args['playerCount']
		));

		$select = $db->prepare('SELECT max(id) from game');
		$select->execute();
		$id = $select->fetch(PDO::FETCH_ASSOC)['max(id)'];

		$statement = $db->prepare('INSERT INTO enlist(playerName, gameID) values(:name, :id)');
		$statement->execute(array(
				'name' => $args['hostName'],
				'id' => $id
		));

		return $response->write("Success!");
	}
);

$app->get('/updateUser/{usr}/{s1}/{s2}/{s3}',
	function($request, $response, $args){
		$db = $this->dbConn;
		$statement = $db->prepare('UPDATE user SET sport1= :one, sport2 = :two, sport3 = :three WHERE name = :username');
		$statement->execute(array(
				'one' => $args['s1'],
				'two' => $args['s2'],
				'three' => $args['s3'],
				'username' => $args['usr']
		));
		return $response->write(json_encode($args));
	}
);

$app->get('/login/{name}/{pwd}',
	function($request, $response, $args){
		$db = $this->dbConn;

		$statement = $db->prepare('SELECT * FROM user WHERE name=:usr');
		$statement->execute(array('usr'=>$args['name']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		if(empty($result)){
			return $response->write('failed');
		}

		$statement = $db->prepare('SELECT salt, hash FROM user WHERE name = :nm');
		$statement->execute(array(
			'nm' => $args['name'],
		));

		$item = $statement->fetch(PDO::FETCH_ASSOC);
		$salt = $item['salt'];

		$hash = hash('sha256', $args['pwd'] . $salt);

		if($hash == $item['hash']){
			return $response->write("success");
		} else {
			return $response->write('failed');
		}
	}
);


$app->get('/addUserToGame/{gameID}/{username}',
	function($request, $response, $args){
		$db = $this->dbConn;
		$statement = $db->prepare('INSERT into enlist(playerName, gameID) values(:username, :gameID)');
		$statement->execute(array(
				'username' => $args['username'],
				'gameID' => $args['gameID']
		));
		return $response->write(json_encode($args));
	}
);

/*delete user from game*/
$app->get('/deleteUserFromGame/{gameID}/{username}',
	function($request, $response, $args){
		$db = $this->dbConn;
		$statement = $db->prepare('DELETE FROM game WHERE gameID=:gid AND username=:usr');
		$statement->execute(array('usr' => $args['username'], 'gid' => $args['gameID']));
		return $response->write('Deleted.'); 
	}
);
