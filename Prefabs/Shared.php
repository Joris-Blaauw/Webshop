<?php

namespace Shared;

/**
 * Class for functions related to the database.
 *
 * Used for establishing a connection while keeping the login info secure, and executing sql queries using a simple one-line function
 */
class DB {
    private string $servername = "145.53.245.193";
    private string $username = "webshop";
    private string $password = "webcrimes";
    private string $dbname = "webshop";
    /**
     * @var string The name of the current page
     */
    public string $PageName;
    /**
     * @var \mysqli The main database connection established when the class is initialised
     */
    public \mysqli $conn;

    public function __construct($PageName) {
        $conn = new \mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($conn->connect_error) {
            die("Connection Failed: $conn->connect_error");
        }
        $this->conn = $conn;
        $this->PageName = $PageName;
    }

    /**
     * Function to fetch data from the database
     *
     * @param string $sql SQL Query to run on the database
     * @return array Fetched data from the query
     */
    public function FetchData(string $sql): array
    {
        return mysqli_fetch_all(mysqli_query($this->conn, $sql));
    }

    /**
     * Fetches an associative array from the database
     *
     * @param string $sql SQL Query to run
     * @return array Fetched assoc array
     */
    public function FetchAssoc(string $sql): array
    {
        $BundledArray = array();
        $result = mysqli_query($this->conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            // Process each row as an associative array
            $BundledArray[] = $row;
        }
        return $BundledArray;

    }

    public function FetchPageInfo(): array
    {
        return mysqli_fetch_assoc(mysqli_query($this->conn, "SELECT * FROM page WHERE Role = '$this->PageName'"));
    }

    /**
     * Function to close the database connection, MUST BE RAN AT THE END OF EXECUTION
     *
     * @return void
     */
    public function CloseConn(): void
    {
        mysqli_close($this->conn);
    }
}

class Queries {
    public string $GetProducts = "SELECT * FROM product";
}