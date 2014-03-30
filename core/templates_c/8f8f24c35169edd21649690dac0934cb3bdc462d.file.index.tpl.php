<?php /* Smarty version Smarty-3.1-DEV, created on 2014-03-30 16:17:58
         compiled from "core/templates/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1215079232533843b66680e3-86205480%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8f8f24c35169edd21649690dac0934cb3bdc462d' => 
    array (
      0 => 'core/templates/index.tpl',
      1 => 1394302444,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1215079232533843b66680e3-86205480',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'libs' => 0,
    'title' => 0,
    'exit' => 0,
    'user' => 0,
    'login' => 0,
    'password' => 0,
    'sign_up' => 0,
    'fill_lp' => 0,
    'inc_lp' => 0,
    'panel' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1-DEV',
  'unifunc' => 'content_533843b71e7b98_71723824',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_533843b71e7b98_71723824')) {function content_533843b71e7b98_71723824($_smarty_tpl) {?><!DOCTYPE HTML>
<html>
<head>
  <meta charset="utf-8">
  <?php echo $_smarty_tpl->tpl_vars['libs']->value;?>

  <title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
</head>
<body>
      <?php if ($_GET['header']!='disabled'){?>
      <?php if ($_POST['header']!='disabled'){?>
      <nav class="unselectable navbar navbar-default navbar-static-top navbar-inverse" role="navigation">
	  <div class="navbar-header">
	      <span class="navbar-brand" href="#"><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</span>
	  </div>
          <?php if (isset($_SESSION['access'])){?>
          <div class="collapse navbar-collapse navbar-ex1-collapse pull-right">		  
	      <a class="pull-right btn btn-primary navbar-btn" href="?logout=1"><i class="glyphicon glyphicon-off"></i> <?php echo $_smarty_tpl->tpl_vars['exit']->value;?>
</a>
	      <span style="margin-right:10px" class="pull-right navbar-text ulbl"><?php echo $_smarty_tpl->tpl_vars['user']->value;?>
: <?php echo $_SESSION['name'];?>
</span>
	  </div>
	  <?php }?>
      </nav>
      <?php }?>
      <?php }?>
      <div id="page" style="position:static;">
	  <?php if (!isset($_SESSION['access'])){?>
    <form id="loginform" action="core/login.php" method="post"> 
	     <input class="form-control input-lg" type="text" name="login" placeholder="<?php echo $_smarty_tpl->tpl_vars['login']->value;?>
" /><br>
	     <input class="form-control input-lg" type="password" name="pass" placeholder="<?php echo $_smarty_tpl->tpl_vars['password']->value;?>
" /><br>
	     <input type="hidden" name="action" value="1">
	     <input type="submit" class="btn btn-primary btn-lg" value="<?php echo $_smarty_tpl->tpl_vars['sign_up']->value;?>
" />
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
			show_error("<?php echo $_smarty_tpl->tpl_vars['fill_lp']->value;?>
", "alert alert-warning"); 
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
			show_error("<?php echo $_smarty_tpl->tpl_vars['inc_lp']->value;?>
", "alert alert-danger");
			}
	    } 
	    function show_error(msg, msg_class) {
		      $("#login_msg").removeClass();
		      $("#login_msg").addClass(msg_class);
		      $('#login_msg').html(msg);
		     }
    </script>
	  <?php }else{ ?>
	    <ul id="navigate" style="margin:5px; margin-top:-15px;" class="nav nav-tabs">
	    <?php echo $_smarty_tpl->tpl_vars['panel']->value;?>

	    </ul>
	    <div style="padding:10px; margin-top:-7px;" id="modules">
	    </div>
         <?php }?>
	 </div>
</body>
</html><?php }} ?>