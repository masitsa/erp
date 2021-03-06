<?php
	$personnel_id = $this->session->userdata('personnel_id');
	
	if($personnel_id == 0)
	{
		$parents = $this->sections_model->all_parent_sections('section_position');
	}
	
	else
	{
		$personnel_roles = $this->personnel_model->get_personnel_roles($personnel_id);
		
		$parents = $personnel_roles;
	}
	$children = $this->sections_model->all_child_sections();

	$page = explode("/",uri_string());
	$total = count($page);
	$section_title = ucfirst($page[0]);

	
	$sections = '';
	// $section_title = $this->
	if($parents->num_rows() > 0)
	{
		foreach($parents->result() as $res)
		{
			$section_parent = $res->section_parent;
			$section_id = $res->section_id;
			$section_name = $res->section_name;
			$section_icon = $res->section_icon;
			
			if($section_parent == 0)
			{
				$web_name = strtolower($this->site_model->create_web_name($section_name));
				$link = site_url().$web_name;
				$section_children = $this->admin_model->check_children($children, $section_id, $web_name);
				$total_children = count($section_children);
				
				if($total_children == 0)
				{
						// var_dump($section_name); die();
					if($section_title == $section_name)
					{
						$sections .= '<li class="active">';
					}
					
					else
					{
						$sections .= '<li>';
					}
					$sections .= '
						<a href="'.$link.'">
							<i class="fa fa-'.$section_icon.'" aria-hidden="true"></i>
							<span>'.$section_name.'</span>
						</a>
					</li>
					';
				}
				
				else
				{
					if($section_title == $section_name)
					{
						$sections .= '<li class="active dropdown">';
					}
					
					else
					{
						$sections .= '<li class="dropdown">';
					}
					$sections .= '
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-'.$section_icon.'" aria-hidden="true"></i> '.$section_name.' <b class="caret"></b></a> 
						
						<ul class="dropdown-menu">';
					
					//children
					for($r = 0; $r < $total_children; $r++)
					{
						$name = $section_children[$r]['section_name'];
						$link = $section_children[$r]['link'];
						
						$sections .= '
							<li>
								<a href="'.$link.'">
									 '.$name.'
								</a>
							</li>
						';
					}
					
					$sections .= '
					</ul></li>
					';
				}
			}
			
			else
			{
				//get parent section
				$parent_query = $this->sections_model->get_section($section_parent);
				
				$parent_row = $parent_query->row();
				$parent_name = $parent_row->section_name;
				$section_icon = $parent_row->section_icon;
				
				$web_name = strtolower($this->site_model->create_web_name($parent_name));
				$link = site_url().$web_name.'/'.strtolower($this->site_model->create_web_name($section_name));
				
				$sections .= '
				<li>
					<a href="'.$link.'">
						<i class="fa fa-'.$section_icon.'" aria-hidden="true"></i>
						<span>'.$section_name.'</span>
					</a>
				</li>
				';
			}
		}
	}
	
?>	
<header class="page-header">
	<div id="navbar">    
	  	<nav class="navbar navbar-default navbar-static-top" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
              <!-- <a class="navbar-brand" href="#">HR</a> -->
            </div>
            
            <div class="collapse navbar-collapse" id="navbar-collapse-1">
                <ul class="nav navbar-nav">
                	<?php echo $sections;?>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
	</div>
</header>