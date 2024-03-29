<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="<?php if($openEdit == true){echo 'open-edit ';} ?>lead-wrapper" <?php if(isset($lead) && ($lead->junk == 1 || $lead->lost == 1)){ echo 'lead-is-junk-or-lost';} ?>>

   <?php if(isset($lead)){ ?>

   <div class="btn-group pull-left lead-actions-left">

      <a href="#" lead-edit class="mright10 font-medium-xs pull-left<?php if($lead_locked == true){echo ' hide';} ?>">

         <?php echo _l('edit'); ?>

         <i class="fa fa-pencil-square-o"></i>

      </a>

      <a href="#" class="font-medium-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="lead-more-btn">

      <?php echo _l('more'); ?>

      <span class="caret"></span>

      </a>

      <ul class="dropdown-menu dropdown-menu-left" id="lead-more-dropdown">

         <?php if($lead->junk == 0){

         if($lead->lost == 0 && (total_rows(db_prefix().'clients',array('leadid'=>$lead->id)) == 0)){ ?>

         <li>

            <a href="#" onclick="lead_mark_as_lost(<?php echo $lead->id; ?>); return false;">

              <i class="fa fa-mars"></i>

              <?php echo _l('lead_mark_as_lost'); ?>

            </a>

         </li>

         <?php } else if($lead->lost == 1){ ?>

         <li>

            <a href="#" onclick="lead_unmark_as_lost(<?php echo $lead->id; ?>); return false;">

              <i class="fa fa-smile-o"></i>

              <?php echo _l('lead_unmark_as_lost'); ?>

            </a>

         </li>

         <?php } ?>

         <?php } ?>

         <!-- mark as junk -->

         <?php if($lead->lost == 0){

         if($lead->junk == 0 && (total_rows(db_prefix().'clients',array('leadid'=>$lead->id)) == 0)){ ?>

         <li>

            <a href="#" onclick="lead_mark_as_junk(<?php echo $lead->id; ?>); return false;">

              <i class="fa fa fa-times"></i>

              <?php echo _l('lead_mark_as_junk'); ?>

            </a>

         </li>

         <?php } else if($lead->junk == 1){ ?>

         <li>

            <a href="#" onclick="lead_unmark_as_junk(<?php echo $lead->id; ?>); return false;">

              <i class="fa fa-smile-o"></i>

              <?php echo _l('lead_unmark_as_junk'); ?>

            </a>

         </li>

         <?php } ?>

         <?php } ?>

         <?php if((has_permission('leads','','delete') && $lead_locked == false) || is_admin()){ ?>

         <li>

            <a href="<?php echo admin_url('leads/delete/'.$lead->id); ?>" class="text-danger delete-text _delete" data-toggle="tooltip" title="">

              <i class="fa fa-remove"></i>

              <?php echo _l('lead_edit_delete_tooltip'); ?>

            </a>

         </li>

         <?php } ?>

      </ul>

   </div>

      <a data-toggle="tooltip" class="btn btn-default pull-right lead-print-btn lead-top-btn lead-view mleft5" onclick="print_lead_information(); return false;" data-placement="top" title="<?php echo _l('print'); ?>" href="#">

      <i class="fa fa-print"></i>

      </a>

       <?php

           $client = false;

           $convert_to_client_tooltip_email_exists = '';

           if(total_rows(db_prefix().'contacts',array('email'=>$lead->email)) > 0 && total_rows(db_prefix().'clients',array('leadid'=>$lead->id)) == 0){

             $convert_to_client_tooltip_email_exists = _l('lead_email_already_exists');

             $text = _l('lead_convert_to_client');

          } else if (total_rows(db_prefix().'clients',array('leadid'=>$lead->id))){

             $client = true;

          } else {

             $text = _l('lead_convert_to_client');

          }

      ?>

      <?php if($lead_locked == false){ ?>

      <div class="lead-edit<?php if(isset($lead)){echo ' hide';} ?>">

         <button type="button" class="btn btn-info pull-right mleft5 lead-top-btn lead-save-btn" onclick="document.getElementById('lead-form-submit').click();">

              <?php echo _l('submit'); ?>

          </button>

      </div>

      <?php } ?>

      <?php if($client && (has_permission('customers','','view') || is_customer_admin(get_client_id_by_lead_id($lead->id)))){ ?>

      <a data-toggle="tooltip" class="btn btn-success pull-right lead-top-btn lead-view" data-placement="top" title="<?php echo _l('lead_converted_edit_client_profile'); ?>" href="<?php echo admin_url('clients/client/'.get_client_id_by_lead_id($lead->id)); ?>">

      <i class="fa fa-user-o"></i>

      </a>

   <?php } ?>

   <?php if(total_rows(db_prefix().'clients',array('leadid'=>$lead->id)) == 0){ ?>

      <a href="#" data-toggle="tooltip" data-title="<?php echo $convert_to_client_tooltip_email_exists; ?>" class="btn btn-success pull-right lead-convert-to-customer lead-top-btn lead-view" onclick="convert_lead_to_customer(<?php echo $lead->id; ?>); return false;">

            <i class="fa fa-user-o"></i>

            <?php echo $text; ?>

      </a>

   <?php } ?>

   <?php } ?>

   <div class="clearfix no-margin"></div>
   <?php if(isset($lead)){ ?>
   <div class="row mbot15">
      <hr class="no-margin" />
   </div>
   <div class="alert alert-warning hide mtop20" role="alert" id="lead_proposal_warning">

      <?php echo _l('proposal_warning_email_change',array(_l('lead_lowercase'),_l('lead_lowercase'),_l('lead_lowercase'))); ?>

      <hr />

      <a href="#" onclick="update_all_proposal_emails_linked_to_lead(<?php echo $lead->id; ?>); return false;">

        <?php echo _l('update_proposal_email_yes'); ?>

        </a>

      <br />

      <a href="#" onclick="init_lead_modal_data(<?php echo $lead->id; ?>); return false;">

        <?php echo _l('update_proposal_email_no'); ?>

      </a>

   </div>

   <?php } ?>

   <?php echo form_open((isset($lead) ? admin_url('leads/lead/'.$lead->id) : admin_url('leads/lead')),array('id'=>'lead_form')); ?>

   <div class="row">

      <div class="lead-view<?php if(!isset($lead)){echo ' hide';} ?>" id="leadViewWrapper">

         <div class="col-md-4 col-xs-12 lead-information-col">

            <div class="lead-info-heading">

               <h4 class="no-margin font-medium-xs bold">

                  <?php echo _l('lead_info'); ?>

               </h4>

            </div>

            <p class="text-muted lead-field-heading no-mtop"><?php echo _l('lead_add_edit_name'); ?></p>

            <p class="bold font-medium-xs lead-name"><?php echo (isset($lead) && $lead->name != '' ? $lead->name : '-'); echo (isset($lead) && $lead->leadlastname != '' ? ' '.$lead->leadlastname : '-') ?></p>

            <!-- <p class="text-muted lead-field-heading"><?php echo _l('lead_title'); ?></p>

            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->title != '' ? $lead->title : '-') ?></p> -->

            <p class="text-muted lead-field-heading"><?php echo _l('lead_add_edit_email'); ?></p>

            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->email != '' ? '<a href="mailto:'.$lead->email.'">' . $lead->email.'</a>' : '-') ?></p>
            <?php if(isset($lead) && $lead->ano_email != '' && count(explode("|", $lead->ano_email))){ ?>
               <p class="text-muted lead-field-heading">Another Email</p>
               <p class="bold font-medium-xs"><?php echo implode(", ", explode("|", $lead->ano_email)); ?></p>
            <?php } ?>
            <?php if(isset($lead) && $lead->ano_phone != '' && count(explode("|", $lead->ano_phone))){ ?>
               <p class="text-muted lead-field-heading">Another Phone</p>
               <p class="bold font-medium-xs"><?php echo implode(", ", explode("|", $lead->ano_phone)); ?></p>
            <?php } ?>
            <!-- <p class="text-muted lead-field-heading"><?php echo _l('lead_website'); ?></p>

            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->website != '' ? '<a href="'.maybe_add_http($lead->website).'" target="_blank">' . $lead->website.'</a>' : '-') ?></p> -->

            <p class="text-muted lead-field-heading"><?php echo _l('lead_add_edit_phonenumber'); ?></p>

            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->phonenumber != '' ? '<a href="tel:'.$lead->phonenumber.'">' . $lead->phonenumber.'</a>' : '-') ?></p>

            <!-- <p class="text-muted lead-field-heading"><?php echo _l('lead_value'); ?></p>

            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->lead_value != 0 ? app_format_money($lead->lead_value , $base_currency->id) : '-') ?></p> -->

            <!-- <p class="text-muted lead-field-heading"><?php echo _l('lead_company'); ?></p>

            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->company != '' ? $lead->company : '-') ?></p> -->

            <h4><?php echo _l('lead_address'); ?></h4>
            <p class="text-muted lead-field-heading"><?php echo _l('lead_address'); ?></p>

            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->address != '' ? $lead->address : '-') ?></p>

            <p class="text-muted lead-field-heading"><?php echo _l('lead_city'); ?></p>

            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->city != '' ? $lead->city : '-') ?></p>

            <p class="text-muted lead-field-heading"><?php echo _l('lead_state'); ?></p>

            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->state != '' ? $lead->state : '-') ?></p>

            <p class="text-muted lead-field-heading"><?php echo _l('lead_country'); ?></p>

            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->country != 0 ? get_country($lead->country)->short_name : '-') ?></p>

            <p class="text-muted lead-field-heading"><?php echo _l('lead_zip'); ?></p>

            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->zip != '' ? $lead->zip : '-') ?></p>

            <?php if(isset($lead) && $lead->same_as_mailing == 0){ ?>
               <!-- <h4><?php echo _l('lead_mailing_address'); ?></h4>
               <p class="text-muted lead-field-heading"><?php echo _l('lead_address'); ?></p>

               <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->bill_address != '' ? $lead->bill_address : '-') ?></p>

               <p class="text-muted lead-field-heading"><?php echo _l('lead_city'); ?></p>

               <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->bill_city != '' ? $lead->bill_city : '-') ?></p>

               <p class="text-muted lead-field-heading"><?php echo _l('lead_state'); ?></p>

               <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->bill_state != '' ? $lead->bill_state : '-') ?></p>

               <p class="text-muted lead-field-heading"><?php echo _l('lead_country'); ?></p>

               <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->bill_country != 0 ? get_country($lead->bill_country)->short_name : '-') ?></p>

               <p class="text-muted lead-field-heading"><?php echo _l('lead_zip'); ?></p>

               <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->bill_zip != '' ? $lead->bill_zip : '-') ?></p> -->
            <?php } ?>
         </div>

         <div class="col-md-4 col-xs-12 lead-information-col">

            <div class="lead-info-heading">

               <h4 class="no-margin font-medium-xs bold">

                  <?php echo _l('lead_general_info'); ?>

               </h4>

            </div>

            <p class="text-muted lead-field-heading no-mtop"><?php echo _l('lead_add_edit_status'); ?></p>

            <p class="bold font-medium-xs mbot15"><?php echo (isset($lead) && $lead->status_name != '' ? $lead->status_name : '-') ?></p>

            <p class="text-muted lead-field-heading"><?php echo _l('lead_add_edit_source'); ?></p>

            <p class="bold font-medium-xs mbot15"><?php echo (isset($lead) && $lead->source_name != '' ? $lead->source_name : '-') ?></p>
            
            <p class="text-muted lead-field-heading"><?php echo _l('lead_category'); ?></p>
            <p class="bold font-medium-xs mbot15"><?php echo (isset($lead) && $lead->job_category_name != '' ? $lead->job_category_name : '-') ?></p>

            <p class="text-muted lead-field-heading"><?php echo _l('lead_work_type'); ?></p>
            <p class="bold font-medium-xs mbot15"><?php echo (isset($lead) && $lead->work_type_name != '' ? $lead->work_type_name : '-') ?></p>

            <p class="text-muted lead-field-heading"><?php echo _l('lead_trade_type'); ?></p>
            <p class="bold font-medium-xs mbot15">
               <?php if(isset($lead) && $lead->trade_type != ''){
                  echo get_trade_type($lead->trade_type);
               } else {
                 echo '-';
               } ?></p>


            <p class="text-muted lead-field-heading"><?php echo _l('lead_location_photo'); ?></p>
            <p class="bold font-medium-xs mbot15">
               <?php
               if(isset($lead) && $lead->location_photo != ''){
                  $locimgArr = explode("|", $lead->location_photo);
                  $locationPath = 'uploads/leads/location/';
                  if(count($locimgArr) > 0){
                     for ($ijk=0; $ijk < count($locimgArr); $ijk++) {
                        if (file_exists($locationPath.$locimgArr[$ijk])) {
                           echo '<img src="'.site_url($locationPath.$locimgArr[$ijk]).'" style="height:75px;width:75px;'.($ijk != 0?"margin-left: 5px;":"").'" />';
                        }
                     }
                  } else {
                     echo '-';
                  }
               } else {
                  echo '-';
               }
               ?>

            <?php if(!is_language_disabled()){ ?>

            <p class="text-muted lead-field-heading"><?php echo _l('localization_default_language'); ?></p>

            <p class="bold font-medium-xs mbot15"><?php echo (isset($lead) && $lead->default_language != '' ? ucfirst($lead->default_language) : _l('system_default_string')) ?></p>

            <?php } ?>

            <p class="text-muted lead-field-heading"><?php echo _l('lead_add_edit_assigned'); ?></p>

            <p class="bold font-medium-xs mbot15"><?php echo (isset($lead) && $lead->assigned != 0 ? get_staff_full_name($lead->assigned) : '-') ?></p>
            <!-- 31-10-2022 -->
            <p class="text-muted lead-field-heading"><?php echo _l('Policy Number'); ?></p>

            <p class="bold font-medium-xs mbot15"><?php echo (isset($lead)? $lead->policy_number : '-') ?></p>

            <p class="text-muted lead-field-heading"><?php echo _l('Claim Number'); ?></p>

            <p class="bold font-medium-xs mbot15"><?php echo (isset($lead)? $lead->claim_number : '-') ?></p>
            <!-- 31-10-2022 -->

            <p class="text-muted lead-field-heading"><?php echo _l('tags'); ?></p>

            <p class="bold font-medium-xs mbot10">

               <?php

                  if(isset($lead)){

                    $tags = get_tags_in($lead->id,'lead');

                    if(count($tags) > 0){

                      echo render_tags($tags);

                      echo '<div class="clearfix"></div>';

                   } else {

                      echo '-';

                   }

                  }

                  ?>

            </p>

            <p class="text-muted lead-field-heading"><?php echo _l('leads_dt_datecreated'); ?></p>

            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->dateadded != '' ? '<span class="text-has-action" data-toggle="tooltip" data-title="'._dt($lead->dateadded).'">' . time_ago($lead->dateadded) .'</span>' : '-') ?></p>

            <p class="text-muted lead-field-heading"><?php echo _l('leads_dt_last_contact'); ?></p>

            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->lastcontact != '' ? '<span class="text-has-action" data-toggle="tooltip" data-title="'._dt($lead->lastcontact).'">' . time_ago($lead->lastcontact) .'</span>' : '-') ?></p>

            <p class="text-muted lead-field-heading"><?php echo _l('lead_public'); ?></p>

            <p class="bold font-medium-xs mbot15">

               <?php if(isset($lead)){

                    if($lead->is_public == 1){

                      echo _l('lead_is_public_yes');

                    } else {

                      echo _l('lead_is_public_no');

                    }

                  } else {

                    echo '-';

                  }

               ?>

            </p>

            <?php if(isset($lead) && $lead->from_form_id != 0){ ?>

            <p class="text-muted lead-field-heading"><?php echo _l('web_to_lead_form'); ?></p>

            <p class="bold font-medium-xs mbot15"><?php echo $lead->form_data->name; ?></p>

            <?php } ?>

         </div>

         <div class="col-md-4 col-xs-12 lead-information-col">

            <?php if(total_rows(db_prefix().'customfields',array('fieldto'=>'leads','active'=>1)) > 0 && isset($lead)){ ?>

            <div class="lead-info-heading">

               <h4 class="no-margin font-medium-xs bold">

                  <?php echo _l('custom_fields'); ?>

               </h4>

            </div>

            <?php

            $custom_fields = get_custom_fields('leads');

            foreach ($custom_fields as $field) {

                $value = get_custom_field_value($lead->id, $field['id'], 'leads'); ?>

                <p class="text-muted lead-field-heading no-mtop"><?php echo $field['name']; ?></p>

                <p class="bold font-medium-xs"><?php echo ($value != '' ? $value : '-') ?></p>

            <?php } ?>

            <?php } ?>

         </div>

         <div class="clearfix"></div>

         <div class="col-md-12">

            <p class="text-muted lead-field-heading"><?php echo _l('lead_description'); ?></p>

            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->description != '' ? $lead->description : '-') ?></p>

         </div>

      </div>

      <div class="clearfix"></div>

      <div class="lead-edit<?php if(isset($lead)){echo ' hide';} ?>">

         <div class="col-md-4">

          <?php

            $selected = '';

            if(isset($lead)){

              $selected = $lead->status;

            } else if(isset($status_id)){

              $selected = $status_id;

            }

            echo render_leads_status_select($statuses, $selected,'lead_add_edit_status');

          ?>

         </div>

         <div class="col-md-4">

            <?php

               $selected = (isset($lead) ? $lead->source : get_option('leads_default_source'));

               echo render_leads_source_select($sources, $selected,'lead_add_edit_source');

            ?>

         </div>

         <div class="col-md-4">

            <?php

               $assigned_attrs = array();

               $selected = (isset($lead) ? $lead->assigned : get_staff_user_id());

               if(isset($lead)

                  && $lead->assigned == get_staff_user_id()

                  && $lead->addedfrom != get_staff_user_id()

                  && !is_admin($lead->assigned)

                  && !has_permission('leads','','view')

               ){

                 $assigned_attrs['disabled'] = true;

               }

               echo render_select('assigned',$members,array('staffid',array('firstname','lastname')),'lead_add_edit_assigned',$selected,$assigned_attrs); ?>

         </div>

         <div class="clearfix"></div>
         <div class="col-md-4">
            <?php
               $selected = (isset($lead) ? $lead->job_category : '');
               echo render_select('job_category',$categories,array('id','name'),'lead_category',$selected,[]); ?>

         </div>
         <div class="col-md-4">
            <?php
               $selected = (isset($lead) ? $lead->work_type : '');
               echo render_select('work_type',$work_types,array('id','name'),'lead_work_type',$selected,[]); ?>
         </div>
         <div class="col-md-4">
            <?php
               $selected = (isset($lead) ? $lead->trade_type : '');
               echo render_select('trade_type[]',$trade_types,array('id','name'),'lead_trade_type',$selected,['multiple'=>'multiple']); ?>
         </div>
         <div class="clearfix"></div>

            <hr class="mtop5 mbot10" />

             <div class="col-md-12">

                  <div class="form-group no-mbot" id="inputTagsWrapper">

                     <label for="tags" class="control-label"><i class="fa fa-tag" aria-hidden="true"></i> <?php echo _l('tags'); ?></label>

                     <input type="text" class="tagsinput" id="tags" name="tags" value="<?php echo (isset($lead) ? prep_tags_input(get_tags_in($lead->id,'lead')) : ''); ?>" data-role="tagsinput">

                  </div>

               </div>

         <div class="clearfix"></div>

         <hr class="no-mtop mbot15" />



         <div class="col-md-6">
            <div class="row">
            <?php $value = (isset($lead) ? $lead->name : ''); ?>
               <div class="col-md-6">
                  <?php echo render_input('name','First Name',$value); ?>
               </div>
               <?php $value = (isset($lead) ? $lead->leadlastname : ''); ?>
               <div class="col-md-6">
                  <?php echo render_input('leadlastname','Last Name',$value); ?>
               </div>
            </div>
           

            <?php $value = (isset($lead) ? $lead->title : ''); ?>

            <?php echo '';//render_input('title','lead_title',$value); ?>

            <?php $value = (isset($lead) ? $lead->email : ''); ?>
            <div class="mul_email">
               <?php echo render_input('email','lead_add_edit_email',$value); ?>
            </div>
            <a href="javascript:;" class="add_ano_email">+ Add Another Email</a>

           <?php /*if((isset($lead) && empty($lead->website)) || !isset($lead)){

                 $value = (isset($lead) ? $lead->website : '');

                 echo render_input('website','lead_website',$value);

              } else { ?>

              <div class="form-group">

               <label for="website"><?php echo _l('lead_website'); ?></label>

               <div class="input-group">

                  <input type="text" name="website" id="website" value="<?php echo $lead->website; ?>" class="form-control">

                  <div class="input-group-addon">

                     <span>

                      <a href="<?php echo maybe_add_http($lead->website); ?>" target="_blank" tabindex="-1">

                        <i class="fa fa-globe"></i>

                      </a>

                    </span>

                  </div>

               </div>

            </div>

            <?php }*/

            $value = (isset($lead) ? $lead->phonenumber : ''); ?>
            <div class="mul_phone">
               <?php echo render_input('phonenumber','lead_add_edit_phonenumber',$value); ?>
            </div>
            <a href="javascript:;" class="add_ano_phone">+ Add Another Phone</a>
            

            <!-- <div class="form-group">

                <label for="lead_value"><?php echo _l('lead_value'); ?></label>

                <div class="input-group" data-toggle="tooltip" title="<?php echo _l('lead_value_tooltip'); ?>">

                    <input type="number" class="form-control" name="lead_value" value="<?php if(isset($lead)){echo $lead->lead_value; }?>">

                    <div class="input-group-addon">

                      <?php echo $base_currency->symbol; ?>

                    </div>

                </div>

               </label>

            </div> -->

            <?php $value = (isset($lead) ? $lead->company : ''); ?>

            <?php //echo render_input('company','lead_company',$value); ?>

         </div>

         <div class="col-md-6">
            <div class="form-group">
               <label for="location_photo" class="profile-image"><?php echo _l('lead_location_photo_choose'); ?></label>
               <input type="file" name="location_photo[]" class="form-control" id="location_photo" multiple>
            </div>
            <?php if(!is_language_disabled()){ ?>
               <div class="form-group">
                  <label for="default_language" class="control-label"><?php echo _l('localization_default_language'); ?></label>
                  <select name="default_language" data-live-search="true" id="default_language" class="form-control selectpicker" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                     <option value=""><?php echo _l('system_default_string'); ?></option>
                     <?php foreach($this->app->get_available_default_languages() as $availableLanguage){
                        $selected = '';
                        if(isset($lead)){
                          if($lead->default_language == $availableLanguage){
                            $selected = 'selected';
                         }
                        }
                        ?>
                     <option value="<?php echo $availableLanguage; ?>" <?php echo $selected; ?>><?php echo ucfirst($availableLanguage); ?></option>
                     <?php } ?>
                  </select>
               </div>
            <?php } ?>

            <?php $value = (isset($lead) ? $lead->address : ''); ?>

            <?php echo render_textarea('address','lead_address',$value,array('rows'=>1,'style'=>'height:36px;font-size:100%;')); ?>

            <?php $value = (isset($lead) ? $lead->city : ''); ?>

            <?php echo render_input('city','lead_city',$value); ?>

            <?php $value = (isset($lead) ? $lead->state : ''); ?>

            <?php echo render_input('state','lead_state',$value); ?>

            <?php

               $countries= get_all_countries();
               $get_default_countries= get_default_countries();

               $customer_default_country = get_option('customer_default_country');

               $selected =( isset($lead) ? $lead->country : $customer_default_country);

               echo render_select( 'country',$get_default_countries,array( 'country_id',array( 'short_name')), 'lead_country',$selected,array('data-none-selected-text'=>_l('dropdown_non_selected_tex')));

               ?>

            <?php $value = (isset($lead) ? $lead->zip : ''); ?>

            <?php echo render_input('zip','lead_zip',$value); ?>

            

         </div>
         <!-- <div class="clearfix"></div>
         <?php $isSameChecked = (isset($lead) && $lead->same_as_mailing == 0 ? '' : 'checked'); ?>
         <div class="col-md-3">
            <h4>Billing Address</h4>
            <input type="checkbox" name="same_as_mailing" value="1" <?php echo $isSameChecked; ?> id="same_as_mailing"/> <label for="same_as_mailing">Same as mailing</label>
         </div>
         <div class="clearfix"></div>
         <div class="div_billing <?php echo $isSameChecked != ''?'hidden':''; ?>">
            <div class="col-md-4">
               <?php $value = (isset($lead) ? $lead->bill_address : ''); ?>

               <?php echo render_textarea('bill_address','lead_address',$value,array('rows'=>1,'style'=>'height:36px;font-size:100%;')); ?>
            </div>
            <div class="col-md-4">
               <?php $value = (isset($lead) ? $lead->bill_city : ''); ?>

               <?php echo render_input('bill_city','lead_city',$value); ?>
            </div>
            <div class="col-md-4">
               <?php $value = (isset($lead) ? $lead->bill_state : ''); ?>

               <?php echo render_input('bill_state','lead_state',$value); ?>
            </div>
            <div class="col-md-4">
               <?php
                  $selected =( isset($lead) ? $lead->bill_country : $customer_default_country);

                  echo render_select( 'bill_country',$get_default_countries,array( 'country_id',array( 'short_name')), 'lead_country',$selected,array('data-none-selected-text'=>_l('dropdown_non_selected_tex')));

                  ?>
            </div>
            <div class="col-md-4">
               <?php $value = (isset($lead) ? $lead->bill_zip : ''); ?>

               <?php echo render_input('bill_zip','lead_zip',$value); ?>
            </div>
         </div> -->
         <div class="clearfix"></div>
         <div class="col-md-12 mtop15">
            <div class="row">
               <?php $value = (isset($lead) ? $lead->policy_number : ''); ?>
                  <div class="col-md-6">
                     <?php echo render_input('policy_number','Policy Number',$value); ?>
                  </div>
                  <?php $value = (isset($lead) ? $lead->claim_number : ''); ?>
                  <div class="col-md-6">
                     <?php echo render_input('claim_number','Claim Number',$value); ?>
                  </div>
               </div>
         </div>
         <div class="clearfix"></div>
         <div class="col-md-12">

            <?php $value = (isset($lead) ? $lead->description : ''); ?>

            <?php echo render_textarea('description','lead_description',$value); ?>

            <div class="row">

               <div class="col-md-12">

                  <?php if(!isset($lead)){ ?>

                  <div class="lead-select-date-contacted hide">

                     <?php echo render_datetime_input('custom_contact_date','lead_add_edit_datecontacted','',array('data-date-end-date'=>date('Y-m-d'))); ?>

                  </div>

                  <?php } else { ?>

                     <?php echo render_datetime_input('lastcontact','leads_dt_last_contact',_dt($lead->lastcontact),array('data-date-end-date'=>date('Y-m-d'))); ?>

                  <?php } ?>

                  <div class="checkbox-inline checkbox checkbox-primary<?php if(isset($lead)){echo ' hide';} ?><?php if(isset($lead) && (is_lead_creator($lead->id) || has_permission('leads','','edit'))){echo ' lead-edit';} ?>">

                  <input type="checkbox" name="is_public" <?php if(isset($lead)){if($lead->is_public == 1){echo 'checked';}}; ?> id="lead_public">

                  <label for="lead_public"><?php echo _l('lead_public'); ?></label>

               </div>

                  <?php if(!isset($lead)){ ?>
                  <div class="checkbox-inline checkbox checkbox-primary">
                     <input type="checkbox" name="contacted_today" id="contacted_today" checked>
                     <label for="contacted_today"><?php echo _l('lead_add_edit_contacted_today'); ?></label>
                  </div>
                <?php } ?>
               </div>
            </div>
         </div>
         <div class="col-md-12 mtop15">

            <?php $rel_id = (isset($lead) ? $lead->id : false); ?>

            <?php echo render_custom_fields('leads',$rel_id); ?>

         </div>

         <div class="clearfix"></div>

      </div>

   </div>

   <?php if(isset($lead)){ ?>

   <div class="lead-latest-activity lead-view">

      <div class="lead-info-heading">

         <h4 class="no-margin bold font-medium-xs"><?php echo _l('lead_latest_activity'); ?></h4>

      </div>

      <div id="lead-latest-activity" class="pleft5"></div>

   </div>

   <?php } ?>

   <?php if($lead_locked == false){ ?>

   <div class="lead-edit<?php if(isset($lead)){echo ' hide';} ?>">

      <hr />

      <button type="submit" class="btn btn-info pull-right lead-save-btn" id="lead-form-submit"><?php echo _l('submit'); ?></button>

      <button type="button" class="btn btn-default pull-right mright5" data-dismiss="modal"><?php echo _l('close'); ?></button>

   </div>

   <?php } ?>

   <div class="clearfix"></div>

   <?php echo form_close(); ?>

