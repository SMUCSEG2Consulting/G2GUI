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

$app->get('/dbtest',
	function($request, $response, $args) {
		$db = $this->dbConn;
		$strToReturn = '';

		foreach($db->query('SELECT * FROM departments') as $row){
			$strToReturn .= '<br />' . $row['dept_name'];
		}

		return $response->write('This is a DB Test.' . $strToReturn);
	}
);
