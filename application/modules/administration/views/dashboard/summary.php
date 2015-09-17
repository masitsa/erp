<?php 
	$queue_total = number_format($this->reports_model->get_queue_total(), 0, '.', ',');
	$daily_balance = number_format($this->reports_model->get_daily_balance(), 0, '.', ',');
	$patients_today = number_format($this->reports_model->get_patients_total(), 0, '.', ',');
 ?>
		<div class="row">
            <div class="col-md-12">
                <!-- Page header start -->
                <div class="page-header">
                    <div class="page-title">
                        <h3>Dashboard</h3>
                        <span>
                        <?php 
						//salutation
						if(date('a') == 'am')
						{
							echo 'Good morning, ';
						}
						
						else if((date('H') >= 12) && (date('H') < 17))
						{
							echo 'Good afternoon, ';
						}
						
						else
						{
							echo 'Good evening, ';
						}
						echo $this->session->userdata('first_name');
						?>
                        </span>
                    </div>
                    <ul class="page-stats">
                        <li>
                            <div class="summary">
                                <span>Queue Total</span>
                                <h3><?php echo $queue_total;?></h3>
                            </div>
                            <span id="queue_total"></span>
                        </li>
                        <li>
                            <div class="summary">
                                <span>Available Cash</span>
                                <h3>KSH <?php echo $daily_balance;?></h3>
                            </div>
                            <!--<span id="payment_methods" style="height:60px;"></span>-->
                        </li>
                    </ul>
                </div>
                <!-- Page header ends -->
            </div>
          </div>

          <div class="row statistics">
              <div class="col-md-6 col-sm-6">
                  <ul class="today-datas">
                      <!-- List #1 -->
                      <li class="overall-datas">
                          <!-- Graph -->
                          <div class="pull-left visual bred"><span id="patients_per_day" class="spark"></span></div>
                          <!-- Text -->
                          <div class="datas-text pull-right">Patients Today <span class="bold"><?php echo $patients_today;?></span></div>

                          <div class="clearfix"></div>
                      </li>
                      <li class="more-stats">
                          <a class="more" href="<?php echo base_url()."data/reports/patients.php";?>" target="_blank">
                              View More
                              <i class="pull-right icon-angle-right"></i>
                          </a>
                      </li>
                  </ul>
              </div>
              <div class="col-md-6 col-sm-6">
                  <ul class="today-datas">
                      <li class="overall-datas" style="height:77px;">
                          <!-- Graph -->
                          <!-- <div class="pull-left visual bgreen"><span id="payment_methods" class="spark"></span></div>-->
                          <!-- Text -->
                          <div class="datas-text pull-right">Revenue Type <span class="bold">KSH <?php echo $daily_balance;?></span></div>

                          <div class="clearfix"></div>
                      </li>
                      <li class="more-stats">
                          <a class="more" href="<?php echo base_url()."data/reports/cash_reports.php";?>" target="_blank">
                              View More
                              <i class="pull-right icon-angle-right"></i>
                          </a>
                      </li>
                  </ul>
              </div>
          </div>
          
        <script type="text/javascript">
			var config_url = $('#config_url').val();

//Get patients per day for the last 7 days
$.ajax({
	type:'POST',
	url: config_url+"administration/charts/latest_patient_totals",
	cache:false,
	contentType: false,
	processData: false,
	dataType: "json",
	success:function(data){
		
		var bars = data.bars;
		var days_total = bars.split(',').map(function(item) {
			return parseInt(item, 10);
		});
		
		$("#patients_per_day").sparkline(days_total, {
			type: 'bar',
			height: data.highest_bar,
			barWidth: 4,
			barColor: '#fff'});
	},
	error: function(xhr, status, error) {
		alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
	}
});

//Get Revenue for the individual revenue types
$.ajax({
	type:'POST',
	url: config_url+"administration/charts/queue_total",
	cache:false,
	contentType: false,
	processData: false,
	dataType: "json",
	success:function(data){
		
		var bars = data.bars;
		var queue_total = bars.split(',').map(function(item) {
			return parseInt(item, 10);
		});
		
		$("#queue_total").sparkline(queue_total, {
			type: 'bar',
			height: data.highest_bar,
			barWidth: 4,
    		barColor: '#E25856'});
	},
	error: function(xhr, status, error) {
		alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
	}
});

//Get payment methods
$.ajax({
	type:'POST',
	url: config_url+"administration/charts/payment_methods",
	cache:false,
	contentType: false,
	processData: false,
	dataType: "json",
	success:function(data){
		
		var bars = data.bars;
		var queue_total = bars.split(',').map(function(item) {
			return parseInt(item, 10);
		});
		
		$("#payment_methods").sparkline(queue_total, {
			type: 'bar',
			height: data.highest_bar,
			barWidth: 4,
    		barColor: '#94B86E'});
	},
	error: function(xhr, status, error) {
		alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
	}
});
		</script>