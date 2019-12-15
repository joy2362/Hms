function validation()
{
	let uname = document.reg.uname;
	let fname = document.reg.fname;
	let pass = document.reg.pass;
	let repass = document.reg.repass;
	let address = document.reg.address;
	let age = document.reg.age;
	let gender = document.reg.gender;
	let phone = document.reg.phone;
	let email = document.reg.email;
	let checkbox = document.getElementById("checkedTerm");
	//debug
	//alert(checkbox.value);
	//console.log(checkbox.value);

	if (uname.value.trim() == "" && fname.value.trim() == "" && pass.value.trim() == "" && repass.value.trim() == "" && age.value.trim() == "" && gender.value == "gender" && email.value.trim() == "" && !checkbox.checked) {
		document.getElementById('alert_style').style.display = 'block';
		document.getElementById("errorText").innerHTML=" Fill the form first!!!";
		uname.focus();
		return false;
	}else if (uname.value.trim()==""){
		document.getElementById('alert_style').style.display = 'block';
		document.getElementById("errorText").innerHTML="  username empty!!!";
		uname.focus();
		return false;
	}else if (fname.value.trim()==""){
		document.getElementById('alert_style').style.display = 'block';
		document.getElementById("errorText").innerHTML="  Full name empty!!!";
		fname.focus();
		return false;
	}else if (pass.value.trim()==""){
		document.getElementById('alert_style').style.display = 'block';
		document.getElementById("errorText").innerHTML="  password empty!!!";
		pass.focus();
		return false;
	}else if (repass.value.trim()==""){
		document.getElementById('alert_style').style.display = 'block';
		document.getElementById("errorText").innerHTML=" Repeat password empty!!!";
		repass.focus();
		return false;
	}else if (age.value.trim()==""){
		document.getElementById('alert_style').style.display = 'block';
		document.getElementById("errorText").innerHTML=" Age empty!!!";
		Age.focus();
		return false;
	}else if (!checkbox.checked){
		document.getElementById('alert_style').style.display = 'block';
		document.getElementById("errorText").innerHTML=" Accept Terms and Condition!!!";
		checkbox.focus();
		return false;
	}else if (pass.value.trim() != repass.value.trim()){
		document.getElementById('alert_style').style.display = 'block';
		document.getElementById("errorText").innerHTML=" Password and repeat password not match!!!";
		checkbox.focus();
		return false;
	}else if (uname.value.trim().length <5){
		document.getElementById('alert_style').style.display = 'block';
		document.getElementById("errorText").innerHTML=" Username Too short!!!";
		checkbox.focus();
		return false;
	}else if (pass.value.trim().length <5){
		document.getElementById('alert_style').style.display = 'block';
		document.getElementById("errorText").innerHTML=" Password Too short!!!";
		checkbox.focus();
		return false;
	}else{
		return true;
	}
}