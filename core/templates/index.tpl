<!DOCTYPE HTML>
<html>
<head>
  <meta charset="utf-8">
  {$libs}
  <title>{$title}</title>
</head>
<body>
      {if $smarty.get.header != 'disabled'}
      {if $smarty.post.header != 'disabled'}
      <nav class="unselectable navbar navbar-default navbar-static-top navbar-inverse" role="navigation">
	  <div class="navbar-header">
	      <span class="navbar-brand" href="#">{$title}</span>
	  </div>
          {if isset($smarty.session.access)}
          <div class="collapse navbar-collapse navbar-ex1-collapse pull-right">		  
	      <a class="pull-right btn btn-primary navbar-btn" href="?logout=1"><i class="glyphicon glyphicon-off"></i> {$exit}</a>
	      <span style="margin-right:10px" class="pull-right navbar-text ulbl">{$user}: {$smarty.session.name}</span>
	  </div>
	  {/if}
      </nav>
      {/if}
      {/if}
      <div id="page" style="position:static;">
	  {if ! isset($smarty.session.access)}
    <form id="loginform" action="core/login.php" method="post"> 
	     <input class="form-control input-lg" type="text" name="login" placeholder="{$login}" /><br>
	     <input class="form-control input-lg" type="password" name="pass" placeholder="{$password}" /><br>
	     <input type="hidden" name="action" value="1">
	     <input type="submit" class="btn btn-primary btn-lg" value="{$sign_up}" />
	     <div style="margin-top:10px" id="login_msg"></div>
	</form>
    <script>
	    $(document).ready(function() { 
		var options = { 
		//target:        '#output1',   // target element(s) to be updated with server response 
		beforeSubmit:  showRequest,  // pre-submit callback 
		success:       showResponse  // post-submit callback 
		}; 
		$('#loginform').ajaxForm(options); 
	    }); 
	    function showRequest(formData, jqForm, options) { 
		    var queryString = $.param(formData); 
		    for (var i=0; i < formData.length; i++) { 
			if (!formData[i].value) { 
			show_error("{$fill_lp}", "alert alert-warning"); 
			return false; 
			} 
		    }
		    return true; 
	    } 
	    function showResponse(responseText, statusText, xhr, $form)  { 
		     if(responseText=="1")
			{
			$.get('index.php', function(data) { $('body').html(data); });
			}
		     else
			{
			show_error("{$inc_lp}", "alert alert-danger");
			}
	    } 
	    function show_error(msg, msg_class) {
		      $("#login_msg").removeClass();
		      $("#login_msg").addClass(msg_class);
		      $('#login_msg').html(msg);
		     }
    </script>
	  {else}
	    <ul id="navigate" style="margin:5px; margin-top:-15px;" class="nav nav-tabs">
	    {$panel}
	    </ul>
	    <div style="padding:10px; margin-top:-7px;" id="modules">
	    </div>
         {/if}
	 </div>
</body>
</html>