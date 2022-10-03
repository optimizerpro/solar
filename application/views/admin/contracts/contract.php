<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
   <div class="content">
      <div class="row">
         <?php
         if(isset($contract) && $contract->signed == 1) { ?>
            <div class="col-md-12">
               <div class="alert alert-warning">
                  <?php echo  _l('contract_signed_not_all_fields_editable'); ?>
               </div>
            </div>
         <?php } ?>
         <?php
            /*$rel_type = '';
            $rel_id = '';
            if(isset($contract) || ($this->input->get('rel_id') && $this->input->get('rel_type'))){
             if($this->input->get('rel_id')){
               $rel_id = $this->input->get('rel_id');
               $rel_type = $this->input->get('rel_type');
             } else {
               $rel_id = $contract->client_id;
               $rel_type = $contract->rel_type;
             }
            }*/
            $description=$manufacturer_warranty=$roll_yard=$shingle_color=$ventilation=$install_decking=$fastners='';
            if(isset($contract)){if($contract->manufacturer_warranty !=''){$manufacturer_warranty= $contract->manufacturer_warranty;}}; 
            if(isset($contract)){if($contract->roll_yard !=''){$roll_yard= $contract->roll_yard;}}; 
            if(isset($contract)){if($contract->shingle_color !=''){$shingle_color= $contract->shingle_color;}}; 
            if(isset($contract)){if($contract->ventilation !=''){$ventilation= $contract->ventilation;}}; 
            if(isset($contract)){if($contract->install_decking !=''){$install_decking= $contract->install_decking;}}; 
            if(isset($contract)){if($contract->fastners !=''){$fastners= $contract->fastners;}}; 
            if(isset($contract)){if($contract->description !=''){$description= addslashes($contract->description);}}; 
            $agreement_fields='<div class="col-md-12"><div class="row"><div class="col-md-12" id="adjuster_label"><h4>Agreement Details</h4><hr></div><div class="col-md-6"><div class="form-group"><label for="manufacturer_warranty">Manufacturer Warranty (yrs)</label>';
            $agreement_fields.='<input type="text" id="manufacturer_warranty" name="manufacturer_warranty" value="'.$manufacturer_warranty.'" class="form-control"></div></div>';
            //$agreement_fields.='<div class="col-md-6"><div class="form-group"><label for="roll_yard">Roll yard with magnetic roller</label><input type="text" id="roll_yard" name="roll_yard" value="'.$roll_yard.'" class="form-control"></div></div>';
            $rollyard = '';
            if(isset($contract)){
               if($contract->roll_yard !=''){
                  $rollyard= $contract->roll_yard;
               }
            }
            $rollyardyes_checked = $rollyardno_checked='';
            if($rollyard=='Yes' || $rollyard==''){
               $rollyardyes_checked=' checked';
            } else {
               $rollyardno_checked=' checked';
            }

            $agreement_fields.='<div class="col-md-6"><label>Roll yard with magnetic roller</label><div class="form-group"><label for="rollyardyes"><input type="radio" id="rollyardyes" name="roll_yard" value="Yes" '.$rollyardyes_checked.'>&nbsp;&nbsp;Yes</label>&nbsp;&nbsp;<label for="rollyardno"><input type="radio" id="rollyardno" name="roll_yard" value="No" '.$rollyardno_checked.'>&nbsp;&nbsp;No</label></div></div>';
            $agreement_fields.='<div class="clearfix"></div>';
            $agreement_fields.='<div class="col-md-6"><div class="form-group"><label for="shingle_color">Shingle Color</label><input type="text" id="shingle_color" name="shingle_color" value="'.$shingle_color.'" class="form-control"></div></div>';
            $agreement_fields.='<div class="col-md-6"><div class="form-group"><label for="ventilation">Ventilation</label><input type="text" id="ventilation" name="ventilation" value="'.$ventilation.'" class="form-control"></div></div>';
            $agreement_fields.='<div class="col-md-6"><div class="form-group"><label for="install_decking">Install Decking</label><input type="text" id="install_decking" name="install_decking" value="'.$install_decking.'" class="form-control"></div></div>';
            $agreement_fields.='<div class="col-md-6"><div class="form-group"><label for="fastners">Fasteners</label><input type="text" id="fastners" name="fastners" value="'.$fastners.'" class="form-control"></div></div>';

            /* 10-09-2022 */
            $policy_number = $acv_rcv = $adj_appoint_date = $adj_appoint_time = '';
            if(isset($contract)){
               if($contract->policy_number !=''){
                  $policy_number= $contract->policy_number;
               }
               if($contract->acv_rcv_aggre !=''){
                  $acv_rcv= $contract->acv_rcv_aggre;
               }
               if($contract->adj_appoint_date !=''){
                  $adj_appoint_date= $contract->adj_appoint_date;
               }
               if($contract->adj_appoint_time !=''){
                  $adj_appoint_time= $contract->adj_appoint_time;
               }
            }
            $acv_checked=$rcv_checked='';
            if($acv_rcv=='acv' || $acv_rcv==''){
               $acv_checked=' checked';
            }
            else{
               $rcv_checked=' checked';
            }
            //$agreement_fields.='<div class="col-md-6"><div class="form-group"><label for="policy_number">Policy Number</label><input type="text" id="policy_number" name="policy_number" value="'.$policy_number.'"></div></div>';
            $agreement_fields.='<div class="col-md-6"><label>RCV/ACV</label><div class="form-group"><label for="acv_aggre"><input type="radio" id="acv_aggre" name="acv_rcv_aggre" value="acv" '.$acv_checked.'>&nbsp;&nbsp;ACV</label>&nbsp;&nbsp;<label for="rcv_aggre"><input type="radio" id="rcv_aggre" name="acv_rcv_aggre" value="rcv" '.$rcv_checked.'>&nbsp;&nbsp;RCV</label></div></div>';
            $agreement_fields.='<div class="clearfix"></div>';
            $agreement_fields.='<div class="col-md-6"><div class="form-group"><label for="adj_appoint_date">Adjusment Appointment Date</label><input type="date" id="adj_appoint_date" name="adj_appoint_date" value="'.$adj_appoint_date.'" class="form-control"></div></div>';
            $agreement_fields.='<div class="col-md-6"><div class="form-group"><label for="adj_appoint_time">Adjusment Appointment Time</label><input type="time" id="adj_appoint_time" name="adj_appoint_time" value="'.$adj_appoint_time.'" class="form-control"></div></div>';

            $agreement_fields.= '</div>';

            $agreement_fields.='<div class="form-group" app-field-wrapper="description"><label for="description" class="control-label">Extra Work &amp; Notes</label><textarea id="description" name="description" class="form-control" rows="10" aria-invalid="false" class="form-control">'.$description.'</textarea></div></div>';
         $description=$roof_type=$layers=$pitch=$acv_rcv=$acv_rcv_plus_tax=$ad_allowance=$first_check=$second_check=$deductible='';
         $soffit=$fascia=$sidewall=$driveway=$shingle=$color=$dripedge=$material_drop=$ventilation='';
         if(isset($contract)){if($contract->roof_type !=''){$roof_type= $contract->roof_type;}}; 
         if(isset($contract)){if($contract->layers !=''){$layers= $contract->layers;}}; 
         if(isset($contract)){if($contract->pitch !=''){$pitch= $contract->pitch;}}; 
         if(isset($contract)){if($contract->acv_rcv !=''){$acv_rcv= $contract->acv_rcv;}}; 
         if(isset($contract)){if($contract->acv_rcv_plus_tax !=''){$acv_rcv_plus_tax= $contract->acv_rcv_plus_tax;}}; 
         if(isset($contract)){if($contract->ad_allowance !=''){$ad_allowance= $contract->ad_allowance;}};
         if(isset($contract)){if($contract->first_check !=''){$first_check= $contract->first_check;}};
         if(isset($contract)){if($contract->second_check !=''){$second_check= $contract->second_check;}};
         if(isset($contract)){if($contract->deductible !=''){$deductible= $contract->deductible;}};
         if(isset($contract)){if($contract->soffit !=''){$soffit= $contract->soffit;}};
         if(isset($contract)){if($contract->fascia !=''){$fascia= $contract->fascia;}};
         if(isset($contract)){if($contract->sidewall !=''){$sidewall= $contract->sidewall;}};
         if(isset($contract)){if($contract->driveway !=''){$driveway= $contract->driveway;}};
         if(isset($contract)){if($contract->shingle !=''){$shingle= $contract->shingle;}};
         if(isset($contract)){if($contract->color !=''){$color= $contract->color;}};
         if(isset($contract)){if($contract->dripedge !=''){$dripedge= $contract->dripedge;}};
         if(isset($contract)){if($contract->material_drop !=''){$material_drop= $contract->material_drop;}};
         if(isset($contract)){if($contract->ventilation !=''){$ventilation= $contract->ventilation;}};
         if(isset($contract)){if($contract->description !=''){$description= $contract->description;}};
         $acv_checked=$rcv_checked='';
         if($acv_rcv=='acv' || $acv_rcv==''){
            $acv_checked=' checked';
         }
         else{
            $rcv_checked=' checked';
         }
         $work_order_fields='<div class="col-md-12"><div class="row"><div class="col-md-12" id="adjuster_label"><h4>Work Order details</h4><hr></div><div class="col-md-6"><div class="form-group"><label for="roof_type">Roof Type</label><input type="text" id="roof_type" name="roof_type" value="'.$roof_type.'" class="form-control"></div></div>';
         $work_order_fields.='<div class="col-md-6"><div class="form-group"><label for="layers">Layers</label><input type="text" id="layers" name="layers" value="'.$layers.'" class="form-control"></div></div>';
         $work_order_fields.='<div class="col-md-6"><div class="form-group"><label for="pitch">Pitch</label><input type="text" id="pitch" name="pitch" value="'.$pitch.'" class="form-control"></div></div></div>';
         $work_order_fields.='<div class="row"><div class="col-md-12" id="adjuster_label"><h4>Adjuster Estimate</h4><hr></div><div class="col-md-6"><div class="form-group"><label for="acv"><input type="radio" id="acv" name="acv_rcv" value="acv" '.$acv_checked.'>&nbsp;&nbsp;ACV</label>&nbsp;&nbsp;<label for="rcv"><input type="radio" id="rcv" name="acv_rcv" value="rcv" '.$rcv_checked.'>&nbsp;&nbsp;RCV</label></div></div>';
         $work_order_fields.='<div class="col-md-6"><div class="form-group"><label for="acv_rcv_plus_tax">ACV/RCV + Tax</label><input type="text" id="acv_rcv_plus_tax" name="acv_rcv_plus_tax" value="'.$acv_rcv_plus_tax.'" class="form-control"></div></div>';
         $work_order_fields.='<div class="col-md-6"><div class="form-group"><label for="ad_allowance">Advertising Allowance</label><input type="text" id="ad_allowance" name="ad_allowance" value="'.$ad_allowance.'" class="form-control"></div></div></div>';
         $work_order_fields.='<div class="row"><div class="col-md-12" id="payment_schedule"><h4>Payment Schedule</h4><hr></div><div class="col-md-6"><div class="form-group"><label for="first_check">First Check</label><input type="text" id="first_check" name="first_check" value="'.$first_check.'" class="form-control"></div></div>';
         $work_order_fields.='<div class="col-md-6"><div class="form-group"><label for="second_check">Second Check</label><input type="text" id="second_check" name="second_check" value="'.$second_check.'" class="form-control"></div></div>';
         $work_order_fields.='<div class="col-md-6"><div class="form-group"><label for="deductible">Deductible</label><input type="text" id="deductible" name="deductible" value="'.$deductible.'" class="form-control"></div></div></div>';
         $work_order_fields.='<div class="row"><div class="col-md-12" id="pre_existing_structural_defects"><h4>Pre-existing Structural Defects</h4><hr></div><div class="col-md-6"><div class="form-group"><label for="soffit">Soffit</label><input type="text" id="soffit" name="soffit" value="'.$soffit.'" class="form-control"></div></div>';
         $work_order_fields.='<div class="col-md-6"><div class="form-group"><label for="fascia">Fascia</label><input type="text" id="fascia" name="fascia" value="'.$fascia.'" class="form-control"></div></div>';
         $work_order_fields.='<div class="col-md-6"><div class="form-group"><label for="sidewall">Sidewall</label><input type="text" id="sidewall" name="sidewall" value="'.$sidewall.'" class="form-control"></div></div>';
         $work_order_fields.='<div class="col-md-6"><div class="form-group"><label for="driveway">Driveway</label><input type="text" id="driveway" name="driveway" value="'.$driveway.'" class="form-control"></div></div>';
         $work_order_fields.='<div class="col-md-6"><div class="form-group"><label for="shingle">Shingle</label><input type="text" id="shingle" name="shingle" value="'.$shingle.'" class="form-control"></div></div>';
         $work_order_fields.='<div class="col-md-6"><div class="form-group"><label for="color">Color</label><input type="text" id="color" name="color" value="'.$color.'" class="form-control"></div></div>';
         $work_order_fields.='<div class="col-md-6"><div class="form-group"><label for="dripedge">Drip Edge</label><input type="text" id="dripedge" name="dripedge" value="'.$dripedge.'" class="form-control"></div></div>';
         $work_order_fields.='<div class="col-md-6"><div class="form-group"><label for="material_drop">Material Drop</label><input type="text" id="material_drop" name="material_drop" value="'.$material_drop.'" class="form-control"></div></div>';
         $work_order_fields.='<div class="col-md-6"><div class="form-group"><label for="ventilation">Ventilation</label><input type="text" id="ventilation" name="ventilation" value="'.$ventilation.'" class="form-control"></div></div></div>';
         $work_order_fields.='<div class="form-group" app-field-wrapper="description"><label for="description" class="control-label">Special Notes</label><textarea id="description" name="description" class="form-control" rows="10" aria-invalid="false">'.$description.'</textarea></div></div>';
         ?>
         <div class="col-md-5 left-column">
            <div class="panel_s">
               <div class="panel-body">
                  <?php echo form_open($this->uri->uri_string(),array('id'=>'contract-form')); ?>
                  <div class="form-group">
                     <div class="checkbox checkbox-primary no-mtop checkbox-inline">
                        <input type="checkbox" id="trash" name="trash"<?php if(isset($contract)){if($contract->trash == 1){echo ' checked';}}; ?>>
                        <label for="trash"><i class="fa fa-question-circle" data-toggle="tooltip" data-placement="left" title="<?php echo _l('contract_trash_tooltip'); ?>" ></i> <?php echo _l('contract_trash'); ?></label>
                     </div>
                     <div class="checkbox checkbox-primary checkbox-inline">
                        <input type="checkbox" name="not_visible_to_client" id="not_visible_to_client" <?php if(isset($contract)){if($contract->not_visible_to_client == 1){echo 'checked';}}; ?>>
                        <label for="not_visible_to_client">Disable Customer Side</label>
                     </div>
                  </div>
                  <!-- <div class="form-group select-placeholder">
                     <label for="rel_type" class="control-label"><?php echo _l('proposal_related'); ?></label>
                     <select name="rel_type" id="rel_type" class="selectpicker" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                        <option value=""></option>
                        <option value="lead" <?php if((isset($contract) && $contract->rel_type == 'lead') || $this->input->get('rel_type')){if($rel_type == 'lead'){echo 'selected';}} ?>>Contract for lead</option>
                        <option value="customer" <?php if((isset($contract) &&  $contract->rel_type == 'customer') || $this->input->get('rel_type')){if($rel_type == 'customer'){echo 'selected';}} ?>>Contract for customer</option>
                     </select>
                  </div>
                  <div class="form-group select-placeholder f_client_id" id="rel_id_wrapper">
                     <label for="clientid" class="control-label"><span class="text-danger">* </span><?php echo _l('contract_client_string'); ?></label>
                     <div id="rel_id_select">
                        <select id="clientid" name="client" data-live-search="true" data-width="100%" class="ajax-search" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>"<?php echo isset($contract) && $contract->signed == 1 ? ' disabled' : ''; ?>>
                           <?php $selected = (isset($contract) ? $contract->client : '');
                           if($selected == ''){
                              $selected = (isset($customer_id) ? $customer_id: '');
                           }
                           if($selected != ''){
                              $rel_data = get_relation_data('customer',$selected);
                              $rel_val = get_relation_values($rel_data,'customer');
                              echo '<option value="'.$rel_val['id'].'" selected>'.$rel_val['name'].'</option>';
                           } ?>
                        </select>
                     </div>
                  </div> -->

                  <!-- 04-09-2022 -->
                  <?php
                  $rel_type = '';
                  $rel_id = '';
                  if(isset($contract) || ($this->input->get('rel_id') && $this->input->get('rel_type'))){
                   if($this->input->get('rel_id')){
                     $rel_id = $this->input->get('rel_id');
                     $rel_type = $this->input->get('rel_type');
                   } else {
                     $rel_id = $contract->rel_id;
                     $rel_type = $contract->rel_type;
                   }
                  }
                  if(!isset($contract) && isset($_GET['customer_id']) && $_GET['customer_id'] != ''){
                     $rel_id = $_GET['customer_id'];
                     $rel_type = 'customer';
                  }
                  ?>
                  <div class="form-group select-placeholder">
                     <label for="rel_type" class="control-label"><?php echo _l('proposal_related'); ?></label>
                     <select name="rel_type" id="rel_type" class="selectpicker" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                        <option value=""></option>
                        <option value="lead" <?php if((isset($contract) && $contract->rel_type == 'lead') || $this->input->get('rel_type')){if($rel_type == 'lead'){echo 'selected';}} ?>><?php echo _l('proposal_for_lead'); ?></option>
                        <option value="customer" <?php if((isset($contract) &&  $contract->rel_type == 'customer') || $rel_type != ''){if($rel_type == 'customer'){echo 'selected';}} ?>><?php echo _l('proposal_for_customer'); ?></option>
                     </select>
                  </div>

                  <div class="form-group select-placeholder<?php if($rel_id == ''){echo ' hide';} ?> " id="rel_id_wrapper">
                     <label for="rel_id"><span class="rel_id_label"></span></label>
                     <div id="rel_id_select">
                        <select name="rel_id" id="rel_id" class="ajax-search" data-width="100%" data-live-search="true" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                        <?php if($rel_id != '' && $rel_type != ''){
                           $rel_data = get_relation_data($rel_type,$rel_id);
                           $rel_val = get_relation_values($rel_data,$rel_type);
                              echo '<option value="'.$rel_val['id'].'" selected>'.$rel_val['name'].'</option>';
                           } ?>
                        </select>
                     </div>
                  </div>
                  <!-- 04-09-2022 End -->

               <div class="form-group select-placeholder projects-wrapper<?php if((!isset($contract)) || (isset($contract) && !customer_has_projects($contract->client))){ echo ' hide';} ?>">
                  <label for="project_id"><?php echo _l('project'); ?></label>
                  <div id="project_ajax_search_wrapper">
                   <select name="project_id" id="project_id" class="projects ajax-search ays-ignore" data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>"<?php echo isset($contract) && $contract->signed == 1 ? ' disabled' : ''; ?>>
                      <?php
                      if(isset($contract) && $contract->project_id != 0){
                        echo '<option value="'.$contract->project_id.'" selected>'.get_project_name_by_id($contract->project_id).'</option>';
                     }
                     ?>
                  </select>
               </div>
            </div>

            <?php $value = (isset($contract) ? $contract->subject : ''); ?>
            <i class="fa fa-question-circle pull-left" data-toggle="tooltip" title="<?php echo _l('contract_subject_tooltip'); ?>"></i>
            <?php echo render_input('subject','contract_subject',$value); ?>
            <!--<div class="form-group">
               <label for="contract_value"><?php echo _l('contract_value'); ?></label>
               <div class="input-group" data-toggle="tooltip" title="<?php echo isset($contract) && $contract->signed == 1 ? '' : _l('contract_value_tooltip'); ?>">
                  <input type="number" class="form-control" name="contract_value" value="<?php if(isset($contract)){echo $contract->contract_value; }?>"<?php echo isset($contract) && $contract->signed == 1 ? ' disabled' : ''; ?>>
                  <div class="input-group-addon">
                     <?php echo $base_currency->symbol; ?>
                  </div>
               </div>
            </div>-->
            <?php
            $onchange=' onchange="contractTypeChanged();"';
            $selected = (isset($contract) ? $contract->contract_type : '');
            if(is_admin() || get_option('staff_members_create_inline_contract_types') == '1'){
             //echo render_select_with_input_group('contract_type',$types,array('id','name'),'contract_type',$selected,'<a href="#" onclick="new_type();return false;"><i class="fa fa-plus"></i></a>');
               ?>
               <div class="form-group form-group-select-input-contract_type input-group-select">
                  <label for="contract_type" class="control-label">Contract type</label>
                  <div class="input-group input-group-select select-contract_type" app-field-wrapper="contract_type">
                     
                     <select id="contract_type" <?php echo $onchange; ?> name="contract_type" class="selectpicker _select_input_group" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true" tabindex="-98">
                        <?php
                           foreach($types as $type){
                              ?>
                              <option value="<?php echo $type['id']; ?>" <?php if($selected==$type['id']){ echo 'selected'; } ?>><?php echo $type['name']; ?></option>
                              <?php
                           }
                        ?>
                     </select>
                     <div class="input-group-addon" style="opacity: 1;">
                        <a href="#" onclick="new_type();return false;"><i class="fa fa-plus"></i></a>
                     </div>
                  </div>
               </div>
               <?php
            } else {
            //echo render_select('contract_type',$types,array('id','name'),'contract_type',$selected);
            ?>
               <div class="form-group form-group-select-input-contract_type">
                  <label for="contract_type" class="control-label">Contract type</label>
                  <select id="contract_type" <?php echo $onchange; ?> name="contract_type" class="selectpicker" data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true" tabindex="-98">
                     <?php
                        foreach($types as $type){
                           ?>
                           <option value="<?php echo $type['id']; ?>" <?php if($selected==$type['id']){ echo 'selected'; } ?>><?php echo $type['name']; ?></option>
                           <?php
                        }
                     ?>
                  </select>
                </div>
               <?php
         }
         ?>
         <div class="row">
            <div class="col-md-6">
               <?php $value = (isset($contract) ? _d($contract->datestart) : _d(date('Y-m-d'))); ?>
               <?php echo render_date_input(
                  'datestart',
                  'contract_start_date',
                  $value,
                  isset($contract) && $contract->signed == 1 ? ['disabled'=>true] : []
               ); ?>
            </div>
            <!-- <div class="col-md-6">
               <?php $value = (isset($contract) ? _d($contract->dateend) : _d(date('Y-m-d'))); ?>
               <?php echo render_date_input(
                  'dateend',
                  'contract_end_date',
                  $value,
                  isset($contract) && $contract->signed == 1 ? ['disabled'=>true] : []
               ); ?>
            </div> -->
         </div>
         <div class="row" id='dynamic_variables'>
            <?php
               if(isset($contract) && $contract->contract_type==2){
                  echo $work_order_fields;
               }
               else{
                  echo $agreement_fields;
               }
            ?>
         </div>
         <?php $value = (isset($contract) ? $contract->description : ''); ?>
         <?php //echo render_textarea('description','Extra Work & Notes',$value,array('rows'=>10)); ?>
         <?php $rel_id = (isset($contract) ? $contract->id : false); ?>
         <?php echo render_custom_fields('contracts',$rel_id); ?>
         <div class="btn-bottom-toolbar text-right">
            <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
         </div>
         <?php echo form_close(); ?>
      </div>
   </div>
