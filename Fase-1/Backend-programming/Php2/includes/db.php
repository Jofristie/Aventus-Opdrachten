<?php
/**
 * Databaseconnectie
 * Gebruikt PDO binnen een kleine wrapper-klasse (Singleton patroon)
 */

class Database
{
    private static ?PDO $instance = null;

    private const HOST = 'localhost';
    private const DBNAME = 'portfolio_db';
    private const USER = 'root';
    private const PASS = '';

    // Voorkom dat er losse instanties gemaakt worden
    private function __construct()
    {
    }

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            try {
                $dsn = 'mysql:host=' . self::HOST . ';dbname=' . self::DBNAME . ';charset=utf8mb4';
                self::$instance = new PDO($dsn, self::USER, self::PASS, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } catch (PDOException $e) {
                die('Databaseverbinding mislukt: ' . htmlspecialchars($e->getMessage()));
            }
        }

        return self::$instance;
    }
}
