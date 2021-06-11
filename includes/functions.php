<?php
global $strday;
global $student_number;
global $query_counter;
global $sidebar_context;
//this is a function for redirecting pages
	function redirect_to($new_location){
		header("Location: " . $new_location);
		exit;
	}

//global functions
	function mysql_prep($string) {
		global $connection;
		
		$escaped_string = mysqli_real_escape_string($connection, $string);
		return $escaped_string;
	}

//function for converting string Day to numeric day
	function order_day($day){
		if ($day == "Monday") {
			$numericday = 1;
		}
		elseif($day == "Tuesday"){
			$numericday = 2;
		}
		elseif($day == "Wednesday"){
			$numericday = 3;
		}
		elseif($day == "Thursday"){
			$numericday = 4;
		}
		elseif($day == "Friday"){
			$numericday = 5;
		}
		elseif($day == "Saturday"){
			$numericday = 6;
		}
		elseif($day == "Sunday"){
			$numericday = 7;
		}
	}

//function to convert the number days to str days
	function number_to_day($number){
		if ($number == "1") {
			$strday = "Monday";
		}
		elseif($number == "2"){
			$strday = "Tuesday";
		}
		elseif($number == "3"){
			$strday = "Wednesday";
		}
		elseif($number == "4"){
			$strday = "Thursday";
		}
		elseif($number == "5"){
			$strday = "Friday";
		}
		elseif($number == "6"){
			$strday = "Saturday";
		}
		elseif($number == "7"){
			$strday = "Sunday";
		}

		return $strday;
	}

//function to get the equivalent grade
	function equivalent_grade($raw_computed_grade){
		if ($raw_computed_grade >= 96) {
	      $final_grade = 1.0;
	    }
	    else if ($raw_computed_grade >= 90 && $raw_computed_grade <= 95) {
	      $final_grade = 1.25;
	    }
	    else if ($raw_computed_grade >= 86 && $raw_computed_grade <= 89) {
	      $final_grade = 1.5;
	    }
	    else if ($raw_computed_grade >= 80 && $raw_computed_grade <= 85) {
	      $final_grade = 1.75;
	    }
	    else if ($raw_computed_grade >= 76 && $raw_computed_grade <= 79) {
	      $final_grade = 2;
	    }
	    else if ($raw_computed_grade >= 70 && $raw_computed_grade <= 75) {
	      $final_grade = 2.25;
	    }
	    else if ($raw_computed_grade >= 66 && $raw_computed_grade <= 69) {
	      $final_grade = 2.5;
	    }
	    else if ($raw_computed_grade >= 60 && $raw_computed_grade <= 65) {
	      $final_grade = 2.75;
	    }
	    else if ($raw_computed_grade >= 50 && $raw_computed_grade <= 59) {
	      $final_grade = 3;
	    }
	    else if ($raw_computed_grade <= 49) {
	      $final_grade = 5;
	    }
	    else{
	      $final_grade = 5;
	    }
	    return $final_grade;
	}

	function generate_student_number(string $sy,string $course,string $reg_id){
		$sy = substr($sy,2,2);

		if (strlen($reg_id) == 1) {
		 $reg_id = "000".$reg_id;	
		}
		elseif (strlen($reg_id) == 2) {
		 $reg_id = "00".$reg_id;
		}
		elseif (strlen($reg_id) == 3) {
		 $reg_id = "0".$reg_id;
		}

		$student_number = $course.$sy."-".$reg_id;

		return $student_number;

	}
	function generate_emp_code(string $teacher_id,$emp_code){

		if (strlen($teacher_id) == 1) {
		 $teacher_id = "000".$teacher_id;	
		}
		elseif (strlen($teacher_id) == 2) {
		 $teacher_id = "00".$teacher_id;
		}

		$emp_code = "EMP-".$teacher_id;

		return $emp_code;

	}
