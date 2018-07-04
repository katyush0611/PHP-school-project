<?php

class User {
	private $premission;
	private $name;
	private $username;
	private $password;

    public function __construct($premission, $name, $username, $password) {
        $this->premission = $premission;
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
    }

    public function checkEnteryData() {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("
            SELECT premission, name
            FROM premissions
            WHERE username = ? AND password = ?
        ");
        $stmt->bind_param('si', $this->username, $this->password);
        if ($stmt->execute() == false) {
            echo 'First query failed: ' . $mysqli->error;
        };
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (is_null($row['name'])) {
            $footer = include 'footer.php';
            exit("<div id='error-login'>
                    <h1>Invalid Login Info, please try again...</h1>
                    <button >Back..</button>
            </div>
            <script type='text/javascript' src='../jquery-3.3.1.min.js'></script>
            <script type='text/javascript' src='../main.js'></script>
            ");

        } else {
            return $row['premission'];
        };

    }
};