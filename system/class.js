	var firsTime = true;
	var activeFunctions = true;
	var hexcase=0;
	function hex_md5(a){return rstr2hex(rstr_md5(str2rstr_utf8(a)))}function hex_hmac_md5(a,b){return rstr2hex(rstr_hmac_md5(str2rstr_utf8(a),str2rstr_utf8(b)))}function md5_vm_test(){return hex_md5("abc").toLowerCase()=="900150983cd24fb0d6963f7d28e17f72"}function rstr_md5(a){return binl2rstr(binl_md5(rstr2binl(a),a.length*8))}function rstr_hmac_md5(c,f){var e=rstr2binl(c);if(e.length>16){e=binl_md5(e,c.length*8)}var a=Array(16),d=Array(16);for(var b=0;b<16;b++){a[b]=e[b]^909522486;d[b]=e[b]^1549556828}var g=binl_md5(a.concat(rstr2binl(f)),512+f.length*8);return binl2rstr(binl_md5(d.concat(g),512+128))}function rstr2hex(c){try{hexcase}catch(g){hexcase=0}var f=hexcase?"0123456789ABCDEF":"0123456789abcdef";var b="";var a;for(var d=0;d<c.length;d++){a=c.charCodeAt(d);b+=f.charAt((a>>>4)&15)+f.charAt(a&15)}return b}function str2rstr_utf8(c){var b="";var d=-1;var a,e;while(++d<c.length){a=c.charCodeAt(d);e=d+1<c.length?c.charCodeAt(d+1):0;if(55296<=a&&a<=56319&&56320<=e&&e<=57343){a=65536+((a&1023)<<10)+(e&1023);d++}if(a<=127){b+=String.fromCharCode(a)}else{if(a<=2047){b+=String.fromCharCode(192|((a>>>6)&31),128|(a&63))}else{if(a<=65535){b+=String.fromCharCode(224|((a>>>12)&15),128|((a>>>6)&63),128|(a&63))}else{if(a<=2097151){b+=String.fromCharCode(240|((a>>>18)&7),128|((a>>>12)&63),128|((a>>>6)&63),128|(a&63))}}}}}return b}function rstr2binl(b){var a=Array(b.length>>2);for(var c=0;c<a.length;c++){a[c]=0}for(var c=0;c<b.length*8;c+=8){a[c>>5]|=(b.charCodeAt(c/8)&255)<<(c%32)}return a}function binl2rstr(b){var a="";for(var c=0;c<b.length*32;c+=8){a+=String.fromCharCode((b[c>>5]>>>(c%32))&255)}return a}function binl_md5(p,k){p[k>>5]|=128<<((k)%32);p[(((k+64)>>>9)<<4)+14]=k;var o=1732584193;var n=-271733879;var m=-1732584194;var l=271733878;for(var g=0;g<p.length;g+=16){var j=o;var h=n;var f=m;var e=l;o=md5_ff(o,n,m,l,p[g+0],7,-680876936);l=md5_ff(l,o,n,m,p[g+1],12,-389564586);m=md5_ff(m,l,o,n,p[g+2],17,606105819);n=md5_ff(n,m,l,o,p[g+3],22,-1044525330);o=md5_ff(o,n,m,l,p[g+4],7,-176418897);l=md5_ff(l,o,n,m,p[g+5],12,1200080426);m=md5_ff(m,l,o,n,p[g+6],17,-1473231341);n=md5_ff(n,m,l,o,p[g+7],22,-45705983);o=md5_ff(o,n,m,l,p[g+8],7,1770035416);l=md5_ff(l,o,n,m,p[g+9],12,-1958414417);m=md5_ff(m,l,o,n,p[g+10],17,-42063);n=md5_ff(n,m,l,o,p[g+11],22,-1990404162);o=md5_ff(o,n,m,l,p[g+12],7,1804603682);l=md5_ff(l,o,n,m,p[g+13],12,-40341101);m=md5_ff(m,l,o,n,p[g+14],17,-1502002290);n=md5_ff(n,m,l,o,p[g+15],22,1236535329);o=md5_gg(o,n,m,l,p[g+1],5,-165796510);l=md5_gg(l,o,n,m,p[g+6],9,-1069501632);m=md5_gg(m,l,o,n,p[g+11],14,643717713);n=md5_gg(n,m,l,o,p[g+0],20,-373897302);o=md5_gg(o,n,m,l,p[g+5],5,-701558691);l=md5_gg(l,o,n,m,p[g+10],9,38016083);m=md5_gg(m,l,o,n,p[g+15],14,-660478335);n=md5_gg(n,m,l,o,p[g+4],20,-405537848);o=md5_gg(o,n,m,l,p[g+9],5,568446438);l=md5_gg(l,o,n,m,p[g+14],9,-1019803690);m=md5_gg(m,l,o,n,p[g+3],14,-187363961);n=md5_gg(n,m,l,o,p[g+8],20,1163531501);o=md5_gg(o,n,m,l,p[g+13],5,-1444681467);l=md5_gg(l,o,n,m,p[g+2],9,-51403784);m=md5_gg(m,l,o,n,p[g+7],14,1735328473);n=md5_gg(n,m,l,o,p[g+12],20,-1926607734);o=md5_hh(o,n,m,l,p[g+5],4,-378558);l=md5_hh(l,o,n,m,p[g+8],11,-2022574463);m=md5_hh(m,l,o,n,p[g+11],16,1839030562);n=md5_hh(n,m,l,o,p[g+14],23,-35309556);o=md5_hh(o,n,m,l,p[g+1],4,-1530992060);l=md5_hh(l,o,n,m,p[g+4],11,1272893353);m=md5_hh(m,l,o,n,p[g+7],16,-155497632);n=md5_hh(n,m,l,o,p[g+10],23,-1094730640);o=md5_hh(o,n,m,l,p[g+13],4,681279174);l=md5_hh(l,o,n,m,p[g+0],11,-358537222);m=md5_hh(m,l,o,n,p[g+3],16,-722521979);n=md5_hh(n,m,l,o,p[g+6],23,76029189);o=md5_hh(o,n,m,l,p[g+9],4,-640364487);l=md5_hh(l,o,n,m,p[g+12],11,-421815835);m=md5_hh(m,l,o,n,p[g+15],16,530742520);n=md5_hh(n,m,l,o,p[g+2],23,-995338651);o=md5_ii(o,n,m,l,p[g+0],6,-198630844);l=md5_ii(l,o,n,m,p[g+7],10,1126891415);m=md5_ii(m,l,o,n,p[g+14],15,-1416354905);n=md5_ii(n,m,l,o,p[g+5],21,-57434055);o=md5_ii(o,n,m,l,p[g+12],6,1700485571);l=md5_ii(l,o,n,m,p[g+3],10,-1894986606);m=md5_ii(m,l,o,n,p[g+10],15,-1051523);n=md5_ii(n,m,l,o,p[g+1],21,-2054922799);o=md5_ii(o,n,m,l,p[g+8],6,1873313359);l=md5_ii(l,o,n,m,p[g+15],10,-30611744);m=md5_ii(m,l,o,n,p[g+6],15,-1560198380);n=md5_ii(n,m,l,o,p[g+13],21,1309151649);o=md5_ii(o,n,m,l,p[g+4],6,-145523070);l=md5_ii(l,o,n,m,p[g+11],10,-1120210379);m=md5_ii(m,l,o,n,p[g+2],15,718787259);n=md5_ii(n,m,l,o,p[g+9],21,-343485551);o=safe_add(o,j);n=safe_add(n,h);m=safe_add(m,f);l=safe_add(l,e)}return Array(o,n,m,l)}function md5_cmn(h,e,d,c,g,f){return safe_add(bit_rol(safe_add(safe_add(e,h),safe_add(c,f)),g),d)}function md5_ff(g,f,k,j,e,i,h){return md5_cmn((f&k)|((~f)&j),g,f,e,i,h)}function md5_gg(g,f,k,j,e,i,h){return md5_cmn((f&j)|(k&(~j)),g,f,e,i,h)}function md5_hh(g,f,k,j,e,i,h){return md5_cmn(f^k^j,g,f,e,i,h)}function md5_ii(g,f,k,j,e,i,h){return md5_cmn(k^(f|(~j)),g,f,e,i,h)}function safe_add(a,d){var c=(a&65535)+(d&65535);var b=(a>>16)+(d>>16)+(c>>16);return(b<<16)|(c&65535)}function bit_rol(a,b){return(a<<b)|(a>>>(32-b))};
	
	function redireccionar(pagina)
	{
		setTimeout(function(){window.location=pagina},2000);
	}
	
	function goMylove(div,src,url)
	{		
		$(div).load(src,function()
		{
			if(url != "" && url != null)
				window.history.pushState(0, "Titulo", url);
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
		w2popup.close();
		goMylove('#container','../system/script/download_report.php?id='+var1.replace(/ /g,'%')+'&mail='+var2.replace(/ /g,'%')+'&type='+var3.replace(/ /g,'%')+'&reason='+var4.replace(/ /g,'%'))
	}
					
	function FilereportFile(file) 
	{
		if (!w2ui.foo) 
		{
			$().w2form({
				name: 'FileReport',
				style: 'border: 0px; background-color: transparent;',
				formHTML:
					'<center>'+
					'<div class="w2ui-page page-0" style="width:90%">'+
					'    <div class="w2ui-field" style="margin-bottom:5px">'+
					'           <input name="file_mail" type="text" value="" style="width:90%"/>'+
					'    </div>'+
					'    <div class="w2ui-field" style="margin-bottom:5px">'+
					'			<select name="file_type" style="width:90%">'+
					'				<option>Copyright</option>'+
					'				<option>Contenido Inadecuado</option>'+
					'			</select>'+
					'    </div>'+
					'    <div class="w2ui-field" style="margin-bottom:5px">'+
					'            <textarea name="file_reason" cols="10" rows="1" id="razon" style="width:90%; height: 100px;">Razon...</textarea>'+
					'    </div>'+
					'</div>'+
					'<div class="w2ui-buttons">'+
					'    <button class="btn" name="reset">Reset</button>'+
					'    <button class="btn" name="reportar">Reportar</button>'+
					'</div>'+
					'</center>',
				fields: [
					{ field: 'file_mail', type: 'password' },
					{ field: 'file_type', type: 'password' },
					{ field: 'file_reason', type: 'password' },
				],
				record: { 
					file_mail : 'Su Correo Electronico',
					file_type : '',
					file_reason  : 'Razon...'
				},
				actions: {
					"reset": function () { this.clear(); },
					"reportar": function () { reportFile(file,$('#file_mail').val(),$('#file_type').val(),$('#file_reason').val()) },
				}
			});
		}
		$().w2popup('open', {
			title   : 'Reportar Archivo',
			body    : '<div id="form" style="width: 100%; height: 100%;"></div>',
			style   : 'padding: 15px 0px 0px 0px',
			width   : 25,
			height  : 30, 
			showMax : true,
			onToggle: function (event) {
				$(w2ui.FileReport.box).hide();
				event.onComplete = function () {
					$(w2ui.FileReport.box).show();
					w2ui.FileReport.resize();
				}
			},
			onOpen: function (event) {
				event.onComplete = function () {
					// specifying an onOpen handler instead is equivalent to specifying an onBeforeOpen handler, which would make this code execute too early and hence not deliver.
					$('#w2ui-popup #form').w2render('FileReport');
				}
			}
		});
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
	
	function userChangePass() 
	{
		if (!w2ui.foo) 
		{
			$().w2form({
				name: 'changepass',
				style: 'border: 0px; background-color: transparent;',
				formHTML:
					'<center>'+
					'<div class="w2ui-page page-0" style="width:90%">'+
					'    <div class="w2ui-field">'+
					'        <label>Nueva Contrase&ntilde;a:</label>'+
					'        <div>'+
					'           <input name="oldpass_user" type="password" maxlength="20" style="width: 90%"/>'+
					'        </div>'+
					'    </div>'+
					'    <div class="w2ui-field">'+
					'        <label>Nueva Contrase&ntilde;a:</label>'+
					'        <div>'+
					'            <input name="newpass_user" type="password" maxlength="20" style="width: 90%"/>'+
					'        </div>'+
					'    </div>'+
					'    <div class="w2ui-field">'+
					'        <label>Repetir Contrase&ntilde;a:</label>'+
					'        <div>'+
					'            <input name="repass_user" type="password" maxlength="20" style="width: 90%"/>'+
					'        </div>'+
					'    </div>'+
					'</div>'+
					'<div class="w2ui-buttons">'+
					'    <button class="btn" name="reset">Reset</button>'+
					'    <button class="btn" name="cambiar">Cambiar</button>'+
					'</div>'+
					'</center>',
				fields: [
					{ field: 'oldpass_user', type: 'password' },
					{ field: 'newpass_user', type: 'password' },
					{ field: 'repass_user', type: 'password' },
				],
				record: { 
					oldpass_user : '',
					newpass_user : '',
					repass_user  : ''
				},
				actions: {
					"reset": function () { this.clear(); },
					"cambiar": function () { changepass($('#oldpass_user').val(),$('#newpass_user').val(),$('#repass_user').val()) },
				}
			});
		}
		$().w2popup('open', {
			title   : 'Cambiar Contrase&ntilde;a',
			body    : '<div id="form" style="width: 100%; height: 100%;"></div>',
			style   : 'padding: 15px 0px 0px 0px',
			width   : 25,
			height  : 25, 
			showMax : true,
			onToggle: function (event) {
				$(w2ui.changepass.box).hide();
				event.onComplete = function () {
					$(w2ui.changepass.box).show();
					w2ui.changepass.resize();
				}
			},
			onOpen: function (event) {
				event.onComplete = function () {
					// specifying an onOpen handler instead is equivalent to specifying an onBeforeOpen handler, which would make this code execute too early and hence not deliver.
					$('#w2ui-popup #form').w2render('changepass');
				}
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
	
	function userChangeEmail() 
	{
		if (!w2ui.foo) 
		{
			$().w2form({
				name: 'changemail',
				style: 'border: 0px; background-color: transparent;',
				formHTML:
					'<center>'+
					'<div class="w2ui-page page-0" style="width:90%">'+
					'    <div class="w2ui-field">'+
					'        <label>Nuevo Correo:</label>'+
					'        <div>'+
					'           <input name="mail_user" type="email" maxlength="20" style="width: 90%"/>'+
					'        </div>'+
					'    </div>'+
					'</div>'+
					'<div class="w2ui-buttons">'+
					'    <button class="btn" name="reset">Reset</button>'+
					'    <button class="btn" name="cambiar">Cambiar</button>'+
					'</div>'+
					'</center>',
				fields: [
					{ field: 'mail_user', type: 'email' },
				],
				record: { 
					mail_user : '',
				},
				actions: {
					"reset": function () { this.clear(); },
					"cambiar": function () { changemail($('#mail_user').val()) },
				}
			});
		}
		$().w2popup('open', {
			title   : 'Cambiar Correo Electr&oacute;nico',
			body    : '<div id="form" style="width: 100%; height: 100%;"></div>',
			style   : 'padding: 15px 0px 0px 0px',
			width   : 25,
			height  : 18, 
			showMax : true,
			onToggle: function (event) {
				$(w2ui.changemail.box).hide();
				event.onComplete = function () {
					$(w2ui.changemail.box).show();
					w2ui.changemail.resize();
				}
			},
			onOpen: function (event) {
				event.onComplete = function () {
					// specifying an onOpen handler instead is equivalent to specifying an onBeforeOpen handler, which would make this code execute too early and hence not deliver.
					$('#w2ui-popup #form').w2render('changemail');
				}
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
					goMylove('#filename_'+var1,'../system/script/panel_filename.php?id='+var1);
					w2popup.close();
                }
        });
	}
	
	function FileChangeFileName(file) 
	{
		if (!w2ui.foo) 
		{
			$().w2form({
				name: 'changename'+file,
				style: 'border: 0px; background-color: transparent;',
				formHTML:
					'<center>'+
					'<div class="w2ui-page page-0" style="width:90%">'+
					'    <div class="w2ui-field">'+
					'        <label>Nuevo Nombre:</label>'+
					'        <div>'+							
					'			<textarea id="id_filename_'+file+'" type="hidden" readonly="readonly" style="display:none">'+file+'</textarea>'+
					'           <input id="name_filename_'+file+'" type="text" style="width:170px" maxlength="22" />'+
					'        </div>'+
					'    </div>'+
					'</div>'+
					'<div class="w2ui-buttons">'+
					'    <button class="btn" name="reset">Reset</button>'+
					'    <button class="btn" name="cambiar">Cambiar</button>'+
					'</div>'+
					'</center>',
				fields: [
					{ field: 'name_filename_'+file, type: 'text' },
				],
				actions: {
					"reset": function () { this.clear(); },
					"cambiar": function () { changefilename($('#id_filename_'+file).val(),$('#name_filename_'+file).val()) },
				}
			});
		}
		$().w2popup('open', {
			title   : 'Cambiar Nombre',
			body    : '<div id="form" style="width: 100%; height: 100%;"></div>',
			style   : 'padding: 15px 0px 0px 0px',
			width   : 25,
			height  : 18, 
			showMax : true,
			onToggle: function (event) {
				$(w2ui.changename+file.box).hide();
				event.onComplete = function () {
					$(w2ui.changename+file.box).show();
					w2ui.changename+file.resize();
				}
			},
			onOpen: function (event) {
				event.onComplete = function () {
					// specifying an onOpen handler instead is equivalent to specifying an onBeforeOpen handler, which would make this code execute too early and hence not deliver.
					$('#w2ui-popup #form').w2render('changename'+file);
				}
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
					w2popup.close();
					$("#resultado").fadeIn(1000);	
					$("#resultado").html("<img src='/system/style/load.gif'></img>");
				},
                success:  function (response) 
				{
					$("#temporal_message").fadeIn(1000);
					$("#temporal_message").html('<div class="Blanco border-round" style="visibility: display; height: auto; width: 250px; margin-top: 40px; padding: 20px 0px 20px 0px; color: #006699;">'+response+'</div>');
					$("#resultado").fadeOut(1000);
					$("#temporal_message").fadeOut(2000);
					setTimeout(function () { goMylove('#container','/system/class/panel.php?id='+var2); }, 2000);
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
	
	function animateprogress (id, val)
	{
		var getRequestAnimationFrame = function () {  /* <------- Declaro getRequestAnimationFrame intentando obtener la máxima compatibilidad con todos los navegadores */
			return window.requestAnimationFrame ||
			window.webkitRequestAnimationFrame ||   
			window.mozRequestAnimationFrame ||
			window.oRequestAnimationFrame ||
			window.msRequestAnimationFrame ||
			function ( callback ){
				window.setTimeout(enroute, 1 / 60 * 1000);
			};
			
		};
		
		var fpAnimationFrame = getRequestAnimationFrame();   
		var i = 0;
		var animacion = function () {
				
		if (i<=val) 
			{
				document.querySelector(id).setAttribute("value",i);      /* <----  Incremento el valor de la barra de progreso */
				//document.querySelector(id+"+ span").innerHTML = i+"%";     /* <---- Incremento el porcentaje y lo muestro en la etiqueta span */
				i++;
				fpAnimationFrame(animacion);          /* <------------------ Mientras que el contador no llega al porcentaje fijado la función vuelve a llamarse con fpAnimationFrame     */
			}
											
		}

			fpAnimationFrame(animacion);   /*  <---- Llamo la función animación por primera vez usando fpAnimationFrame para que se ejecute a 60fps  */
					
	}