</div>

<?php if(isset($lead) && $lead_locked == true){ ?>

<script>

  $(function() {

      // Set all fields to disabled if lead is locked

      $.each($('.lead-wrapper').find('input, select, textarea'), function() {

          $(this).attr('disabled', true);

          if($(this).is('select')) {

              $(this).selectpicker('refresh');

          }

      });

  });

</script>

<?php } ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCe8HvpYz71UY4riWVHh5qJ26blcKBHBv8&callback=initAutoCompvvv&libraries=places&v=weekly"
      defer ></script>
      <script>
         function initAutoCompvvv(){
            initAutocomplete();
            //initAutocompleteBill();
         }
         function initAutoComp(){
            $("#lead-modal").on('shown.bs.modal',function(){
               initAutocomplete();
               //initAutocompleteBill();
            });
         }
var autocomplete;
var address1Field;
var address2Field;
var postalField;

function initAutocomplete() {
  address1Field = document.getElementById('address');
  address2Field = document.getElementById("city");
  postalField = document.getElementById("zip");
  // Create the autocomplete object, restricting the search predictions to
  // addresses in the US and Canada.
  autocomplete = new google.maps.places.Autocomplete(address1Field, {
    componentRestrictions: { country: ["us", "ca"] },
    fields: ["address_components", "geometry"],
    types: ["address"],
  });
  //address1Field.focus();
  // When the user selects an address from the drop-down, populate the
  // address fields in the form.
  autocomplete.addListener("place_changed", fillInAddress);
}

