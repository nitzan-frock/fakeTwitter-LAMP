<?php
    class Database {
        // DB config
        private $driver;
        private $host;
        private $port;
        private $db_name;
        private $username;
        private $password;

        private $conn;

        public function __construct($config = 'config.ini', $creds = 'creds.ini'){
            if (!$settings = parse_ini_file($config, TRUE)) {
                throw new exception('Unable to open ' . $config . '.');
            }
            if (!$creds = parse_ini_file($creds, TRUE)) {
                throw new exception('Unable to open ' . $creds . '.');
            }

            $this->driver = $settings['database']['driver'];
            $this->host = $settings['database']['host'];
            $this->port = !empty($settings['database']['port']) ? ($settings['database']['port']) : '';
            $this->db_name = $settings['database']['schema'];
            $this->username = $creds['credentials']['username'];
            $this->password = $creds['credentials']['password'];
        }

        // DB Connect
        public function connect() {
            $this->conn = null;

            try {
                $this->conn = new PDO(
                    $this->driver .
                    ':host=' . $this->host . 
                    ';port=' . $this->port .
                    ';dbname=' . $this->db_name, 
                    $this->username, $this->password
                );
                $this->conn->setAttribute(
                    PDO::ATTR_ERRMODE, 
                    PDO::ERRMODE_EXCEPTION
                );
            } catch(PDOException $e) {
                echo 'Connection Error: ' . $e->getMessage();
            }

            return $this->conn;
        }
    }
?>