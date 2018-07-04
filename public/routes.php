<?php

include 'student.php';
include 'course.php';
include 'db.php';
include 'users.php';

//main
$app->get('/welcom', function() {
	include 'display.php';
	include 'footer.php';
	
});
//for validation error
$app->get('/addingnewstudent', function () {
	include 'display.php';
	include 'footer.php';
	echo "
		<script type='text/javascript'>
			$('#addstudent').trigger('click');
		</script>
	";

});
//show one student
$app->get('/{id}',function ($request, $response, $args) {
	include 'display.php';
	$id = $args['id'];
	$name = '';
	$img = '';
	$phone = '';
	$email = '';
	$student = new Student($id, $name, $img, $phone, $email);
	$student->showOne($id);

	include 'footer.php';
});
//edit student-
$app->post('/edited/{id}', function ($request, $response, $args) {
	include 'display.php';

	$id = $args['id'];
	$name = $_POST['stdName'];
	$email = $_POST['stdEmail'];
	$phone = $_POST['stdPhone'];

	if (isset($_POST['sameImg'])) {
		$img = $_POST['sameImg'];
		$newimg = 0;
	} else {

		$imgName = $_FILES['stdImg']['name'];
		$imgTmpName = $_FILES['stdImg']['tmp_name'];
		$imgError = $_FILES['stdImg']['error'];
		$imgExt = explode('.', $imgName);
		$imgActualExt = strtolower(end($imgExt));

		$allowed = array('jpg', 'jpeg', 'png');

		if (in_array($imgActualExt, $allowed)) {
			if ($imgError === 0) {
				$imgNewName = uniqid('', true).".".$imgActualExt;
				$imgDestination = 'photos/'.$imgNewName;
				move_uploaded_file($imgTmpName, $imgDestination);
				$img = $imgNewName;
				$newimg = 1;
			} else {
				echo 'Error uploading image';
			};	
		} else {
			echo 'You cannot upload files of this type';
		};
	};

	$student = new Student($id, $name, $img, $phone, $email);
	$succeces = $student->modifyStudentInfo($newimg);
	
	if ($succeces > 0) {
		return $response->withRedirect('/'.$id);
	} else {
		echo 'ERROR';
	};
	echo "<script type='text/javascript' src='../jquery-3.3.1.min.js'></script>";
	echo "<script type='text/javascript' src='../main.js'></script>";
});
//show one course
$app->get('/course/{id}', function ($request, $response, $args) {
	include 'display.php';
	$id = $args['id'];
	$name = '';
	$img = '';
	$description = '';
	$courses = new Course($id, $name, $img, $description);
	$courses->showOneCourse($id);
	echo "<script type='text/javascript' src='../jquery-3.3.1.min.js'></script>";
	echo "<script type='text/javascript' src='../main.js'></script>";
});
//edit course-
$app->post('/{id}/modified', function ($request, $response, $args) {
	include 'display.php';
	$id = $args['id'];
	$name = $_POST['crsName'];
	$description = $_POST['crsDes'];

	// $img = $_POST['srcImg'];

	if (isset($_POST['sameImg'])) {
		$img = $_POST['sameImg'];
		$newimg = 0;
	} else {

		$imgName = $_FILES['crsImg']['name'];
		$imgTmpName = $_FILES['crsImg']['tmp_name'];
		$imgError = $_FILES['crsImg']['error'];
		$imgExt = explode('.', $imgName);
		$imgActualExt = strtolower(end($imgExt));

		$allowed = array('jpg', 'jpeg', 'png');

		if (in_array($imgActualExt, $allowed)) {
			if ($imgError === 0) {
				$imgNewName = uniqid('', true).".".$imgActualExt;
				$imgDestination = 'photos/'.$imgNewName;
				move_uploaded_file($imgTmpName, $imgDestination);
				$img = $imgNewName;
				$newimg = 1;
			} else {
				echo 'Error uploading image';
			};	
		} else {
			echo 'You cannot upload files of this type';
		};
	};

	$course = new Course($id, $name, $img, $description);
	$succeces = $course->modifyCourseInfo();
	echo "<script type='text/javascript' src='../jquery-3.3.1.min.js'></script>";
	echo "<script type='text/javascript' src='../main.js'></script>";
	if ($succeces = 1) {
		return $response->withRedirect('/course/'.$id);
	};
});
//creating new course
$app->post('/coursecreated', function ($request, $response, $args) {
	include 'display.php';
	$id = intval(rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9));
	$name = $_POST['name'];
    $description = $_POST['description'];
    // $img = $_POST['img'];
    $imgName = $_FILES['img']['name'];
	$imgTmpName = $_FILES['img']['tmp_name'];
	$imgError = $_FILES['img']['error'];
	$imgExt = explode('.', $imgName);
	$imgActualExt = strtolower(end($imgExt));

	$allowed = array('jpg', 'jpeg', 'png');

	if (in_array($imgActualExt, $allowed)) {
		if ($imgError === 0) {
			$imgNewName = uniqid('', true).".".$imgActualExt;
			$imgDestination = 'photos/'.$imgNewName;
			move_uploaded_file($imgTmpName, $imgDestination);
			$img = $imgNewName;
		} else {
			echo 'Error uploading image';
		};	
	} else {
		echo 'You cannot upload files of this type';
	};
	$newcourse = new Course($id, $name, $img, $description);
	$newcourse->createNewCourse();
	echo "<script type='text/javascript' src='../jquery-3.3.1.min.js'></script>";
	echo "<script type='text/javascript' src='../main.js'></script>";
	return $response->withRedirect('/welcom');
});
//creating new student
$app->post('/studentadded', function ($request, $response, $args) {
	include 'display.php';
	$id = '';
	$name = $_POST['name'];
	// $img = $_FILES['img'];

	$imgName = $_FILES['img']['name'];
	$imgTmpName = $_FILES['img']['tmp_name'];
	$imgError = $_FILES['img']['error'];
	$imgExt = explode('.', $imgName);
	$imgActualExt = strtolower(end($imgExt));

	$allowed = array('jpg', 'jpeg', 'png');

	if (in_array($imgActualExt, $allowed)) {
		if ($imgError === 0) {
			$imgNewName = uniqid('', true).".".$imgActualExt;
			$img = $imgNewName;
			$imgDestination = 'photos/'.$imgNewName;
			move_uploaded_file($imgTmpName, $imgDestination);
		} else {
			echo 'Error uploading image';
		};	
	} else {
		echo 'You cannot upload files of this type';
	};

	$phone = intval($_POST['phone']);
	$email = $_POST['email'];
	
	$newstudent = new Student($id, $name, $img, $phone, $email);
	$succeces = $newstudent->addNewStudent();
	var_dump($succeces);
	if ($succeces > 0) {
		return $response->withRedirect('/welcom');		
	};
	echo "<script type='text/javascript' src='../jquery-3.3.1.min.js'></script>";
	echo "<script type='text/javascript' src='../main.js'></script>";
	
});
//delete one student
$app->get('/{id}/deleted', function ($request, $response, $args) {
	include 'display.php';
	$id = $args['id'];
	$name = '';
	$img = '';
	$phone = '';
	$email = '';
	$student = new Student($id, $name, $img, $phone, $email);
	$student->deleteStudent();
	return $response->withRedirect('/welcom');
});
//delete one course
$app->get('/deleted/{id}', function ($request, $response, $args) {
	include 'display.php';
	$id = $args['id'];
	$name = '';
	$img = '';
	$description = '';
	$course = new Course($id, $name, $img, $description);
	$course->deleteCourse();
	return $response->withRedirect('/welcom');
});
//sign student to course
$app->get('/{studentid}/signedto/{courseid}', function ($request, $response, $args) {
	include 'display.php';
	$course_id = $args['courseid'];
	$id = $args['studentid'];
	$name = '';
	$img = '';
	$phone = '';
	$email = '';
	$student = new Student($id, $name, $img, $phone, $email);
	$student->signToCourse($course_id);

	return $response->withRedirect('/studenteditmode/'.$id);
});
//unsign student from course - course control
$app->get('/unsign/{studentid}/from/{courseid}', function ($request, $response, $args) {
	include 'header.php';
	$course_id = $args['courseid'];
	$id = $args['studentid'];
	$name = '';
	$img = '';
	$phone = '';
	$email = '';
	$student = new Student($id, $name, $img, $phone, $email);
	$student->unsignFromCourse($course_id);

	return $response->withRedirect('/courseeditmode/'.$course_id);
});
//unsign student from course - student control
$app->get('/{studentid}/unsign/{courseid}', function ($request, $response, $args) {
	include 'header.php';
	$course_id = $args['courseid'];
	$id = $args['studentid'];
	$name = '';
	$img = '';
	$phone = '';
	$email = '';
	$student = new Student($id, $name, $img, $phone, $email);
	$student->unsignFromCourse($course_id);

	return $response->withRedirect('/studenteditmode/'.$id);
});
//trigger student 'edit' button
$app->get('/studenteditmode/{studentid}', function ($request, $response, $args) {
	include 'display.php';
	$id = $args['studentid'];
	$name = '';
	$img = '';
	$phone = '';
	$email = '';
	$student = new Student($id, $name, $img, $phone, $email);
	$student->showOne($id);
	echo "<script type='text/javascript' src='../jquery-3.3.1.min.js'></script>";
	echo "<script type='text/javascript' src='../main.js'></script>";
	echo "<script type='text/javascript'>
			$('#edit-std').trigger('click');

	</script>";
});
//trigger course 'edit' button
$app->get('/courseeditmode/{courseid}', function ($request, $response, $args) {
	include 'display.php';
	$id = $args['courseid'];
	$name = '';
	$img = '';
	$description = '';
	$courses = new Course($id, $name, $img, $description);
	$courses->showOneCourse($id);
	echo "<script type='text/javascript' src='../jquery-3.3.1.min.js'></script>";
	echo "<script type='text/javascript' src='../main.js'></script>";
	echo "<script type='text/javascript'>
		$('#edit-crs').trigger('click');
	</script>";
});
