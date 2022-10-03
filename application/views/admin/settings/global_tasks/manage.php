<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<div class="_buttons">
							<a href="#" onclick="new_task(); return false;" class="btn btn-info pull-left display-block"><?php echo _l('new_global_tasks'); ?></a>
						</div>
						<div class="clearfix"></div>
						<hr class="hr-panel-heading" />
						<?php if(count($global_tasks) > 0){ ?>

						<table class="table dt-table">
							<thead>
								<th><?php echo _l('id'); ?></th>
								<th><?php echo _l('global_tasks_dt_name'); ?></th>
								<th><?php echo _l('options'); ?></th>
							</thead>
							<tbody>
								<?php foreach($global_tasks as $task){ ?>
								<tr>
									<td><?php echo $task['id']; ?></td>
									<td><a href="#" onclick="edit_task(this,<?php echo $task['id']; ?>);return false;" data-name="<?php echo $task['name']; ?>"><?php echo $task['name']; ?></a></td>
									<td>
										<a href="#" onclick="edit_task(this,<?php echo $task['id']; ?>); return false" data-name="<?php echo $task['name']; ?>" class="btn btn-default btn-icon"><i class="fa fa-pencil-square-o"></i></a>
										<a href="<?php echo admin_url('global_tasks/delete/'.$task['id']); ?>" class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
						<?php } else { ?>
						<p class="no-margin"><?php echo _l('no_ticket_priorities_found'); ?></p>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="mdl_global_task" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<?php echo form_open(admin_url('global_tasks/add')); ?>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">
					<span class="edit-title"><?php echo _l('global_tasks_edit'); ?></span>
					<span class="add-title"><?php echo _l('global_tasks_add'); ?></span>
				</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div id="additional"></div>
						<?php echo render_input('name','global_tasks_add_edit_name'); ?>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
				<button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
			</div>
		</div><!-- /.modal-content -->
		<?php echo form_close(); ?>
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php init_tail(); ?>
<script>
	$(function(){
		appValidateForm($('form'),{ name:'required' },manage_global_task);
		$('#mdl_global_task').on('hidden.bs.modal', function(event) {
			$('#additional').html('');
			$('#mdl_global_task input[name="name"]').val('');
			$('.add-title').removeClass('hide');
			$('.edit-title').removeClass('hide');
		});
	});
	function manage_global_task(form) {
		var data = $(form).serialize();
		var url = form.action;
		$.post(url, data).done(function(response) {
			window.location.reload();
		});
		return false;
	}
	function new_task(){
		$('#mdl_global_task').modal('show');
		$('.edit-title').addClass('hide');
	}
	function edit_task(invoker,id){
		var name = $(invoker).data('name');
		$('#additional').append(hidden_input('id',id));
		$('#mdl_global_task input[name="name"]').val(name);
		$('#mdl_global_task').modal('show');
		$('.add-title').addClass('hide');
	}
</script>
</body>
</html>
