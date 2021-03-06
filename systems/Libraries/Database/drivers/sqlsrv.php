<?php
/**
 * Driver SQL Server
 *
 * @author 		Dony Wahyu Isp
 * @copyright 	2015 Dony Wahyu Isp
 * @link 		http://github.io/database
 * @license		MIT
 * @version 	1.0.3
 * @package		SQL Server
 **/
class Divalia_MsSQL {
	private $dbcon=NULL;

	private $_select = '';

	private $_fields = '';

	private $_num_rows = 0;

	private $_pk = '';
	
	private $_insert_id = null;

	private $_joinFields = array();

	private $_raw_res = NULL;

	private $_query = '';

	private $_raw_callback;
	
	private $_field_type = array(
		-5 		=> 'bigint',
		-2 		=> 'binary',
		-7 		=> 'bit',
		   1	=> 'char',
		  91 	=> 'date',
		  93 	=> 'datetime',
		-155 	=> 'datetimeoffset',
		   3	=> 'decimal',
		   6    => 'float',
		-4		=> 'image',
		   4	=> 'int',
		   3 	=> 'money',
		-8 		=> 'nchar',
		-10		=> 'ntext',
		   2	=> 'numeric',
		-9		=> 'nvarchar',
		   7	=> 'real',
		   5	=> 'smallint',
		-154	=> 'time',
		-6		=> 'tinyint',
		-151	=> 'udt',
		-11		=> 'uniqueidentifier',
		-3 		=> 'varbinary',
		  12	=> 'varchar',
		-152	=> 'xml'   
	);

	public function __construct() {

	}

	public function connect($dbname, $hostname='localhost', $username='root', $password='', $failover=FALSE) {
		
		$connectionInfo = array("Database"=>$dbname);
		if (!empty($username)) $connectionInfo['UID'] =$username;
		if (!empty($password)) $connectionInfo['PWD'] =$password;

		$this->dbcon = sqlsrv_connect(
		    $hostname,
		    $connectionInfo
		);

		if ($failover === FALSE) {
			if ( !$this->dbcon ) {
			    header('X-Error-Message: Fail Connecting', true, 500);
			    die("Failed to connect to MsSQL ");
			}
		}

		return $this->dbcon;
	}

	public function exec($sql) {
		$this->_query = $sql;
		$res = sqlsrv_query($this->dbcon, $sql);
		if (!$res){
			$error = sqlsrv_errors();
			echo "<strong>Query: ".$sql."</strong><br />";
			echo 'Query Error: '.$error[0][2];
		}

		return $res;
	}

	public function fetch($res, $callback=null) {
		$callback_is = 0;
        if (is_callable($callback))
            $callback_is = 1;
        elseif (is_array($callback))
            $callback_is = 2;

		$result = array();
		$this->_num_rows = sqlsrv_num_rows($res);
		while( $data = sqlsrv_fetch_object($res) ) {
			if ($callback_is  == 1) {
                while(list($field, $value) = each($data)) {
                    $data->$field = $callback($data->$field, $data);
                }
            } elseif ($callback_is == 2) {
            	reset($callback);
                while(list($field, $func) = each($callback)) {
                    if (isset($data->$field))
                        $data->$field = $func($data->$field, $data);
                }
            }

            if (count($this->_joinFields) > 0) {
            	reset($this->_joinFields);
            	while (list($field, $join) = each($this->_joinFields)) {
            		
            		if (isset($data->$field)) {
            			$modelJoin = $this->_joinFields[$field][0];
            			$realField = $this->_joinFields[$field][1];

            			if (!isset($data->$modelJoin)) {
            				$dataJoin = new \stdClass;
            				$dataJoin->$realField = $data->$field;
            				$data->$modelJoin = $dataJoin;
            			} else
            				$data->$modelJoin->$realField = $data->$field;

            			unset($data->$field);
	            	}
            	}
            	unset($dataJoin);
            	
            	$result[] = $data;	            		
            } else
				$result[] = $data;
		}

		sqlsrv_free_stmt($res);

		return $result;
	}

	public function affected() {
        return sqlsrv_rows_affected($this->dbcon);
    }

	public function __destruct() {
		if ($this->dbcon)
			sqlsrv_close($this->dbcon);
	}

