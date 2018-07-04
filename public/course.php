<?php

class Course {
	private $id;
	private $name;
	private $img;
	private $description;

    public function __construct($id, $name, $img, $description) {
        $this->id = $id;
        $this->name = $name;
        $this->img = $img;
        $this->description = $description;
    }

    public function getall() {
    	$all = DB::getConnection()->query("
			SELECT *  
			FROM courses
    		");
    	while ($row = mysqli_fetch_array($all)) {
	    	echo "<div class='onestudent'>
                    <a href='/course/".$row['id']."'>
                        <img id='stdimg' src='../photos/".$row['img']."'>
                    </a>
                    <p>Course Name:".$row['name']."
                </div>";
    	}
    }

    public function showOneCourse($id) {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("
            SELECT name, img, description
            FROM courses
            WHERE id = ?
            LIMIT 1
        ");
        $stmt->bind_param('i', $id);
        if ($stmt->execute() == false) {
            echo 'First query failed: ' . $mysqli->error;
        };
        $stmt->bind_result($name, $img, $description);
        $stmt->fetch();

        echo "<main>
        <div style='margin: 10% 5% 0;'>
                <div id='premision-btns'>
                    <button id='edit-crs'>Edit</button>
                    <button id='deletecrs'>x</button>
                </div>
                
                <div class='crsInfo' id='".$id."'>
                    <form id='crsmain' enctype='multipart/form-data' action='/".$id."/modified' method='POST'>
                        <img src='../photos/".$img."' class='form-img' id='".$img."'>
                        <div class='data'>
                            <h2 id='crsName' class='".$id."'>".$name."</h2>
                            <p id='crsDes'>".$description."</p>
                        </div>
                    </form>
                </div>
                <div id='signed-std'>
                    <h3 style='width: 100%;'>Students in this Course:</h3>";   
        $stmt->close();

        $students = array();
        $query = "SELECT student_id FROM exchange WHERE course_id =".$id;
        $allstd = DB::getConnection()->query($query);
        while ($row = mysqli_fetch_array($allstd)) {
            array_push($students, $row['student_id']);
        }; 

        for ($i = 0; $i < count($students); $i++) {
            $sql = "SELECT name, img FROM students WHERE id =".$students[$i];
            $getone = DB::getConnection()->query($sql);
            while ($row = mysqli_fetch_array($getone)) {
                echo "<div id='".$students[$i]."' class='showstd'>
                        <img class='signedimg' src='../photos/".$row['img']."'>
                        <p class='onetitle'>".$row['name']."</p>
                    </div>"
                ;
            };
        };
        echo "</div></div>";


    }

    public function modifyCourseInfo() {
        $conn = DB::getConnection();

        if (!is_null($this->img)) {
            $query = "UPDATE courses SET img = ? WHERE id = ?";
            $img = $conn->prepare($query);
            $img->bind_param('si', $this->img, $this->id);
            $img->execute();
            $img->close();
        };

        $stmt = $conn->prepare("
            UPDATE courses
            SET name = ?, description = ?
            WHERE id = ?    
        ");
        $stmt->bind_param('ssi', $this->name, $this->description, $this->id);
        $stmt->execute();
        return 1;
    }
    public function createNewCourse() {

        $conn = DB::getConnection();
        $stmt = $conn->prepare("
            INSERT INTO courses (id, name, img, description)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->bind_param('isss', $this->id, $this->name, $this->img, $this->description);
        $stmt->execute();
    }

    public function deleteCourse() {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("
            DELETE  
            FROM exchange
            WHERE course_id = ?
        ");    
        $stmt->bind_param('i', $this->id);
        if ($stmt->execute() == false) {
            echo $stmt->error;
        };
        $stmt->close();

        $query = "DELETE FROM courses WHERE id =".$this->id; 
        $delete = DB::getConnection()->query($query);
    }

    public function signedCourses($student_id) {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("
            SELECT course_id 
            FROM exchange
            WHERE student_id = ?
        ");
        $stmt->bind_param('i', $student_id);
        $stmt->execute();
        echo 'all good';
    }
} 