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

		$statement = $db->prepare('SELECT playerID FROM enlist WHERE gameID=:id');
		$statement->execute(array('id' => $args['id']));
		$temp = array_values($statement->fetchAll(PDO::FETCH_ASSOC));
		
		$ids = array();
		foreach($temp as $player){
			$ids[] = $player['playerID'];
		}

		$arr['playerIDs'] = $ids;
		
		return $response->write(json_encode($arr));
	}
);