	public function insert($table, $data) {
		$table = (!empty($this->table))?$this->table:$table;
		$fields = $values = array();

		while (list($field, $value) = each($data)) {
			$fields[] = $field;

			if (is_array($value) && $value[1] == FALSE)
				$values[] = $value[0];
			else {
				$value = addslashes($value);
				if (gettype($value) == 'string')
					$value = "'$value'";

				$values[] = $value;
			}
		}

		$fields = implode(',', $fields);
		$values = implode(',', $values);
		$query = "INSERT INTO $table ($fields) VALUES ($values); SELECT SCOPE_IDENTITY() as lastId";

		$res = $this->exec($query);

		sqlsrv_next_result($resource); 
		sqlsrv_fetch($resource); 
		$this->_insert_id = sqlsrv_get_field($resource, 0);
		return (object) array(
			'query'=>$query, 
			'result'=>$res,
			'id'=>$this->insert_id()
		);
	}

	public function update($table, $id, $data) {
		$fieldsValues = array();
		$and = array();

		while(list($pk, $value) = each($id)) {

			if (is_array($value) && $value[1] == FALSE)
				$value = $value[0];
			else {
				$value = addslashes($value);
				if (gettype($value) == 'string')
					$value = "'$value'";
			}

			if (preg_match('/<|>|!=/', $value))
				$and[] = "$pk$value";
			else
				$and[] = "$pk=$value";
		}

		$where = '';
		if (count($id) > 0)
			$where = 'WHERE '.implode(' AND ', $and);

		while (list($field, $value) = each($data)) {
			if (is_array($value) && $value[1] == FALSE)
				$fieldsValues[] = "#field=".$value[0];
			else {
				$value = addslashes($value);
				if (gettype($value) == 'string')
					$value = "'$value'";

				$fieldsValues[] = "$field=".$value;
			}
		}

		$fieldsValues = implode(',', $fieldsValues);
		$query = "UPDATE $table SET $fieldsValues $where";
		return (object) array(
			'query'=>$query, 
			'result'=>$this->exec($query),
			'id'=>$id
		);
	}

	public function delete($table, $id) {
		$fieldsValues = array();
		$and = array();

		while(list($pk, $value) = each($id)) {
			if (is_array($value) && $value[1] == FALSE)
				$value = $value[0];
			else {
				$value = addslashes($value);
				if (gettype($value) == 'string')
					$value = "'$value'";
			}

			if (preg_match('/<|>|!=/', $value))
				$and[] = "$pk$value";
			else
				$and[] = "$pk='$value'";
		}

		$where = '';
		if (count($id) > 0)
			$where = 'WHERE '.implode(' AND ', $and);

		$query = "DELETE FROM $table $where";
		return (object) array(
			'query'=>$query, 
			'id'=>$id,
			'result'=>$this->exec($query) 
		);
	}

	public function find($table, $condition=array(), $limit=array(), $order_by=array()) {
		$ret = array();
		$callback = null;
		$this->_fields = null;
        $this->_num_rows = 0;

        if (isset($condition['callback'])) {
            $callback = $condition['callback'];
            unset($condition['callback']);
        }

        if (isset($condition['join']) && count($condition['join']) > 0) {
        	if (!isset($condition['select'])) $condition['select'] = array(array("$table.*"));

        	$this->_joinFields = array();
        	while (list($id, $join) = each($condition['join'])) {
        		$this->_fields = '';
        		$fields = $this->fields($join[1]);

        		while (list($id, $field) = each($fields)) {
        			$this->_joinFields["__$join[1]_$field->name"] = array($join[1], $field->name);
        			$condition['select'][] = array("$join[1].$field->name", 'as'=>"__$join[1]_$field->name");
        		}
        	}
        	
        	reset($condition['join']);
        }

        $fields = $this->fields($table);
        QueryHelper::$select_limit = $fields[0]->name;

		$query = QueryHelper::find($table, $condition, $limit, $order_by);
		if ($res = $this->exec($query)){
			$this->_num_rows = sqlsrv_num_rows($res);
			$this->_fields = '';
			$fields = array();
			foreach( sqlsrv_field_metadata( $res ) as $field ) {
			    $fields[] = (object) array(
					'name' => $field['Name'],
					'type' => $this->_field_type[$field['Type']],
					'size' => $field['Size'],
					'table' => $table
				);
			}
			$this->_fields = $fields;
			$ret = $this->fetch($res, $callback);
		}
		else 
			echo sqlsrv_errors($this->dbcon);
		
		return $ret;
	}