//password randomizer
	function password_generate($chars) 
	{
	  $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
	  return substr(str_shuffle($data), 0, $chars);
	}
	function query_for_current_students(string $table, string $course_id,string $year,string $term, string $section, string $sy){
		$query_counter = "SELECT * FROM ".$table." WHERE course_id='".$course_id."' AND year='".$year."' AND term='".$term."' AND section='".$section."' AND school_yr='".$sy."'";
		return $query_counter;
		//this will be reused through the scheduling forms, delete enrollment form, and manual scheduling for irreg students
	}
	//bunch of functions for admin and authentication
	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed.");
			$error = error_reporting(E_ALL);
			echo $error;
		}
	}
	function find_admin_by_username($username) {
		global $connection;

		$safe_username = mysqli_real_escape_string($connection, $username);

		$query  = "SELECT * ";
		$query .= "FROM users ";
		$query .= "WHERE username = '{$safe_username}' ";
		$query .= "LIMIT 1";
		$admin_set = mysqli_query($connection, $query);
		confirm_query($admin_set);
		if($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
			echo "Username Exist";
		} else {
			return null;

		}
	}
	function password_check($password, $existing_hash) {
		// existing hash contains format and salt at start
		$hash = crypt($password, $existing_hash);
		if ($hash == $existing_hash) {
			return true;
		} else {
			return false;
		}
	}
	function attempt_login($username, $password) {
		$admin = find_admin_by_username($username);
		if($admin) {
			// Found Admin, now check password
			if (password_verify($password, $admin["password"])) {
				// password matches
				return $admin;
			} else {
				// password does not match
				return false;
			}
		} else {
			return false;
		}
	}
	function logged_in(){
		return isset($_SESSION["user_id"]);
	}
	function confirm_logged_in(){
		if (!logged_in()) {
			redirect_to("index.php");
		}
	}
	function generate_salt($length) {
		// Not 100% unique, not 100% random, but good enough for a salt
		// MD5 returns 32 characters
		$unique_random_string = md5(uniqid(mt_rand(), true));

		// Valid characters for a salt are [a-zA-Z0-9./]
		$base64_string = base64_encode($unique_random_string);

		// But not '+' which is valid in base64 encoding
		$modified_base64_string = str_replace('+', '.', $base64_string);

		// Truncate string to the correct length
		$salt = substr($modified_base64_string, 0, $length);

		return $salt;
	}
	function password_encrypt($password) {
		//password hashing function for security

		$hash_format = "$2y$10$";	// Tells PHP to use Blowfish with a "cost" of 10
		$salt_length = 22;			// Blowfish salts should be 22-characters or more
		$salt = generate_salt($salt_length);
		$format_and_salt = $hash_format . $salt;
		$hash = crypt($password, $format_and_salt);
		return $hash;
	}


//utility functions that calls the general query run on the system to save space and refactor the codes
	function return_current_sy($connection,$current_sy){
		$query_return_current_sy = "SELECT active_sy FROM site_settings LIMIT 1";
        $result_return_current_sy = mysqli_query($connection, $query_return_current_sy);
        while($row_return_current_sy = mysqli_fetch_assoc($result_return_current_sy))
        {
          $current_sy = $row_return_current_sy['active_sy'];
     	
        }
        return $current_sy;
	}
	function return_current_term($connection,$current_term){
		$query_return_current_term = "SELECT active_term FROM site_settings LIMIT 1";
        $result_return_current_term = mysqli_query($connection, $query_return_current_term);
        while($row_return_current_term = mysqli_fetch_assoc($result_return_current_term))
        {
          $current_term = $row_return_current_term['active_term'];
     	
        }
        return $current_term;
	}
	function return_max_units($connection){
		$query_return_max_units = "SELECT max_units FROM site_settings LIMIT 1";
        $result_return_max_units = mysqli_query($connection, $query_return_max_units);
        while($row_return_max_units = mysqli_fetch_assoc($result_return_max_units))
        {
          $max_units = $row_return_max_units['max_units'];
     	
        }
        return $max_units;
	}

