<?php

namespace App\Modules\System;

class Db
{
	protected \PDO $pdo;

	function __construct(Configuration $configuration)
	{
		try {
			$databaseConfiguration = $configuration->getDatabaseConfiguration();
			$dsn = "{$databaseConfiguration['driver']}:host={$databaseConfiguration['host']};dbname={$databaseConfiguration['database']};charset={$databaseConfiguration['charset']}";
			$opt = [
				\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
				\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
				\PDO::ATTR_EMULATE_PREPARES => false
			];
			$this->pdo = new \PDO($dsn, $databaseConfiguration['user'], $databaseConfiguration['password'], $opt);
		}catch (\Exception $exception)
		{
			echo $exception->getMessage();
		}
	}

	final public function sqlExecution(string $sql, array $values = [])
	{
		try {
			$placeholders = self::getPlaceholdersFromSql($sql);
			self::checkValuesCount($placeholders, $values);
			$stmt = $this->pdo->prepare($sql);
			$requestType = self::getRequestType($sql);
			if($stmt->execute($values))
			{
				if($requestType == 'SELECT')
				{
					return $this->fetchSelectQuery($stmt);
				}elseif($requestType == 'INSERT')
				{
					return $this->pdo->lastInsertId();
				}
				return true;
			}else
			{
				throw new \Exception('Ooopss... Something goes wrong!');
			}
		}catch (\Exception $exception)
		{
			echo $exception->getMessage();
		}
	}

	static public function getPlaceholdersFromSql(string $sql)
	{
		preg_match_all('/:([A-Za-z0-9_]+)/', $sql, $matches);
		return $matches[1];
	}

	static public function checkValuesCount(array $placeholders, array $values)
	{
		if(count($placeholders) != count($values))
		{
			throw new \Exception('The count placeholders is not equal to the count of values');
		}
	}

	final static public function getRequestType(string $sql)
	{
		preg_match('/^([A-Za-z]+)/', $sql, $matches);
		if(count($matches) > 0)
		{
			return $matches[0];
		}
		return false;
	}

	public function fetchSelectQuery(\PDOStatement $stmt)
	{
		if($stmt->rowCount() > 1)
		{
			return $stmt->fetchAll();
		}
		return $stmt->fetch();
	}
}