	public function raw_find($table, $condition=array(), $limit=array(), $order_by=array()) {
		$this->_fields = null;
        $this->_num_rows = 0;

        if (isset($condition['callback'])) {
            $this->_raw_callback = $condition['callback'];
            unset($condition['callback']);
        }

        if (isset($condition['join']) && count($condition['join']) > 0) {
        	if (!isset($condition['select'])) $condition['select'] = array(array("$table.*"));

        	$this->_joinFields = array();
        	while (list($id, $join) = each($condition['join'])) {
        		$this->_fields = '';
        		$fields = $this->fields($join[1]);

        		while (list($id, $field) = each($fields)) {
        			$this->_joinFields["__$join[1]_$field->name"] = array($join[1], $field->name);
        			$condition['select'][] = array("$join[1].$field->name", 'as'=>"__$join[1]_$field->name");
        		}
        	}
        	
        	reset($condition['join']);
        }

		$query = QueryHelper::find($table, $condition, $limit, $order_by);
		if ($this->_raw_res = $this->exec($query)) {
			$this->_num_rows = sqlsrv_num_rows($this->_raw_res);
			$this->_fields = '';
			$fields = array();
			foreach( sqlsrv_field_metadata( $this->_raw_res ) as $field ) {
			    $fields[] = (object) array(
					'name' => $field['Name'],
					'type' => $this->_field_type[$field['Type']],
					'size' => $field['Size'],
					'table' => $table
				);
			}
			$this->_fields = $fields;
		}
		else 
			echo sqlsrv_errors($this->dbcon);

		return $this;
	}

	public function each(\Closure $callable) {
		$data = array();
		if (!empty($this->_raw_res) && is_callable($callable)) {
			$res = $this->_raw_res;
			$this->_raw_res = NULL;

			$callback_is = 0;
	        if (is_callable($this->_raw_callback))
	            $callback_is = 1;
	        elseif (is_array($this->_raw_callback))
	            $callback_is = 2;

	        $callback = $this->_raw_callback;
	        
			$this->_num_rows = sqlsrv_num_rows($res);
			while( $row = sqlsrv_fetch_object($res) ) {
	            if ($callback_is  == 1) {
                	while(list($field, $value) = each($row))
	                    $row->$field = $callback($row->$field, $row);
	               
	            } elseif ($callback_is == 2) {
	            	reset($callback);
	                while(list($field, $func) = each($callback)) {
	                    if (isset($row->$field))
	                        $row->$field = $func($row->$field, $row);
	                }
	            }

	            if (count($this->_joinFields) > 0) {;
	            	reset($this->_joinFields);
	            	while (list($field, $join) = each($this->_joinFields)) {
	            		if (isset($row->$field)) {
	            			$modelJoin = $this->_joinFields[$field][0];
	            			$realField = $this->_joinFields[$field][1];

	            			if (!isset($dataJoin->$realField)) $dataJoin = new stdclass;

	            			$dataJoin->$realField = $row->$field;
		            		unset($row->$field);


			            	$row->$modelJoin = $dataJoin;
		            	}
	            	}
	            }

	            $callable($row);
	            array_push($data, $row);
			}

			sqlsrv_free_stmt($res);
		}

		return (object) array(
			'query' => $this->_query,
			'result' => (object) array(
				'num_rows' => $this->_num_rows,
				'fields' => $this->_fields,
				'data' => $data
			)
		);
	}

	public function fields($table) {
		if (empty($this->_fields)) {
			$query = "SELECT TOP 1 * FROM $table";
			if ($res = $this->exec($query)) {
				$fields = array();
				foreach( sqlsrv_field_metadata( $res ) as $field ) {
				    $fields[] = (object) array(
						'name' => $field['Name'],
						'type' => $this->_field_type[$field['Type']],
						'size' => $field['Size'],
						'table' => $table
					);
				}
				$this->_fields = $fields;
				sqlsrv_free_stmt($res);
			} else
				echo $this->dbcon->error;
		} 
			
		return $this->_fields;
	}

	public function num_rows() {
		return $this->_num_rows;
	}

	public function insert_id() {
		return $this->_insert_id;
	}

	public function set_pk($pk) {
		$this->_pk = $pk;
	}
}

class QueryHelper {
	public static $select_limit = '';

	public static function select($list) {
		$select = array();

		if (is_array($list) && count($list) > 0) {
			while(list($idx, $selectlist) = each($list)) {
				while(list($id, $fields) = each($selectlist)) {
					

					if (is_int($id)) {
						if (count($selectlist)>1)
							$select[] = $fields;
						else
							$select[] = $fields;

					} elseif (is_string($fields)) {
						if (strtoupper($id) != 'AS')
							$select[] = strtoupper($id)."($fields)";
						else
							$select[count($select)-1] .= " AS $fields";
					}
				}
			}
			
			$ret = implode(', ', $select).' ';
		}

		return (!isset($ret))?' * ':$ret;
	}

