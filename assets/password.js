
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


	var pass0 = document.getElementsByName("reg_pw0")[0].value;

	if (pass1 == pass0)
		document.getElementById("passre").className = "unsatisfied";
	else
		document.getElementById("passre").className = "satisfied";

}

function pw2Check() {
	var pass1 = document.getElementsByName("reg_pw1")[0].value;
	var pass2 = document.getElementsByName("reg_pw2")[0].value;

	if (pass1 != pass2)
		document.getElementById("passmatch").className = "unsatisfied";
	else
		document.getElementById("passmatch").className = "satisfied";
}
