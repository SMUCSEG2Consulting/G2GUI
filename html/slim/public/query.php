<html>

<?php

try {
	$db = new PDO('mysql:host=localhost;dbname=employees;charset=utf8', 'root', '');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
	$select = $db->query("SELECT first_name, last_name, salary FROM employees e, salaries s WHERE e.emp_no = s.emp_no AND s.salary > 150000 AND s.to_date IN (SELECT max(to_date) FROM salaries) ORDER BY s.salary");
	$myArr = $select->fetchAll(PDO::FETCH_ASSOC);
	foreach($myArr as $item){
		echo $item['first_name'] . " ";
		echo $item['last_name'] . ": ";
		echo "$" .$item['salary'] . "<br \>";
	}
} catch(PDOException $e){
	echo "Error: " . $e->getMessage();
}
?>

</html>