</div>

<?php if(isset($contract)) { ?>
   <div class="col-md-7 right-column">
      <div class="panel_s">
         <div class="panel-body">
            <h4 class="no-margin"><?php echo $contract->subject; ?></h4>
            <a href="<?php echo site_url('contract/'.$contract->id.'/'.$contract->hash); ?>" target="_blank">
               <?php echo _l('view_contract'); ?>
            </a>
            <hr class="hr-panel-heading" />
            <?php if($contract->trash > 0){
               echo '<div class="ribbon default"><span>'._l('contract_trash').'</span></div>';
            } ?>
            <div class="horizontal-scrollable-tabs preview-tabs-top">
               <div class="scroller arrow-left"><i class="fa fa-angle-left"></i></div>
               <div class="scroller arrow-right"><i class="fa fa-angle-right"></i></div>
               <div class="horizontal-tabs">
                  <ul class="nav nav-tabs tabs-in-body-no-margin contract-tab nav-tabs-horizontal mbot15" role="tablist">
                     <li role="presentation" class="<?php if(!$this->input->get('tab') || $this->input->get('tab') == 'tab_content'){echo 'active';} ?>">
                        <a href="#tab_content" aria-controls="tab_content" role="tab" data-toggle="tab">
                           <?php echo _l('contract_content'); ?>
                        </a>
                     </li>
                     <li role="presentation" class="<?php if($this->input->get('tab') == 'attachments'){echo 'active';} ?>">
                        <a href="#attachments" aria-controls="attachments" role="tab" data-toggle="tab">
                           <?php echo _l('contract_attachments'); ?>
                           <?php if($totalAttachments = count($contract->attachments)) { ?>
                            <span class="badge attachments-indicator"><?php echo $totalAttachments; ?></span>
                         <?php } ?>
                      </a>
                   </li>
                   <li role="presentation">
                     <a href="#tab_comments" aria-controls="tab_comments" role="tab" data-toggle="tab" onclick="get_contract_comments(); return false;">
                        <?php echo _l('contract_comments'); ?>
                        <?php
                        $totalComments = total_rows(db_prefix().'contract_comments','contract_id='.$contract->id)
                        ?>
                        <span class="badge comments-indicator<?php echo $totalComments == 0 ? ' hide' : ''; ?>"><?php echo $totalComments; ?></span>
                     </a>
                  </li>
                  <!-- <li role="presentation" class="<?php if($this->input->get('tab') == 'renewals'){echo 'active';} ?>">
                     <a href="#renewals" aria-controls="renewals" role="tab" data-toggle="tab">
                        <?php echo _l('no_contract_renewals_history_heading'); ?>
                        <?php if($totalRenewals = count($contract_renewal_history)) { ?>
                           <span class="badge"><?php echo $totalRenewals; ?></span>
                        <?php } ?>
                     </a>
                  </li> -->
                  <li role="presentation" class="tab-separator">
                     <a href="#tab_tasks" aria-controls="tab_tasks" role="tab" data-toggle="tab" onclick="init_rel_tasks_table(<?php echo $contract->id; ?>,'contract'); return false;">
                        <?php echo _l('tasks'); ?>
                     </a>
                  </li>
                  <li role="presentation" class="tab-separator">
                     <a href="#tab_notes" onclick="get_sales_notes(<?php echo $contract->id; ?>,'contracts'); return false" aria-controls="tab_notes" role="tab" data-toggle="tab">
                        <?php echo _l('contract_notes'); ?>
                        <span class="notes-total">
                           <?php if($totalNotes > 0){ ?>
                              <span class="badge"><?php echo $totalNotes; ?></span>
                           <?php } ?>
                        </span>
                     </a>
                  </li>
                  <!-- <li role="presentation" class="tab-separator">
                     <a href="#tab_templates" onclick="get_templates('contracts', <?php echo $contract->id ?>); return false" aria-controls="tab_templates" role="tab" data-toggle="tab">
                        <?php echo _l('templates');
                        $total_templates = total_rows(db_prefix() . 'templates', [
                            'type' => 'contracts',
                          ]
                        );
                        ?>
                         <span class="badge total_templates <?php echo $total_templates === 0 ? 'hide' : ''; ?>"><?php echo $total_templates ?></span>
                     </a>
                  </li> -->
                  <li role="presentation" data-toggle="tooltip" title="<?php echo _l('emails_tracking'); ?>" class="tab-separator">
                     <a href="#tab_emails_tracking" aria-controls="tab_emails_tracking" role="tab" data-toggle="tab">
                        <?php if(!is_mobile()){ ?>
                           <i class="fa fa-envelope-open-o" aria-hidden="true"></i>
                        <?php } else { ?>
                           <?php echo _l('emails_tracking'); ?>
                        <?php } ?>
                     </a>
                  </li>
                  <li role="presentation" class="tab-separator toggle_view">
                     <a href="#" onclick="contract_full_view(); return false;" data-toggle="tooltip" data-title="<?php echo _l('toggle_full_view'); ?>">
                        <i class="fa fa-expand"></i></a>
                     </li>
                  </ul>
               </div>
            </div>
            <div class="tab-content">
               <div role="tabpanel" class="tab-pane<?php if(!$this->input->get('tab') || $this->input->get('tab') == 'tab_content'){echo ' active';} ?>" id="tab_content">
                  <div class="row mtop15">
                     <?php if($contract->signed == 1){ ?>
                        <div class="col-md-12">
                           <div class="alert alert-success">
                              <?php echo _l('document_signed_info',array(
                                 '<b>'.$contract->acceptance_firstname . ' ' . $contract->acceptance_lastname . '</b> (<a href="mailto:'.$contract->acceptance_email.'">'.$contract->acceptance_email.'</a>)',
                                 '<b>'. _dt($contract->acceptance_date).'</b>',
                                 '<b>'.$contract->acceptance_ip.'</b>')
                              ); ?>
                           </div>
                        </div>
                     <?php } else if($contract->marked_as_signed == 1) { ?>
                        <div class="col-md-12">
                           <div class="alert alert-info">
                              <?php echo _l('contract_marked_as_signed_info'); ?>
                           </div>
                        </div>
                     <?php } ?> 
                     <div class="col-md-12 text-right _buttons">
                        <?php if($contract->signed == 0 && $contract->marked_as_signed == 0) { ?>
                           <div class="btn-group">
                              <button type="submit" id="accept_action" class="btn btn-success pull-right action-button"><?php echo _l('e_signature_sign'); ?></button>
                           </div>
                        <?php } ?>
                        <!-- <div class="btn-group">
                           <a href="<?php echo admin_url('contracts/pdf/'.$contract->id); ?>" class="btn btn-default action-button mright5 contract-html-pdf"><i class="fa fa-file-pdf-o"></i> <?php echo _l('clients_invoice_html_btn_download'); ?></a>
                        </div> -->
                        <div class="btn-group">
                           <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf-o"></i><?php if(is_mobile()){echo ' PDF';} ?> <span class="caret"></span></a>
                           <ul class="dropdown-menu dropdown-menu-right">
                              <li class="hidden-xs"><a href="<?php echo admin_url('contracts/pdf/'.$contract->id.'?output_type=I'); ?>"><?php echo _l('view_pdf'); ?></a></li>
                              <li class="hidden-xs"><a href="<?php echo admin_url('contracts/pdf/'.$contract->id.'?output_type=I'); ?>" target="_blank"><?php echo _l('view_pdf_in_new_window'); ?></a></li>
                              <li><a href="<?php echo admin_url('contracts/pdf/'.$contract->id); ?>"><?php echo _l('download'); ?></a></li>
                              <li>
                                 <a href="<?php echo admin_url('contracts/pdf/'.$contract->id.'?print=true'); ?>" target="_blank">
                                    <?php echo _l('print'); ?>
                                 </a>
                              </li>
                           </ul>
                        </div>
                        
                        
                        <a href="#" class="btn btn-default" data-target="#contract_send_to_client_modal" data-toggle="modal"><span class="btn-with-tooltip" data-toggle="tooltip" data-title="<?php echo _l('contract_send_to_email'); ?>" data-placement="bottom">
                           <i class="fa fa-envelope"></i></span>
                        </a>
                        <div class="btn-group">
                           <button type="button" class="btn btn-default pull-left dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <?php echo _l('more'); ?> <span class="caret"></span>
                           </button>
                           <ul class="dropdown-menu dropdown-menu-right">
                              <li>
                                 <a href="<?php echo site_url('contract/'.$contract->id.'/'.$contract->hash); ?>" target="_blank">
                                    <?php echo _l('view_contract'); ?>
                                 </a>
                              </li>
                              <?php
                              if($contract->signed == 0 && $contract->marked_as_signed == 0 && staff_can('edit', 'contracts')) { ?>
                               <li>
                                 <a href="<?php echo admin_url('contracts/mark_as_signed/'.$contract->id); ?>">
                                    <?php echo _l('mark_as_signed'); ?>
                                 </a>
                              </li>
                           <?php } else if($contract->signed == 0 && $contract->marked_as_signed == 1 && staff_can('edit', 'contracts')) { ?>
                              <li>
                                 <a href="<?php echo admin_url('contracts/unmark_as_signed/'.$contract->id); ?>">
                                    <?php echo _l('unmark_as_signed'); ?>
                                 </a>
                              </li>
                           <?php } ?>
                           <?php hooks()->do_action('after_contract_view_as_client_link', $contract); ?>
                           <?php if(has_permission('contracts','','create')){ ?>
                              <li>
                                 <a href="<?php echo admin_url('contracts/copy/'.$contract->id); ?>">
                                    <?php echo _l('contract_copy'); ?>
                                 </a>
                              </li>
                           <?php } ?>
                           <?php if($contract->signed == 1 && has_permission('contracts','','delete')){ ?>
                              <li>
                                 <a href="<?php echo admin_url('contracts/clear_signature/'.$contract->id); ?>" class="_delete">
                                    <?php echo _l('clear_signature'); ?>
                                 </a>
                              </li>
                           <?php } ?>
                           <?php if(has_permission('contracts','','delete')){ ?>
                              <li>
                                 <a href="<?php echo admin_url('contracts/delete/'.$contract->id); ?>" class="_delete">
                                    <?php echo _l('delete'); ?></a>
                                 </li>
                              <?php } ?>
                           </ul>
                        </div>
                     </div>
                     <!--<div class="col-md-12">
                        <?php if(isset($contract_merge_fields)){ ?>
                           <hr class="hr-panel-heading" />
                           <p class="bold text-right no-mbot"><a href="#" onclick="slideToggle('.avilable_merge_fields'); return false;"><?php echo _l('available_merge_fields'); ?></a></p>
                           <div class=" avilable_merge_fields mtop15 hide">
                              <ul class="list-group">
                                 <?php
                                 /*foreach($contract_merge_fields as $field){
                                  foreach($field as $f){
                                     echo '<li class="list-group-item"><b>'.$f['name'].'</b>  <a href="#" class="pull-right" onclick="insert_merge_field(this); return false">'.$f['key'].'</a></li>';
                                  }
                               }*/
                               ?>
                            </ul>
                         </div>
                      <?php } ?>
                   </div>-->
                   <style>
                     .contract-html-content .table-responsive:nth-child(2) table, .contract-html-content .table-responsive:nth-child(3) table,
                     .contract-html-content table:nth-child(2), .contract-html-content table:nth-child(3) {
                        width: 100%;
                     }
                     </style>
                   <div class="col-md-12 contract-html-content" style="overflow: auto;">
                      <?php echo $contract->content; ?>
                   </div>
                </div>
                <hr class="hr-panel-heading" />
                <?php if(!staff_can('edit','contracts')) { ?>
                  <div class="alert alert-warning contract-edit-permissions">
                     <?php echo _l('contract_content_permission_edit_warning'); ?>
                  </div>
               <?php } ?>
               <div class="tc-content<?php if(staff_can('edit','contracts') &&
                  !($contract->signed == 1)){echo ' editable';} ?>"
                  style="border:1px solid #d2d2d2;min-height:70px; border-radius:4px;display:none;">
                  <?php
                  if(empty($contract->content) && staff_can('edit','contracts')){
                   echo hooks()->apply_filters('new_contract_default_content', '<span class="text-danger text-uppercase mtop15 editor-add-content-notice"> ' . _l('click_to_add_content') . '</span>');
                } else {
                   echo $contract->content;
                }
                ?>
             </div>
             <?php if(!empty($contract->signature)) { ?>
               <div class="row mtop25" style="display:none;">
                  <div class="col-md-6 col-md-offset-6 text-right">
                     <div class="bold">
                        <p class="no-mbot"><?php echo _l('contract_signed_by') . ": {$contract->acceptance_firstname} {$contract->acceptance_lastname}"?></p>
                        <p class="no-mbot"><?php echo _l('contract_signed_date') . ': ' . _dt($contract->acceptance_date) ?></p>
                        <p class="no-mbot"><?php echo _l('contract_signed_ip') . ": {$contract->acceptance_ip}"?></p>
                     </div>
                     <p class="bold"><?php echo _l('document_customer_signature_text'); ?>
                     <?php if($contract->signed == 1 && has_permission('contracts','','delete')){ ?>
                        <a href="<?php echo admin_url('contracts/clear_signature/'.$contract->id); ?>" data-toggle="tooltip" title="<?php echo _l('clear_signature'); ?>" class="_delete text-danger">
                           <i class="fa fa-remove"></i>
                        </a>
                     <?php } ?>
                  </p>
                  <div class="pull-right">
                     <img src="<?php echo site_url('download/preview_image?path='.protected_file_url_by_path(get_upload_path_by_type('contract').$contract->id.'/'.$contract->signature)); ?>" class="img-responsive" alt="">
                  </div>
               </div>
            </div>
         <?php } ?>
      </div>
      <div role="tabpanel" class="tab-pane" id="tab_notes">
         <?php echo form_open(admin_url('contracts/add_note/'.$contract->id),array('id'=>'sales-notes','class'=>'contract-notes-form mtop15')); ?>
         <?php echo render_textarea('description'); ?>
         <div class="text-right">
            <button type="submit" class="btn btn-info mtop15 mbot15"><?php echo _l('contract_add_note'); ?></button>
         </div>
         <?php echo form_close(); ?>
         <hr />
         <div class="panel_s mtop20 no-shadow" id="sales_notes_area">
         </div>
      </div>
      <div role="tabpanel" class="tab-pane" id="tab_comments">
         <div class="row contract-comments mtop15">
            <div class="col-md-12">
               <div id="contract-comments"></div>
               <div class="clearfix"></div>
               <textarea name="content" id="comment" rows="4" class="form-control mtop15 contract-comment"></textarea>
               <button type="button" class="btn btn-info mtop10 pull-right" onclick="add_contract_comment();"><?php echo _l('proposal_add_comment'); ?></button>
            </div>
         </div>
      </div>
      <div role="tabpanel" class="tab-pane<?php if($this->input->get('tab') == 'attachments'){echo ' active';} ?>" id="attachments">
         <?php echo form_open(admin_url('contracts/add_contract_attachment/'.$contract->id),array('id'=>'contract-attachments-form','class'=>'dropzone mtop15')); ?>
         <?php echo form_close(); ?>
         <div class="text-right mtop15">
            <button class="gpicker" data-on-pick="contractGoogleDriveSave">
               <i class="fa fa-google" aria-hidden="true"></i>
               <?php echo _l('choose_from_google_drive'); ?>
            </button>
            <div id="dropbox-chooser"></div>
            <div class="clearfix"></div>
         </div>
         <!-- <img src="https://drive.google.com/uc?id=14mZI6xBjf-KjZzVuQe8-rjtv_wXEbDTw" /> -->

         <div id="contract_attachments" class="mtop30">
            <?php
            $data = '<div class="row">';
            foreach($contract->attachments as $attachment) {
              $href_url = site_url('download/file/contract/'.$attachment['attachment_key']);
              if(!empty($attachment['external'])){
                $href_url = $attachment['external_link'];
             }
             $data .= '<div class="display-block contract-attachment-wrapper">';
             $data .= '<div class="col-md-10">';
             $data .= '<div class="pull-left"><i class="'.get_mime_class($attachment['filetype']).'"></i></div>';
             $data .= '<a href="'.$href_url.'"'.(!empty($attachment['external']) ? ' target="_blank"' : '').'>'.$attachment['file_name'].'</a>';
             $data .= '<p class="text-muted">'.$attachment["filetype"].'</p>';
             $data .= '</div>';
             $data .= '<div class="col-md-2 text-right">';
             if($attachment['staffid'] == get_staff_user_id() || is_admin()){
               $data .= '<a href="#" class="text-danger" onclick="delete_contract_attachment(this,'.$attachment['id'].'); return false;"><i class="fa fa fa-times"></i></a>';
            }
            $data .= '</div>';
            $data .= '<div class="clearfix"></div><hr/>';
            $data .= '</div>';
         }
         $data .= '</div>';
         echo $data;
         ?>
      </div>
   </div>
   <!-- <div role="tabpanel" class="tab-pane<?php if($this->input->get('tab') == 'renewals'){echo ' active';} ?>" id="renewals">
     <div class="mtop15">
      <?php if(has_permission('contracts', '', 'edit')){ ?>
         <div class="_buttons">
            <a href="#" class="btn btn-default" data-toggle="modal" data-target="#renew_contract_modal">
               <i class="fa fa-refresh"></i> <?php echo _l('contract_renew_heading'); ?>
            </a>
         </div>
         <hr />
      <?php } ?>
      <div class="clearfix"></div>
      <?php
      if(count($contract_renewal_history) == 0){
       echo _l('no_contract_renewals_found');
    }
    foreach($contract_renewal_history as $renewal){ ?>
      <div class="display-block">
         <div class="media-body">
            <div class="display-block">
               <b>
                  <?php
                  echo _l('contract_renewed_by',$renewal['renewed_by']);
                  ?>
               </b>
               <?php if($renewal['renewed_by_staff_id'] == get_staff_user_id() || is_admin()){ ?>
                  <a href="<?php echo admin_url('contracts/delete_renewal/'.$renewal['id'] . '/'.$renewal['contractid']); ?>" class="pull-right _delete text-danger"><i class="fa fa-remove"></i></a>
                  <br />
               <?php } ?>
               <small class="text-muted"><?php echo _dt($renewal['date_renewed']); ?></small>
               <hr class="hr-10" />
               <span class="text-success bold" data-toggle="tooltip" title="<?php echo _l('contract_renewal_old_start_date',_d($renewal['old_start_date'])); ?>">
                  <?php echo _l('contract_renewal_new_start_date',_d($renewal['new_start_date'])); ?>
               </span>
               <br />
               <?php if(is_date($renewal['new_end_date'])){
                  $tooltip = '';
                  if(is_date($renewal['old_end_date'])){
                   $tooltip = _l('contract_renewal_old_end_date',_d($renewal['old_end_date']));
                }
                ?>
                <span class="text-success bold" data-toggle="tooltip" title="<?php echo $tooltip; ?>">
                  <?php echo _l('contract_renewal_new_end_date',_d($renewal['new_end_date'])); ?>
               </span>
               <br/>
            <?php } ?>
            <?php if($renewal['new_value'] > 0){
               $contract_renewal_value_tooltip = '';
               if($renewal['old_value'] > 0){
                $contract_renewal_value_tooltip = ' data-toggle="tooltip" data-title="'._l('contract_renewal_old_value', app_format_money($renewal['old_value'], $base_currency)).'"';
             } ?>
             <span class="text-success bold"<?php echo $contract_renewal_value_tooltip; ?>>
               <?php echo _l('contract_renewal_new_value', app_format_money($renewal['new_value'], $base_currency)); ?>
            </span>
            <br />
         <?php } ?>
      </div>
   </div>
   <hr />
</div>
<?php } ?>
</div>
</div> -->
<div role="tabpanel" class="tab-pane" id="tab_emails_tracking">
   <div class="mtop15">
      <?php
         $this->load->view('admin/includes/emails_tracking',array(
           'tracked_emails'=>
           get_tracked_emails($contract->id, 'contract'))
      ); ?>
   </div>
