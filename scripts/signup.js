function validatePassword()//password match validation
{
	var pass1 = document.getElementById("password").value;
	var pass2 = document.getElementById("password1").value;
	
	if( pass1 != pass2 )
	{
		document.getElementById("password1").value = "";
		alert('Password not matching');
		document.getElementById("password1").focus();
	}
}

function setGender()//To set hidden gender field
{
    //alert('setGender');
	if( document.getElementById('male').checked ) 
	{
		//Male radio button is checked
		document.getElementById('gender').value = 'M';
	}
	else if( document.getElementById('female').checked ) 
	{
		//Female radio button is checked
		document.getElementById('gender').value = 'F';
	}
	//alert(document.getElementById('gender').value);
}

function setSports()//to set and append all sports in 1 hidden field
{
	var vSports = '';
	if(document.getElementById('football').checked) 
	{
		vSports = vSports + 'football|';
	}
	if(document.getElementById('tennis').checked) 
	{
		vSports = vSports + 'tennis|';
	}
	if(document.getElementById('cricket').checked) 
	{
		vSports = vSports + 'cricket|';
	}
	document.getElementById('sports').value = vSports;
	//alert(document.getElementById('sports').value);
        }
        
        window.onload = initSignUp;

   