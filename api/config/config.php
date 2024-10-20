<?php

namespace App\Config;

class Config{
    
    // Database connection data
    public static string $DB_HOST = "localhost";
    static string $DB_NAME = "autodealer" ;
    static string $DB_USER = "root";
    static string $DB_PASSWORD = "12052003";

    // Project configurations
    static int $DEBUG = 1;

    // Defined routes
    public static string $API_URL = "http://autodealer-system.local/api/";
}
