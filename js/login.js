// login form logic
$(document).on('submit','#login-form',function(e) {
	e.preventDefault();
	var user = $('#username').val();
	var pass = $('#password').val();

	if (user.length == '' || pass.length == '') {
		errorMessage("Please fill out all fields.");
		return;
  }

	$.ajax({
		type: "POST",
		url: baseURL + "login.php",
		data: "user="+user+"&password="+pass,
		success: function(data) {
			if (data.status == 'NO') {
				if (data.content == 'invalid_session') {
					if (session_exp == false) {
						session_exp = true;
						checkSession();
					}
				} else {
					console.log(data.content);
					alert(data.content);
					return;
				}
			} else {
				var dc = data.content;
				
				var token = dc.token;
				var uid = dc.user_id;
				var eid = dc.employee_id;
				var employee_code = dc.employee_code;
				var email = dc.email;				
				var user_groups = JSON.stringify(dc.user_groups);
				var redirect_url = dc.redirect_url;

				$.ajax({
					type: "POST",
					data: `&userID=${uid}&user=${employee_code}&token=${token}&name=${dc.name}&employeeID=${eid}&email=${email}&user_groups=${user_groups}&redirect_url=${redirect_url}&customer=${dc.customer}`,
					url: "php/login_session.php", // portal file
					success: function(data) {
						if (data.status == "NO") {
							alert("Failed to set session.");
							return;
						} else {
							
							var redirectURL = data.content.redirect_url;
							if (redirectURL == undefined || redirectURL == null || redirectURL == '') {
								redirectURL = 'index.php';
							}
							window.location.assign(redirectURL);
						}
					}
				});
			}
		}
	});
});

function ftlPassword(data) {
	$('#ftlModal').modal('toggle');

	$(document).on('click','.submit-password-change',function() {
		var token = data.token;
		// var is_admin = data.fusion;
		var uid = data.user_id;
		var user = data.username;
		var groups = data.groups[0];

		if ($('#newpass').val() != $('#newpassconfirm').val()) {
			$('.password-form-group').addClass('has-error');
			return;
		}
		if ($('#newpass').val().length < 6 || $('#newpassconfirm').val().length < 6) {
			return;
		}

		$.ajax({
			type: "POST",
			data: "user="+user+"&token="+token+"&userID="+uid+"&username="+user+"&new_pass="+$('#newpass').val(),
			url: baseURL + "ftl_pass.php",
			success: function(data) {
				if (data.status == 'NO') {
					console.log(data.content);
					alert(data.content);
					return;
				} else {
					$.ajax({
						type: "POST",
						data: "user="+user+"&token="+token+"&userID="+uid+"&name="+user+"&group="+groups,
						url: "php/login_session.php",
						success: function(data) {
							if (data.status == 'NO') {
								alert("Failed to set session.");
								return;
							} else {
								var redirectURL = data.content.redirect_url;
								if (redirectURL == undefined) {
									var redirectURL = 'index.php';
								}
								window.location.assign(redirectURL);
							}
						}
					});
				}
			}
		});
	});
}