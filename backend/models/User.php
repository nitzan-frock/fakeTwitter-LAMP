<?php
    class POST {
        // DB stuff
        private $conn;
        private $table = 'users';

        // Post Properties
        public $id;
        public $firstName;
        public $lastName;
        public $username;
        public $createdOn;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get Users
        public function read() {
            // Create query
            $query = 'SELECT 
                    id,
                    firstName,
                    lastName,
                    username,
                    createdOn
                FROM
                    ' . $this->table . '
                ORDER BY
                    p.createdOn DESC';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        // Get Single User
        public function read_single() {
            // Create query
            $query = 'SELECT 
                    id,
                    firstName,
                    lastName,
                    username,
                    createdOn
                FROM
                    ' . $this->table . '
                WHERE id = ?
                LIMIT 0,1';
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(1, $this->id);

            // Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set Properties
            $this->firstName = $row['firstName'];
            $this->lastName = $row['lastName'];
            $this->username = $row['username'];
            $this->id = $row['id'];
            $this->createdOn = $row['createdOn'];
        }

        // Create user
        public function create() {
            // create query
            $query = 'INSERT INTO ' . $this->table . '
                SET
                    firstName=:firstName, 
                    lastName=:lastName,
                    username=:username
            ';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->firstName = htmlspecialchars(strip_tags($this->firstName));
            $this->lastName = htmlspecialchars(strip_tags($this->lastName));
            $this->username = htmlspecialchars(strip_tags($this->username));

            // Bind data
            $stmt->bindParam(':firstName', $this->firstName);
            $stmt->bindParam(':lastName', $this->lastName);
            $stmt->bindParam(':username', $this->username);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        public function update() {
            // create query
            $query = 'UPDATE ' . $this->table . '
                SET
                    firstName=:firstName,
                    lastName=:lastName
                WHERE
                    id=:id
            ';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->firstName = htmlspecialchars(strip_tags($this->firstName));
            $this->lastName = htmlspecialchars(strip_tags($this->lastName));
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $stmt->bindParam(':firstName', $this->firstName);
            $stmt->bindParam(':lastName', $this->lastName);
            $stmt->bindParam(':id', $this->id);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        // Delete post
        public function delete() {
            // Create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE id=:id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $stmt->bindParam(':id', $this->id);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }
    }
?>