	public static function where($list, $group='and', $idx_where=1, $group_prev='') {
		$ret = '';
		$where = array('and'=>array(), 'or'=>array());
		$opt = array('and', 'or');
		$optrow = array();
		$wherestr = '';

		if (is_array($list) && count($list) > 0) {
			while (list($idx, $wherelist) = each($list)) {
				
				//sub operator
				if ( is_string($idx) && in_array($idx, $opt)) {
					$where[$idx][] .= '('.self::where($wherelist, $idx, $idx_where+1, $idx).')';
					$optrow[] = $idx;
				//logical
				} elseif (is_array($wherelist)) {
					
					if (count($wherelist) == 1 && isset($wherelist[0])) {
						$where[$group][] = $wherelist[0];
					} else {
						$id_step = 0;
						while (list($cond, $val) = each($wherelist)) {
							// if Count item 1
							if (count($wherelist) == 1) {
								
								for( $i=0; $i <= substr_count($cond, '?'); $i++) {
									$pos = strpos($cond, '?');
									$tmp = substr($cond, 0, $pos);
									$tmp .= $val[$i];
									$cond = $tmp.substr($cond, $pos+1);
								}


								$where[$group][] = $cond;
							// if Count item 2
							} elseif (count($wherelist) == 2) {
								
								if (is_array($val)) {
									while(list($condkey, $condval) = each($val)) {
										for( $i=0; $i <= substr_count($cond, '?'); $i++) {
											$pos = strpos($cond, '?');
											$tmp = substr($cond, 0, $pos);
											$tmp .= $condval;
											$cond = $tmp.substr($cond, $pos+1);
										}
									}
								} else {
									if ($id_step == 0) {
										$condfield = $val;
										$id_step++;
										continue;
									} else {
										$val = addslashes($val);
										if (gettype($val) == 'string')
 											$val = "'$val'";

										$cond = $val;
									}
								}

								$where[$group][] = $condfield.$cond;
								$condfield = '';
							// if Count item 3
							} elseif (count($wherelist) == 3) {
								if (is_array($val) && !is_int($cond)) {
									while(list($condkey, $condval) = each($val)) {
										for( $i=0; $i <= substr_count($cond, '?'); $i++) {
											$pos = strpos($cond, '?');
											$tmp = substr($cond, 0, $pos);
											$tmp .= $condval;
											$cond = $tmp.substr($cond, $pos+1);
										}
									}
								} else {
									if ($id_step == 0) {
										$condfield = $val;
										$id_step++;
										continue;
									} elseif($id_step == 1) {
										if (in_array($val, ['=','!=','<>','<','>','<=','>=']))
											$condopt = $val;
										else {
											$condopt = ' '.strtoupper($val).' ';
										}
										$id_step++;
										continue;
									} else {
										if (is_array($val)) {
											if (trim($condopt) == 'BETWEEN')
												$val = implode(' AND ', $val);
											elseif (is_array($val) && $val[1] == FALSE)
												$val = $val[0];
											else
												$val = '('.implode(', ', $val).')';
										} else {
											$val = addslashes($val);
											if (gettype($val) == 'string')
 												$val = "'$val'";
										}

										$cond = $val;
									}
								}
								
								$where[$group][] = $condfield.$condopt.$cond;
								$condfield = '';
							}
						}

					}
				}
			}

			if ($idx_where == 1 && (count($where['and'] > 0) || count($where['or'] > 0)) )
				$ret = ' WHERE ';

			if (count($optrow) > 0) {
				
				while (list($id, $opt) = each($optrow)) {
					$wherestr .= implode(' '.strtoupper($opt).' ', $where[$opt]);
					if ($id == 0 && $idx_where == 2) $wherestr .= ' '.strtoupper($group_prev).' ';
				}

				$ret .= $wherestr;
			} else
				$ret .= implode(' '.strtoupper($group).' ', $where[$group]);//.$wherestr;
		}

		return $ret;
	}

