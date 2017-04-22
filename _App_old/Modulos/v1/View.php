<?php 
	if (isset($jsonText)) {
		echo json_encode($response);
	} else {
		echo json_encode($response,JSON_NUMERIC_CHECK);
	}

 ?>