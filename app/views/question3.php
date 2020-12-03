<h4>User input stops</h4>
<div class="row justify-content-md-center" style="margin-top:25px;">
	<div class="col-md-6">
		<?php if($error){
			echo '
				<div class="alert alert-danger" role="alert">
				  	'.$error.'
				</div>';
		}?>

		<?php echo form_open('http://mbtatest.local/question3', ' class="form_submit form-inline" role="form"'); ?>
		  	<div class="form-group mb-2">
		    	<label for="staticEmail2" class="sr-only">From</label>
		    	<!-- <?php echo form_dropdown('from',$destinations,$this->input->post('from')?:"",'class="form-control from m-select2" placeholder="Destination From"'); ?> -->
		    	<?php echo form_input('from',$this->input->post('from')?:"",'class="form-control from m-select2" placeholder="Destination From"'); ?>
		  	</div>
		  	<div class="form-group mx-sm-3 mb-2">
		    	<label for="inputPassword2" class="sr-only">Destination</label>
		    	<!-- <?php echo form_dropdown('to',$destinations,$this->input->post('to')?:"",'class="form-control to m-select2" placeholder="Destination to"'); ?> -->
		    	<?php echo form_input('to',$this->input->post('to')?:"",'class="form-control to m-select2" placeholder="Destination to"'); ?>
		  	</div>
		  	<input type="submit" type="button" class="btn btn-primary mb-2" value="Submit"/>
		  <!-- <button type="submit" value="1"  class="btn btn-primary mb-2">Submit</button> -->
		</form>
	</div>
</div>
<?php if($results){?>
<div class="row">
	<div class="col-md-12">
		Answer: 
		<h4><?php echo $results;?></h4>
	</div>
</div>
<?php }?>

