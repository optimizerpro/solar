<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<?php
			echo form_open($this->uri->uri_string(),array('id'=>'estimate-form','class'=>'_transaction_form'));
			if(isset($estimate)){
				echo form_hidden('isedit');
			}
			?>
			<div class="col-md-12">
				<?php $this->load->view('admin/estimates/estimate_template'); ?>
			</div>
			<?php echo form_close(); ?>
			<?php $this->load->view('admin/invoice_items/item'); ?>
		</div>
	</div>
</div>
</div>
<?php init_tail(); ?>
<script>
	$(function(){
		validate_estimate_form();
		// Init accountacy currency symbol
		init_currency();
		// Project ajax search
		init_ajax_project_search_by_customer_id();
		// Maybe items ajax search
	    init_ajax_search('items','#item_select.ajax-search',undefined,admin_url+'items/search');
	});
</script>

<script>
var _rel_id = $('#rel_id'),
_rel_type = $('#rel_type'),
_rel_id_wrapper = $('#rel_id_wrapper'),
_project_wrapper = $('.projects-wrapper'),
data = {};
<?php if (isset($estimate) && $estimate->rel_type === 'customer') { ?>
init_proposal_project_select('select#project_id')
<?php } ?>
$('body').on('change','#rel_type', function() {
   if (_rel_type.val() != 'customer') {
        _project_wrapper.addClass('hide')
   }
});

$('body').on('change','#rel_id', function() {
   if (_rel_type.val() == 'customer') {
       console.log('working')
       var projectAjax = $('select#project_id');
       var clonedProjectsAjaxSearchSelect = projectAjax.html('').clone();
       projectAjax.selectpicker('destroy').remove();
       projectAjax = clonedProjectsAjaxSearchSelect;
       $('#project_ajax_search_wrapper').append(clonedProjectsAjaxSearchSelect);
       init_proposal_project_select(projectAjax);
       _project_wrapper.removeClass('hide')
   }
});
$('.rel_id_label').html(_rel_type.find('option:selected').text());
_rel_type.on('change', function() {
  var clonedSelect = _rel_id.html('').clone();
  _rel_id.selectpicker('destroy').remove();
  _rel_id = clonedSelect;
  $('#rel_id_select').append(clonedSelect);
  proposal_rel_id_select();
  if($(this).val() != ''){
    _rel_id_wrapper.removeClass('hide');
  } else {
    _rel_id_wrapper.addClass('hide');
  }
  $('.rel_id_label').html(_rel_type.find('option:selected').text());
});
proposal_rel_id_select();
<?php 
$rel_type = '';
$rel_id = '';
if(isset($estimate) || ($this->input->get('rel_id') && $this->input->get('rel_type'))){
 if($this->input->get('rel_id')){
   $rel_id = $this->input->get('rel_id');
   $rel_type = $this->input->get('rel_type');
 } else {
   $rel_id = $estimate->rel_id;
   $rel_type = $estimate->rel_type;
 }
}
if(!isset($estimate) && $rel_id && $rel_id != ''){ ?>
_rel_id.change();
<?php } ?>
$('body').on('change','#rel_id', function() {
 if($(this).val() != ''){
  $.get(admin_url + 'proposals/get_relation_data_values/' + $(this).val() + '/' + _rel_type.val(), function(response) {
    $('input[name="estimate_to"]').val(response.to);
    var currency_selector = $('#currency');
    if(_rel_type.val() == 'customer'){
      if(typeof(currency_selector.attr('multi-currency')) == 'undefined'){
        currency_selector.attr('disabled',true);
      }

     } else {
       currency_selector.attr('disabled',false);
    }
   /* Check if customer default currency is passed */
   if(response.currency){
     currency_selector.selectpicker('val',response.currency);
   } else {
    /* Revert back to base currency */
    currency_selector.selectpicker('val',currency_selector.data('base'));
  }
  currency_selector.selectpicker('refresh');
  currency_selector.change();
}, 'json');
}
});
function init_proposal_project_select(selector) {
   init_ajax_search('project', selector, {
       customer_id: function () {
           return $('#rel_id').val();
       }
   })
}
function proposal_rel_id_select(){
  var serverData = {};
  serverData.rel_id = _rel_id.val();
  data.type = _rel_type.val();
  init_ajax_search(_rel_type.val(),_rel_id,serverData);
}
</script>
</body>
</html>
