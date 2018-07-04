<?php 

class Student {
	private $id;
	private $name;
	private $img;
	private $phone;
	private $email;

    public function __construct($id, $name, $img, $phone, $email) {
        $this->id = $id;
        $this->name = $name;
        $this->img = $img;
        $this->phone = $phone;
        $this->email = $email;
    }

    public function getAll() {
    	$all = DB::getConnection()->query("
			SELECT *
			FROM students
    	");
    	while ($row = mysqli_fetch_array($all)) {
    	    echo "<div class='onestudent'>
                    <a href='/".$row['id']."'>
                        <img id='stdimg' src='../photos/".$row['img']."'>
                    </a>
                    <p>Name:".$row['name']."</p>
                    <p>Phone:".$row['phone']."</p>
                </div>";
    	};
    }

    public function showOne($id) {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("
            SELECT name, img, phone, email
            FROM students 
            WHERE id = ?
            LIMIT 1
        ");
        $stmt->bind_param('i', $id);
        if ($stmt->execute() == false) {
            echo 'First query failed: ' . $mysqli->error;
        };
        $stmt->bind_result($name, $img, $phone, $email);
        $stmt->fetch();
        echo "<main>
        <div style='margin: 10% 5% 0;'>
                <div id='premision-btns'>
                    <button id='edit-std'>Edit</button>
                    <button id='deletestd'>x</button>
                </div>
                    <div id='stdInfo'  class='".$id."'>
                        <form id='main' enctype='multipart/form-data' action='/edited/".$id."' method='POST'>
                            <img src='../photos/".$img."' class='form-img' id='".$img."'>
                            <div class='data'>
                                <h1 id='stdName' class='".$id."'>".$name."</h1>
                                <p class='personal-data' id='stdEmail'>".$email."</p>
                                <p class='personal-data' id='stdPhone'>".$phone."</p>
                            </div>
                        </form>
                    </div>
                        <div class='container'> 
                            <div class='dropdown'>
                                <span class='selLabel'>available courses list</span>
                                <input type='hidden' name='cd-dropdown'>
                                <ul class='dropdown-list'>
      
        ";
        $stmt->close();




        $courses = array();
        $allcrs = DB::getConnection()->query("SELECT id FROM courses");
        while ($row = mysqli_fetch_array($allcrs)) {
            array_push($courses, $row['id']);    
        };
        $query = "SELECT course_id 
        FROM exchange 
        WHERE student_id =".$id;
        $all = DB::getConnection()->query($query);
        $signed = array();
        while ($row = mysqli_fetch_array($all)) {
            array_push($signed, $row['course_id']);
            array_splice($courses, array_search($row['course_id'], $courses), 1);
        };
        $all->close();
        for ($i = 0; $i < count($courses); $i++) {
            $search = "SELECT name, img FROM courses WHERE id =".$courses[$i];
            $one = DB::getConnection()->query($search);   
            while ($row = mysqli_fetch_array($one)) {
                echo "<li data-value='".$i."' id='".$courses[$i]."'>
                        <span>".$row['name']."</span>
                    </li>";          
            };  
            $one->close();     
        };    
        echo "</ul></div></div><div id='list'><h2>Signed Courses <span>⤵</span></h2>";

        for ($i = 0; $i < count($signed); $i++) {
                $course_query = "SELECT name, img FROM courses WHERE id =".$signed[$i];
                $print = DB::getConnection()->query($course_query);
                
                while ($row = mysqli_fetch_array($print)) {
                    echo "<div id='".$signed[$i]."' class='signed-course'>
                            <img class='signedimg' src='../photos/".$row['img']."'>
                            <p class='onetitle'>".$row['name']."</p>
                        </div>";
                };
                $print->close();
                
        }; 
    }

    public function modifyStudentInfo($newimg) {
        $phone = intval($this->phone);
        $email = $this->email;
        $succeces = 0;
        $id = $this->id;

        function phoneValidation($phone, $id) {
            $array = array_map('intval', str_split($phone, 2));
            if (is_int($phone) && strlen($phone) == 9 && ($array[0] == 52 || $array[0] == 54 || $array[0] == 50)) {
                    return 1;
            } else {
                echo "<div id='error-popup'>
                        <h1>Invalid Phone number</h1>
                        <button id='".$id."' class='error-popup-button'>Back..</button>
                </div>";
            };  
        };

        function emailValidation($email, $id) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return 1;
            } else {
                echo "<div id='error-popup'>
                    <h1>Invalid Email</h1>
                    <button id='".$id."' class='error-popup-button'>Back..</button>
                </div>";
            };
        };
        if ($newimg == 1) {
            $query = "UPDATE students SET img = ? WHERE id = ?";
            $img = DB::getConnection()->prepare($query);
            $img->bind_param('si', $this->img, $id);
            $img->execute();
            $img->close();
        };

        $phoneisok = phoneValidation($phone, $id);

        if ($phoneisok == 1) {
            $emailisok = emailValidation($email, $id);

            if ($emailisok == 1) {
                $stmt = DB::getConnection()->prepare("
                    UPDATE students
                    SET name = ?, phone = ?, email = ?
                    WHERE id = ?    
                ");
                $phone = "0".$phone;
                $stmt->bind_param('sssi', $this->name, $phone, $email, $id);
                $stmt->execute();
                $succeces++;
                $stmt->close();
            };
        };
        return $succeces;
    }
    public function addNewStudent() {
        $phone = intval($this->phone);
        $email = $this->email;

        function phoneValidation($phone) {
            $array = array_map('intval', str_split($phone, 2));
            if (is_int($phone) && strlen($phone) == 9 && ($array[0] == 52 || $array[0] == 54 || $array[0] == 50)) {
                    return $phoneisok = 1;
                    $a = "0";
                    $phone = $a . strval($phone);
            } else {
                echo "<div id='error-popup'>
                        <h1>Invalid Phone number</h1>
                        <button id='backtonew'>Back..</button>
                </div>";
            };  
        };

        function emailValidation($email) {
            $succeces = 0;
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $emailisok = 1;
            } else {
                echo "<div id='error-popup'>
                    <h1>Invalid Email</h1>
                    <button id='backtonew'>Back..</button>
                </div>";
            };
        };
        $phoneisok = phoneValidation($phone);
        if ($phoneisok == 1) {
            $emailisok = emailValidation($email);

            if ($emailisok == 1) {
                $conn = DB::getConnection();
                $stmt = $conn->prepare("
                    INSERT INTO students (name, img, phone, email)
                    VALUES (?, ?, ?, ?)
                ");
                $correctphone = "0".$this->phone;
                $stmt->bind_param('ssss', $this->name, $this->img, $correctphone, $this->email);
                if ($phoneisok == 1 && $emailisok == 1) {
                    $stmt->execute();
                    $succeces = 1;
                };
                echo "<button id='done'></button>";
                echo "<script type='text/javascript'>
                    $('#done').trigger('click');
                </script>"; 
            };
        };
        return $succeces;        
        
    }

    public function deleteStudent() {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("
            DELETE  
            FROM exchange
            WHERE student_id = ?
        ");    
        $stmt->bind_param('i', $this->id);
        if ($stmt->execute() == false) {
            echo $stmt->error;
        };
        $stmt->close();

        $query = "DELETE FROM students WHERE id =".$this->id; 
        $delete = DB::getConnection()->query($query);
    }

    public function signToCourse($course_id) {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("
            INSERT INTO exchange (course_id, student_id) 
            VALUES (?, ?)
        ");
        $stmt->bind_param('ii', $course_id, $this->id);
        $stmt->execute();
    }

    public function unsignFromCourse($course_id) {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("
            DELETE 
            FROM exchange 
            WHERE student_id = ? AND course_id = ?
        ");
        $stmt->bind_param('ii', $this->id, $course_id);
        $stmt->execute();   
        $stmt->close();



    }
}