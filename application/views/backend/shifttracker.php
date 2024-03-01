<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
         <div class="page-wrapper">
            <div class="message"></div>
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-calendar" style="color:#1976d2"></i> Shift Tracker</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Shift Tracker</li>
                    </ol>
                </div>
            </div>
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">

                <div class="row m-b-10"> 
                    <div class="col-12">
                        <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a href="<?php echo base_url(); ?>shifttracker/Save_Shifttracker" class="text-white"><i class="" aria-hidden="true"></i> Add New Record  </a></button>
                    </div>
                </div>  
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"> Recent Shifts  </h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="attendance123" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Employee Name</th>
                                                <th>Phone No</th>
                                                <th>Client</th>
                                                <th>Date</th>
                                                <th>Total Hours</th>
                                                <th>Client Rate</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <?php
                                            if($shifttracker_list !== false){
                                            ?>
                                           <?php foreach($shifttracker_list as $key => $value): 

            $employee_details   = $this->employee_model->readRecord($value["employee_id"]);
            $client_details     = $this->client_model->readRecord($value["client_id"]);

            $currency_symbol = $settingsvalue->symbol;

            if(($employee_details !== false) && ($client_details !== false)){
                if( (count($employee_details) > 0) && (count($client_details) > 0) ){

                    $total_cost = 0;
                    if( is_numeric($value["total_hours"]) && is_numeric($value["client_rate"]) ){
                        $total_cost = $currency_symbol.($value["total_hours"] * $value["client_rate"]);
                    }
                    

                                            ?>
                                            <tr>
                                                <td><?php echo $key + 1; ?></td>
                                                <td><?php echo $employee_details["first_name"]." ".$employee_details["last_name"]; ?></td>
                                                <td><?php echo $employee_details["em_phone"]; ?></td>
                                                <td><?php echo $client_details["org_name"]; ?></td>
                                                <td><?php echo $value["shift_date"]; ?></td>
                                                <td><?php echo $value["total_hours"]; ?></td>
                                                <td><?php echo $value["client_rate"]; ?></td>
                                                <td><?php echo $total_cost ?></td>
                                                <td class="jsgrid-align-center ">
                                                    <a href="Edit?A=<?php echo $value["id"]; ?>" title="Edit" class="btn btn-sm btn-success waves-effect waves-light" data-value="Approve" >Edit</a>
                                                    <a href="Remind?A=<?php echo $value["id"]; ?>" title="Edit" class="btn btn-sm btn-primary waves-effect waves-light" data-value="Approve" >Send Reminder</a>
                                                </td>
                                            </tr>
                                            <?php
                }
            }
                                            ?>
                                            <?php endforeach; ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<div id="Bulkmodal" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                           <form method="post" action="import" enctype="multipart/form-data">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Add Attendance</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Import Attendance<span><img src="<?php echo base_url(); ?>assets/images/finger.jpg" height="100px" width="100px"></span>Upload only CSV file</h4>
                                             
                                            <input type="file" name="csv_file" id="csv_file" accept=".csv"><br><br>
                                                                                        
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success waves-effect">Save</button>
                                                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
                                            </div>
                                            </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>                             
<?php $this->load->view('backend/footer'); ?>
<script>
    $('#attendance123').DataTable({
        "aaSorting": [[2,'desc']],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
</script>