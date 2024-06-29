<?php
class ModelCatalogGoogleAnalytics extends Model {
	
	public function editGoogleAnalytics($data) {
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
		                 SET `value` = '" . $this->db->escape($data['google_analytics']) . "'
		                 WHERE `key` = 'config_google_analytics'");
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
		                 SET `value` = '" . $this->db->escape($data['google_tag_manager']) . "'
		                 WHERE `key` = 'config_google_tag_manager'");
						 
	}
	
	public function getGoogleAnalytics() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `key` = 'config_google_analytics'");
		
		return $query->row;
	}
	
	public function getTables($database) {
		$table_data = array();

		$query = $this->db->query("SHOW TABLES FROM `" . $database . "`");

		foreach ($query->rows as $result) {
			if (utf8_substr($result['Tables_in_' . $database], 0, strlen(DB_PREFIX)) == DB_PREFIX) {
				if (isset($result['Tables_in_' . $database])) {
					$table_data[] = $result['Tables_in_' . $database];
				}
			}
		}

		return $table_data;
	}
	
	public function backup($tables,$database=DB_DATABASE,$password=DB_PASSWORD,$username=DB_USERNAME) {

		$output = '';
		//$output .= "SET FOREIGN_KEY_CHECKS=0;\n\n";
		foreach ($tables as $table) {
			if (DB_PREFIX) {
				if (strpos($table, DB_PREFIX) === false) {
					$status = false;
				} else {
					$status = true;
				}
			} else {
				$status = true;
			}

			if ($status) {
				if($database!=DB_DATABASE){
					
					$query = $this->connection_db(DB_HOSTNAME,$username,$password,$database,$table);
					//$output .= 'TRUNCATE TABLE `' . $table . '`;' . "\n\n";
				}else{
					//$output .= 'TRUNCATE TABLE `' . $table . '`;' . "\n\n";

					$query = $this->db->query("SELECT * FROM `" . $table . "`");
				}
				
				$q = mysql_query('DESCRIBE ' . $table);
				
				$output .= "-- ----------------------------\n";
				$output .= "-- Table structure for $table \n";
				$output .= "-- ----------------------------\n";

				$output .= "DROP TABLE IF EXISTS `$table`;\n";
				$output .= "CREATE TABLE `$table` (\n";
				$value_key = array();
				$count_attr = mysql_num_rows($q);
				$i=1;
				while($row = mysql_fetch_array($q)) {
					$not_null = '';
					if($row['Null']=='NO'){
						$not_null = 'NOT NULL';
					}
					$value_default = '';
					if($row['Default']!=''){
						$value_default = "default '{$row['Default']}'";
					}
					if($row['Key']=='PRI'){
						$value_key[] = $row['Field'];
					}
					$output .= "`{$row['Field']}` {$row['Type']} $not_null $value_default {$row['Extra']}";
					
					if($i!=$count_attr || count($value_key)>0){
						$output .= ",";
					}
					$output .= "\n";
					$i++;
				}
				if(count($value_key)>0){
				$output .= "PRIMARY KEY (";
				foreach($value_key as $key=>$item){
					$output .= "`$item`";
					if($key!=count($value_key)-1){
						$output .= ",";
					}
				}
				$output .= ")\n";
				}
				
				$output .= ")ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;\n\n";
				
				//$output .= 'TRUNCATE TABLE `' . $table . '`;' . "\n\n";
				$output .= "-- ----------------------------\n";
				$output .= "-- Records of $table \n";
				$output .= "-- ----------------------------\n";
				
				foreach ($query->rows as $result) {
					$fields = '';

					foreach (array_keys($result) as $value) {
						$fields .= '`' . $value . '`, ';
					}

					$values = '';

					foreach (array_values($result) as $value) {
						$value = str_replace(array("\x00", "\x0a", "\x0d", "\x1a"), array('\0', '\n', '\r', '\Z'), $value);
						$value = str_replace(array("\n", "\r", "\t"), array('\n', '\r', '\t'), $value);
						$value = str_replace('\\', '\\\\',	$value);
						$value = str_replace('\'', '\\\'',	$value);
						$value = str_replace('\\\n', '\n',	$value);
						$value = str_replace('\\\r', '\r',	$value);
						$value = str_replace('\\\t', '\t',	$value);

						$values .= '\'' . $value . '\', ';
					}

					$output .= 'INSERT INTO `' . $table . '` (' . preg_replace('/, $/', '', $fields) . ') VALUES (' . preg_replace('/, $/', '', $values) . ');' . "\n";
				}

				$output .= "\n\n";
			}
		}

		return $output;
	}
	
	private function connection_db($hostname, $username, $password, $database, $table){
		$output = '';
		if (!$connection = mysql_connect($hostname, $username, $password)) {
			exit('Error: Could not make a database connection using ' . $username . '@' . $hostname);
		}
		
		if (!mysql_select_db($database, $connection)) {
			exit('Error: Could not connect to database ' . $database);
		}

		mysql_query("SET NAMES 'utf8'", $connection);
		mysql_query("SET CHARACTER SET utf8", $connection);
		mysql_query("SET CHARACTER_SET_CONNECTION=utf8", $connection);
		mysql_query("SET SQL_MODE = ''", $connection);
		
		$sql = "SELECT * FROM `" . $table . "`";
		$resource = mysql_query($sql, $connection);
		
		if ($resource) {
			if (is_resource($resource)) {
				$i = 0;

				$data = array();

				while ($result = mysql_fetch_assoc($resource)) {
					$data[$i] = $result;

					$i++;
				}

				mysql_free_result($resource);

				$query = new stdClass();
				$query->row = isset($data[0]) ? $data[0] : array();
				$query->rows = $data;
				$query->num_rows = $i;

				unset($data);

				return $query;
			} else {
				return TRUE;
			}
		} else {
			exit('Error: ' . mysql_error($this->connection) . '<br />Error No: ' . mysql_errno($this->connection) . '<br />' . $sql);
		}
	}
}
?>