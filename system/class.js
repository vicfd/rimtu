	function redireccionar(pagina)
	{
		setTimeout(function(){window.location=pagina},2000);
	}
	
	function goMylove(div,src,url)
	{
		
		$("#resultado").fadeIn(1000);
		$("#resultado").html("<img src='/system/style/load.gif'></img>");
		
		$(div).load(src,function()
		{
			if(url != "" && url != null)
				window.history.pushState(0, "Titulo", url);
			$("#resultado").fadeOut(1000);
		});	
	}
	
	function showFolder(id)	
	{
        $.ajax({
                url:   '../system/class/folder.php?id='+id,
                type:  'post',
				beforeSend: function () 
				{
					$("#resultado").fadeIn(1000);	
					$("#resultado").html("<img src='/system/style/load.gif'></img>");
					$("#container").empty();
				},
                success:  function (response) 
				{
					$('#container').load('../system/class/folder.php?id='+id,function()
					{
						if(url != "" && url != null)
							window.history.pushState(0, "Titulo", url);
						$("#resultado").fadeOut(1000);
					});	
					$("#resultado").fadeOut(1000)
                }
        });
	}
	
	function doMaintenance()	
	{
        $.ajax({
                url:   '../system/script/admin_maintenance.php',
                type:  'post',
				beforeSend: function () 
				{
					$("#resultado").fadeIn(1000);	
					$("#resultado").html("<img src='/system/style/load.gif'></img>");
				},
                success:  function (response) 
				{
					goMylove('#container','../system/class/admin.php?id=1');
					$("#resultado").fadeOut(1000)
                }
        });
	}
	
	function reportFile(var1,var2,var3,var4)
	{
		goMylove('#container','../system/script/download_report.php?id='+var1.replace(/ /g,'%')+'&mail='+var2.replace(/ /g,'%')+'&type='+var3.replace(/ /g,'%')+'&reason='+var4.replace(/ /g,'%'))
	}
	
	function changepass(var1,var2,var3)	
	{
        var parametros = 
		{
                "oldpass" : var1,
                "newpass" : var2,
				"repass" : var3
        };
        $.ajax({
                data:  parametros,
                url:   '../system/script/panel_changepass.php',
                type:  'post',
				beforeSend: function () 
				{
					$("#resultado").fadeIn(1000);	
					$("#resultado").html("<img src='/system/style/load.gif'></img>");
				},
                success:  function (response) 
				{
					$("#temporal_message").fadeIn(1000);
					$("#temporal_message").html('<div class="Blanco border-round" style="visibility: display; height: auto; width: 260px; margin-top: 40px; padding: 20px 0px 20px 0px; color: #006699;">'+response+'</div>');
					$("#resultado").fadeOut(1000);
					$("#temporal_message").fadeOut(5000)
                }
        });
	}
	
	function changemail(var1)	
	{
        var parametros = 
		{
                "mail" : var1
        };
        $.ajax({
                data:  parametros,
                url:   '../system/script/panel_changemail.php',
                type:  'post',
				beforeSend: function () 
				{
					$("#resultado").fadeIn(1000);	
					$("#resultado").html("<img src='/system/style/load.gif'></img>");
				},
                success:  function (response) 
				{
					$("#temporal_message").fadeIn(1000);
					$("#temporal_message").html('<div class="Blanco border-round" style="visibility: display; height: auto; width: 260px; margin-top: 40px; padding: 20px 0px 20px 0px; color: #006699;">'+response+'</div>');
					$("#resultado").fadeOut(1000);
					$("#temporal_message").fadeOut(5000)
                }
        });
	}	
	
	function changefilename(var1,var2)	
	{		
        var parametros = 
		{
                "id" : var1,
                "name" : var2
        };
        $.ajax({
                data:  parametros,
                url:   '../system/script/panel_changenamefile.php',
                type:  'post',
				beforeSend: function () 
				{
					$("#resultado").fadeIn(1000);	
					$("#resultado").html("<img src='/system/style/load.gif'></img>");
				},
                success:  function (response) 
				{
					goMylove('#filename_'+var1,'../system/script/panel_filename.php?id='+var1)
                }
        });
	}
	
	function deletefile(var1,var2)	
	{
        var parametros = 
		{
                "id" : var1,
                "v" : var2
        };
        $.ajax({
                data:  parametros,
                url:   '../system/script/panel_delete.php',
                type:  'get',
				beforeSend: function ()
				{
					$("#resultado").fadeIn(1000);	
					$("#resultado").html("<img src='/system/style/load.gif'></img>");
				},
                success:  function (response) 
				{
					goMylove('#container','../system/class/panel.php?id='+var2)
                }
        });
	}
	
	function register(var1,var2,var3,var4,var5,var6,var7)	
	{
        var parametros = 
		{
                "username" : var1,
                "name" : var2,
				"password" : var3,
				"password2" : var4,
				"email" : var5,
				"recaptcha_challenge_field" : var6,
				"recaptcha_response_field" : var7
        };
        $.ajax({
                data:  parametros,
                url:   '../system/script/function_register.php',
                type:  'post',
				beforeSend: function () 
				{
					$("#resultado").fadeIn(1000);	
					$("#resultado").html("<img src='/system/style/load.gif'></img>");
				},
                success:  function (response) 
				{
					$("#register").html(response);
					$("#resultado").fadeOut(1000);
                }
        });
	}
	
	function login(var1,var2)	
	{
        var parametros = 
		{
                "user" : var1,
                "pass" : var2
        };
        $.ajax({
                data:  parametros,
                url:   '../system/script/function_login.php',
                type:  'post',
				beforeSend: function () 
				{
					$("#resultado").fadeIn(1000);	
					$("#resultado").html("<img src='/system/style/load.gif'></img>");
				},
                success:  function (response) 
				{
					$("#login").html(response);
					$("#resultado").fadeOut(1000);
                }
        });
	}

	function recovery(var1)
	{
        var parametros = 
		{
                "mail" : var1
        };
		$.ajax({
				data:  parametros,
				url:   '../system/script/function_recovery.php',
				type:  'post',
				beforeSend: function () 
				{
					$("#resultado").fadeIn(1000);	
					$("#resultado").html("<img src='/system/style/load.gif'/>");
				},
				success:  function (response) 
				{
					$("#recovery").html(response);
					$("#resultado").fadeOut(1000);
				}
		});
	}
	
	function disconnect()
	{
        var parametros = 
		{
                "disconnect" : true
        };
		$.ajax({
				data:  parametros,
				url:   '../system/script/function_disconnect.php',
				type:  'post',
				beforeSend: function () 
				{
					$("#resultado").fadeIn(1000);	
					$("#resultado").html("<img src='/system/style/load.gif'/>");
				},
				success:  function (response) 
				{
					$("#container").html(response);
					$("#resultado").fadeOut(1000);
				}
		});
	}
	
	function containerDisconnect()
	{
        var parametros = 
		{
                "containerDisconnect" : true
        };
		$.ajax({
				data:  parametros,
				url:   '../system/function.php',
				type:  'post',
				beforeSend: function () 
				{
						$("#resultado").html("<img src='/system/style/load.gif'/>");
				},
				success:  function (response) 
				{
						$("#container").html(response);
						setTimeout(function(){goHome()},2000);
				}
		});
	}