<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
   <?php echo form_hidden('project_id',$project->id) ?>
   <div class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="panel_s project-top-panel panel-full">
               <div class="panel-body _buttons">
                  <div class="row">
                     <div class="col-md-7 project-heading">
                        <h3 class="hide project-name"><?php echo $project->name; ?></h3>
                        <div id="project_view_name" class="pull-left">
                           <select class="selectpicker" id="project_top" data-width="100%"<?php if(count($other_projects) > 6){ ?> data-live-search="true" <?php } ?>>
                              <option value="<?php echo $project->id; ?>" selected data-content="<?php echo $project->name; ?> - <small><?php echo $project->client_data->company; ?></small>">
                                <?php echo $project->client_data->company; ?> <?php echo $project->name; ?>
                              </option>
                              <?php foreach($other_projects as $op){ ?>
                              <option value="<?php echo $op['id']; ?>" data-subtext="<?php echo $op['company']; ?>">#<?php echo $op['id']; ?> - <?php echo $op['name']; ?></option>
                              <?php } ?>
                           </select>
                        </div>
                        <div class="visible-xs">
                           <div class="clearfix"></div>
                        </div>
                        <?php echo '<div class="label pull-left mleft15 mtop8 p8 project-status-label-'.$project->status.'" style="background:'.$project_status['color'].'">'.$project_status['name'].'</div>'; ?>
                     </div>
                     <div class="col-md-5 text-right">
                        <?php if(has_permission('tasks','','create')){ ?>
                        <a href="#" onclick="new_task_from_relation(undefined,'project',<?php echo $project->id; ?>); return false;" class="btn btn-info"><?php echo _l('new_task'); ?></a>
                        <?php } ?>
                        <?php
                           $invoice_func = 'pre_invoice_project';
                           ?>
                        <?php if(has_permission('invoices','','create')){ ?>
                        <a href="#" onclick="<?php echo $invoice_func; ?>(<?php echo $project->id; ?>); return false;" class="invoice-project btn btn-info<?php if($project->client_data->active == 0){echo ' disabled';} ?>"><?php echo _l('invoice_project'); ?></a>
                        <?php } ?>
                        <?php
                           $project_pin_tooltip = _l('pin_project');
                           if(total_rows(db_prefix().'pinned_projects',array('staff_id'=>get_staff_user_id(),'project_id'=>$project->id)) > 0){
                             $project_pin_tooltip = _l('unpin_project');
                           }
                           ?>
                        <div class="btn-group">
                           <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           <?php echo _l('more'); ?> <span class="caret"></span>
                           </button>
                           <ul class="dropdown-menu dropdown-menu-right width200 project-actions">
                              <li>
                                 <a href="<?php echo admin_url('projects/pin_action/'.$project->id); ?>">
                                 <?php echo $project_pin_tooltip; ?>
                                 </a>
                              </li>
                              <?php if(has_permission('projects','','edit')){ ?>
                              <li>
                                 <a href="<?php echo admin_url('projects/project/'.$project->id); ?>">
                                 <?php echo _l('edit_project'); ?>
                                 </a>
                              </li>
                              <?php } ?>
                              <?php if(has_permission('projects','','create')){ ?>
                              <li>
                                 <a href="#" onclick="copy_project(); return false;">
                                 <?php echo _l('copy_project'); ?>
                                 </a>
                              </li>
                              <?php } ?>
                              <?php if(has_permission('projects','','create') || has_permission('projects','','edit')){ ?>
                              <li class="divider"></li>
                              <?php foreach($statuses as $status){
                                 if($status['id'] == $project->status){continue;}
                                 ?>
                              <li>
                                 <a href="#" data-name="<?php echo _l('project_status_'.$status['id']); ?>" onclick="project_mark_as_modal(<?php echo $status['id']; ?>,<?php echo $project->id; ?>, this); return false;"><?php echo _l('project_mark_as',$status['name']); ?></a>
                              </li>
                              <?php } ?>
                              <?php } ?>
                              <li class="divider"></li>
                              <?php if(has_permission('projects','','create')){ ?>
                              <li>
                                 <a href="<?php echo admin_url('projects/export_project_data/'.$project->id); ?>" target="_blank"><?php echo _l('export_project_data'); ?></a>
                              </li>
                              <?php } ?>
                              <?php if(is_admin()){ ?>
                              <li>
                                 <a href="<?php echo admin_url('projects/view_project_as_client/'.$project->id .'/'.$project->clientid); ?>" target="_blank"><?php echo _l('project_view_as_client'); ?></a>
                              </li>
                              <?php } ?>
                              <?php if(has_permission('projects','','delete')){ ?>
                              <li>
                                 <a href="<?php echo admin_url('projects/delete/'.$project->id); ?>" class="_delete">
                                 <span class="text-danger"><?php echo _l('delete_project'); ?></span>
                                 </a>
                              </li>
                              <?php } ?>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="panel_s project-menu-panel">
               <div class="panel-body">
                  <?php hooks()->do_action('before_render_project_view', $project->id); ?>
                  <?php $this->load->view('admin/projects/project_tabs'); ?>
               </div>
            </div>
            <?php
               if((has_permission('projects','','create') || has_permission('projects','','edit'))
                 && $project->status == 1
                 && $this->projects_model->timers_started_for_project($project->id)
                 && $tab['slug'] != 'project_milestones') {
               ?>
            <div class="alert alert-warning project-no-started-timers-found mbot15">
               <?php echo _l('project_not_started_status_tasks_timers_found'); ?>
            </div>
            <?php } ?>
            <?php
               if($project->deadline && date('Y-m-d') > $project->deadline
                && $project->status == 2
                && $tab['slug'] != 'project_milestones') {
               ?>
            <div class="alert alert-warning bold project-due-notice mbot15">
               <?php echo _l('project_due_notice', floor((abs(time() - strtotime($project->deadline)))/(60*60*24))); ?>
            </div>
            <?php } ?>
            <?php
               if(!has_contact_permission('projects',get_primary_contact_user_id($project->clientid))
                 && total_rows(db_prefix().'contacts',array('userid'=>$project->clientid)) > 0
                 && $tab['slug'] != 'project_milestones') {
               ?>
            <div class="alert alert-warning project-permissions-warning mbot15">
               <?php echo _l('project_customer_permission_warning'); ?>
            </div>
            <?php } ?>
            <div class="panel_s">
               <div class="panel-body">
                  <?php $this->load->view(($tab ? $tab['view'] : 'admin/projects/project_overview')); ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
