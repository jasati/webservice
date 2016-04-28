<?php
	$dir = "App/Upload/";

	if (isset($_GET['img'])) {
		$nomeImg = $_GET['img'];
		echo "<a href='".$dir.$nomeImg."''><img src='".$dir.$nomeImg."'/></a>";
	} else {
     	$array_dir = scandir($dir);
     	foreach ($array_dir as $images) {
        	if ($images != "." && $images != "..") {
	  			echo "<a href='".$dir.$images."''><img src='".$dir.$images."'/></a>";
			}
     	}

	}
?>