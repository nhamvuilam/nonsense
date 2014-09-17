<?php
class Core_Utils_DB
{	
	public static function update($tableName,$data,$where) {
    	if(empty($data)) return;
    	if(empty($where)) return;
    	$arraySet = array();
    	$params = array();
    	foreach ($data as $key => $value) {
    		$arraySet[]=" `$key` = :$key ";
    		$params[$key] = $value;
    	}
    	$sWhere = ' 1 = 1 ';
    	foreach ($where as $key => $value) {
    		$sWhere.=" AND `$key` = $value";
    	}
    	$query = 'UPDATE `'.$tableName.'` SET '.join(',', $arraySet).' WHERE '.$sWhere;
    	$db = Core_Global::getDbMaster();
    	$stmt = $db->prepare($query);
    	$stmt->execute($params);
    	$stmt->closeCursor();
    	$db->closeConnection();
    } 
    public static function insert($tableName,$data,$return = false) {
    	if(empty($data)) return;
    	$params = array();
    	$fieldNames = array();
    	$fieldValues = array();
    	foreach ($data as $key => $value) {
    		$params[$key] = $value;
    		$fieldNames[] = "`$key`";
    		$fieldValues[] = ":$key";
    	}
    	$query = 'INSERT INTO `'.$tableName.'`('.join(',', $fieldNames).') VALUES('.join(',', $fieldValues).') ';
    	$db = Core_Global::getDbMaster();
    	$stmt = $db->prepare($query);
    	$stmt->execute($params);
    	if($return) {
    		$stmt = $db->prepare('SELECT LAST_INSERT_ID() as id');
    		$stmt->execute();
    		$row = $stmt->fetch();
    		$id = $row['id'];
    	}
    	$stmt->closeCursor();
    	$db->closeConnection();
    	return $id;
    }
    public static function query($sql,$flag = 1,$params = array()) {
    	$db = Core_Global::getDbMaster();
    	$stmt = $db->prepare($sql);
    	$stmt->execute($params);
    	$result = null;
    	if($flag == 1) {//return rows
    		$result = $stmt->fetchAll();
    	} elseif ($flag == 2) { // return one
    		$result = $stmt->fetch();
    		$result = $result==false?null:$result;
    	} else if ($flag == 3) { //execute not return
    		
    	}
    	$stmt->closeCursor();
    	$db->closeConnection();
    	return $result;
    }
    public static function delete($tableName,$id,$key='id') {
    	$db = Core_Global::getDbMaster();
    	$stmt = $db->prepare('DELETE FROM `'.$tableName.'` WHERE `'.$key.'` = ?');
    	$stmt->execute(array($id));
    	$stmt->closeCursor();
    	$db->closeConnection();
    }
    public static function search($tableName,$where,$orderBy = '',$select='*') {
    	$sWhere = ' 1 = 1 ';
    	foreach ($where as $key => $value) {
    		if(empty($value)) continue;
    		if(Core_Utils_String::contains($value, '%')) {
    			$sWhere.=" AND `$key` LIKE '$value'";
    		} else {
    			$sWhere.=" AND `$key` = '$value'";
    		}
    	}
    	$query = 'SELECT '.$select.' FROM `'.$tableName.'` WHERE '.$sWhere.$orderBy;
    	$db = Core_Global::getDbMaster();
    	$stmt = $db->prepare($query);
    	$stmt->execute();
    	$result = $stmt->fetchAll();
    	$stmt->closeCursor();
    	$db->closeConnection();
    	return $result;
    } 
}