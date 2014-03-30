<script>
	 
				  
	function go_to_lesson(id) {
		 $.post('modules/plan.mod.php', { theme_id: id }).done(function(data) { $('#modules').html(data); });
				  }
	function go_to_course(course_id) {
		 $.post('modules/plan.mod.php', { course_id: course_id }).done(function(data) { $('#modules').html(data); });
}
</script>
{$html}
<ol class="breadcrumb unselectable">
   {$bc}
</ol>
<table class="table table-bordered table-hover">
      <thead>
	    <tr>
		{$thead1}
		{if isset($smarty.post.course_id) }
		{else}
		<th rowspan="2" style="width:16%">{$lang.caption}</th>
		<th rowspan="2" style="width:16%">{$lang.author}</th>
		<th colspan="{$type_of_work_table_count+1}" style="width:16%">{$lang.summary}</th>
		<th colspan="3" style="width:16%">{$lang.date}</th>
		<th rowspan="2" style="width:16%" >{$lang.apply}</th>
		<th rowspan="2" style="width:16%">{$lang.comment}</th>
		</tr>
		<tr>
		{/if}
		{foreach from=$type_of_work item=i}
		<th style="width:2%" title="{$i.caption}">{$i.abbr}</th>
		{/foreach}
		<th>&#931;</th>
		{$thead2}
	    </tr>
      </thead>
      <tbody>
	    {$tbody}
      </tbody>
</table>