//NEXT: Utility function to count the current enrollment of irreg students for the given course, year, term, SY, and section
	function get_enrolled_regular_students($sec_id,$term,$sy,$current_reg_student_enrolled,$connection){
		$query_get_enrolled  = "SELECT COUNT(*) AS num FROM enrollment WHERE sec_id='".$sec_id."' AND school_yr='".$sy."' AND term='".$term."'";
       	$result_get_enrolled = mysqli_query($connection, $query_get_enrolled);
        while($row_get_enrolled = mysqli_fetch_assoc($result_get_enrolled)){
          $current_reg_student_enrolled = $row_get_enrolled['num'];
         }
        return $current_reg_student_enrolled;
	}
	function get_teacher_name($teacher_id, $teacher_name, $connection){
		$query_teacher_name = "SELECT * FROM teachers WHERE teacher_id='".$teacher_id."' LIMIT 1";
        $result_teacher_name = mysqli_query($connection, $query_teacher_name);
        while($row_teacher_name = mysqli_fetch_assoc($result_teacher_name))
        {
          $teacher_name = $row_teacher_name['first_name']." ".$row_teacher_name['last_name'];
        
        }

        return $teacher_name;
    }
 	function get_section_name($sec_id, $section_name, $connection){
		$query_section_name = "SELECT * FROM sections WHERE sec_id='".$sec_id."' LIMIT 1";
        $result_section_name = mysqli_query($connection, $query_section_name);
        while($row_section_name = mysqli_fetch_assoc($result_section_name))
        {
          $section_name = $row_section_name['sec_name'];
        
        }

        return $section_name;
    }
 	function get_course_id_from_section($sec_id, $course_name, $connection){
		$query_course_id= "SELECT * FROM sections WHERE sec_id='".$sec_id."' LIMIT 1";
        $result_course_id = mysqli_query($connection, $query_course_id);
        while($row_course_id = mysqli_fetch_assoc($result_course_id))
        {
          $course_id = $row_course_id['course_id'];
        
        }

        return $course_id;
    }
  	function get_section_name_by_class($class_id, $section_id, $connection){
		$query_section_name_by_class = "SELECT * FROM classes WHERE class_id='".$class_id."' LIMIT 1";
        $result_section_name_by_class = mysqli_query($connection, $query_section_name_by_class);
        while($row_section_name_by_class = mysqli_fetch_assoc($result_section_name_by_class))
        {
          $section_id = $row_section_name_by_class['sec_id'];
        
        }

        return $section_id;
    }
  	function get_teacher_id_by_class($class_id, $teacher_id, $connection){
		$query_teacher_id_by_class = "SELECT * FROM classes WHERE class_id='".$class_id."' LIMIT 1";
        $result_teacher_id_by_class = mysqli_query($connection, $query_teacher_id_by_class);
        while($row_teacher_id_by_class = mysqli_fetch_assoc($result_teacher_id_by_class))
        {
          $teacher_id = $row_teacher_id_by_class['teacher_id'];
        
        }
        return $teacher_id;
    }
    function find_schedule_data($subject_id, $class_id, $connection, $schedule_id){
		$query_find_schedule_data = "SELECT * FROM schedule_block WHERE class_id='".$class_id."' AND subject_id='".$subject_id."'";
		$result_find_schedule_data = mysqli_query($connection, $query_find_schedule_data);

		if (mysqli_num_rows($result_find_schedule_data) > 0) {
			while($row_find_schedule_data = mysqli_fetch_assoc($result_find_schedule_data))
			{
				$schedule_id = $row_find_schedule_data['schedule_id'];
			}
		}

		else{
			$schedule_id = NULL;
		}

		return $schedule_id;

    }
  	function get_subject_id_by_class($subject_id, $class_id, $connection){
		$query_subject_id_by_class = "SELECT * FROM classes WHERE class_id='".$class_id."' LIMIT 1";
        $result_subject_id_by_class = mysqli_query($connection, $query_subject_id_by_class);
        while($row_subject_id_by_class = mysqli_fetch_assoc($result_subject_id_by_class))
        {
          $subject_id = $row_subject_id_by_class['subject_id'];
        
        }

        return $subject_id;
    }

    function get_students_enrolled_in_class($class_id,$students_enrolled,$connection){

			$query_class_info = "SELECT * FROM classes WHERE class_id='".$class_id."'";
			$result_class_info = mysqli_query($connection, $query_class_info);

			while($row_class_info = mysqli_fetch_assoc($result_class_info))
			{
			  $current_students = $row_class_info['students_enrolled'];
			}
			return $current_students;

    }

 	function get_section_year($sec_id, $section_year, $connection){
		$query_section_year = "SELECT * FROM sections WHERE sec_id='".$sec_id."' LIMIT 1";
        $result_section_year = mysqli_query($connection, $query_section_year);
        while($row_section_year = mysqli_fetch_assoc($result_section_year))
        {
          $section_year = $row_section_year['year'];
        
        }

        return $section_year;
    }
 	function get_subject_name($subject_id, $subject_name, $connection){
		$query_subject_name = "SELECT * FROM subjects WHERE subject_id='".$subject_id."' LIMIT 1";
        $result_subject_name = mysqli_query($connection, $query_subject_name);
        while($row_subject_name = mysqli_fetch_assoc($result_subject_name))
        {
          $subject_name = $row_subject_name['subject_name'];
        
        }

        return $subject_name;
    }
  	function get_subject_code($subject_id, $subject_code, $connection){
		$query_subject_code = "SELECT * FROM subjects WHERE subject_id='".$subject_id."' LIMIT 1";
        $result_subject_code = mysqli_query($connection, $query_subject_code);
        while($row_subject_code = mysqli_fetch_assoc($result_subject_code))
        {
          $subject_code = $row_subject_code['subject_code'];
        
        }

        return $subject_code;
    }
   	function get_subject_total_unit($subject_id, $total_unit, $connection){
		$query_get_subject_total_unit = "SELECT * FROM subjects WHERE subject_id='".$subject_id."' LIMIT 1";
        $result_get_subject_total_unit = mysqli_query($connection, $query_get_subject_total_unit);

        while($row_subject_total_unit = mysqli_fetch_assoc($result_get_subject_total_unit))
        {
        	$total_units = $row_subject_total_unit['total_units'];
        }

        return $total_units;
    }
   	function check_if_subject_exist($subject_id, $connection){
		$query_check_if_subject_exist = "SELECT * FROM subjects WHERE subject_id='".$subject_id."' LIMIT 1";
        $result_check_if_subject_exist = mysqli_query($connection, $query_check_if_subject_exist);

        $rowcount = mysqli_num_rows($result_check_if_subject_exist);

        return $rowcount;
    }
   	function get_subject_unit_count($subject_id, $unit, $connection){
		$query_subject_unit = "SELECT * FROM subjects WHERE subject_id='".$subject_id."' LIMIT 1";
        $result_subject_unit = mysqli_query($connection, $query_subject_unit);

        $units_array = array();
        while($row_subject_unit = mysqli_fetch_assoc($result_subject_unit))
        {
          $lect_units = $row_subject_unit['lect_units'];
          $lab_units = $row_subject_unit['lab_units'];
          $total_units = $row_subject_unit['total_units'];
        }
        array_push($units_array, $lect_units,$lab_units,$total_units);
        
        return $units_array;
    }
   	function get_course_code($course_id, $course_code, $connection){
		$query_course_code = "SELECT * FROM courses WHERE course_id='".$course_id."'";
        $result_course_code = mysqli_query($connection, $query_course_code);
        while($row_course_code = mysqli_fetch_assoc($result_course_code))
        {
          $course_code =$row_course_code['course_code'];
        
        }

        return $course_code;
    }
   	function get_prerequisite_id($subject_id, $prerequisite_id, $connection){
		$query_prerequisite_id = "SELECT pre_id FROM subjects WHERE subject_id='".$subject_id."' LIMIT 1";
        $result_prerequisite_id = mysqli_query($connection, $query_prerequisite_id);
        while($row_prerequisite_id = mysqli_fetch_assoc($result_prerequisite_id))
        {
          $prerequisite_id = $row_prerequisite_id['pre_id'];
        
        }
        if (check_if_subject_exist($prerequisite_id, $connection)>0) {
        	return $prerequisite_id;
        	// create a new function: check if subject exist
        }  
    }
   	function is_subject_credited($subject_id, $stud_reg_id,  $subject_credited, $connection){
		$query_is_subject_credited = "SELECT * FROM transfer_of_credits WHERE equivalent_subject_id='".$subject_id."' AND stud_reg_id='".$stud_reg_id."' LIMIT 1";
        $result_is_subject_credited = mysqli_query($connection, $query_is_subject_credited);
        
        if (mysqli_num_rows($result_is_subject_credited) == 1) {
        	$subject_credited = TRUE;
        	
        }
        else{
        	$subject_credited = FALSE;
        }
        return $subject_credited;
    }

    function check_if_student_passed($subject_id, $student_reg_id, $remarks, $connection){
		$query_check_if_student_passed = "SELECT remarks FROM student_grades WHERE stud_reg_id='".$student_reg_id."' AND  subject_id ='".$subject_id."' LIMIT 1";
        $result_check_if_student_passed = mysqli_query($connection, $query_check_if_student_passed);
        
        if (mysqli_num_rows($result_check_if_student_passed)==0) {
        	$remarks = "no grade";
        }
        else{
        	while($row_check_if_student_passed = mysqli_fetch_assoc($result_check_if_student_passed))
			{
				$remarks = $row_check_if_student_passed['remarks'];
			}
        }
  
        return $remarks;
    }
    function get_student_name($stud_reg_id,$connection){
    	$query_student_name = "SELECT * FROM students_reg WHERE stud_reg_id=".$stud_reg_id;
    	$result_student_name = mysqli_query($connection, $query_student_name);
    	while($row_student_name = mysqli_fetch_assoc($result_student_name))
    	 {
    	  $student_name = $row_student_name['last_name'].", ".$row_student_name['first_name'].", ".substr($row_student_name['middle_name'], 0,1.).".";
    	 }
    	 return $student_name;
    }
     function get_student_number($stud_reg_id,$connection){
    	$query_student_number = "SELECT * FROM enrollment WHERE stud_reg_id='".$stud_reg_id."' LIMIT 1";
    	$result_student_number = mysqli_query($connection, $query_student_number);
    	while($row_student_number = mysqli_fetch_assoc($result_student_number))
    	 {
    	  $student_number = $row_student_number['student_number'];
    	 }
    	 return $student_number;
    }
    function get_student_reg_id($student_number,$connection){
    	$query_student_reg_id = "SELECT * FROM enrollment WHERE student_number='".$student_number."' LIMIT 1";
    	$result_student_reg_id = mysqli_query($connection, $query_student_reg_id);
    	while($row_student_reg_id = mysqli_fetch_assoc($result_student_reg_id))
    	 {
    	  $student_reg_id = $row_student_reg_id['stud_reg_id'];
    	 }
    	 return $student_reg_id;
    }
 ?>

