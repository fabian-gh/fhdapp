<script type="text/javascript" src="sources/customjs/quiz.js">DrawPageContent();</script>
<?php

	echo "<h1>Quiz</h1>
	Ich möchte...";

	require_once 'controllers/quizController.php';
    $quizController = new QuizController();

    echo "<fieldset data-role='controlgroup'>";
    
	    $tags = $quizController->getTags();
		if(count($tags) > 0)
		    foreach($tags as $tag)
		    {
		    	echo "<input type='checkbox' value='{$tag['id']}' id='{$tag['id']}' onchange=\"checkBoxChecked();\"/>
		    	<label for='{$tag['id']}'> ...{$tag['name']}</label>";
			}

	echo "</fieldset>";

	echo "<br/>Diese Studiengänge wären interessant für dich:
	<ul id='list' data-role='listview' data-inset='true' style='margin:.5em 0;'>";
	
		if(isset($_POST['action']))
		{
			$courses = $quizController->getList($_POST['params']);
			if(count($courses) > 0)
			foreach($courses as $course)
				echo "<li data-icon='false'><a href='index.php?eis={$_GET['eis']}&selector=".urlencode($_GET['selector'])."' data-role='button'><h6>{$course['name']}</h6></a></li>";
		}
	
	echo "</ul>";
?>



