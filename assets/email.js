
function mailCheck()
{
	var email = document.getElementsByName("reg_email")[0].value;

	if(!isValidEmailAddress(email))
		document.getElementById("mailvalid").className = "unsatisfied";
	else
		document.getElementById("mailvalid").className = "satisfied";
}

function isValidEmailAddress(emailAddress) 
{
	return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(emailAddress);
}

function mail2Check()
{
	var p1 = document.getElementsByName("reg_email")[0].value;
	var p2 = document.getElementsByName("reg_email2")[0].value;

	if(p1 != p2)
		document.getElementById("mailmatch").className = "unsatisfied";
	else
		document.getElementById("mailmatch").className = "satisfied";       
}