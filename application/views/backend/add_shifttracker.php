<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<?php /* <div style="background-color: #333; width:600px; height:1500px" ></div>*/ ?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" ><!--
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
-->
<link href="<?php echo base_url(); ?>assets/css/bootstrap3.3.6.jed.css" rel="stylesheet" />



         <div class="page-wrapper">
            <div class="message"></div>
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Shift Tracker</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Shift Tracker</li>
                    </ol>
                </div>
            </div>
            <div class="container-fluid">

                <div class="row m-b-10"> 
                    <div class="col-12">
                        <button type="button" class="btn btn-info"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>shifttracker/Shifttracker" class="text-white"><i class="" aria-hidden="true"></i>  Shift Tracker List</a></button>
                    </div>
                </div>  
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"> Shift Tracker </h4>
                            </div>
                            <div class="card-body">
    <form method="post" action="Add_Shifttracker" id="holidayform" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-6 col-md-4">
                    <label>Employee <span class="text-danger">*</span></label>
                    <select class="form-control custom-select selectpicker" data-live-search="true" data-placeholder="Choose a Category" tabindex="1" name="employee_id" required>
                       
                       <?php if(!empty($attval->id)){ ?>
                        <option value="<?php echo $attval->id ?>"><?php echo $attval->first_name.' '.$attval->last_name ?></option>           
                       <?php } else { ?>
                       <option value="">--Select--</option>
                        <?php foreach($employee as $value): ?>
                        <option value="<?php echo $value->id ?>"><?php echo $value->first_name.' '.$value->last_name ?></option>
                        <?php endforeach; ?>
                        <?php } ?>
                    </select>
                </div>
                
                <div class="form-group col-6 col-md-4">
                    <label>Client <span class="text-danger">*</span></label>
                    <select class="form-control custom-select selectpicker" data-live-search="true" data-placeholder="Choose a Category" tabindex="1" name="client_id" required>
                       
                       <?php if(!empty($attval->em_code)){ ?>
                        <option value="<?php echo $attval->em_code ?>"><?php echo $attval->first_name.' '.$attval->last_name ?></option>           
                       <?php } else { ?>
                       <option value="">Select Here</option>
                        <?php foreach($clients as $value): ?>
                        <option value="<?php echo $value["id"] ?>"><?php echo $value["org_name"] ?></option>
                        <?php endforeach; ?>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-6 col-md-4">
                    <label>Department <span class="text-danger">*</span></label>
                    <select class="form-control custom-select selectpicker" data-live-search="true" data-placeholder="Choose a Category" tabindex="1" name="department" required>
                       <option value="">Select Here</option>
                        <?php foreach($department as $value): ?>
                        <option value="<?php echo $value->id ?>"><?php echo $value->dep_name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group col-6 col-md-4">
                    <label>Period <span class="text-danger">*</span></label>
                    <select class="form-control custom-select selectpicker" data-live-search="true" data-placeholder="Choose a Category" tabindex="1" name="period" required>
                        <option value="">Select Here</option>
                        <option value="Full Day">Full Day</option>
                        <option value="Full Night">Full Night</option>
                        <option value="Half Day">Half Day</option>
                        <option value="Half Night">Half Night</option>
                        <option value="Twilight">Twilight</option>
                    </select>
                </div>

                <div class="form-group col-6 col-md-4">
                    <label>Date: <span class="text-danger">*</span></label>
                    <div id="" class="input-group date" >
                        <input name="shift_date" class="form-control mydatetimepickerFull" value="<?php if(!empty($attval->atten_date)) { 
                        $old_date_timestamp = strtotime($attval->atten_date);
                        $new_date = date('Y-m-d', $old_date_timestamp);    
                        echo $new_date; } ?>" required>
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>

                <div class="form-group col-6 col-md-4" >
                   <label class="m-t-20">Client Rate <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="client_rate" value="" required>
                </div>

                <div class="form-group col-6 col-md-4" >
                   <label class="m-t-20">Employee Rate <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="employee_rate" value="" required>
                </div>

                <div class="form-group col-6 col-md-4">
                    <label>Break <span class="text-danger">*</span></label>
                    <select class="form-control custom-select selectpicker" data-live-search="true" data-placeholder="Choose a Category" tabindex="1" name="break" required>
                        <option value="">Select Here</option>
                        <option value="0 mins">0 mins</option>
                        <option value="15 mins">15 mins</option>
                        <option value="30 mins">30 mins</option>
                        <option value="45 mins">45 mins</option>
                        <option value="1 hour">1 hour</option>
                        <option value="1 hour 15 mins">1 hour 15 mins</option>
                        <option value="1 hour 30 mins">1 hour 30 mins</option>
                    </select>
                </div>

                <div class="form-group col-6 col-md-4" >
                   <label class="m-t-20">Start Time</label>
                    <input class="form-control" name="start_time" id="single-input" value="<?php if(!empty($attval->signin_time)) { echo  $attval->signin_time;} ?>" >
                </div>

                <div class="form-group col-6 col-md-4">
                    <label class="m-t-20">End Time</label>
                    <div class="input-group clockpicker">
                        <input type="text" name="end_time" class="form-control" value="<?php if(!empty($attval->signout_time)) { echo  $attval->signout_time;} ?>">
                    </div>
                </div>

                <div class="form-group col-6 col-md-4" >
                   <label class="m-t-20">Mileage </label>
                    <input type="text" class="form-control" name="mileage" value="" >
                </div>

                <div class="form-group col-6 col-md-4" >
                   <label class="m-t-20">Total Hours <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="total_hours" value="" required>
                </div>

                <div class="form-group col-6 col-md-4">
                    <label>Bank Holiday</label>
                    <select class="form-control custom-select" data-placeholder="" tabindex="1" name="bank_holiday" required>
                        <option value="No">No</option>
                        <option value="Yes">Yes</option>
                    </select>
                </div>
            </div>
        </div>   
        <div class="modal-footer">
        <input type="hidden" name="id" value="<?php if(!empty($attval->id)){ echo  $attval->id;} ?>" class="form-control" id="recipient-name1">                                       
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" id="attendanceUpdate" class="btn btn-success">Submit</button>
        </div>
    </form>
                            </div>
                        </div>
                    </div>
                </div>
                        <div class="modal fade" id="holysmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content ">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel1">Holidays</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <form method="post" action="Add_Holidays" id="holidayform" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        
                                            <div class="form-group">
                                                <label class="control-label">Holidays name</label>
                                                <input type="text" name="holiname" class="form-control" id="recipient-name1" minlength="4" maxlength="25" value="" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Holidays Start Date</label>
                                                <input type="date" name="startdate" class="form-control" id="recipient-name1"  value="">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Holidays End Date</label>
                                                <input type="date" name="enddate" class="form-control" id="recipient-name1" value="">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Number of Days</label>
                                                <input type="number" name="nofdate" class="form-control" id="recipient-name1" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="message-text" class="control-label"> Year</label>
                                                <textarea class="form-control" name="year" id="message-text1"></textarea>
                                            </div>                                           
                                        
                                    </div>
                                    <div class="modal-footer">
                                    <input type="hidden" name="id" value="" class="form-control" id="recipient-name1">                                       
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
<script type="text/javascript">
    $(function() {
      $('.selectpicker').selectpicker();
    });

