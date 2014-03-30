<script type="text/javascript">
	var Prepare = {
    dialog: function(id, title, body, footer) {
		{strip}
		return '<div class="modal fade" id="'+ id +'" tabindex="-1" role="dialog" aria-labelledby="'+ id +'Label" aria-hidden="true">
				<div class="modal-dialog">
				<div class="modal-content">
				     <div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					  <h5 id="' + id + 'Label">' + title + '</h5>
				     </div>
					<div class="modal-body">' + body + '</div>
					<div class="modal-footer">' + footer + '</div>
				</div>
			    </div>
			</div>';
		{/strip}
	    }
    };
</script>