function fillInAddress() {
  // Get the place details from the autocomplete object.
  const place = autocomplete.getPlace();
  var address1 = "";
  var postcode = "";

  // Get each component of the address from the place details,
  // and then fill-in the corresponding field on the form.
  // place.address_components are google.maps.GeocoderAddressComponent objects
  // which are documented at http://goo.gle/3l5i5Mr
  for (const component of place.address_components) {
    // @ts-ignore remove once typings fixed
    const componentType = component.types[0];

    switch (componentType) {
      case "street_number": {
        address1 = `${component.long_name} ${address1}`;
        break;
      }

      case "route": {
        address1 += component.short_name;
        break;
      }

      case "postal_code": {
        postcode = `${component.long_name}${postcode}`;
        break;
      }

      case "postal_code_suffix": {
        postcode = `${postcode}-${component.long_name}`;
        break;
      }
      case "locality":
        document.querySelector("#city").value = component.long_name;
        break;
      case "administrative_area_level_1": {
        document.querySelector("#state").value = component.short_name;
        break;
      }
      case "country":
         if("United States"==component.long_name)
         {
            document.querySelector("#country").value = 236;
            $("#country").selectpicker('refresh');
         }
        break;
    }
  }

  address1Field.value = address1;
  postalField.value = postcode;
  // After filling the form with address components from the Autocomplete
  // prediction, set cursor focus on the second address line to encourage
  // entry of subpremise information such as apartment, unit, or floor number.
  address2Field.focus();
}

