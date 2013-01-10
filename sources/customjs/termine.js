function checkDate(element)
{
	if(element.value == 'T.M.JJJJ' || element.value == 'TT.MM.JJJJ')
		element.style='';
	else
	{
		var parts = element.value.split(".");
		if((parts[0] >= 1 && parts[0] <= 31) && (parts[1] >= 1 && parts[1] <= 12) && (parts[2] >= 1000 && parts[2] <= 3000))
			element.style='';
		else
			setErrorStyle(element);
	}
}

function checkYear(element)
{
	if(element.value == 'JJJJ')
		element.style='';
	else
	{
		if(element.value >= 1000 && element.value <= 3000)
			element.style='';
		else
			setErrorStyle(element);
	}
}

function checkName(element)
{
	for(var i = 0; i < element.value.length; i++)
		if(element.value[i] != " ")
		{
			element.style='';
			return;
		}
	setErrorStyle(element);
}

function setErrorStyle(element)
{
	element.style='border:1px solid red;';
}