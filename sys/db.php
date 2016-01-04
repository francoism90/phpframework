<?php
namespace Sys;
use Exception;
use PDO;
use Redis;
use RedisException;
class DB {
	public static function init(string $k) {
		$c = Arr::merge("config/db/$k");
		switch ($c['class']) {
			case 'pdo':
				try {
					$dbh = new PDO($c['dsn'], $c['user'], $c['pass'], $c['parm']);
					$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
				} catch (PDOException $e) {
					exit('PDO: '.$e->getMessage());
				}
				break;
			case 'redis':
				try {
					$dbh = new Redis();
					$dbh->connect($c['path']);
					$dbh->select($c['db']);
				} catch(RedisException $e) {
					exit('Redis: '.$e->getMessage());
				}
				break;
			default:
				exit("Init error: $k");
			}
			return $dbh;
		}

		public static function sql(array $c) {
			extract(array_merge(Arr::merge('config/db/sql'), $c));

			// Extract data
			if (!empty($data)) {
				$sep = ($mode == 'update') ? ',' : " $sep ";
				foreach ($data as $k => $v) $a[] = "$k = :$k";
				$w = implode($sep, $a);
			}

			// Create Query
			switch ($mode) {
				case 'select':
					$sql = "SELECT $columns FROM $table";
					$sql.= !empty($data) ? " WHERE $w" : '';
					break;
				case 'insert':
					$sql = "INSERT INTO $table (".implode(',', array_keys($data)).") ";
					$sql.= "VALUES (:".implode(',:', array_keys($data)).")";
					break;
				case 'update':
					$sql = "UPDATE $table SET $w";
					break;
				case 'delete':
					$sql = "DELETE FROM $table WHERE $w";
					break;
			}

			// Perform Query
			$dbh = self::init($dbh);
			$sth = $dbh->prepare($sql . (!empty($extra) ? " $extra" : ''));
			$sth->execute($data);
			if ($mode == 'select')
				return $fetchall ? $sth->fetchAll($fetchstyle) : $sth->fetch($fetchstyle);

			return $dbh;
		}
}
?>
