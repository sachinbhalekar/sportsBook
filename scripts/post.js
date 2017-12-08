
function setSports()//setting value of hidden 'sports' input element
{
	//alert(document.getElementById('sport').value);
	if( document.getElementById('football').checked ) 
	{
		//Football radio button is checked
		document.getElementById('sport').value = 'football';
	}
	else if( document.getElementById('tennis').checked ) 
	{
		//Tennis radio button is checked
		document.getElementById('sport').value = 'tennis';
	}
	else if( document.getElementById('cricket').checked ) 
	{
		//Cricket radio button is checked
		document.getElementById('sport').value = 'cricket';
	}
	//alert(document.getElementById('sport').value);
}

window.onload = initPost;
