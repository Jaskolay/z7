<?php
session_start();
if (isset($_POST['login']))
	{
	$wszystko_OK=true;
	$login=$_POST['login']; // login z formularza
	$haslo1 = $_POST['haslo1'];
	$haslo2 = $_POST['haslo2'];
	$folder = $_POST['login'];
	
	if ($haslo1!=$haslo2)
	{
		$wszystko_OK=false;
		echo "Podane hasla nie sa identyczne!";
	}
	
	try 
		{
		$dbhost="mysql01.jaskolski.beep.pl"; $dbuser="jaskolayx7"; $dbpassword="zaq1@WSX"; $dbname="zadaniex7";
		$polaczenie = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
		if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				$rezultat = $polaczenie->query("SELECT id FROM users WHERE login='$login'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_nickow = $rezultat->num_rows;
				if($ile_takich_nickow>0)
				{
					$wszystko_OK=false;
					echo "Taki uzytkownik juz istnieje!";
				}
				
				if ($wszystko_OK==true)
				{
				if ($polaczenie->query("INSERT INTO users (login, haslo) VALUES ('$login', '$haslo1')"))
					{
						$_SESSION['udanarejestracja']=true;
						echo "Udana rejestracja!"."<br>";
						mkdir($login);
						echo "<b>Folder o nazwie: <i>$login</i> zostal stworzony!</b>"."<br>";
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
				}
			$polaczenie->close();

		}
		}
	catch(Exception $e)
		{
			echo '<span style="color:red;">B��d serwera!</span>';
			echo '<br />Informacja: '.$e;
		}
		
	}
?>
<html lang="pl" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
</head>
<body>
<input type="button" value="Logowanie" onClick="location.href='http://jaskolayx.pl/z7/logowanie_form.html';" /><br>
</body>
</html>