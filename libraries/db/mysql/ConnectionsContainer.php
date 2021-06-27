<?php
declare(strict_types=1);

namespace Libs\Db\Mysql;

class ConnectionsContainer
{
    private $connections = [];
    private $connectionsOptions = [];

    /**
     * add options for new PDO instance
     * @param $id - pdo instance identifier
     * @param array $options - [dsn, username, password, options]
     * @link http://php.net/manual/ru/pdo.construct.php
     *
     */
    public function addConnection(string $id, array $options): void
    {
        $options += ['dsn' => null, 'username' => null, 'password' => null, 'options' => null];
        $this->connectionsOptions[$id] = $options;
        if (!isset($this->connections[$id])) {
            $this->connections[$id] = null;
        }
    }

    /**
     * get PDO instance by args
     * @param string $id - pdo instance identifier
     * @return \PDO
     */
    public function getConnection(string $id): \PDO
    {
        if (!$this->connections[$id] instanceof \PDO) {
            $options = $this->connectionsOptions[$id];
            $pdo = new \PDO(
                $options['dsn'],
                $options['username'],
                $options['password'],
                [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC]
            );
            $this->connections[$id] = $pdo;
        }
        return $this->connections[$id];
    }
}
