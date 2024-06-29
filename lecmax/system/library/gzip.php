<?php

ob_start(); 
ob_implicit_flush(0); 
function CheckCanGzip(){ 
	//global $HTTP_ACCEPT_ENCODING;
	//

	$HTTP_ACCEPT_ENCODING = $_SERVER["HTTP_ACCEPT_ENCODING"];
	
	// CHU Y : Kể từ PHP4.0.1 , hàm connection_timeout() không còn được hỗ trợ , do vậy bạn chỉ cần xóa cụm "connection_timeout() ||" đi   
	if (headers_sent() || connection_aborted()){ 
		return 0; 
	} 
	if (strpos($HTTP_ACCEPT_ENCODING, 'x-gzip') !== false) return "x-gzip"; 
	
	if (strpos($HTTP_ACCEPT_ENCODING,'gzip') !== false) return "gzip"; 
	
	return 0; 
} 


// Mặc định sử dụng chế độ nén thấp nhất là 1 , nếu bạn muốn sử dụng chế độ nén cao nhất , hãy sửa $level=1 thành $level=9
function GzDocOut($level=1){ 
	$ENCODING = CheckCanGzip(); 
	
	
	if ($ENCODING){ 
		
		print "\n<!-- Da nen trang web bang co che $ENCODING "; 
		$Contents = ob_get_contents(); 
		ob_end_clean(); 
		$s = "<p>Kich thuoc khi chua nen: ".strlen($Contents); 
		$s .= "<br>Kick thuoc da nen: ".strlen(gzcompress($Contents,$level));
		$s .= "-->\n";
		$Contents .= $s; 
		
		header("Content-Encoding: $ENCODING");      
		print "\x1f\x8b\x08\x00\x00\x00\x00\x00"; 
		$Size = strlen($Contents); 
		$Crc = crc32($Contents); 
		$Contents = gzcompress($Contents,$level); 
		$Contents = substr($Contents, 0, strlen($Contents) - 4); 
		print $Contents; 
		print pack('V',$Crc); 
		print pack('V',$Size); 
		
		//exit; 
	}else{ 
		ob_end_flush(); 
		//exit; 
	}
} 

?>