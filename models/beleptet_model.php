<?php

class Beleptet_Model
{
	public function get_data($vars)
	{
		$retData['eredmeny'] = "";
		try {
			$connection = Database::getConnection();
			$sql = "select id, csaladi_nev, utonev, jelszo, jogosultsag from felhasznalok where bejelentkezes='".$vars['login']."'";
			$stmt = $connection->query($sql);
			$felhasznalo = $stmt->fetchAll(PDO::FETCH_ASSOC);
			switch(count($felhasznalo)) {
				case 0:
					$retData['eredmeny'] = "ERROR";
					$retData['uzenet'] = "Helytelen felhasználói név-jelszó pár!";
					break;
				case 1:
					if(password_verify($vars['password'], $felhasznalo[0]['jelszo']))
					{
						$retData['eredmeny'] = "OK";
						$retData['uzenet'] = "Kedves ".$felhasznalo[0]['csaladi_nev']." ".$felhasznalo[0]['utonev']."!<br><br>
											  Jó munkát kívánunk rendszerünkkel.<br><br>
											  Az üzemeltetők";
						$_SESSION['userid'] =  $felhasznalo[0]['id'];
						$_SESSION['userlastname'] =  $felhasznalo[0]['csaladi_nev'];
						$_SESSION['userfirstname'] =  $felhasznalo[0]['utonev'];
						$_SESSION['userlevel'] = $felhasznalo[0]['jogosultsag'];
						Menu::setMenu();
					}
					else
					{
						$retData['eredmeny'] = "ERROR";
						$retData['uzenet'] = "Helytelen felhasználói név-jelszó pár!";
					}
					break;
				default:
					$retData['eredmeny'] = "ERROR";
					$retData['uzenet'] = "Több felhasználót találtunk a megadott felhasználói név -jelszó párral!";
			}
		}
		catch (PDOException $e) {
					$retData['eredmeny'] = "ERROR";
					$retData['uzenet'] = "Adatbázis hiba: ".$e->getMessage()."!";
		}
		return $retData;
	}
}

?>