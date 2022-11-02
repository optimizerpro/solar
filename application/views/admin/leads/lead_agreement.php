<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!--<div class="modal-header">
   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
   <h4 class="modal-title">
      <?php if(isset($lead)){
         if(!empty($lead->name)){
           $name = $lead->name;
         } else if(!empty($lead->company)){
           $name = $lead->company;
         } else {
           $name = _l('lead');
         }
         echo '#'.$lead->id . ' - ' .  $name;
         } else {
         echo _l('add_new',_l('lead_lowercase'));
         }
         ?>
   </h4>
</div>-->
<div class="modal-body">
   <?php
      if(isset($lead)){
           if($lead->lost == 1){
              echo '<div class="ribbon danger"><span>'._l('lead_lost').'</span></div>';
           } else if($lead->junk == 1){
              echo '<div class="ribbon warning"><span>'._l('lead_junk').'</span></div>';
           } else {
              if (total_rows(db_prefix().'clients', array(
                'leadid' => $lead->id))) {
                echo '<div class="ribbon success"><span>'._l('lead_is_client').'</span></div>';
             }
          }
      }
      ?>
   <div class="row">
      <div class="col-md-12">
         <?php if(isset($lead)){
            echo form_hidden('leadid',$lead->id);
            } ?>
         
         <!-- Tab panes -->
         <div class="tab-content mtop20">
            <!-- from leads modal -->
            <div role="tabpanel" class="tab-pane active" id="tab_lead_profile">
               <?php $this->load->view('admin/leads/profile_agreement'); ?>
            </div>
            
            <?php hooks()->do_action('after_lead_tabs_content', $lead ?? null); ?>
         </div>
      </div>
   </div>
</div>
<?php hooks()->do_action('lead_modal_profile_bottom',(isset($lead) ? $lead->id : '')); ?>