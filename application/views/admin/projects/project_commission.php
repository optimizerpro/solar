<?php
    $CI =& get_instance();
    $CI->load->database();
?>
<style>
    .dt-table-loading.table, .table-loading .dataTables_filter, .table-loading .dataTables_length, .table-loading .dt-buttons, .table-loading table tbody tr, .table-loading table thead th{
        opacity: 1 !important;
    }
</style>
<div class="row">
    <div class="col-md-6">
        <h4>Payment Received</h4>
        <div class="row">
            <div class="col-md-12">
                <?php
                    $query = $CI->db->query("SELECT id,total,clientid,total_tax,duedate,status FROM tblinvoices WHERE project_id='".$project_id."' AND status=2");
                ?>
                <!--<div class="table-responsive">-->
                    <table class="table table-sm mydatatable datatable" id="mydatatable">
                        <thead >
                            <tr>
                                <th style="text-align:center;">#</th>
                                <th style="text-align:center;">Customer</th>
                                <th style="text-align:center;">Amount</th>
                                <th style="text-align:center;">Total Tax</th>
                                <th style="text-align:center;">Due Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                //echo $query->num_rows();
                                $total_payment_received=0;
                                if($query->num_rows()>0){
                                    //echo $query->num_rows();
                                    foreach ($query->result() as $row){
                                        //var_dump($row);
                                        $clientid=$row->clientid;
                                        $clientname="";
                                        if($clientid!='' && $clientid!=0){
                                            $clientquery=$CI->db->query("SELECT * FROM tblclients WHERE userid='".$clientid."'");
                                            if($clientquery->num_rows()>0){
                                                foreach($clientquery->result() as $clientrow){
                                                    //var_dump($clientrow);
                                                    $clientname=$clientrow->company;
                                                }
                                            }
                                        }
                                        $total_payment_received=$total_payment_received+$row->total;
                                    
                            ?>
                                        <tr>
                                            <td style="text-align:center;"><?php echo $row->id; ?></td>
                                            <td style="text-align:center;"><?php echo $clientname; ?></td>
                                            <td>$<?php echo $row->total; ?></td>
                                            <td style="text-align:center;">$<?php echo $row->total_tax; ?></td>
                                            <td style="text-align:center;"><?php echo date("d M , Y",strtotime($row->duedate)); ?></td>
                                        </tr>
                            <?php
                                    }
                                }
                            ?>
                            
                        </tbody>
                    </table>
                    <hr/>
                    <h5 class="text-center">Total Payment Received : $<?php echo number_format($total_payment_received,2); ?></h5>
                    <hr/>
                <!--</div>-->
            </div>
        </div>
        
        <h4>Total Expenses</h4>
        <div class="row">
            <div class="col-md-12">
                <?php
                    $query = $CI->db->query("SELECT id,clientid,amount as total,tax as total_tax,date as duedate FROM tblexpenses WHERE project_id='".$project_id."'");
                ?>
                <!--<div class="table-responsive">-->
                    <table class="table table-sm mydatatable datatable" id="mydatatable1">
                        <thead >
                            <tr>
                                <th style="text-align:center;">#</th>
                                <th style="text-align:center;">Customer</th>
                                <th style="text-align:center;">Amount</th>
                                <th style="text-align:center;">Total Tax</th>
                                <th style="text-align:center;">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                //echo $query->num_rows();
                                $total_expense_made=0;
                                if($query->num_rows()>0){
                                    //echo $query->num_rows();
                                    foreach ($query->result() as $row){
                                        //var_dump($row);
                                        $clientid=$row->clientid;
                                        $clientname="";
                                        if($clientid!='' && $clientid!=0){
                                            $clientquery=$CI->db->query("SELECT * FROM tblclients WHERE userid='".$clientid."'");
                                            if($clientquery->num_rows()>0){
                                                foreach($clientquery->result() as $clientrow){
                                                    //var_dump($clientrow);
                                                    $clientname=$clientrow->company;
                                                }
                                            }
                                        }
                                        $total_expense_made=$total_expense_made+$row->total;
                                    
                            ?>
                                        <tr>
                                            <td style="text-align:center;"><?php echo $row->id; ?></td>
                                            <td style="text-align:center;"><?php echo $clientname; ?></td>
                                            <td>$<?php echo $row->total; ?></td>
                                            <td style="text-align:center;">$<?php echo number_format($row->total_tax,2); ?></td>
                                            <td style="text-align:center;"><?php echo date("d M , Y",strtotime($row->duedate)); ?></td>
                                        </tr>
                            <?php
                                    }
                                }
                            ?>
                            
                        </tbody>
                    </table>
                    <hr/>
                    <h5 class="text-center">Total Expenses : $<?php echo number_format($total_expense_made,2); ?></h5>
                    <hr/>
                    <!--</div>-->
            </div>
        </div>
    </div>
    <?php
    $perDropDown = '';
    for ($i=5; $i <= 100; $i++) { 
        if(($i % 5) == 0){
            $perDropDown .= '<option value="'.$i.'">'.$i.'</option>';
        }
    }
    ?>
    <div class="col-md-6">
        <?php
         echo form_open(base_url('admin/projects/save_sales_commision'),array('id'=>'salescommision-form','class'=>'salescommision-form'));
         ?>
         <input type="hidden" name="project_id" value="<?php echo $project->id; ?>">
            <h4>Job commissions calculated based on gross profit range</h4>
            <div class="row">
                <div class="col-md-6"><h5>Gross Profit : $<?php echo number_format(($gross_profit=$total_payment_received-$total_expense_made),2); ?></h5></div>
                <div class="col-md-6"><h5>Gross Profit Percentage : 
                    <?php
                        if($total_payment_received==0){
                            echo '--';
                        }
                        else{
                            $percentage=($gross_profit*100)/$total_payment_received;
                            echo number_format($percentage,2).'%';
                        }
                        $commission=0;
                    ?></h5>
                </div>
                <div class="col-md-6">
                    <input type="hidden" name="gross_profit" id="gross_profit" value="<?php echo $gross_profit; ?>">
                    <input type="hidden" name="commission" id="commission" value="<?php echo $commission; ?>">
                    <input type="hidden" name="total_payment_received" id="total_payment_received" value="<?php echo $total_payment_received; ?>">
                    <input type="hidden" name="total_expense_made" id="total_expense_made" value="<?php echo $total_expense_made; ?>">                
                    <div class="hidden" id="perDropDown"><?php echo $perDropDown; ?></div>
                    <div class="form-group">
                        <label for="gross_profit_range">Rate</label>
                        <select id="gross_profit_range" name="gross_profit_range" class="form-control">
                            <option value="0" selected>0</option>
                            <?php echo $perDropDown; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <h5>Commission <span id="commission_span">$0.00</span></h5>
                    </div>
                </div>
            </div>
            <!--  -->
            <h4>Commissions calculate per salesperson</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive s_table" style="border-bottom:2px solid gray;margin-bottom:10px;">
                        <table class="table commision-sales-table items table-main-estimate-edit">
                           <thead>
                              <tr>
                                 <th align="left">Name</th>
                                 <th align="left">Portion</th>
                                 <th>Amount</th>
                                 <th align="center"><i class="fa fa-cog"></i></th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr class="main">
                                 <td>
                                    <?php
                                     $i = 0;
                                     $selected = '';
                                     foreach($staff as $member){
                                      if(isset($proposal)){
                                        if($proposal->assigned == $member['staffid']) {
                                          $selected = $member['staffid'];
                                        }
                                      }
                                      $i++;
                                     }
                                     echo render_select('assigned_main',$staff,array('staffid',array('firstname','lastname')),'',$selected);
                                    ?>
                                 </td>
                                 <td>
                                    <select name="sales_portion_main" class="form-control">
                                        <option value="0" selected>0</option>
                                        <?php echo $perDropDown; ?>
                                    </select>
                                 </td>
                                 <td>
                                    <input type="hidden" name="sales_portion_amount_main" value="">
                                    <span class="sales_portion_amount_main">0.00</span>
                                 </td>
                                 <td>
                                    <button type="button" class="btn pull-right btn-info add_item_to_sales"><i class="fa fa-check"></i></button>
                                 </td>
                              </tr>
                              <?php
                              if(isset($project) && isset($project->sales_commision) && count($project->sales_commision) > 0){
                                $trHtml = '';
                                foreach ($project->sales_commision as $k1 => $v1) {
                                  $trHtml .= '<tr class="used">';
                                  $trHtml .= '<td><input type="hidden" name="sales_staff[]" value="'.$v1['staff_id'].'">'.$v1['full_name'].'</td>';
                                  $trHtml .= '<td><input type="hidden" name="sales_portion[]" value="'.$v1['percent'].'">'.$v1['percent'].'%</td>';
                                  $trHtml .= '<td><input type="hidden" name="sales_portion_amount[]" value="'.$v1['amount'].'">$'.$v1['amount'].'</td>';
                                  $trHtml .= '<td><a href="javascript:;" class="btn btn-danger pull-left delete_sales_item"><i class="fa fa-times"></i></a></td>';
                                  $trHtml .= '</tr>';
                                }
                                echo $trHtml;
                              } ?>
                           </tbody>
                        </table>
                     </div>
                </div>
            </div>
            <!--  -->
            <div class="text-right">
                <button class="btn btn-info mleft5" type="submit">
                  <?php echo _l('submit'); ?>
                </button>
           </div>
       <?php echo form_close(); ?>
    </div>
</div>