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
		swal("Sorry!", "Fill the form first!", "error");
		uname.focus();
		return false;
	}else if (uname.value.trim()==""){
		swal("Sorry!", "Write username first!!!!", "error");
		uname.focus();
		return false;
	}else if (fname.value.trim()==""){
		swal("Sorry!", "Write Full name first!!!!", "error");
		fname.focus();
		return false;
	}else if (pass.value.trim()==""){
		swal("Sorry!", "Write password first!!!!", "error");
		pass.focus();
		return false;
	}else if (repass.value.trim()==""){
		swal("Sorry!", "Write Repeat password first!!!!", "error");
		repass.focus();
		return false;
	}else if (age.value.trim()==""){
		swal("Sorry!", "Write Age first!!!!", "error");
		age.focus();
		return false;
	}else if (gender.value == "gender"){
		swal("Sorry!", "Write Gender first!!!!", "error");
		gender.focus();
		return false;
	}else if (address.value.trim()==""){
		swal("Sorry!", "Write Address first!!!!", "error");
		address.focus();
		return false;
	}else if (phone.value.trim()==""){
		swal("Sorry!", "Write phone number first!!!!", "error");
		phone.focus();
		return false;
	}else if (email.value.trim()==""){
		swal("Sorry!", "Write email first!!!!", "error");
		email.focus();
		return false;
	}else if (!checkbox.checked){
		swal("Sorry!", "Accept Terms and Condition!!!!", "error");
		checkbox.focus();
		return false;
	}else if (pass.value.trim() != repass.value.trim()){
		swal("Sorry!", "Password and repeat password not match!!!!", "error");
		checkbox.focus();
		return false;
	}else if (uname.value.trim().length <5){
		swal("Sorry!", "Username Too short!!!!", "error");
		checkbox.focus();
		return false;
	}else if (pass.value.trim().length <5){
		swal("Sorry!", "Password Too short!!!!", "error");
		checkbox.focus();
		return false;
	}else{
		return true;
	}
}