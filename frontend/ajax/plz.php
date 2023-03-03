<?php
	include '../business_logic.php';

	if(isset($_POST['plz'])) {
		$plz = filter_var($_POST['plz'], FILTER_SANITIZE_NUMBER_INT);
		holeGemeinde($plz);
	}
?>