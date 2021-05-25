<?php
class Config
{
    const DATE_FORMAT = "Y-m-d H:i:s";
    const JWT_SECRET = "dk*M6spn7qk6b$<5";
    const JWT_TOKEN_TIME = 604800;

    public static function DB_HOST()
    {
        return Config::get_env("DB_HOST", "localhost");
    }
    public static function DB_USERNAME()
    {
        return Config::get_env("DB_USERNAME", "cardiaries");
    }
    public static function DB_PASSWORD()
    {
        return Config::get_env("DB_PASSWORD", "cardiaries");
    }
    public static function DB_SCHEME()
    {
        return Config::get_env("DB_SCHEME", "cardiaries");
    }
    public static function DB_PORT()
    {
        return Config::get_env("DB_PORT", "3306");
    }
    public static function SMTP_HOST()
    {
        return Config::get_env("SMTP_HOST", "smtp.mailgun.org");
    }
    public static function SMTP_PORT()
    {
        return Config::get_env("SMTP_PORT", "587");
    }
    public static function SMTP_USER()
    {
        return Config::get_env("SMTP_USER", "postmaster@sandbox236d84405d3145cfa817be35c06cc2c4.mailgun.org");
    }
    public static function SMTP_PASSWORD()
    {
        return Config::get_env("SMTP_PASSWORD", "c83c5f07b1e53dbec7efd0d04f9b9391-fa6e84b7-27e16869");
    }
    public static function SPACES_KEY()
    {
        return Config::get_env("SPACES_KEY", "ZE2E6JG2P3NDIQFFFZBP");
    }
    public static function SPACES_SECRET()
    {
        return Config::get_env("SPACES_SECRET", "EbGbuDhf7pYFJhFqeMvCJL1m0mZZvtkleBnKswZHcEU");
    }

    public static function get_env($name, $default)
    {
        return isset($_ENV[$name]) && trim($_ENV[$name]) != '' ? $_ENV[$name] : $default;
    }
}
