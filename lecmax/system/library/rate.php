<?php
final class Rate {
	public function __construct($registry) {
		$this->config = $registry->get('config');
		//$this->customer = $registry->get('customer');
		//$this->session = $registry->get('session');
		$this->db = $registry->get('db');
		//$this->tax = $registry->get('tax');
		//$this->weight = $registry->get('weight');

		/*if (!isset($this->session->data['cart']) || !is_array($this->session->data['cart'])) {
			$this->session->data['cart'] = array();
		}*/
	}
	
	public function getRateFromVCB() {
		
		$url = "http://www.vietcombank.com.vn/exchangerates/ExrateXML.aspx";
		$xml = file_get_contents($url);
		$data = simplexml_load_string($xml);
		
		$thoi_gian_cap_nhat = $data->DateTime;
		$ty_gia = $data->Exrate;
		
		
		if($this->getTotalRates()>0){
			foreach($ty_gia as $ngoai_te) {
				$this->updateRate($ngoai_te['CurrencyCode'], $ngoai_te);
			}
		}else{
			foreach($ty_gia as $ngoai_te) {
				$this->addRate($ngoai_te);
			}
		}
		
	}
	
	public function getRate($CurrencyCode='') {
		
		$data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "rate p WHERE p.currencycode='" . $CurrencyCode . "' AND p.status = '1'");
		if ($query->num_row['currencycode']) {
			$data = $query->num_row;
		}

		return $data;
		
	}
	
	public function addRate($data=array()) {
		$str = "";		
		if(isset($data['CurrencyCode']))
			$str .= " currencycode = '" . $this->db->escape($data['CurrencyCode']) . "',";
		else
			$str .= " currencycode = '',";
		
		if(isset($data['CurrencyName']))
			$str .= " currencyname = '" . $this->db->escape($data['CurrencyName']) . "',";
		else
			$str .= " currencyname = '',";
		
		if(isset($data['Transfer']))
			$str .= " transfer = '" . $this->db->escape($data['Transfer']) . "',";
		else
			$str .= " transfer = '',";
		
		if(isset($data['Buy']))
			$str .= " buy = '" . $this->db->escape($data['Buy']) . "',";
		else
			$str .= " buy = '',";
		
		if(isset($data['Sell']))
			$str .= " sell = '" . $this->db->escape($data['Sell']) . "',";
		else
			$str .= " sell = '',";
		
	    $this->db->query("UPDATE " . DB_PREFIX . "rate SET sort_order=sort_order+1 ");
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "rate SET 			
		                 status = '1', 			
		                 sort_order = '0', 
		                 $str
		                 date_added = NOW()");
		
		$rate_id = $this->db->getLastId();		
		
	}
	
	public function updateRate($CurrencyCode='', $data=array()) {
		$str = "";		
		
		if(isset($data['CurrencyName']))
			$str .= " currencyname = '" . $this->db->escape($data['CurrencyName']) . "',";
		else
			$str .= " currencyname = '',";
		
		if(isset($data['Transfer']))
			$str .= " transfer = '" . $this->db->escape($data['Transfer']) . "',";
		else
			$str .= " transfer = '',";
		
		if(isset($data['Buy']))
			$str .= " buy = '" . $this->db->escape($data['Buy']) . "',";
		else
			$str .= " buy = '',";
		
		if(isset($data['Sell']))
			$str .= " sell = '" . $this->db->escape($data['Sell']) . "',";
		else
			$str .= " sell = '',";
		
		$this->db->query("UPDATE " . DB_PREFIX . "rate SET 
		                 $str
						 date_added = NOW() 
		                 WHERE currencycode = '" . $CurrencyCode . "'");		
		
		
	}
	
	public function getRates() {
		$data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "rate p");
		if ($query->num_rows) {
			$data = $query->num_rows;
		}

		return $data;
	}
	
	public function getTotalRates() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "rate p");
		
		return isset($query->row['total'])?(int)$query->row['total']:0;
	}
	
}
?>