</div>
<div role="tabpanel" class="tab-pane" id="tab_tasks">
   <div class="mtop15">
      <?php init_relation_tasks_table(array('data-new-rel-id'=>$contract->id,'data-new-rel-type'=>'contract')); ?>
   </div>
</div>
   <!-- <div role="tabpanel" class="tab-pane" id="tab_templates">
      <div class="row contract-templates mtop15">
         <div class="col-md-12">
            <button type="button" class="btn btn-info" onclick="add_template('contracts', <?php echo $contract->id ?>);"><?php echo _l('add_template'); ?></button>
            <hr>
         </div>
         <div class="col-md-12">
            <div id="contract-templates" class="contract-templates-wrapper"></div>
         </div>
      </div>
   </div> -->
</div>
</div>
</div>
</div>
<?php } ?>
</div>
</div>
</div>
<div id="modal-wrapper"></div>
<?php init_tail(); ?>

<?php if(isset($contract)){ ?>
   <!-- init table tasks -->
   <script>
      var contract_id = '<?php echo $contract->id; ?>';
      $("body").addClass("identity-confirmation");
   </script>
   <?php $this->load->view('admin/contracts/send_to_client'); ?>
   <?php $this->load->view('admin/contracts/renew_contract'); ?>
<?php } ?>
<?php $this->load->view('admin/contracts/contract_type'); ?>

