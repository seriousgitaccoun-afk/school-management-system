        <?php 

		//////////LOADING SYSTEM SETTINGS FOR ALL PAGES AND ACCOUNTS/////////
		$system_title	=	get_school_name();
		$session	=	$this->db->get_where('settings' , array('type'=>'session'))->row()->description;
		?>