</div>
<?php if(isset($discussion)){
   echo form_hidden('discussion_id',$discussion->id);
   echo form_hidden('discussion_user_profile_image_url',$discussion_user_profile_image_url);
   echo form_hidden('current_user_is_admin',$current_user_is_admin);
   }
   echo form_hidden('project_percent',$percent);
   ?>
<div id="invoice_project"></div>
<div id="pre_invoice_project"></div>
<?php $this->load->view('admin/projects/milestone'); ?>
<?php $this->load->view('admin/projects/copy_settings'); ?>
<?php $this->load->view('admin/projects/_mark_tasks_finished'); ?>
<?php init_tail(); ?>
<!-- For invoices table -->
<script>
   taskid = '<?php echo $this->input->get('taskid'); ?>';
</script>
<script>
   var gantt_data = {};
   <?php if(isset($gantt_data)){ ?>
   gantt_data = <?php echo json_encode($gantt_data); ?>;
   <?php } ?>
   var discussion_id = $('input[name="discussion_id"]').val();
   var discussion_user_profile_image_url = $('input[name="discussion_user_profile_image_url"]').val();
   var current_user_is_admin = $('input[name="current_user_is_admin"]').val();
   var project_id = $('input[name="project_id"]').val();
   if(typeof(discussion_id) != 'undefined'){
     discussion_comments('#discussion-comments',discussion_id,'regular');
   }
   $(function(){
    var project_progress_color = '<?php echo hooks()->apply_filters('admin_project_progress_color','#84c529'); ?>';
    var circle = $('.project-progress').circleProgress({fill: {
     gradient: [project_progress_color, project_progress_color]
   }}).on('circle-animation-progress', function(event, progress, stepValue) {
     $(this).find('strong.project-percent').html(parseInt(100 * stepValue) + '<i>%</i>');
   });
   });

   function discussion_comments(selector,discussion_id,discussion_type){
     var defaults = _get_jquery_comments_default_config(<?php echo json_encode(get_project_discussions_language_array()); ?>);
     var options = {
      // https://github.com/Viima/jquery-comments/pull/169
      wysiwyg_editor: {
            opts: {
                enable: true,
                is_html: true,
                container_id: 'editor-container',
                comment_index: 0,
            },
            init: function (textarea, content) {
                var comment_index = textarea.data('comment_index');
                 var editorConfig = _simple_editor_config();
                 editorConfig.setup = function(ed) {
                      textarea.data('wysiwyg_editor', ed);

                      ed.on('change', function() {
                          var value = ed.getContent();
                          if (value !== ed._lastChange) {
                            ed._lastChange = value;
                            textarea.trigger('change');
                          }
                      });

                      ed.on('keyup', function() {
                        var value = ed.getContent();
                          if (value !== ed._lastChange) {
                            ed._lastChange = value;
                            textarea.trigger('change');
                          }
                      });

                      ed.on('Focus', function (e) {
                        setTimeout(function(){
                          textarea.trigger('click');
                        }, 500)
                      });

                      ed.on('init', function() {
                        if (content) ed.setContent(content);

                        if ($('#mention-autocomplete-css').length === 0) {
                              $('<link>').appendTo('head').attr({
                                 id: 'mention-autocomplete-css',
                                 type: 'text/css',
                                 rel: 'stylesheet',
                                 href: site_url + 'assets/plugins/tinymce/plugins/mention/autocomplete.css'
                              });
                           }

                           if ($('#mention-css').length === 0) {
                              $('<link>').appendTo('head').attr({
                                 type: 'text/css',
                                 id: 'mention-css',
                                 rel: 'stylesheet',
                                 href: site_url + 'assets/plugins/tinymce/plugins/mention/rte-content.css'
                              });
                           }
                      })
                  }

                  editorConfig.toolbar = editorConfig.toolbar.replace('alignright','alignright strikethrough')
                  editorConfig.plugins[0] += ' mention';
                  editorConfig.content_style = 'span.mention {\
                     background-color: #eeeeee;\
                     padding: 3px;\
                  }';
                  var projectUserMentions = [];
                  editorConfig.mentions = {
                     source: function (query, process, delimiter) {
                           if (projectUserMentions.length < 1) {
                              $.getJSON(admin_url + 'projects/get_staff_names_for_mentions/' + project_id, function (data) {
                                 projectUserMentions = data;
                                 process(data)
                              });
                           } else {
                              process(projectUserMentions)
                           }
                     },
                     insert: function(item) {
                           return '<span class="mention" contenteditable="false" data-mention-id="'+ item.id + '">@'
                           + item.name + '</span>&nbsp;';
                     }
                  };

                var containerId = this.get_container_id(comment_index);
                tinyMCE.remove('#'+containerId);

                setTimeout(function(){
                  init_editor('#'+ containerId, editorConfig)
                },100)
            },
            get_container: function (textarea) {
                if (!textarea.data('comment_index')) {
                    textarea.data('comment_index', ++this.opts.comment_index);
                }

                return $('<div/>', {
                    'id': this.get_container_id(this.opts.comment_index)
                });
            },
            get_contents: function(editor) {
               return editor.getContent();
            },
            on_post_comment: function(editor, evt) {
               editor.setContent('');
            },
            get_container_id: function(comment_index) {
              var container_id = this.opts.container_id;
              if (comment_index) container_id = container_id + "-" + comment_index;
              return container_id;
            }
        },
      currentUserIsAdmin:current_user_is_admin,
      getComments: function(success, error) {
        $.get(admin_url + 'projects/get_discussion_comments/'+discussion_id+'/'+discussion_type,function(response){
          success(response);
        },'json');
      },
      postComment: function(commentJSON, success, error) {
        $.ajax({
          type: 'post',
          url: admin_url + 'projects/add_discussion_comment/'+discussion_id+'/'+discussion_type,
          data: commentJSON,
          success: function(comment) {
            comment = JSON.parse(comment);
            success(comment)
          },
          error: error
        });
      },
      putComment: function(commentJSON, success, error) {
        $.ajax({
          type: 'post',
          url: admin_url + 'projects/update_discussion_comment',
          data: commentJSON,
          success: function(comment) {
            comment = JSON.parse(comment);
            success(comment)
          },
          error: error
        });
      },
      deleteComment: function(commentJSON, success, error) {
        $.ajax({
          type: 'post',
          url: admin_url + 'projects/delete_discussion_comment/'+commentJSON.id,
          success: success,
          error: error
        });
      },
      uploadAttachments: function(commentArray, success, error) {
        var responses = 0;
        var successfulUploads = [];
        var serverResponded = function() {
          responses++;
            // Check if all requests have finished
            if(responses == commentArray.length) {
                // Case: all failed
                if(successfulUploads.length == 0) {
                  error();
                // Case: some succeeded
              } else {
                successfulUploads = JSON.parse(successfulUploads);
                success(successfulUploads)
              }
            }
          }
          $(commentArray).each(function(index, commentJSON) {
            // Create form data
            var formData = new FormData();
            if(commentJSON.file.size && commentJSON.file.size > app.max_php_ini_upload_size_bytes){
             alert_float('danger',"<?php echo _l("file_exceeds_max_filesize"); ?>");
             serverResponded();
           } else {
            $(Object.keys(commentJSON)).each(function(index, key) {
              var value = commentJSON[key];
              if(value) formData.append(key, value);
            });

            if (typeof(csrfData) !== 'undefined') {
               formData.append(csrfData['token_name'], csrfData['hash']);
            }
            $.ajax({
              url: admin_url + 'projects/add_discussion_comment/'+discussion_id+'/'+discussion_type,
              type: 'POST',
              data: formData,
              cache: false,
              contentType: false,
              processData: false,
              success: function(commentJSON) {
                successfulUploads.push(commentJSON);
                serverResponded();
              },
              error: function(data) {
               var error = JSON.parse(data.responseText);
               alert_float('danger',error.message);
               serverResponded();
             },
           });
          }
        });
        }
      }
      var settings = $.extend({}, defaults, options);
    $(selector).comments(settings);
   }
   if($('.mydatatable').length>0){
      //var tables = $.fn.dataTable.fnTables(true);

      //$(tables).each(function () {
         //$(this).dataTable().fnDestroy();
      //});
      $('.mydatatable').dataTable({searching: false, paging: false, info: false,ordering:false});
      $(".table-loading").removeClass('table-loading');
   }

   <?php
   if(isset($project) && $project->profit_percent > 0){ ?>
      let profit_percent = "<?php echo $project->profit_percent; ?>";
      $("#gross_profit_range").val(profit_percent);
      setTimeout(function(){
         $("#gross_profit_range").change();
      }, 250);
   <?php } ?>
   var preNetProfitAmt = 0;
   var pendingCommAmt = parseFloat($("#pendingCommAmt").val());
   var pendingCommPer = parseFloat($("#pendingCommPer").val());
   $("#gross_profit_range").change(function(){
      var gross_profit_range=$("#gross_profit_range").val();
      var gross_profit=$("#gross_profit").val();
      preNetProfitAmt = gross_profit;
      if(gross_profit_range==0){
         var commission=0;
         $("#commission_span").html("$0.00");
         $("#commission").val(commission.toFixed(2));
      } else {
         var commission=(gross_profit*gross_profit_range)/100;
         $("#commission_span").html("$"+commission.toFixed(2));
         pendingCommAmt = gross_profit - commission;
         pendingCommPer = 100 - gross_profit_range;
         $("#pendingCommAmt").val(pendingCommAmt);
         $("#pendingCommPer").val(pendingCommPer);
         $("#commission").val(commission.toFixed(2));
      }
   });
   /* Sales Person Commision 08-10-2022 Start */
   var totalPer = 100;
   $("body").on("change","select[name='sales_portion_main']", function(e){
      _this = $(this);
      let mainComm = parseFloat($("#commission").val());
      if(!isNaN(mainComm) && mainComm > 0){
         let portionAmt = parseFloat(_this.val());
         let salesPAmt = (mainComm * portionAmt)/100;
         salesPAmt = salesPAmt.toFixed(2);
         _this.closest('tr').find('input[name="sales_portion_amount_main"]').val(salesPAmt);
         _this.closest('tr').find('span.sales_portion_amount_main').html('$'+salesPAmt);
      }
   });
   $("body").on("click",".delete_sales_item", function(e){
      $(this).closest('tr').remove();
      set_used_percentage();
   });
   $("body").on("click","button.add_item_to_sales", function(e){
      let tr = $(this).closest('tr');
      let sel_staff = tr.find('select[name="assigned_main"]').val();
      if(sel_staff == ''){
         return false;
      }
      let sel_staff_name = tr.find('select[name="assigned_main"]').find('option:selected').text();
      let sel_portion = tr.find('select[name="sales_portion_main"]').val();
      
      if(totalPer < parseInt(sel_portion)){
         alert('Not Allow To Assign % More Then Available');
         return false;
      }
      let sel_portion_amount = tr.find('input[name="sales_portion_amount_main"]').val();
      let trHtml = '<tr class="used">';
      trHtml += '<td><input type="hidden" name="sales_staff[]" value="'+sel_staff+'">'+sel_staff_name+'</td>';
      trHtml += '<td><input type="hidden" name="sales_portion[]" value="'+sel_portion+'">'+sel_portion+'%</td>';
      trHtml += '<td><input type="hidden" name="sales_portion_amount[]" value="'+sel_portion_amount+'">$'+sel_portion_amount+'</td>';
      trHtml += '<td><a href="javascript:;" class="btn btn-danger pull-left delete_sales_item"><i class="fa fa-times"></i></a></td>';
      trHtml += '</tr>';
      $('.commision-sales-table tbody').append(trHtml);
      reset_main_item_values();
      set_used_percentage();
   });
   function set_used_percentage() {
      let usedTr = $('.commision-sales-table').find('tr.used');
      if(usedTr.length > 0){
         let usedPer = 0; let preAmtUsed = 0;
         usedTr.each(function(ind, elm) {
            let percentage = parseInt($(elm).find('input[name="sales_portion[]"]').val());
            let rowPreAmtUsed = parseInt($(elm).find('input[name="sales_portion_amount[]"]').val());
            usedPer += percentage;
            preAmtUsed += rowPreAmtUsed;
         });
         
         let mainProfit = parseFloat($("#gross_profit").val());
         preNetProfitAmt = mainProfit - preAmtUsed;
         $("#pre_net_profit").text("$"+preNetProfitAmt);
         $("input[name='pre_net_profit']").val(preNetProfitAmt);
         totalPer = 100 - usedPer;
      }
   }
   function reset_main_item_values() {
       var previewArea = $('.commision-sales-table').find('tr.main');

       previewArea.find('.sales_portion_amount_main').text('0.00');
       previewArea.find('select[name="sales_portion_main"]').val('0');
       previewArea.find('select[name="assigned_main"]').selectpicker('val','');
       // init_selectpicker();
   }
   /* Sales Person Commision 08-10-2022 End */

   /* Gross Profit Commision 10-10-2022 Start */
   $("body").on("change","select[name='gp_sales_portion_main']", function(e){
      _this = $(this);
      let penProfit = getPenDistAmt();
      if(!isNaN(penProfit) && penProfit > 0){
         //penProfit = parseFloat($("#pendingCommAmt").val());
         let guUsed = parseFloat($("#gross_used").val());
         guUsed = isNaN(guUsed)?0:guUsed;
         penProfit = (parseFloat($("input[name='pre_net_profit']").val()) - guUsed);
         //penProfit = parseFloat($("input[name='pre_net_profit']").val());
         let portionAmt = parseFloat(_this.val());
         let salesPAmt = (penProfit * portionAmt)/100;
         salesPAmt = salesPAmt.toFixed(2);
         _this.closest('tr').find('input[name="gp_sales_portion_amount_main"]').val(salesPAmt);
         _this.closest('tr').find('span.gp_sales_portion_amount_main').html('$'+salesPAmt);
      }
   });
   function getPenDistAmt(mode = 'gross') {
      let penProfit = parseFloat($("#pendingCommAmt").val());
      if(mode == 'gross'){
         let gross_used = parseFloat($("#gross_used").val());
         return penProfit - gross_used;
      } else {
         let net_used = parseFloat($("#net_used").val());
         return penProfit - net_used;
      }
   }
   $("body").on("click",".gp_delete_sales_item", function(e){
      $(this).closest('tr').remove();
      set_used_gp_amount();
   });
   $("body").on("click","button.add_item_to_gp_sales", function(e){
      let tr = $(this).closest('tr');
      
      let sel_staff_name = tr.find('input[name="gp_name_main"]').val();
      if(sel_staff_name == ''){
         return false;
      }
      let sel_portion = tr.find('select[name="gp_sales_portion_main"]').val();
      let penDistAmt = getPenDistAmt();
      let sel_portion_amount = tr.find('input[name="gp_sales_portion_amount_main"]').val();
      if(penDistAmt < parseFloat(sel_portion_amount)){
         alert('Not Allow To Assign More Amount Then Available');
         return false;
      }
      let trHtml = '<tr class="used">';
      trHtml += '<td><input type="hidden" name="gp_sales_name[]" value="'+sel_staff_name+'">'+sel_staff_name+'</td>';
      trHtml += '<td><input type="hidden" name="gp_sales_portion[]" value="'+sel_portion+'">'+sel_portion+'%</td>';
      trHtml += '<td><input type="hidden" name="gp_sales_portion_amount[]" value="'+sel_portion_amount+'">$'+sel_portion_amount+'</td>';
      trHtml += '<td><a href="javascript:;" class="btn btn-danger pull-left gp_delete_sales_item"><i class="fa fa-times"></i></a></td>';
      trHtml += '</tr>';
      $('.addi-commision-gross-profit-table tbody').append(trHtml);
      reset_gp_main_item_values();
      set_used_gp_amount();
   });
   function set_used_gp_amount() {
      let usedTr = $('.addi-commision-gross-profit-table').find('tr.used');
      let gpAmtRow = 0;
      if(usedTr.length > 0){
         usedTr.each(function(ind, elm) {
            let gpAmt = parseFloat($(elm).find('input[name="gp_sales_portion_amount[]"]').val());
            gpAmtRow += gpAmt;
         });
      }
      $("#gross_used").val(gpAmtRow.toFixed(2));
      $(".gross_used").text("$"+gpAmtRow.toFixed(2));
      const preNet = getPenDistAmt('gross');
      $("input[name='net_profit']").val(preNet.toFixed(2));
      $(".net_profit").text("$"+preNet.toFixed(2));
   }
   function reset_gp_main_item_values() {
       var previewArea = $('.addi-commision-gross-profit-table').find('tr.main');
       previewArea.find('.gp_sales_portion_amount_main').text('0.00');
       previewArea.find('input[name="gp_name_main"]').val('');
       previewArea.find('select[name="gp_sales_portion_main"]').val('');
   }
   /* Gross Profit Commision 10-10-2022 End */


   /* Net Profit Commision 11-10-2022 Start */
   $("body").on("change","select[name='np_sales_portion_main']", function(e){
      _this = $(this);
      let penProfit = getPenDistAmt('net');
      if(!isNaN(penProfit) && penProfit > 0){
         //penProfit = parseFloat($("#pendingCommAmt").val());
         let npUsed = parseFloat($("#net_used").val());
         npUsed = isNaN(npUsed)?0:npUsed;
         penProfit = (parseFloat($("input[name='net_profit']").val()) - npUsed);
         let portionAmt = parseFloat(_this.val());
         let salesPAmt = (penProfit * portionAmt)/100;
         salesPAmt = salesPAmt.toFixed(2);
         _this.closest('tr').find('input[name="np_sales_portion_amount_main"]').val(salesPAmt);
         _this.closest('tr').find('span.np_sales_portion_amount_main').html('$'+salesPAmt);
      }
   });
   
   $("body").on("click",".np_delete_sales_item", function(e){
      $(this).closest('tr').remove();
      set_used_np_amount();
   });
   $("body").on("click","button.add_item_to_np_sales", function(e){
      let tr = $(this).closest('tr');
      
      let sel_staff_name = tr.find('input[name="np_name_main"]').val();
      if(sel_staff_name == ''){
         return false;
      }
      let sel_portion = tr.find('select[name="np_sales_portion_main"]').val();
      let penDistAmt = getPenDistAmt('net');
      let sel_portion_amount = tr.find('input[name="np_sales_portion_amount_main"]').val();
      if(penDistAmt < parseFloat(sel_portion_amount)){
         alert('Not Allow To Assign More Amount Then Available');
         return false;
      }
      let trHtml = '<tr class="used">';
      trHtml += '<td><input type="hidden" name="np_sales_name[]" value="'+sel_staff_name+'">'+sel_staff_name+'</td>';
      trHtml += '<td><input type="hidden" name="np_sales_portion[]" value="'+sel_portion+'">'+sel_portion+'%</td>';
      trHtml += '<td><input type="hidden" name="np_sales_portion_amount[]" value="'+sel_portion_amount+'">$'+sel_portion_amount+'</td>';
      trHtml += '<td><a href="javascript:;" class="btn btn-danger pull-left np_delete_sales_item"><i class="fa fa-times"></i></a></td>';
      trHtml += '</tr>';
      $('.addi-commision-net-profit-table tbody').append(trHtml);
      reset_np_main_item_values();
      set_used_np_amount();
   });
   function set_used_np_amount() {
      let usedTr = $('.addi-commision-net-profit-table').find('tr.used');
      let gpAmtRow = 0;
      if(usedTr.length > 0){
         usedTr.each(function(ind, elm) {
            let gpAmt = parseFloat($(elm).find('input[name="np_sales_portion_amount[]"]').val());
            gpAmtRow += gpAmt;
         });
      }
      $("#net_used").val(gpAmtRow.toFixed(2));
      $(".net_used").text("$"+gpAmtRow.toFixed(2));
      const fnlNet = getPenDistAmt('net');
      $("input[name='final_net_profit']").val(fnlNet.toFixed(2));
      $(".final_net_profit").text("$"+fnlNet.toFixed(2));
   }
   function reset_np_main_item_values() {
       var previewArea = $('.addi-commision-net-profit-table').find('tr.main');
       previewArea.find('.np_sales_portion_amount_main').text('0.00');
       previewArea.find('input[name="np_name_main"]').val('');
       previewArea.find('select[name="np_sales_portion_main"]').val('');
   }
   /* Net Profit Commision 11-10-2022 End */
</script>
</body>
</html>
