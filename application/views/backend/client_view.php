<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<?php
$proceed = false;
if(isset($client)){
    if($client !== false){
        $proceed = true;
    }
}
if($proceed === false){
    // Client Not Found
    echo "<div class='m-5 text-center'>Client Not Found</div>";
}else{
?>
    <div class="page-wrapper">
        <div class="message"></div>
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-users" style="color:#1976d2"></i> <?php echo $client['org_name']; ?></h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Client Info</li>
                    </ol>
                </div>
            </div>
                <?php $degvalue = $this->employee_model->getdesignation(); ?>
                <?php $depvalue = $this->employee_model->getdepartment(); ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-xlg-12 col-md-12">
                        <div class="card">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs profile-tab" role="tablist">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab" style="font-size: 14px;">  Client Info </a> </li>
                            </ul>
                            <!-- Tab panes -->

                            <div class="tab-content">
                                <div class="tab-pane active" id="home" role="tabpanel">
                                    <div class="card">
				                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <center class="m-t-30">
                                    <h4 class="card-title m-t-10"><?php echo $client['org_name']; ?></h4>
                                    <h6 class="card-subtitle"><?php echo $client['address']; ?></h6>
                                </center>
                            </div>
                            <div>
                                <hr> </div>
                            <div class="card-body"> 
                                <small class="text-muted">Email address </small>
                                <h6><?php echo $client['email']; ?></h6> 

                                <small class="text-muted p-t-30 db">Phone</small>
                                <h6><?php echo $client['phone']; ?></h6> 

                            </div>
                        </div>                                                    
                                                </div>
                                                <div class="col-md-8">
				                                <form class="row" action="Update" method="post" enctype="multipart/form-data">
				                                    
				                                    <div class="form-group col-md-4 m-t-10">
				                                        <label>Organization Name </label>
				                                        <input type="text" <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> readonly <?php } ?> class="form-control form-control-line" placeholder="ID" name="org_name" value="<?php echo $client['org_name']; ?>" required > 
				                                    </div>
                                                    
				                                    <div class="form-group col-md-4 m-t-10">
                                                        <label>Contact Email </label>
                                                        <input type="text" class="form-control" placeholder="" name="email" <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> readonly <?php } ?> value="<?php echo $client['email']; ?>" maxlength="250" required> 
                                                    </div>

                                                    <div class="form-group col-md-4 m-t-10">
				                                        <label>Contact Phone </label>
				                                        <input type="text" class="form-control" placeholder="" name="phone" <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> readonly <?php } ?> value="<?php echo $client['phone']; ?>" minlength="2" maxlength="25" required> 
				                                    </div>

                                                    <div class="form-group col-md-12 m-t-5">
                                                        <label>Address</label>
                                                        <textarea name="address" <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> readonly <?php } ?> class="form-control" rows="3" minlength="2" required><?php if(!empty($client['address'])) echo $client['address']  ?></textarea>
                                                    </div>
                                                   
                                                    <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?>
                                                    <?php } else { ?>
				                                    <div class="form-actions col-md-12">
                                                        <input type="hidden" name="client_id" value="<?php echo $client['id']; ?>">
				                                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
				                                        <button type="button" class="btn btn-danger">Cancel</button>
				                                    </div>
				                                    <?php } ?>
				                                </form>
                                            </div>
                                        </div>
				                        </div>
                                    </div>
                                </div>                           
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
<?php 
    }
?>

<?php $this->load->view('backend/em_modal'); ?>
<?php $this->load->view('backend/footer'); ?>