<?php
// Routes

$app->get('/hello', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/goodbye', 
	function ($request, $response, $args) {
		return $response->write("Time to go. Goodbye!");
	}
);

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
		$statement = $db->prepare('SELECT * FROM game');
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

$app->get('/newUser/{name}',
	function($request, $response, $args){
		$db = $this->dbConn;

		$statement = $db->prepare('SELECT * FROM user WHERE name=:usr');
		$statement->execute(array('usr'=>$args['name']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		if(!empty($result)){
			return $response->write('Error - name already taken');
		}

		$statement = $db->prepare('INSERT INTO user(name) values(:usr)');
		$statement->execute(array('usr' => $args['name']));

		return $response->write($args['name']);
	}
);

$app->get('/users',
	function($request, $response, $args){
		$db = $this->dbConn;
		$statement = $db->prepare('SELECT * FROM user');
		$statement->execute();
		$arr = $statement->fetchAll(PDO::FETCH_ASSOC);
		return $response->write(json_encode($arr));
	}
);

$app->get('/deleteUser/{id}', 
	function($request, $response, $args){
		$db = $this->dbConn;
		$statement = $db->prepare('DELETE FROM user WHERE id=:id');
		$statement->execute(array('id' => $args['id']));
		return $response->write('Deleted!');	
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
		$statement = $db->prepare('INSERT INTO game(sport, time, playerCount, location) values (:sport, :time, :count, :loc)');
		$statement->execute(array(
				'sport' => $args['sport'];
				'time' => $args['time'];
				'loc' => $args['location'];
				'count' => $args['playerCount'];
		));

		return $response->write("Success!");
	}
);
