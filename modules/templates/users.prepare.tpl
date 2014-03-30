{include file='prepare.dialog.class.tpl'}
{literal}
var parser='';
//основные сведения о пользователе
var user_gener = {'name':['col-xs-2', '', 'Фамилия', 'form-control', 'text', ''],
	      		  'surname':['col-xs-2', 'margin-left:-20px;', 'Имя', 'form-control', 'text', ''],
	      		  'patronymic':['col-xs-2', 'margin-left:-20px; width:245px;', 'Отчество', 'form-control', 'text', ''],
	      		  'birthday':['col-xs-2', 'margin-left:-20px;', 'Дата рожд.', 'form-control', 'text', 'datepicker'],
				  'tin':['col-xs-2', 'margin-left:-20px;', 'ИНН', 'form-control', 'text', '']};
//сведения о локации пользователя
var user_loc = {'country':['col-xs-2', '', 'Страна', 'form-control', 'text', ''],
	      		'city':['col-md-2', '', 'Область', 'form-control', 'text', ''],
	      		'town':['col-md-2', '', 'Район', 'form-control', 'text', ''],
	      		'hometown':['col-md-2', '', 'Город', 'form-control', 'text', 'datepicker'],
	      		'street':['col-md-2', '', 'Ул/дом/кв', 'form-control', 'text', ''],
	      		'zip':['col-md-2', '', 'Индекс', 'form-control', 'text', '']};
var user_pass = {'country':['col-md-4', '', 'Серия, номер', 'form-control', 'text', ''],
	      		 'statins':['col-md-5', '', 'Орган выдачи', 'form-control', 'text', ''],
	      	 	 'date':['col-md-3', '', 'Дата выдачи', 'form-control', 'text', '']};
var log_pass = {'login':['col-md-6', '', 'логин', 'form-control', 'text', ''],
	      		'pass':['col-md-6', '', 'пароль', 'form-control', 'password', '']};
{/literal}
{strip}
add_user_win_body='<form onkeyup="test_fill();" id="myForm">
			<div class="row" style="margin-bottom:5px;">'
		 		+ Prepare.inputs(user_gener) +'
		 		<div class="col-xs-2" style="margin-left:-20px;">
				<select class="form-control">
					<option>мужской</option>
					<option>женский</option>
				</select>
			</div>
			</div>
			<div class="row" style="margin-bottom:5px;">'
				+ Prepare.inputs(user_loc) + '
			</div>
			<div class="row" style="margin-bottom:5px;">'
				+ Prepare.inputs(user_pass) +'
			</div>
			<div class="row" style="margin-bottom:5px;">'
				+ Prepare.inputs(log_pass) +'
			</div>
			<textarea name="other" class="form-control" rows="3" placeholder="дополнительная информация">
			</textarea>
		</form>';
add_user_win_footer='<button class="btn btn-danger pull-left" data-dismiss="modal" id="del_btn">Удалить аккаунт</button>
					 <button class="btn" data-dismiss="modal" aria-hidden="true">Отменить</button>
					 <button id="save" data-dismiss="modal" class="btn btn-primary">Сохранить изменения</button>';
privilegies_body='<table id="privileges" class="table table-bordered">
               				<thead>
                 					<tr>
                   						<th>{$group}</th>
                  						<th>{$privileges}</th>
		  								<th>{$operations}</th>
                					</tr>
              				</thead>
              				<tbody>
              						$groups_access
              				</tbody>
	      			  </table>';
privileges_footer='<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">{$cancel}</button>
	 				   <button id="add_group" class="btn btn-primary">$add_group</button>';
{/strip}
$('body').prepend(Prepare.dialog("add_user_win", 'Новый пользователь [ ' +$.cookie("user_access")+ ' ]', add_user_win_body, add_user_win_footer));
$('body').prepend(Prepare.dialog("access_window", "{$groups_and_privileges}", privilegies_body, privileges_footer));
//$("#myForm").prepend(parser + '</div>');