<?php
    class POST {
        // DB stuff
        private $conn;
        private $table = 'posts';

        // Post Properties
        public $id;
        public $author_id;
        public $author_username;
        public $body;
        public $createdOn;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get Posts
        public function read() {
            // Create query
            $query = 'SELECT 
                    u.username AS author,
                    p.body,
                    p.id,
                    p.createdOn
                FROM
                    ' . $this->table . ' p
                LEFT JOIN
                    users u ON p.author_id = u.id
                ORDER BY
                    p.createdOn DESC';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        // Get Single Post
        public function read_single() {
            // Create query
            $query = 'SELECT 
                    u.username AS author,
                    p.body,
                    p.id,
                    p.createdOn
                FROM
                    ' . $this->table . ' p
                LEFT JOIN
                    users u ON p.author_id = u.id
                WHERE p.id = ?
                LIMIT 0,1';
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(1, $this->id);

            // Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set Properties
            $this->author = $row['author'];
            $this->body = $row['body'];
            $this->id = $row['id'];
            $this->createdOn = $row['createdOn'];
        }

        // Create post
        public function create() {
            // create query
            $query = 'INSERT INTO ' . $this->table . '
                SET
                    author_id=:author_id, 
                    body=:body
            ';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->body = htmlspecialchars(strip_tags($this->body));

            // Bind data
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':body', $this->body);

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
                    author_id=:author_id, 
                    body=:body
                WHERE
                    id=:id
            ';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':body', $this->body);
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