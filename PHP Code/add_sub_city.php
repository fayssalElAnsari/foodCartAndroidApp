<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");

	require_once("thumbnail_images.class.php");

	 
	
	if(isset($_POST['submit']) and isset($_GET['add']))
	{
		$data = array( 
		'city_id'  =>  $_POST['city_id'],
		'sub_city'  =>  $_POST['sub_city']
		);		

 		$qry = Insert('tbl_city_list',$data);	

		$_SESSION['msg']="10"; 
		header( "Location:manage_sub_city.php");
		exit;	

	}
	
	if(isset($_GET['edit_id']))
	{
		$qry="SELECT * FROM tbl_city_list where id='".$_GET['edit_id']."'";
		$result=mysqli_query($mysqli,$qry);
		$row=mysqli_fetch_assoc($result);
	}
	
	if(isset($_POST['submit']) and isset($_POST['edit_id']))
	{

		$data = array(
			'city_id'  =>  $_POST['city_id'],
			'sub_city'  =>  $_POST['sub_city']
		);	
			
		$category_edit=Update('tbl_city_list', $data, "WHERE id = '".$_POST['edit_id']."'");
		 
		$_SESSION['msg']="11"; 
		header("Location:manage_sub_city.php");
		exit;
 
	}


?>
	<div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title"><?php if(isset($_GET['edit_id'])){?>Edit<?php }else{?>Add<?php }?> Sub City </div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row mrg-top">
            <div class="col-md-12">
               
              <div class="col-md-12 col-sm-12">
                <?php if(isset($_SESSION['msg'])){?> 
               	 <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                	<?php echo $client_lang[$_SESSION['msg']] ; ?></a> </div>
                <?php unset($_SESSION['msg']);}?>	
              </div>
            </div>
          </div>
          <div class="card-body mrg_bottom"> 
            <form action="" name="addeditcategory" method="post" class="form form-horizontal" enctype="multipart/form-data">
            	<input  type="hidden" name="edit_id" value="<?php echo $_GET['edit_id'];?>" />

              <div class="section">
                <div class="section-body">
				
				
				   <div class="form-group">
                    <label class="col-md-3 control-label">City Name :-</label>
                    <div class="col-md-6">
                      <select name="city_id" id="city_id" class="select2" required >
                        <option value="">--Select City Name--</option>
						<?php
						$cat_qry="SELECT * FROM tbl_city ORDER BY id ASC" ;
						$cat_result=mysqli_query($mysqli,$cat_qry); 
						while($cat_row=mysqli_fetch_array($cat_result))
						{
							?>          						 
							<option value="<?php echo $cat_row['id'];?>"  <?php if($cat_row['id']==$row['city_id']){?>selected<?php }?> ><?php echo $cat_row['city_name'];?></option>
							<?php
						}
						?>
                      </select>
                    </div>
                  </div>
				  
                  <div class="form-group">
                    <label class="col-md-3 control-label">City Name :-</label>
                    <div class="col-md-6">
                      <input type="text" name="sub_city" id="sub_city" value="<?php if(isset($_GET['edit_id'])){echo $row['sub_city'];}?>" class="form-control" required>
                    </div>
                  </div>                   
				       
               
                  <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                      <button type="submit" name="submit" class="btn btn-primary">Save</button>
                    </div>
                  </div>
				  
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
        
<?php include("includes/footer.php");?>       
