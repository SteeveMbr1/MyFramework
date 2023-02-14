<?php

namespace MyFramework\Database;

use PDO;

class DB
{
    /**
     * array of PDO Connexions
     * @var PDO[]
     */
    protected static array $connexions;

    /**
     * Hold all the database configurations.
     * @var array
     */
    protected static array $config;

    public function __construct(string $config_file)
    {
        self::$connexions = [];
        self::$config = require $config_file ?? null;
    }

    public static function init(string $config_file)
    {
        return new static($config_file);
    }

    public static function getConnexion(?string $name = null)
    {
        $name = $name ?? self::$config['default'];

        if (!isset(self::$config[$name]))
            throw new \Exception("Error: The '$name' connexion does not exist", 1);

        if (!isset(self::$connexions[$name]))
            self::load_new_connexion($name);
        return self::$connexions[$name];
    }

    private static function load_new_connexion(string $name): void
    {
        $connexion = match (self::$config[$name]['driver']) {
            'sqlite' => self::load_sqlite_connexion(self::$config[$name]),
            'mysql'  => self::load_mysql_connexion(self::$config[$name]),
        };

        self::$connexions[$name] = $connexion;
    }

    private static function load_sqlite_connexion(array $config)
    {
        return new PDO("sqlite:" . $config['file']);
    }

    private static function load_mysql_connexion(array $config)
    {
        $host = $config['host'];
        $dbname = $config['dbname'];
        $username = $config['username'];
        $password = $config['password'];
        return new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    }
}