<?php if(isset($contract) && $contract->signed == 0 && $contract->marked_as_signed == 0) { ?>
<script type="text/javascript" id="signature-pad" src="<?php echo site_url('assets/themes/perfex/js/global.min.js?v='.time()); ?>"></script>
<script type="text/javascript" id="signature-pad" src="<?php echo site_url('assets/plugins/signature-pad/signature_pad.min.js?v=2.9.4'); ?>"></script>
<?php
   $dfltArr = array('formData' => form_hidden('action', 'sign_contract'));
   /*if($this->session->staff_user_id && $this->session->staff_user_id != ''){
      $staffDet = get_staff($this->session->staff_user_id);
      if($staffDet){
         $dfltArr['contact'] = (object)['firstname'=>$staffDet->firstname,'lastname'=>$staffDet->lastname,'email'=>$staffDet->email];
      }
   }*/
   get_template_part('identity_confirmation_form', $dfltArr);
}/*if 728*/
?>
<script>
   Dropzone.autoDiscover = false;
   $(function () {
    init_ajax_project_search_by_customer_id();
    if ($('#contract-attachments-form').length > 0) {
       new Dropzone("#contract-attachments-form",appCreateDropzoneOptions({
          success: function (file) {
             if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                var location = window.location.href;
                window.location.href = location.split('?')[0] + '?tab=attachments';
             }
          }
       }));
    }

    // In case user expect the submit btn to save the contract content
    $('#contract-form').on('submit', function () {
       $('#inline-editor-save-btn').click();
       return true;
    });

    if (typeof (Dropbox) != 'undefined' && $('#dropbox-chooser').length > 0) {
       document.getElementById("dropbox-chooser").appendChild(Dropbox.createChooseButton({
          success: function (files) {
             $.post(admin_url + 'contracts/add_external_attachment', {
                files: files,
                contract_id: contract_id,
                external: 'dropbox'
             }).done(function () {
                var location = window.location.href;
                window.location.href = location.split('?')[0] + '?tab=attachments';
             });
          },
          linkType: "preview",
          extensions: app.options.allowed_files.split(','),
       }));
    }

    appValidateForm($('#contract-form'), {
       client: 'required',
       datestart: 'required',
       subject: 'required'
    });

    appValidateForm($('#renew-contract-form'), {
       new_start_date: 'required'
    });

    var _templates = [];
    $.each(contractsTemplates, function (i, template) {
       _templates.push({
          url: admin_url + 'contracts/get_template?name=' + template,
          title: template
       });
    });

    var editor_settings = {
       selector: 'div.editable',
       inline: true,
       theme: 'inlite',
       relative_urls: false,
       remove_script_host: false,
       inline_styles: true,
       verify_html: false,
       cleanup: false,
       apply_source_formatting: false,
       valid_elements: '+*[*]',
       valid_children: "+body[style], +style[type]",
       file_browser_callback: elFinderBrowser,
       table_default_styles: {
          width: '100%'
       },
       fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
       pagebreak_separator: '<p pagebreak="true"></p>',
       plugins: [
       'advlist pagebreak autolink autoresize lists link image charmap hr',
       'searchreplace visualblocks visualchars code',
       'media nonbreaking table contextmenu',
       'paste textcolor colorpicker'
       ],
       autoresize_bottom_margin: 50,
       insert_toolbar: 'image media quicktable | bullist numlist | h2 h3 | hr',
       selection_toolbar: 'save_button bold italic underline superscript | forecolor backcolor link | alignleft aligncenter alignright alignjustify | fontselect fontsizeselect h2 h3',
       contextmenu: "image media inserttable | cell row column deletetable | paste pastetext searchreplace | visualblocks pagebreak charmap | code",
       setup: function (editor) {

          editor.addCommand('mceSave', function () {
             save_contract_content(true);
          });

          editor.addShortcut('Meta+S', '', 'mceSave');

          editor.on('MouseLeave blur', function () {
             if (tinymce.activeEditor.isDirty()) {
                save_contract_content();
             }
          });

          editor.on('MouseDown ContextMenu', function () {
             if (!is_mobile() && !$('.left-column').hasClass('hide')) {
                contract_full_view();
             }
          });

          editor.on('blur', function () {
             $.Shortcuts.start();
          });

          editor.on('focus', function () {
             $.Shortcuts.stop();
          });

       }
    }

    if (_templates.length > 0) {
       editor_settings.templates = _templates;
       editor_settings.plugins[3] = 'template ' + editor_settings.plugins[3];
       editor_settings.contextmenu = editor_settings.contextmenu.replace('inserttable', 'inserttable template');
    }

    if(is_mobile()) {

       editor_settings.theme = 'modern';
       editor_settings.mobile    = {};
       editor_settings.mobile.theme = 'mobile';
       editor_settings.mobile.toolbar = _tinymce_mobile_toolbar();

       editor_settings.inline = false;
       window.addEventListener("beforeunload", function (event) {
         if (tinymce.activeEditor.isDirty()) {
            save_contract_content();
         }
      });
    }

    tinymce.init(editor_settings);
    //setTimeout(function(){tinymce.activeEditor.setMode('readonly');},2000);
 });

