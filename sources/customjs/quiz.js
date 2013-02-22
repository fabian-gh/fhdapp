function checkBoxChecked()
{
	var params = new Array();//AND (b.tag_id = 7 OR b.tag_id = 1 OR b.tag_id = 2)

	$("input[type=checkbox]").each(function(){
		if($(this).prop("checked") === true){
			params.push($(this).val());
		}
	});

	if(params.length > 0)
	{
		retVal = "AND (";
		for(var i = 0; i < params.length; i++)
		{
			retVal += "b.tag_id = " + params[i];
			if(i < params.length - 1)
				retVal += " OR ";
			else
				retVal += ")";
		}
		showList(retVal);
	}
	else
	{
		$('#listwrapper').html("<br/>Bitte wähle deine Interessen aus.");
		$('#list').empty();
		$("#list").listview('refresh');
	}
}


function showList(str)
{
	var posting = $.post('index.php?eis=i&selector=Quiz', {action:"showList", params:str});
	posting.done(function( data ) {   
        var content = $(data).find('#listwrapper').html();
        $('#listwrapper').empty().append(content);
        var content2 = $(data).find("#list").html();
        $('#list').empty().append(content2);
        $('#list').listview('refresh');
    });
}