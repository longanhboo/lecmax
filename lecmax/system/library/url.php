<?php
class Url {
	private $url;
	private $ssl;
	private $hook = array();
	
	public function __construct($url, $ssl) {
		$this->url = $url;
		$this->ssl = $ssl;
	}
	
	public function link($route, $args = '', $lang='', $connection = 'NONSSL',$page=1) {
		if ($connection ==  'NONSSL') {
			$url = $this->url;	
		} else {
			$url = $this->ssl;	
		}
		
		if($page>1)
			$url .= $page . '/';
		
		$getlang = '';
		if(!empty($lang))
			$getlang .= 'language=' . $lang. '&';
		
		$url .= 'index.php?' . $getlang . 'route=' . $route;
			
		//$url .= 'index.php?route=' . $route;
			
		if ($args) {
			$url .= '&' . ltrim($args, '&'); 
		}
		
		//return $this->rewrite($url);
		return $this->rewrite($url,$lang);
	}
		
	public function addRewrite($hook) {
		$this->hook[] = $hook;
	}

	public function rewrite($url,$lang) {
		foreach ($this->hook as $hook) {
			$url = $hook->rewrite($url,$lang);
		}
		
		return $url;		
	}
        
        public function ts_file_contents($url){
                if(function_exists('curl_init')) {
			$ch = curl_init();
			$timeout = 0; // set to zero for no timeout
			
			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	
			$file_contents = curl_exec($ch);
	
			if (!$file_contents) {
                            $ap = curl_getinfo($ch);
                            return $ap['url'];
			}
	
			curl_close($ch);
		}
		
		else {
			$file_contents = file_get_contents($url);
		}
		
		return $file_contents;
        }
        
        public function ts_b64Image($url,$size){
                $resize = $this->ts_file_contents('/resize.php?w=' . $size . '&i=' . $url . '');

		if(ini_get("zlib.output_compression")) {
		    $b64Image = base64_encode(gzcompress($resize, 9));
		} else {
                    $b64Image = base64_encode(file_get_contents(HTTP_SERVER.$resize));
		}
		
		return $b64Image;
        }
        
        public function urlencode($url,$width){
            return $this->ts_b64Image($url, $width);
        }
}
?>