function save_contract_content(manual) {
   //tinymce.activeEditor.setMode('design');
 var editor = tinyMCE.activeEditor;
 var data = {};
 data.contract_id = contract_id;
 data.content = editor.getContent();
 $.post(admin_url + 'contracts/save_contract_data', data).done(function (response) {
    response = JSON.parse(response);
    if (typeof (manual) != 'undefined') {
          // Show some message to the user if saved via CTRL + S
          alert_float('success', response.message);
       }
       // Invokes to set dirty to false
       editor.save();
    }).fail(function (error) {
       var response = JSON.parse(error.responseText);
       alert_float('danger', response.message);
    });
    //tinymce.activeEditor.setMode('readonly');
 }

 function delete_contract_attachment(wrapper, id) {
    if (confirm_delete()) {
       $.get(admin_url + 'contracts/delete_contract_attachment/' + id, function (response) {
          if (response.success == true) {
             $(wrapper).parents('.contract-attachment-wrapper').remove();

             var totalAttachmentsIndicator = $('.attachments-indicator');
             var totalAttachments = totalAttachmentsIndicator.text().trim();
             if(totalAttachments == 1) {
               totalAttachmentsIndicator.remove();
            } else {
               totalAttachmentsIndicator.text(totalAttachments-1);
            }
         } else {
          alert_float('danger', response.message);
       }
    }, 'json');
    }
    return false;
 }

 function insert_merge_field(field) {
    var key = $(field).text();
    //tinymce.activeEditor.execCommand('mceInsertContent', false, key);
 }

 function contract_full_view() {
    $('.left-column').toggleClass('hide');
    $('.right-column').toggleClass('col-md-7');
    $('.right-column').toggleClass('col-md-12');
    $(window).trigger('resize');
 }

 function add_contract_comment() {
    var comment = $('#comment').val();
    if (comment == '') {
       return;
    }
    var data = {};
    data.content = comment;
    data.contract_id = contract_id;
    $('body').append('<div class="dt-loader"></div>');
    $.post(admin_url + 'contracts/add_comment', data).done(function (response) {
       response = JSON.parse(response);
       $('body').find('.dt-loader').remove();
       if (response.success == true) {
          $('#comment').val('');
          get_contract_comments();
       }
    });
 }

 function get_contract_comments() {
    if (typeof (contract_id) == 'undefined') {
       return;
    }
    requestGet('contracts/get_comments/' + contract_id).done(function (response) {
       $('#contract-comments').html(response);
       var totalComments = $('[data-commentid]').length;
       var commentsIndicator = $('.comments-indicator');
       if(totalComments == 0) {
         commentsIndicator.addClass('hide');
      } else {
         commentsIndicator.removeClass('hide');
         commentsIndicator.text(totalComments);
      }
   });
 }

 function remove_contract_comment(commentid) {
    if (confirm_delete()) {
       requestGetJSON('contracts/remove_comment/' + commentid).done(function (response) {
          if (response.success == true) {

            var totalComments = $('[data-commentid]').length;

            $('[data-commentid="' + commentid + '"]').remove();

            var commentsIndicator = $('.comments-indicator');
            if(totalComments-1 == 0) {
               commentsIndicator.addClass('hide');
            } else {
               commentsIndicator.removeClass('hide');
               commentsIndicator.text(totalComments-1);
            }
         }
      });
    }
 }

 function edit_contract_comment(id) {
    var content = $('body').find('[data-contract-comment-edit-textarea="' + id + '"] textarea').val();
    if (content != '') {
       $.post(admin_url + 'contracts/edit_comment/' + id, {
          content: content
       }).done(function (response) {
          response = JSON.parse(response);
          if (response.success == true) {
             alert_float('success', response.message);
             $('body').find('[data-contract-comment="' + id + '"]').html(nl2br(content));
          }
       });
       toggle_contract_comment_edit(id);
    }
 }

 function toggle_contract_comment_edit(id) {
    $('body').find('[data-contract-comment="' + id + '"]').toggleClass('hide');
    $('body').find('[data-contract-comment-edit-textarea="' + id + '"]').toggleClass('hide');
 }

 function contractGoogleDriveSave(pickData) {
   var data = {};
   data.contract_id = contract_id;
   data.external = 'gdrive';
   data.files = pickData;
   $.post(admin_url + 'contracts/add_external_attachment', data).done(function () {
     var location = window.location.href;
     window.location.href = location.split('?')[0] + '?tab=attachments';
  });
}
var agreement_fields="<?php echo addslashes($agreement_fields); ?>";
var work_order_fields="<?php echo addslashes($work_order_fields); ?>";
function contractTypeChanged(){
   var contract_type=$("#contract_type").val();
   if(contract_type=='' || contract_type=="1"){
      $("#dynamic_variables").html(agreement_fields);
      /*requestGetJSON(admin_url + 'templates/index/1').done(function (response) {
         var data = response.data;
         tinymce.activeEditor.setMode('design'); 
         setTimeout(function(){
               tinymce.activeEditor.setContent('');
               tinymce.activeEditor.execCommand('mceInsertContent', false, data.content);
               $('a[aria-controls="tab_content"]').click();
               setTimeout(function(){tinymce.activeEditor.setMode('readonly');},2000);
         },1000);       
      });*/
   }
   else
   {
      $("#dynamic_variables").html(work_order_fields);
      /*requestGetJSON(admin_url + 'templates/index/2').done(function (response) {
         var data = response.data;
         tinymce.activeEditor.setMode('design'); 
         setTimeout(function(){
               tinymce.activeEditor.setContent('');
               tinymce.activeEditor.execCommand('mceInsertContent', false, data.content);
               $('a[aria-controls="tab_content"]').click();
               setTimeout(function(){tinymce.activeEditor.setMode('readonly');},2000);
         },1000);       
      });*/
   }  
}
contractTypeChanged();
//setTimeout(function(){},100);
</script>
<script>
   /*var _rel_id = $('#clientid'),
   _rel_type = $('#rel_type'),
   _rel_id_wrapper = $('#rel_id_wrapper'),
   _project_wrapper = $('.projects-wrapper'),
   data = {};

   $(function(){
       <?php if (isset($proposal) && $proposal->rel_type === 'customer') { ?>
       init_proposal_project_select('select#project_id')
       <?php } ?>
       $('body').on('change','#rel_type', function() {
           if (_rel_type.val() != 'customer') {
                _project_wrapper.addClass('hide')
           }
       });
   });*/
