<?php


?>
<body>
	<div id="main_section">
		<div id="left_bar">
			<nav id="courses">
				<div class="nav-title">
					<h3>Courses</h3>
					<button class="plus" id="addcourse">+</button>
				</div>
				<hr>
				<?php 
					$id = '';
					$name = '';
					$img = '';
					$description = '';
					$courses = new Course($id, $name, $img, $description);
					$courses->getall();
				?>
			</nav>
			<nav id="students">
				<div class="nav-title">
					<h3>Students</h3>
					<button class="plus" id="addstudent">+</button>
				</div>
				<hr>
				<?php 
					$id = '';
					$name = '';
					$img = '';
					$phone = '';
					$email = '';
					$students = new Student($id, $name, $img, $phone, $email);
					$students->getall();
				?>
			</nav>
		</div>
		
