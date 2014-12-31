$(function(){
	$("#form_login").submit(function(){
		var formulario = $(this).serialize();
		$.ajax({
			url: "includes/login.php",
			data:({
				formulario: formulario
			}),
			// dataType: "json",
			success: function(result){
				if(result == 0)
					$(".small_box_frame.erro").show();
				else if(result == 1)
					document.location = "?p=minha_conta";
			}
		}).responseText;
		return false;
	});
});