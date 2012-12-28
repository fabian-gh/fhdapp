<form method="post">
	<input type="text" name="text">
	<input type="submit" name="button" value="abschicken">
</form>

<?php

	if(isset($_POST["button"])){
		echo "button gedr&uuml;ckt</br>";
		if(isset($_POST["text"])){
			echo "isset text</br>";
		}
		else{
			echo "!isset text</br>";
		}
		if($_POST["text"] == ""){
			echo "text==\"\"</br>";
		}
		else{
			echo "text==\"...\"</br>";
		}
		if(is_numeric($_POST["text"])){
			echo "numeric</br>";
		}
		else{
			echo "!numeric</br>";
		}
	}
	
	$retVal = true;
	if(is_bool($retVal)){
		echo "is_bool</br>";
	}
	else{
		echo "!is_bool</br>";
	}
	
?>