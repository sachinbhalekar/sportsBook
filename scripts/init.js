function initGender()//set click event for the radio button...
{
    document.getElementById('male').addEventListener("click", function(){setGender();});
    document.getElementById('female').addEventListener("click", function(){setGender();});
}

function initSports()//set click event for the checkboxes...
{
    document.getElementById('football').addEventListener("click", function(){setSports();});
    document.getElementById('tennis').addEventListener("click", function(){setSports();});
    document.getElementById('cricket').addEventListener("click", function(){setSports();});
}

function initAddress()//set change event for address fields...
{
    document.getElementById('address1').addEventListener("change", function(){getLatLong();});//'change' event
    document.getElementById('address2').addEventListener("blur", function(){getLatLong();});//'blur' event
    document.getElementById('city').addEventListener("change", function(){getLatLong();});
    document.getElementById('state').addEventListener("change", function(){getLatLong();});
    document.getElementById('zipcode').addEventListener("change", function(){getLatLong();});
    document.getElementById('country').addEventListener("input", function(){getLatLong();});//'input' event
}

//for SignUp page
function initSignUp()
{
    //alert('Hi');
	document.getElementById('password1').addEventListener("change", function(){validatePassword();});
	initGender();
	initSports();
	initAddress();
}

//for activity/event post
function initPost()
{
	initSports();
	initAddress();
}