<?php
/*
Panglossa go!Johnny PHP library
version 7.0
release 2013-03-20
Please see the readme.txt file that goes with this source.
Licensed under the GPL, please see:
http://www.gnu.org/licenses/gpl-3.0-standalone.html
panglossa@yahoo.com.br
Araçatuba - SP - Brazil - 2013
*/
class TDB {
	var $pdo = null;
	var $type = 'sqlite';
	var $dbname = 'gojohnny.sqlite';
	var $dbhost = 'localhost';
	var $result = null;
	var $connected = false;
	var $server = ''; //used by informix
	var $protocol = 'onsoctcp'; //used by informix
	var $tables = array();
	var $pdofetchmode = PDO::FETCH_ASSOC;
	var $gjversion = '7.0';
	///////////////////////////////////////////////////////
	public function __construct(
		$adatabase = 'gojohnny.sqlite', /*Corresponds to the file name in SQLite and Firebird, to the database name in other drivers*/
		$atype = 'sqlite', 
		$auser = 'root', /*ignored in sqlite; default value for MySQL*/
		$apassword = '',  /*ignored in sqlite; default value for MySQL*/
		$ahost = 'localhost',  /*ignored in sqlite; default value for MySQL*/
		$aport = 3306, /*ignored in sqlite; default value for MySQL*/
		$aserver = '', /*used by informix*/
		$aprotocol = 'onsoctcp' /*used by informix*/
		){
		$this->dbname = $adatabase;
		$this->database = &$this->dbname;
		$this->type = strtolower($atype);
		$this->user = $auser;
		$this->password = $apassword;
		$this->dbhost = $ahost;
		$this->host = &$this->dbhost;
		$this->port = $aport;
		$this->server = $aserver;
		$this->protocol = $aprotocol;
		
		$this->defaultconditionconjunction = 'AND';
		$this->defaultconditionoperator = '=';
		$this->connect();
		if ($this->connected){
			$this->tables = $this->listtables();
			}
		}
	///////////////////////////////////////////////////////
	function connect(){
		try {
			switch ($this->type) {
				case 'sqlite':
					$this->pdo = new PDO("sqlite:{$this->dbname}");
					$this->result = true;
					$this->connected = true;
					break;
				case 'mysql':
					$this->pdo = new PDO("mysql:dbname={$this->dbname};port={$this->port};host={$this->host}", $this->user, $this->password);
					$this->result = true;
					$this->connected = true;
					break;
				case 'cubrid':
					$this->pdo = new PDO("cubrid:host={$this->host};port={$this->port};dbname={$this->dbname}", $this->user, $this->password);
					$this->result = true;
					$this->connected = true;
					break;
				case 'dblib':
					$this->pdo = new PDO("dblib:host={$this->host}:{$this->port};dbname={$this->dbname}", $this->user, $this->password);
					$this->result = true;
					$this->connected = true;
					break;
				case 'mssql':
					$this->pdo = new PDO("mssql:host={$this->host};port={$this->port};dbname={$this->dbname}", $this->user, $this->password);
					$this->result = true;
					$this->connected = true;
					break;
				case 'firebird':
					$this->pdo = new PDO("firebird:dbname={$this->host}:{$this->dbname}", $this->user, $this->password);
					$this->result = true;
					$this->connected = true;
					break;
				case 'ibm':
					$this->pdo = new PDO("odbc:{$this->dbname}", $this->user, $this->password);
					$this->result = true;
					$this->connected = true;
					break;
				case 'informix':
					$this->pdo = new PDO("informix:host={$this->dbhost};service={$this->port};database={$this->dbname}; server={$this->server}; protocol={$this->protocol};EnableScrollableCursors=1", $this->user, $this->password);
					$this->result = true;
					$this->connected = true;
					break;
				case 'oci':
					$this->pdo = new PDO("oci:dbname={$this->dbname}", $this->user, $this->password);
					$this->result = true;
					$this->connected = true;
					break;
				case 'odbc':
					$this->pdo = new PDO("mysql:dbname={$this->dbname};port={$this->port};host={$this->host}", $this->user, $this->password);
					$this->result = true;
					$this->connected = true;
					break;
				case 'sybase':
					$this->pdo = new PDO("sybase:host={$this->host};dbname={$this->dbname}, {$this->user}, {$this->password}");
					$this->result = true;
					$this->connected = true;
					break;
				case 'memory':
					$this->pdo = new PDO("sqlite::memory:");
					$this->result = true;
					$this->connected = true;
					break;
				}
			}catch(PDOException $e){
			$this->result = $e->getMessage();
			$this->connected = false;
			}
		return $this->connected;
		}
	///////////////////////////////////////////////////////
	function listtables(){
		////////////////////////////////////////////
		//Does this work with all database drivers?
		////////////////////////////////////////////
		$res = array();
		$tmp = $this->pdo->query("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_TYPE='BASE TABLE' AND TABLE_SCHEMA='{$this->database}';");
		if ($tmp!==false){
			foreach($tmp as $row){
				$res[] = $row['TABLE_NAME'];
				}
			}
		return $res;
		}
	///////////////////////////////////////////////////////
	function createtable($name = '', $fields = array(), $options = array()){
		if($this->connected){
			$error = false;
			}else{
			$error = 'Not connected.';
			}
		$name = trim($name);
		
		if(
			($name!='')
			&&
			(
				(
					(is_array($fields))
					&&(count($fields)>0)
					)
				||
				(
					(is_string($fields))
					&&
					(trim($fields)!='')
				)
			)
			){
			$q = "CREATE TABLE IF NOT EXISTS `{$name}` (\n";
			$f = '';
			if (is_array($fields)){
				if (count($fields)>0){
					foreach($fields as $field){
						if((is_array($field))&&((((isset($field['name']))&&(trim($field['name'])!=''))&&((isset($field['type']))&&(trim($field['type'])!=''))))){
							if ($f!=''){
								$f .= ",\n";
								}
							//regex desperately needed!
							$field['type'] = trim(strtolower($field['type']));
							$field['type'] = str_replace('int ', 'integer ', $field['type']);
							$field['type'] = str_replace('int(', 'integer(', $field['type']);
							if ($field['type']=='int'){
								$field['type'] = 'integer';
								}
							if ($field['type']=='char'){
								$field['type'] = 'char(255)';
								}
							if ($field['type']=='varchar'){
								$field['type'] = 'varchar(255)';
								}
							if(!isset($field['null'])){
								$field['null'] = false;
								}
							$f .= "`{$field['name']}` {$field['type']}";
							if (isset($field['collate'])){
								$f .= " COLLATE {$field['collate']}";
								}
							if ((isset($field['unique']))&&($field['unique']!=false)){
								$f .= ' UNIQUE';
								}
							if ((isset($field['primary']))&&($field['primary']!=false)){
								switch($this->type){
									case 'mysql':
										if (is_array($options)){
											$options['primary'] = $field['name'];
											}
										$field['autoincrement'] = true;
										break;
									case 'sqlite':
										$f .= ' PRIMARY KEY';
										break;
									}
								
								}
							if (isset($field['autoincrement'])){
								$f .= ' AUTO_INCREMENT';
								}
							if (isset($field['default'])){
								$f .= ' DEFAULT ' . $this->pdo->quote($field['default']);
								}
							if (
								($field['null']==true)
								||
								($field['null']==1)
								||
								(strtolower($field['null'])=='null')
								){
								$f .= ' NULL';
								}else{
								$f .= ' NOT NULL';
								}
							}else{
							$error = 'You need to provide at least a name and a type for each column.';
							}
						}
					}else{
					$error = 'You need to provide at least one field definition.';
					}
				}else{
				$f = "{$fields}\n";
				}
			$q .= $f;
			if (is_array($options)){
				if(isset($options['primary'])){
					switch($this->type){
						case 'mysql':
							$q .= ",\nPRIMARY KEY (`{$options['primary']}`)";
							break;
						}
					}
				}
			$q .= "\n) ";
			if (is_array($options)){
				if (isset($options['engine'])){
					$q .= " ENGINE={$options['engine']}";
					}
				if (isset($options['charset'])){
					$q .= " DEFAULT CHARSET={$options['charset']}";
					}
				if (isset($options['collate'])){
					$q .= " COLLATE={$options['collate']}";
					}
				if (isset($options['autoincrement'])){
					$q .= " AUTO_INCREMENT={$options['autoincrement']}";
					}
				
				}else if (is_string($options)){
				$q .= " {$options};";
				}
			$q .= ';';
			}
		try{
			$error = $this->pdo->prepare($q)->execute();
			}catch(PDOException $e){
			$error = $e->getMessage();
			}
		return $error;
		}
	///////////////////////////////////////////////////////
	function exec($q){
		if($this->connected){
			return $this->pdo->exec($q);
			}
		}
	///////////////////////////////////////////////////////
	function query($s){
		$res = array();
		try{
			$tmp = $this->pdo->prepare($s);
			$tmp->execute();
			}catch(PDOException $e){
			return false;
			}
		$i = 0;
		
		if ($tmp!=false){
			while ($row = $tmp->fetch($this->pdofetchmode)){
				if(count($row)>0){
					if(isset($row['id'])){
						$res[$row['id']] = $row;
						}else{
						$res[$i++] = $row;
						}
					}
				}
			}
		return $res;
		}
	///////////////////////////////////////////////////////
	function gettable($tablename = '', $what = '*', $conditions = array(), $limit = 0, $order = '', $dir = ''){
		require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'auxclasses' . DIRECTORY_SEPARATOR . 'db_table.php');
		$fields = array();
		/*
		get field definitions from table in the database
		*/
		/*
		for SQLite:
		$result = $pdo->query("PRAGMA table_info(" . $table_name . ")");
$result->setFetchMode(PDO::FETCH_ASSOC);
$meta = array();
foreach ($result as $row) {
  $meta[$row['name']] = array(
    'pk' => $row['pk'] == '1',
    'type' => $row['type'],
  );
}
		*/
		$select = $this->pdo->query("SELECT * FROM {$tablename}");
		for ($i = 0; $i < $select->columnCount(); $i++) {
			$info = $select->getColumnMeta($i);
		    $fields[] = array(
		    	'name' => $info['name'],
		    	'type' => $info['native_type'],
		    	'length' => $info['len'],
		    	'collation' => '',
		    	'attributes' => '',
		    	'null' => $info['flags'][0],
		    	'primary' => (
		    		(count($info['flags'])>1)
		    		&&
		    		($info['flags'][1]=='primary_key')
		    		),
		    	'default' => '',
		    	'autoincrement' => false,
		    	'comments' => '',
		    	'values' => ''
		    	);
			}
		if(count($fields)>0){
			$res = new TDBTable($tablename, $fields);
			}else{
			$res = false;
			}
		return $res;
		
		}
	///////////////////////////////////////////////////////
	function fetchtable($tablename){
		return $this->select($tablename);
		}
	///////////////////////////////////////////////////////
	function fetch($tablename = '', $what = '*', $conditions = array(), $limit = 0, $order = '', $dir = ''){
		return $this->select($tablename, $what, $conditions, $limit, $order, $dir);
		}
	///////////////////////////////////////////////////////
	function select($tablename = '', $what = '*', $conditions = array(), $limit = 0, $order = '', $dir = ''){
		$res = array();
		$tablename = trim($tablename);
		if($tablename==''){
			$res = 'Please provide a table name.';
			}else{
			if (is_array($what)){
				$what = implode(',', $what);
				}else{
				if (trim($what)==''){
					$what = '*';
					}
				}
			$where = trim($this->processconditions($conditions));
			if ($where=='1'){
				$where = '';
				}else{
				$where = " WHERE {$where}";
				}
			if(($limit==0)||($limit=='0')){
				$limit = '';
				}else{
				$limit = " LIMIT {$limit}";
				}
			if(trim($order)!=''){
				$order = " ORDER BY {$order}";
				$dir = trim(strtoupper($dir));
				if(($dir=='ASC')||($dir=='DESC')){
					$order .= " {$dir}";
					}
				}
			if ($where!=''){
				$limit = '';
				}
			$s = "SELECT {$what} FROM {$tablename}{$where}{$limit}{$order};";
			return $this->query($s);
			}
		}
	///////////////////////////////////////////////////////
	function insert($tablename = '', $data = array()){
		$tablename = trim($tablename);
		if ($tablename!=''){
			if ((is_array($data))&&(count($data)>0)){
				if((isset($data[0]))&&(is_array($data[0]))){
					$res = true;
					foreach($data as $row){
						$keys = '';
						$vals = '';
						foreach($row as $key => $val){
							if ($keys!=''){
								$keys .= ', ';
								}
							$keys .= "`{$key}`";
							if ($vals!=''){
								$vals .= ', ';
								}
							$vals .= ":{$key}";
							}
						$res = (($res) && ($this->prepexec("INSERT INTO `{$tablename}` ({$keys}) VALUES ({$vals});", $row)));
						}
					return $res;
					}else{
					$keys = '';
					$vals = '';
					foreach($data as $key => $val){
						if ($keys!=''){
							$keys .= ', ';
							}
						$keys .= "`{$key}`";
						if ($vals!=''){
							$vals .= ', ';
							}
						$vals .= ":{$key}";
						}
					return $this->prepexec("INSERT INTO `{$tablename}` ({$keys}) VALUES ({$vals});", $data);
					}
				}else{
				return false;
				}
			}
		}
	///////////////////////////////////////////////////////
	function update($tablename = '', $data = array(), $condition = ''){
		$tablename = trim($tablename);
		if ($tablename!=''){
			$condition = $this->processconditions($condition);
			$items = '';
			if ((is_array($data))&&(isAssoc($data))&&(count($data))>0){
				foreach($data as $key => $val){
					if ($items!=''){
						$items .= ', ';
						}
					$items .= "`{$key}` = :{$key}";
					}
				return $this->prepexec("UPDATE `{$tablename}` SET {$items} WHERE {$condition};", $data);
				}else{
				return false;
				}
			}
		}
	///////////////////////////////////////////////////////
	function prepexec($querystring = '', $data = array()){
		$prep = $this->pdo->prepare($querystring);
		return $prep->execute($data);
		}
	///////////////////////////////////////////////////////
	function processconditions($conditions = array()){
		$where = '';
		if (is_array($conditions)){
			//conditions are passed as an array; process it before using
			$where = '';
			foreach($conditions as $c){
				if (count($c)>1){
					//a valid condition must have at least a key and a value
					if ($where!=''){
						//if this is not the first condition, we need a conjunction (AND, OR)
						if(!isset($c['conj'])){
							if(isset($c['conjunction'])){
								$c['conj'] = $c['conjunction'];
								}else{
								//use the default conjunction, which is AND unless the user sets it otherwise
								$c['conj'] = $this->defaultconditionconjunction;
								}
							}
						$where .= " {$c['conj']} ";
						}
					if (
						(isset($c['key']))
						&&
						(isset($c['val']))
						&&
							(
							(isset($c['op']))
							||
							(isset($c['operator']))
							)
						){
						//all fields are set by name
						//make sure the 'op' field holds a valid operator
						if (!isset($c['op'])){
							if(isset($c['operator'])){
								$c['op'] = $c['operator'];
								}else{
								//touch the field
								$c['op'] = '';
								}
							}
						if (trim($c['op'])==''){
							//use the default conditions operator, which is '=' unless the user sets it otherwise
							$c['op'] = $this->defaultconditionoperator;
							}
						$where .= "`{$c['key']}` {$c['op']} '{$c['val']}'";
						}else{
						//at least one field is not set by name; assume the order: [key] [operator] [value]
						if(count($c)>2){
							$where .= "`{$c[0]}` {$c[1]} '{$c[2]}'";
							}else{
							//there are only two fields; assume the order: [key] [value] and use a default operator
							$where .= "`{$c[0]}` {$this->defaultconditionoperator} '{$c[1]}'";
							}
						}
					}else{
					//or else we assume it refers to the default 'id' field
					$where .= "`id` {$this->defaultconditionoperator} '{$c[0]}'";
					}
				}
			}else{
			//conditions are passed as a string; use it as is
			$where = $conditions;
			}
		if ((trim($where)=='')||(trim($where)=='*')){
			$where = '1';
			}
		//echo $where;
		return trim($where);
		}
	///////////////////////////////////////////////////////
	///////////////////////////////////////////////////////
	}