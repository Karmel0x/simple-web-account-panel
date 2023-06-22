
function nameCheck() {
	var username = document.getElementsByName("reg_uname")[0].value;
	var myRegxp = /^([a-zA-Z0-9]+)$/;

	if (username.length < 4 || username.length > 15)
		document.getElementById("namelen").className = "unsatisfied";
	else
		document.getElementById("namelen").className = "satisfied";

	if (!myRegxp.test(username))
		document.getElementById("namechar").className = "unsatisfied";
	else
		document.getElementById("namechar").className = "satisfied";

	checkavailable(username);
}

function mailCheck() {
	var email = document.getElementsByName("reg_email")[0].value;

	if (!isValidEmailAddress(email))
		document.getElementById("mailvalid").className = "unsatisfied";
	else
		document.getElementById("mailvalid").className = "satisfied";
}

function pw1Check() {
	var pass1 = document.getElementsByName("reg_pw1")[0].value;

	if (pass1.length < 4 || pass1.length > 15)
		document.getElementById("passlen").className = "unsatisfied";
	else
		document.getElementById("passlen").className = "satisfied";

	if (!(/\d/.test(pass1) && /[a-zA-Z]/.test(pass1)))
		document.getElementById("passchar").className = "unsatisfied";
	else
		document.getElementById("passchar").className = "satisfied";
}

function pw2Check() {
	var pass1 = document.getElementsByName("reg_pw1")[0].value;
	var pass2 = document.getElementsByName("reg_pw2")[0].value;

	if (pass1 != pass2)
		document.getElementById("passmatch").className = "unsatisfied";
	else
		document.getElementById("passmatch").className = "satisfied";
}

function checkavailable(username) {
	var xmlHttp = new XMLHttpRequest();
	xmlHttp.onreadystatechange = function () {
		if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
			if (xmlHttp.responseText != "0")
				document.getElementById("nameuniq").className = "unsatisfied";
			else
				document.getElementById("nameuniq").className = "satisfied";
		}
	}
	xmlHttp.open("GET", "./assets/check.php?check=userexist&username=" + username, true);
	xmlHttp.send(null);
}

function isValidEmailAddress(emailAddress) {
	return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(emailAddress);
}
