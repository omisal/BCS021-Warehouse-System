<footer class="footer">
	<div id="footer">
		Copyright Brainners &copy; 2020 All rights reserved.
	</div>
</footer>

<script type="text/javascript">
	function validateLogin() {
		var valid=true;
		if ($("#user").val()=="") {valid=false;$("#userWarn").css("display","block");}
		else{$("#userWarn").css("display","none");}
		if ($("#pwd").val()=="") {valid=false;$("#pwdWarn").css("display","block");}
		else{$("#pwdWarn").css("display","none");}
		return valid;
	}
</script>