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
                <div class="form-group">
                    <label for="gross_profit_range">Rate</label>
                    <select id="gross_profit_range" name="gross_profit_range" class="form-control">
                        <option value="0" selected>0</option>
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                        <option value="30">30</option>
                        <option value="35">35</option>
                        <option value="40">40</option>
                        <option value="45">45</option>
                        <option value="50">50</option>
                        <option value="55">55</option>
                        <option value="60">60</option>
                        <option value="65">65</option>
                        <option value="70">70</option>
                        <option value="75">75</option>
                        <option value="80">80</option>
                        <option value="85">85</option>
                        <option value="90">90</option>
                        <option value="95">95</option>
                        <option value="100">100</option>

                    </select>
                </div>
                <div class="form-group">
                    <h5>Commission <span id="commission_span">$0.00</span></h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">

    </div>
</div>