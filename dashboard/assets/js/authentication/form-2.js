var togglePassword = document.getElementById("toggle-password");
var formContent = document.getElementsByClassName('form-content')[0]; 
var getFormContentHeight = formContent.clientHeight;

var formImage = document.getElementsByClassName('form-image')[0];
if (formImage) {
	var setFormImageHeight = formImage.style.height = getFormContentHeight + 'px';
}
if (togglePassword) {
	togglePassword.addEventListener('click', function() {
	  var x = document.getElementById("password");
	  if (x.type === "password") {
	    x.type = "text";
	  } else {
	    x.type = "password";
	  }
	});
}
var toggleNewPassword = document.getElementById("toggle-new-password");

if (toggleNewPassword) {
	toggleNewPassword.addEventListener('click', function() {
	  var x = document.getElementById("newPassword");
	  if (x.type === "password") {
	    x.type = "text";
	  } else {
	    x.type = "password";
	  }
	});
}
var toggleNewPassword = document.getElementById("toggle-retype-password");

if (toggleNewPassword) {
	toggleNewPassword.addEventListener('click', function() {
	  var x = document.getElementById("retypeNewPassword");
	  if (x.type === "password") {
	    x.type = "text";
	  } else {
	    x.type = "password";
	  }
	});
}