<?php echo form_open('accounts/add-payment', array("class" => "form-horizontal", "role" => "form"));?>
        <div class="form-group">
           <select id="customer_id" name="customer_id" class="form-control custom-select" >
                <option value="">None - Please Select a customer</option>
                <?php echo $lab_tests;?>
            </select>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-sm btn-success">Add Payment</button>
        </div>
    <?php echo form_close();?>
	<script text="javascript">
	$(function() {
		$("#customer_id").customselect();
	});
	</script>