$(document).ready(function () {

    $(".holiday").click(function (e) {
        e.preventDefault(e);
        // Get the record's ID via attribute  
        var iid = $(this).attr('data-id');
        $('#holidayform').trigger("reset");
        $('#holysmodel').modal('show');
        $.ajax({
            url: 'Holidaybyib?id=' + iid,
            method: 'GET',
            data: '',
            dataType: 'json',
        }).done(function (response) {
            console.log(response);
            // Populate the form fields with the data returned from server
			$('#holidayform').find('[name="id"]').val(response.holidayvalue.id).end();
            $('#holidayform').find('[name="holiname"]').val(response.holidayvalue.holiday_name).end();
            $('#holidayform').find('[name="startdate"]').val(response.holidayvalue.from_date).end();
            $('#holidayform').find('[name="enddate"]').val(response.holidayvalue.to_date).end();
            $('#holidayform').find('[name="nofdate"]').val(response.holidayvalue.number_of_days).end();
            $('#holidayform').find('[name="year"]').val(response.holidayvalue.year).end();
		});
    });
});
</script>
<script type="text/javascript">
$(document).ready(function () {
    $(".holidelet").click(function (e) {
        e.preventDefault(e);
        // Get the record's ID via attribute  
        var iid = $(this).attr('data-id');
        $.ajax({
            url: 'HOLIvalueDelet?id=' + iid,
            method: 'GET',
            data: 'data',
        }).done(function (response) {
            console.log(response);
            $(".message").fadeIn('fast').delay(3000).fadeOut('fast').html(response);
        //    window.setTimeout(function(){location.reload()},2000)
            // Populate the form fields with the data returned from server
		});
    });
    $("#attendanceUpdate").on("click", function() {
//        window.setTimeout(function(){location.reload()}, 1000);
    });
});
</script>                    
<?php $this->load->view('backend/footer'); ?>