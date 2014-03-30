{include file='prepare.dialog.class.tpl'}
add_group_body='{strip}
	<form id="group_add" action="modules/groups.mod.php" method="post"> 
    	<input type="hidden" name="act" value="new_group" />
		<div style="margin-bottom:5px" class="row">
    		<div class="col-md-4">
				<input name="group_abbr" class="form-control" placeholder="{$lang.dialog_group_abbr}" type="text">
			</div>
			<div class="col-md-4">
				<input name="qualification" class="form-control" placeholder="{$lang.qualification}" type="text">
	    	</div>
	    	<div class="col-md-4">
				<input name="foe" class="form-control" placeholder="{$lang.foef}" type="text">
	    	</div>
	    </div>
	   	<input style="margin-bottom:5px" name="group_comment" placeholder="{$lang.dialog_group_comment}" class="form-control col-xs-6" type="text">
	   	<input style="margin-bottom:5px" name="spec" placeholder="{$lang.spec}" class="form-control col-xs-6" type="text">
	  	<div style="margin-top:5px" class="row">
	    	<div class="input-group col-xs-6">
				<span class="input-group-addon">{$lang.start}:</span>
				<input name="group_start" type="text" class="form-control datepicker">
	    	</div>
	    	<div class="input-group col-xs-6">
				<span class="input-group-addon">{$lang.end}:</span>
				<input name="group_end" type="text" class="form-control datepicker">
		   	</div>
		</div>
	</form>     
	{/strip}';
add_group_footer='<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancel</button><button id="add_group" onclick="$(\'#group_add\').submit();" class="btn btn-primary">{$lang.dialog_button}</button>';
add_student_body='{strip}
	<form id="add_student_form" action="modules/groups.mod.php" method="post">
		<input name="act" value="add_student" type="hidden" class="form-control">
		<input name="group" type="hidden" class="form-control">
		<input name="login" type="text" class="form-control">
	</form>
	{/strip}';
add_student_footer='{strip}<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancel</button><button id="add_group" onclick="$(\'#add_student_form\').submit();" class="btn btn-primary">{$lang.dialog_button}</button>{/strip}';
$('#modules').prepend(Prepare.dialog("window", "{$lang.new_group}", add_group_body, add_group_footer));
$('#modules').prepend(Prepare.dialog("add_student_window", "{$lang.add_student}", add_student_body, add_student_footer));