<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");

	require_once("thumbnail_images.class.php");

	 
	
	if(isset($_POST['submit']) and isset($_GET['add']))
	{
	

		$category_image=rand(0,99999)."_".$_FILES['category_image']['name'];				
		$tpath1='images/'.$category_image; 			 
		move_uploaded_file($_FILES["category_image"]["tmp_name"], $tpath1);
		
				
	 /*   $category_image=rand(0,99999)."_".$_FILES['category_image']['name'];
		 	 
       //Main Image
	   $tpath1='images/'.$category_image; 			 
       $pic1=compress_image($_FILES["category_image"]["tmp_name"], $tpath1, 80);
	 
		//Thumb Image 
	   $thumbpath='images/thumbs/'.$category_image;		
       $thumb_pic1=create_thumb_image($tpath1,$thumbpath,'200','200');   
  */
          
       $data = array( 
			    'cat_type'  =>  $_POST['cat_type'],
       			'hotelid'=> $_SESSION['id'],
			    'category_name'  =>  $_POST['category_name'],
			   'category_image'  =>  $category_image
			    );		

 		$qry = Insert('tbl_menucategory',$data);	

 	    $cat_id=mysqli_insert_id($mysqli);	

 	   if(!is_dir('categories/'.$cat_id))
	   {
	
	   		mkdir('categories/'.$cat_id, 0777);

	   		mkdir('categories/'.$cat_id.'/thumbs', 0777);
	   }			

		$_SESSION['msg']="10";
 
		header( "Location:manage_menucategory.php");
		exit;	

		 
		
	}
	
	if(isset($_GET['cat_id']))
	{
			 
			$qry="SELECT * FROM tbl_menucategory where cid='".$_GET['cat_id']."'";
			$result=mysqli_query($mysqli,$qry);
			$row=mysqli_fetch_assoc($result);

	}
	if(isset($_POST['submit']) and isset($_POST['cat_id']))
	{
		 
		 if($_FILES['category_image']['name']!="")
		 {		


				$img_res=mysqli_query($mysqli,'SELECT * FROM tbl_menucategory WHERE cid='.$_GET['cat_id'].'');
			    $img_res_row=mysqli_fetch_assoc($img_res);
			

			    if($img_res_row['category_image']!="")
		        {
					unlink('images/thumbs/'.$img_res_row['category_image']);
					unlink('images/'.$img_res_row['category_image']);
			     }


				$category_image=rand(0,99999)."_".$_FILES['category_image']['name'];				
				$tpath1='images/'.$category_image; 			 
				move_uploaded_file($_FILES["category_image"]["tmp_name"], $tpath1);
				
/* 
 				   $category_image=rand(0,99999)."_".$_FILES['category_image']['name'];
		 	 
			       //Main Image
				   $tpath1='images/'.$category_image; 			 
			       $pic1=compress_image($_FILES["category_image"]["tmp_name"], $tpath1, 80);
				 
					//Thumb Image 
				   $thumbpath='images/thumbs/'.$category_image;		
			       $thumb_pic1=create_thumb_image($tpath1,$thumbpath,'200','200');
 */


                    $data = array(
						'cat_type'  =>  $_POST['cat_type'],
					    'category_name'  =>  $_POST['category_name'],
					    'category_image'  =>  $category_image
						);

					$category_edit=Update('tbl_menucategory', $data, "WHERE cid = '".$_POST['cat_id']."'");

		 }
		 else
		 {

					$data = array(
						'cat_type'  =>  $_POST['cat_type'],
						'category_name'  =>  $_POST['category_name']
					);	
 
			         $category_edit=Update('tbl_menucategory', $data, "WHERE cid = '".$_POST['cat_id']."'");

		 }

		     
		$cat_id=$_POST['cat_id'];	

 	   if(!is_dir('categories/'.$cat_id))
	   {
	
	   		mkdir('categories/'.$cat_id, 0777);
	   		mkdir('categories/'.$cat_id.'/thumbs', 0777);
	   }
		
		$_SESSION['msg']="11"; 
		header( "Location:add_menucategory.php?cat_id=".$_POST['cat_id']);
		exit;
 
	}


?>
<div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title"><?php if(isset($_GET['cat_id'])){?>Edit<?php }else{?>Add<?php }?> Menu Category</div>
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
            	<input  type="hidden" name="cat_id" value="<?php echo $_GET['cat_id'];?>" />

              <div class="section">
                <div class="section-body">
				
				   <div class="form-group">
                    <label class="col-md-3 control-label">Menu Category Type :-</label>
                    <div class="col-md-6">
                      <select name="cat_type" id="cat_type" class="select2" required>
                        <option value="">--Select Menu Category Type--</option>
						<?php
						$cat_qry="SELECT * FROM tbl_category_type ORDER BY id ASC" ;
						$cat_result=mysqli_query($mysqli,$cat_qry); 
						while($cat_row=mysqli_fetch_array($cat_result))
						{
							?>          						 
							<option value="<?php echo $cat_row['name'];?>"
							<?php if($cat_row['name']==$row['cat_type']){ echo "selected"; }?>
							><?php echo $cat_row['name'];?></option>
							<?php
						}
						?>
                      </select>
                    </div>
                  </div>
				  
                  <div class="form-group">
                    <label class="col-md-3 control-label">Menu Category Name :-</label>
                    <div class="col-md-6">
                      <input type="text" name="category_name" id="category_name" value="<?php if(isset($_GET['cat_id'])){echo $row['category_name'];}?>" class="form-control" required>
                    </div>
                  </div>
				  
                  <div class="form-group">
                    <label class="col-md-3 control-label">Select Image :-<p class="control-label-help">(Recommended resolution: 500x500)</p>
                     </label>
                     
                    <div class="col-md-6">
                      <div class="fileupload_block">
                        <input type="file" name="category_image" value="fileupload" id="fileupload">
                        <?php if(isset($_GET['cat_id']) and $row['category_image']!="") {?>
                        	  <div class="fileupload_img"><img type="image" src="images/<?php echo $row['category_image'];?>" alt="category image" /></div>
                        	<?php } else {?>
                        	  <div class="fileupload_img"><img type="image" src="assets/images/add-image.png" alt="category image" /></div>
                        	<?php }?>
                      </div>
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