var _rel_id = $('#rel_id'),
   _rel_type = $('#rel_type'),
   _rel_id_wrapper = $('#rel_id_wrapper'),
   data = {};
$('body').on('change','#rel_id', function() {
  if($(this).val() != ''){
   $.get(admin_url + 'proposals/get_relation_data_values/' + $(this).val() + '/' + _rel_type.val(), function(response) {
     $('input[name="proposal_to"]').val(response.to);
     $('textarea[name="address"]').val(response.address);
     $('input[name="email"]').val(response.email);
     $('input[name="phone"]').val(response.phone);
     $('input[name="city"]').val(response.city);
     $('input[name="state"]').val(response.state);
     $('input[name="zip"]').val(response.zip);
     $('select[name="country"]').selectpicker('val',response.country);
     var currency_selector = $('#currency');
     if(_rel_type.val() == 'customer'){
       if(typeof(currency_selector.attr('multi-currency')) == 'undefined'){
         currency_selector.attr('disabled',true);
       }

      } else {
        currency_selector.attr('disabled',false);
     }
     var proposal_to_wrapper = $('[app-field-wrapper="proposal_to"]');
     if(response.is_using_company == false && !empty(response.company)) {
       proposal_to_wrapper.find('#use_company_name').remove();
       proposal_to_wrapper.find('#use_company_help').remove();
       proposal_to_wrapper.append('<div id="use_company_help" class="hide">'+response.company+'</div>');
       proposal_to_wrapper.find('label')
       .prepend("<a href=\"#\" id=\"use_company_name\" data-toggle=\"tooltip\" data-title=\"<?php echo _l('use_company_name_instead'); ?>\" onclick='document.getElementById(\"proposal_to\").value = document.getElementById(\"use_company_help\").innerHTML.trim(); this.remove();'><i class=\"fa fa-building-o\"></i></a> ");
     } else {
       proposal_to_wrapper.find('label #use_company_name').remove();
       proposal_to_wrapper.find('label #use_company_help').remove();
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
proposal_rel_id_select();
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
 function proposal_rel_id_select(){
   var serverData = {};
   serverData.rel_id = _rel_id.val();
   data.type = _rel_type.val();
   init_ajax_search(_rel_type.val(),_rel_id,serverData);
}
$('.contract-html-content').css("height", $('#contract-form').height() - 200);
</script>
</body>
</html>