window.initAutocomplete = initAutocomplete;


////////////////////////////////////
/*var autocompletebill;
var address1FieldBill;
var address2FieldBill;
var postalFieldBill;

function initAutocompleteBill() {
  address1FieldBill = document.getElementById('bill_address');
  address2FieldBill = document.getElementById("bill_city");
  postalFieldBill = document.getElementById("bill_zip");
  // Create the autocomplete object, restricting the search predictions to
  // addresses in the US and Canada.
  autocompletebill = new google.maps.places.Autocomplete(address1FieldBill, {
    componentRestrictions: { country: ["us", "ca"] },
    fields: ["address_components", "geometry"],
    types: ["address"],
  });
  //address1FieldBill.focus();
  // When the user selects an address from the drop-down, populate the
  // address fields in the form.
  autocompletebill.addListener("place_changed", fillInAddressBill);
}

function fillInAddressBill() {
  // Get the place details from the autocomplete object.
  const place = autocompletebill.getPlace();
  var address1 = "";
  var postcode = "";

  // Get each component of the address from the place details,
  // and then fill-in the corresponding field on the form.
  // place.address_components are google.maps.GeocoderAddressComponent objects
  // which are documented at http://goo.gle/3l5i5Mr
  for (const component of place.address_components) {
    // @ts-ignore remove once typings fixed
    const componentType = component.types[0];

    switch (componentType) {
      case "street_number": {
        address1 = `${component.long_name} ${address1}`;
        break;
      }

      case "route": {
        address1 += component.short_name;
        break;
      }

      case "postal_code": {
        postcode = `${component.long_name}${postcode}`;
        break;
      }

      case "postal_code_suffix": {
        postcode = `${postcode}-${component.long_name}`;
        break;
      }
      case "locality":
        document.querySelector("#bill_city").value = component.long_name;
        break;
      case "administrative_area_level_1": {
        document.querySelector("#bill_state").value = component.short_name;
        break;
      }
      case "country":
         if("United States"==component.long_name)
         {
            document.querySelector("#bill_country").value = 236;
            $("#bill_country").selectpicker('refresh');
         }
        break;
    }
  }

  address1FieldBill.value = address1;
  postalFieldBill.value = postcode;
  // After filling the form with address components from the Autocomplete
  // prediction, set cursor focus on the second address line to encourage
  // entry of subpremise information such as apartment, unit, or floor number.
  address2FieldBill.focus();
}

window.initAutocompleteBill = initAutocompleteBill;*/

