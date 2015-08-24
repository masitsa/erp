 <section class="panel">
    <header class="panel-heading">
        <h4 class="pull-left"><i class="icon-reorder"></i>Search Brands </h4>
        <div class="widget-icons pull-right">
            <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
            <a href="#" class="wclose"><i class="icon-remove"></i></a>
        </div>
    
    	<div class="clearfix"></div>
    
    </header>             
    
    <!-- Widget content -->
         <div class="panel-body">
    	<div class="padd">
			<?php
            echo form_open("pharmacy/search_brand", array("class" => "form-horizontal"));
            ?>
            <div class="row">
                <div class="col-md-10">
                    
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Brand name: </label>
                        
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="brand_name" placeholder="Brand name">
                        </div>
                    </div>
                </div>
            </div>
            <br/>
            <div class="center-align">
            	<button type="submit" class="btn btn-info btn-sm">Search brands</button>
            </div>
            
            <?php
            echo form_close();
            ?>
    	</div>
    </div>
</section>