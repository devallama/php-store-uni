<?php
require('db.info.php');
class database {
    public $connection;

    public function __construct() {
        $db_info = getDBInfo();

        $conn = "mysql:host=" . $db_info['servername'] . ";dbname=" . $db_info['dbname'] . ";charset=" . $db_info['charset'];

        try {
            $this->connection = new PDO($conn, $db_info['username'], $db_info['password']);
        } catch (PDOException $e) {
            exit('Connection failed: ' . $e->getMessage());
        }
    }

    // Function to update and insert data
    // $input_data = $data to be binded and used in query
    // $sql = sql query
    public function process($input_data, $sql) {
        $stmt = $this->connection->prepare($sql);
        if(!$stmt) {
            $this->error(0);
        }

        foreach($input_data as $key => $data) {
            if(!isset($data['clientsideOnly']) || !$data['clientsideOnly']) {
                $stmt->bindParam(':' . $key, $data['data']);
            }
        }

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            $this->error(1, $e->getMessage());
        }
        return true;
    }

    // Function to fetchData
    // $input_data = $data to be binded and used in query
    // $sql = sql query
    // $single = whether to return only one row
    public function fetch($input_data, $sql, $single = false) {
        $stmt = $this->connection->prepare($sql);
        if(!$stmt) {
            $this->error(0);
        }

        foreach($input_data as $key => $data) {
            $stmt->bindParam(':' . $key, $data['data']);
        }

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            $this->error(1, $e->getMessage());
        }

        if($single) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $result;
    }

    // Function to fetchData using an array of data
    // $input_data = $data to be binded and used in query
    // $sql = sql query
    // $single = whether to return only one row
    public function fetchWithArray($input_data, $sql, $single = false) {
        $stmt = $this->connection->prepare($sql);
        if(!$stmt) {
            $this->error(0);
        }

        for($i = 0; $i < count($input_data); $i++) {
            $stmt->bindParam($i + 1, $input_data[$i]);
        }

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            $this->error(1, $e->getMessage());
        }

        if($single) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $result;
    }

    // Check if the summited data already exists
    // $input_data = $data to be binded and used in query
    // $sql = sql query
    // $single = whether to return only one row
    public function checkExists($input_data, $sql) {
        $stmt = $this->connection->prepare($sql);
        if(!$stmt) {
            $this->error(0);
        }

        foreach($input_data as $key => $data) {
            $stmt->bindParam(':' . $key, $data['data']);
        }

        try{
            $stmt->execute();
        } catch(PDOException $e) {
            $this->error(1, $e->getMessage());
        }

        if($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function error($id, $info = null) {
        if($id == 0) {
            echo 'There is an error with database query, this will be fixed as soon as possible. <a href="/index.php">Return home</a>';
            exit();
        } else if($id == 1) {
            echo 'There is an error with the database, this will be fixed as soon as possible. <a href="/index.php">Return home</a>';
            exit();
        }
    }
}
