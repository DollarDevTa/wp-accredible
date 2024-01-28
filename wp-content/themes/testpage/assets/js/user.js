window.onload = function(){

  document.getElementById("submitbtn").addEventListener("click",function (){
	var form = document.getElementById("wp_signup_form");
	if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
		  form.classList.add("was-validated");
        }else{
			document.getElementById("wp_signup_form").submit();
		}
   });
};