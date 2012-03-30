<?php
class Model_statistics extends My_records{
	function __construct(){
		parent::__construct();
	}
	
	function getSubscribersCnt($condition=''){
		if(empty($condition))
			$where=1;
		elseif(is_string($condition))
			$where=$condition;
		else
			throw new Exception('Wrong data given');
		if(isset($this->site['site_id']));
			$where.=' AND site_id='.$this->site['site_id'];		
			
		$query=$this->db->query('SELECT count(*) as cnt FROM `subscribers` WHERE '.$where);
		
		$row=$query->row_array();
		return $row['cnt'];
		return $query->row_array();
	}
}