	public static function group_by($dbcon, $list) {
		$ret = '';
		$group_by = array();
		
		if (is_array($list) && count($list) > 0) {
			while(list($idx, $group_bylist) = each($list)) {
				while(list($id, $fields) = each($group_bylist)) {

					if (is_int($id)) {
						if (count($group_bylist)>1){
							$fields = explode('.', $fields);
							if (count($fields) > 1)
								$fields = "$fields[0].$fields[1]";
							else
								$fields = "$fields[0]";

							$group_by[] = $fields;
						}
						else
							$group_by[] = $fields;

					} 

				}
			}
			
			$ret = ' GROUP BY '.implode(', ', $group_by).' ';
		}

		return $ret;
	}

	public static function join($table, $list) {
		$ret = '';
		$join = array();
		if (is_array($list) && count($list) > 0) {
			while (list($idx, $joinlist) = each($list)) {
				if (count($joinlist) == 2)
					$join[] = strtoupper($joinlist[0]).' JOIN '.$joinlist[1];
				elseif (count($joinlist) == 3) {
					if (is_array($joinlist[2]) && count($joinlist[2]) == 2) {
						$on1 = $joinlist[2][0];
						$on2 = $joinlist[2][1];

						if (strpos($on1, '.') > 1 || strpos($on2, '.')) {

							if (strpos($on1, '.') === false)
								$on1 = "$joinlist[1].$on1";

							if (strpos($on2, '.') === false)
								$on2 = "$joinlist[1].$on2";
							
							$join[] = strtoupper($joinlist[0])." JOIN $joinlist[1] ON $on1 = $on2";
						} else
							$join[] = strtoupper($joinlist[0])." JOIN $joinlist[1] ON $joinlist[1].$on1 = $table.$on2";
					} else {
						$join[] = strtoupper($joinlist[0])." JOIN $joinlist[1] ON $joinlist[1].$joinlist[2] = $table.$joinlist[2]";
					}
				}
			}

			$ret = ' '.implode(' ', $join);
		}

		return $ret;
	}

	public static function union($list) {
		$ret = '';
		
		if (is_array($list) && count($list) > 0) {
			$ret = ' UNION '.implode(', ', $list);
		}

		return $ret;
	}

	public static function find($table, $filter=array(), $lmt=array(), $odr_by=array()) {
		$select = '';
		$from = "FROM $table";
		$where = '';
		$group_by = '';
		$limit = '';
		$order_by = '';
		$union = '';
		
		if (is_array($filter) && count($filter) > 0) {
			
			while(list($syntax, $query) = each($filter)) {
				$syntax = strtoupper($syntax);

				switch ($syntax) {
					case 'SELECT':
						$select .= self::select($query);
					break;
					
					case 'WHERE':
						$where = self::where($query);
					break;

					case 'GROUP BY':
						$group_by = self::group_by($dbcon, $query);
					break;

					case 'JOIN':
						$from .= self::join($table, $query);
					break;

					case 'UNION':
						$union = self::union($query);
					break;

					default:
					# code...
					break;
				}
			}
			
		}

		if (is_array($lmt) && count($lmt) > 0) {
			if (!isset($lmt[1]))
				$limit = " a WHERE a.row BETWEEN 0 and $lmt[0]";
			else 
				$limit = " a WHERE a.row BETWEEN $lmt[1] and $lmt[0]";
			
		}

		if (is_array($odr_by) && count($odr_by) > 0) {
			$ord = array('asc'=>array(), 'desc'=>array());
			while(list($sort, $fields) = each($odr_by)) {
				if (strtoupper($sort) == 'ASC') {
					$ord['asc'][] = implode(', ', $fields).' ASC';
				} elseif (strtoupper($sort) == 'DESC') {
					$ord['desc'][] = implode(', ', $fields).' DESC';
				}

			}

			if (count($ord['asc']) > 0 || count($ord['desc'])) {
				$order = [];
				if (count( $ord['asc'] ) > 0)
					$order[] .= implode(', ', $ord['asc']).' ';
				if (count( $ord['desc'] ) > 0)
					$order[] .= implode(', ', $ord['desc']).' ';
				$order = implode(', ', $order);
			} else
				$order = '';

			$order_by = ' ORDER BY '.$order;
		}


		$select = (empty($select))? '* ':$select;
		if (empty($limit))
			$sql = 'SELECT '.$select.$from.$where.$group_by.$order_by.$union;
		else
			$sql = 'SELECT * FROM (SELECT '.$select.', ROW_NUMBER() OVER (ORDER BY '.self::$select_limit.') as row '.$from.$where.$group_by.$order_by.$union.') '.$limit;

		return $sql;
	}

}


return new Divalia_MsSQL();