$(document).ready(function() {
   let ijk = 1;
   $('body').on('click','.add_ano_email', function(e){
      let newHtml = '<div class="form-group" ><label for="email'+ijk+'" class="control-label">Another Email</label><input type="text" id="email'+ijk+'" name="ano_email[]" class="form-control" value=""></div>';
      //let newHtml = '<div class="form-group" ><label for="email'+ijk+'" class="control-label">Another Email</label><div class="input-group"><input type="text" id="email'+ijk+'" name="ano_email[]" class="form-control" value=""><div class="input-group-addon">x</div></div></div>';
      $('#lead_form').find('.mul_email').append(newHtml);
      ijk++;
   })
   let ijkm = 1;

   $('body').on('click','.add_ano_phone', function(e){
      let newHtml2 = '<div class="form-group" ><label for="phone'+ijkm+'" class="control-label">Another Phone</label><input type="text" id="phone'+ijkm+'" name="ano_phone[]" class="form-control" value=""></div>';
      $('#lead_form').find('.mul_phone').append(newHtml2);
      ijkm++;
   })

   $('body').on('change','input[name="same_as_mailing"]', function(e){
      $('#lead_form').find('.div_billing').removeClass('hidden').addClass('hidden');
      if(!$(this).prop('checked')){
         $('#lead_form').find('.div_billing').removeClass('hidden');
      }
   })
});
</script>

