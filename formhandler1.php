<?php 
require 'database.php';

$nameErr = $emailErr = "";
$name = $email = "";
$key = 0;
$ip = $_SERVER['REMOTE_ADDR'];
$day = date("Y/m/d");

$vals = array(
	':name'=>$name,
	':email'=>$email
	);


	
if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{
		//make sure name was input and valid
		if (empty($_POST["name"])) 
			{
				$nameErr = "Name is required";
			} else 
				{
					$name = test_input($_POST["name"]);
				}
  

		if (!preg_match("/^[a-zA-Z ]*$/",$name)) 
		{
			$nameErr = "Only letters and spaces please"; 
		} 
  

		//make sure email was input and valid
		if (empty($_POST["email"])) 
		{
			$emailErr = "Email is required";
		} else 
			{
				$email = test_input($_POST["email"]);
			}
	
  
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
		{
			$emailErr = "Invalid email format"; 
		}
	}


	
if (empty($nameErr)) 
	{
		$key = $key + 1;
	} else 
		{
			echo $nameErr;
		}
	

if (empty($emailErr)) 
	{
		$key = $key + 1;
	} else 
		{
			echo $emailErr;
		}
	

if ($key == 2)
	{
		// make sure email doesn't already exist
		//make sure to change tablename to your tablename
		$check_email = $db->prepare("SELECT * FROM tablename WHERE email=?");
		$check_email->bindValue(1, $email, PDO::PARAM_STR);
		$check_email->execute();
		$count = $check_email->rowCount();
		
		if ($count != 0)
			{
				echo "You are already signed up";
			} else
				{
					
					try 
						{

							// insert new member
							//make sure to change tablename to your tablename
							$stmt = $db->prepare("INSERT INTO tablename (name, email, ip) 
							VALUES (:name, :email, :ip)");
							$stmt->bindParam(':name', $name);
							$stmt->bindParam(':email', $email);
							$stmt->bindParam(':ip', $ip);
							$stmt->execute();

							echo "New records created successfully";
						}
						
						catch(PDOException $e)
							{
								echo "Error: " . $e->getMessage();
							}

						$db = null;
				}
	}



// function to sterilize input data
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>