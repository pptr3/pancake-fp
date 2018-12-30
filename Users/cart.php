<?php
require_once 'dbConnection.php';
class Item{
  public $id;
  public $name;
  private $amount = 0;
  private $price;
  private $photo;

    public function __construct($id, $name, $price){
		$this->id = $id;
        $this->name = $name;
		$this->price = $price;
		$this->getPhotoFromDb();
    }

	public function getPhotoFromDb() {
		$conn =connect();
		$sql = "SELECT Photo from Item WHERE IDItem =".$this->id;
		$result = $conn->query($sql);
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$this->photo = $row["Photo"];
			}
		}
	}

	public function changeAmount($change) {
		$this->amount = $this->amount + $change;
	}
	public function getItem() {
		return $this->id;
	}
	public function getName() {
		return $this->name;
	}
	public function getPrice() {
		return $this->price;
	}
	public function getAmount() {
		return $this->amount;
	}
	public function getPhoto() {
		return $this->photo;
	}
	public function setAmount($amount) {
		$this->amount = $amount;
	}
	public function printItem() {
		echo "IDItem: ".$this->id." Nome: ".$this->name." x".$this->amount."   ".$this->price."<br/>";
	}

}

class Royal{
  public $id;
  public $name;
  private $amount = 0;
  private $price;
  private $note = 111;
  private $photo;

    public function __construct($id, $name, $price){
		$this->id = $id;
        $this->name = $name;
		$this->price = $price;
		$this->getPhotoFromDb();
    }

	public function getPhotoFromDb() {
		$conn =connect();
		$sql = "SELECT Photo from RoyalPancake WHERE IDRoyalPancake =".$this->id;
		$result = $conn->query($sql);
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$this->photo = $row["Photo"];
			}
		}
	}

	public function changeAmount($change) {
		$this->amount = $this->amount + $change;
	}
	public function getItem() {
		return $this->id;
	}
	public function getName() {
		return $this->name;
	}
	public function getPrice() {
		return $this->price;
	}
	public function getNote() {
		return $this->note;
	}
	public function setNote($note) {
		$this->note = $note;
	}
	public function getAmount() {
		return $this->amount;
	}
	public function setAmount($amount) {
		$this->amount = $amount;
	}
	public function getPhoto() {
		return $this->photo;
	}
	public function removeOne($number) {
		if($this->pank + $this->cof + $this->drink == 3) {
			switch ($number) {
				case 0:
					$this->pank = 0;
					break;
				case 1:
					$this->cof = 0;
					break;
				case 2:
					$this->drink = 0;
					break;
			}
		}
	}
	public function printItem() {
		echo "IDItem: ".$this->id." Nome: ".$this->name." Note: ".$this->note." x".$this->amount."   ".$this->price."<br/>";
	}
}


class ShoppingCart {
	private $arrayItem = array();
	private $nItem = 0;

	public function __construct(){
    }

	public function getPrice() {
		$tot = 0;
		for ($i=0;$i<$this->nItem; $i++) {
			$tot += ($this->arrayItem[$i]->getPrice() * $this->arrayItem[$i]->getAmount() );
		}
		return $tot;
	}

	public function getArrayItem() {
		$tmpArr = array();
		$k = 0;
		for ($i=0;$i<$this->nItem; $i++) {
			if($this->arrayItem[$i] instanceof Item) {
				$tmpArr[$k] = $this->arrayItem[$i];
				$k ++;
			}
		}
		return $tmpArr;
	}

	public function getArrayRoyal() {
		$tmpArr = array();
		$k = 0;
		for ($i=0;$i<$this->nItem; $i++) {
			if($this->arrayItem[$i] instanceof Royal) {
				$tmpArr[$k] = $this->arrayItem[$i];
				$k ++;
			}
		}
		return $tmpArr;
	}

	public function addItem($item, $amount, $note) {
		if ($item instanceof Item || $item instanceof Royal) {
			if($this->contains($item, $note) == false) {
				$this->arrayItem[$this->nItem] = $item;
				if($item instanceof Royal) {
				$this->arrayItem[$this->nItem]->setNote($note);
				}
				$this->nItem ++;
			}
			$this->changeItemAmount($item, $amount, $note);
		}
	}

	public function contains($item, $note) {
		for ($i=0;$i<$this->nItem; $i++) {
			if((($item instanceof Item && $this->arrayItem[$i] instanceof Item) || ($item instanceof Royal && $this->arrayItem[$i] instanceof Royal && $this->arrayItem[$i]->getNote() == $note))
				&& ($this->arrayItem[$i]->getItem() == $item->getItem())) {
			return true;
			}
		}
		return false;
	}

	public function printItems() {
		for ($i=0;$i<$this->nItem; $i++) {
			echo $i;
			$this->arrayItem[$i]->printItem();
		}
	}

	public function changeItemAmount($item, $amount, $note) {
		for ($i=0;$i<$this->nItem; $i++) {
			if((($item instanceof Item && $this->arrayItem[$i] instanceof Item) || ($item instanceof Royal && $this->arrayItem[$i] instanceof Royal && $this->arrayItem[$i]->getNote() == $note))
				&& ($this->arrayItem[$i]->getItem() == $item->getItem())) {
				$this->arrayItem[$i]->changeAmount($amount);
				if($this->arrayItem[$i]->getAmount() <= 0) {
					$this->deleteItem($item, $note);
				}
			}
		}
	}

	public function setItemAmount($item, $amount, $note) {
		for ($i=0;$i<$this->nItem; $i++) {
			if((($item instanceof Item && $this->arrayItem[$i] instanceof Item) || ($item instanceof Royal && $this->arrayItem[$i] instanceof Royal && $this->arrayItem[$i]->getNote() == $note))
				&& ($this->arrayItem[$i]->getItem() == $item->getItem())) {
				$this->arrayItem[$i]->setAmount($amount);
				if($this->arrayItem[$i]->getAmount() <= 0) {
					$this->deleteItem($item, $note);
				}
			}
		}
	}

	public function positionOfElement($item, $note) {
		$i=0;
		while($i<$this->nItem) {
			if((($item instanceof Item && $this->arrayItem[$i] instanceof Item) || ($item instanceof Royal && $this->arrayItem[$i] instanceof Royal && $this->arrayItem[$i]->getNote() == $note))
				&& ($this->arrayItem[$i]->getItem() == $item->getItem())) {
				return $i;
			}
			$i++;
		}
		return -1;
	}

	public function deleteItem($item, $note) {
		for ($i=0;$i<$this->nItem; $i++) {
			if((($item instanceof Item && $this->arrayItem[$i] instanceof Item) || ($item instanceof Royal && $this->arrayItem[$i] instanceof Royal && $this->arrayItem[$i]->getNote() == $note))
				&& ($this->arrayItem[$i]->getItem() == $item->getItem())) {
				//array_splice($this->arrayItem, $this->positionOfElement($item), $this->positionOfElement($item));
				unset($this->arrayItem[$this->positionOfElement($item, $note)]);
				$this->arrayItem = array_values($this->arrayItem);
				$this->nItem --;
				return true;
			}
		}
		return false;
	}

	public function changeItemNotes($item, $oldNote, $newNote) { //chiamo questo da online
		$this->changeItemAmount($item, -1, $oldNote);
		$this->addItem($item, 1, $newNote);
	}

	public function moveToDb($usrEmail) {
		$this->moveItemToDb($usrEmail);
		unset($this->arrayItem);
	}

	public function moveItemToDb($usrEmail) {
		for ($i=0;$i<$this->nItem; $i++) {
			if($this->arrayItem[$i] instanceof Item) {
				searchForActiveOrder($usrEmail, $this->arrayItem[$i]->getItem(), $this->arrayItem[$i]->getAmount());
			} else {
				searchForActiveOrderRoyal($usrEmail, $this->arrayItem[$i]->getItem(), $this->arrayItem[$i]->getAmount(), $this->arrayItem[$i]->getNote());
			}
		}
	}

}

	function searchForActiveOrder($email, $idItem, $amount) {
		$idO = getOrderOfUserNotBought($email);
		$idUse = $idO;
		$conn =connect();
		if($idO == -1) {
			$idOrder = getNextIdOrderOfUser($email);
			$idUse = $idOrder;
			$status= "0";
			$sql = "INSERT INTO Orders (Email, IDOrder, Status) VALUES ('".$email."','".$idOrder."','".$status."')";
			$conn->query($sql);

		}
		$sql2 = "SELECT * FROM ItemInOrder WHERE Email = '".$email."' AND IDOrder = ".$idUse." AND IDItem = ".$idItem;
		$result2 = $conn->query($sql2);
		if($result2->num_rows > 0)	{
			while($row2 = $result2->fetch_assoc()) {
				$newAmount = $row2["Amount"] + $amount;
				$sql3 = "UPDATE ItemInOrder SET Amount = ".$newAmount." WHERE Email = '".$email."' AND IDOrder = ".$idUse." AND IDItem = ".$idItem;
				$conn->query($sql3);
			}
		} else {
			$sql3 = "INSERT INTO ItemInOrder (IDItem, Email, IDOrder, Amount)
					VALUES ('".$idItem."', '".$email."', '".$idUse."', '".$amount."')";
			$conn->query($sql3);
		}
	}




	function searchForActiveOrderRoyal($email, $idItem, $amount, $note) {
		$idO = getOrderOfUserNotBought($email);
		$idUse = $idO;
		$conn =connect();
		if($idO == -1) {
			$idOrder = getNextIdOrderOfUser($email);
			$status= "0";
			$idUse = $idOrder;
			$sql ="INSERT INTO Orders (Email, IDOrder, Status) VALUES ('".$email."','".$idOrder."','".$status."')";
			$conn->query($sql);
		}

		$sql2 = "SELECT * FROM OrderRoyalPancake WHERE Email = '".$email."' AND IDOrder = ".$idUse." AND IDRoyalPancake = ".$idItem." AND Note =".$note;
		$result2 = $conn->query($sql2);
		if($result2->num_rows > 0)	{
			while($row2 = $result2->fetch_assoc()) {
				$newAmount = $row2["Amount"] + $amount;
				$sql3 = "UPDATE OrderRoyalPancake SET Amount = ".$newAmount." WHERE Email = '".$email."' AND IDOrder = ".$idUse." AND IDRoyalPancake = ".$idItem." AND Note=".$note;
				$conn->query($sql3);
			}
		} else {
			$totPrice = updateRoyalPrice($idItem, $note);
			$sql3 = "INSERT INTO OrderRoyalPancake (IDRoyalPancake, Email, IDOrder, Amount, Note,Price)
				VALUES ('".$idItem."', '".$email."', '".$idUse."', '".$amount."', '".$note."', '".$totPrice."')";
			$conn->query($sql3);
		}
	}

	function updateOrderTime($email, $datetime) {
		$conn =connect();
		$sql = "SELECT IDOrder from Orders WHERE Status =0 AND Email = '".$email."'";

		$result = $conn->query($sql);
		if($result->num_rows > 0)	{
			while($row = $result->fetch_assoc()) {
				$idOrder = $row["IDOrder"];
				$sql2 = "UPDATE Orders SET DateTime = '".$datetime."' WHERE Email = '".$email."' AND IDOrder = ".$idOrder;
				$conn->query($sql2);
			}
		}
	}

	function insertAddressInOrder($email, $address, $cap) {
		$conn =connect();
		$sql = "SELECT IDOrder from Orders WHERE Status =0 AND Email = '".$email."'";

		$result = $conn->query($sql);
		if($result->num_rows > 0)	{
			while($row = $result->fetch_assoc()) {
				$idOrder = $row["IDOrder"];

				$sql2 = "INSERT INTO DeliveryMode (Address, CAP) VALUES ('".$address."', '".$cap."')";
				$conn->query($sql2);

				$sql3 = "SELECT MAX(IDDeliveryMode) AS max FROM deliverymode";
				$result2 = $conn->query($sql3);
				if($result2->num_rows > 0)	{
					while($row2 = $result2->fetch_assoc()) {
						$idDelivery= $row2["max"];
						$sql4 = "UPDATE Orders SET IDDeliveryMode = '".$idDelivery."' WHERE Email = '".$email."' AND IDOrder = ".$idOrder;
						$conn->query($sql4);
					}
				}

			}
		}
	}
	function insertGeolocalizationInOrder($email, $latitude, $longitude) {
		$conn =connect();
		$sql = "SELECT IDOrder from Orders WHERE Status =0 AND Email = '".$email."'";

		$result = $conn->query($sql);
		if($result->num_rows > 0)	{
			while($row = $result->fetch_assoc()) {
				$idOrder = $row["IDOrder"];

				$sql2 = "INSERT INTO DeliveryMode (Latitude, Longitude) VALUES ('".$latitude."', '".$longitude."')";
				$conn->query($sql2);

				$sql3 = "SELECT MAX(IDDeliveryMode) AS max FROM deliverymode";
				$result2 = $conn->query($sql3);
				if($result2->num_rows > 0)	{
					while($row2 = $result2->fetch_assoc()) {
						$idDelivery= $row2["max"];
						$sql4 = "UPDATE Orders SET IDDeliveryMode = '".$idDelivery."' WHERE Email = '".$email."' AND IDOrder = ".$idOrder;
						$conn->query($sql4);
					}
				}

			}
		}
	}

	function addCardInfos($email, $cardNumber, $cardOwner, $expireDate) {
		$conn =connect();
		$sql = "SELECT IDOrder from Orders WHERE Status =0 AND Email = '".$email."'";

		$result = $conn->query($sql);
		if($result->num_rows > 0)	{
			while($row = $result->fetch_assoc()) {
				$idOrder = $row["IDOrder"];
				$sql2 = "UPDATE Orders SET Status=1, CardNumber = '".$cardNumber."', CardOwner = '".$cardOwner."', ExpireDate = '".$expireDate."' WHERE Email = '".$email."' AND IDOrder = ".$idOrder;
				$conn->query($sql2);
			}
		}
	}

	function setOrderAsBought($email) {
		$conn =connect();
		$sql = "SELECT IDOrder from Orders WHERE Status =0 AND Email = '".$email."'";

		$result = $conn->query($sql);
		if($result->num_rows > 0)	{
			while($row = $result->fetch_assoc()) {
				$idOrder = $row["IDOrder"];
				$sql2 = "UPDATE OrderRoyalPancake SET Status = 1 WHERE Email = '".$email."' AND IDOrder = ".$idOrder;
				$conn->query($sql2);
			}
		}
	}

	function getItemInOrder($email) {
		$conn =connect();
		$sql = "SELECT IDOrder from Orders WHERE Status =0 AND Email = '".$email."'";

		$result = $conn->query($sql);
		if($result->num_rows > 0)	{
			while($row = $result->fetch_assoc()) {
				$idOrder = $row["IDOrder"];
				$sql2 = "SELECT * FROM ItemInOrder WHERE IDOrder = ".$idOrder;
				$result2 = $conn->query($sql2);
				return $result2;
			}
		}
		return $result;
	}

	function getRoyalInOrder($email) {
		$conn =connect();
		$sql = "SELECT IDOrder from Orders WHERE Status =0 AND Email = '".$email."'";

		$result = $conn->query($sql);
		if($result->num_rows > 0)	{
			while($row = $result->fetch_assoc()) {
				$idOrder = $row["IDOrder"];
				$sql2 = "SELECT * FROM OrderRoyalPancake WHERE IDOrder = ".$idOrder;
				$result2 = $conn->query($sql2);
				return $result2;
			}
		}
		return $result;
	}

	function getNextIdOrderOfUser($email) {
		$conn =connect();
		$sql = "SELECT MAX(IDOrder) as max FROM Orders";

		$result = $conn->query($sql);
		if($result->num_rows > 0)	{
			while($row = $result->fetch_assoc()) {
				$mx = $row["max"] + 1;
				return $mx;
			}
		}
		return "1";
	}

	function getOrderOfUserNotBought($email) {
		$conn =connect();
		$sql = "SELECT IDOrder FROM Orders WHERE Email = '".$email."' AND Status=0";

		$result = $conn->query($sql);
		if($result->num_rows > 0)	{
			while($row = $result->fetch_assoc()) {
				$idO = $row["IDOrder"];
				return $idO;
			}
		}
		return "-1";
	}

	function updateRoyalQuantityInOrder($email, $item, $amount) {
		$conn =connect();
		$idOrd= getOrderOfUserNotBought($email);
		if($amount > 0) {
			$sql = "UPDATE OrderRoyalPancake SET Amount = '".$amount."' WHERE Email = '".$email."' AND IDOrder = '".$idOrd."' AND IDRoyalPancake = '".$item."'";
			$conn->query($sql);
		} else {
			$sql2 = "DELETE FROM OrderRoyalPancake WHERE Email = '".$email."' AND IDOrder = '".$idOrd."' AND IDRoyalPancake = '".$item."'";
			$conn->query($sql2);
			$sql3 = "SELECT * FROM OrderRoyalPancake WHERE Email = '".$email."' AND IDOrder = '".$idOrd."'";
			$result = $conn->query($sql3);
			if($result->num_rows <= 0)	{
				$sql4 = "DELETE FROM Orders WHERE Email = '".$email."' AND IDOrder = '".$idOrd."'";
				$conn->query($sql4);
				return 1;
			}
		}
		return 0;
	}

	function updateQuantityInOrder($email, $item, $amount) {
		$conn =connect();
		$idOrd= getOrderOfUserNotBought($email);
		if($amount > 0) {
			$sql = "UPDATE ItemInOrder SET Amount = '".$amount."' WHERE Email = '".$email."' AND IDOrder = '".$idOrd."' AND IDItem = '".$item."'";
			$conn->query($sql);
		} else {
			$sql2 = "DELETE FROM ItemInOrder WHERE Email = '".$email."' AND IDOrder = '".$idOrd."' AND IDItem = '".$item."'";
			$conn->query($sql2);
			$sql3 = "SELECT * FROM ItemInOrder WHERE Email = '".$email."' AND IDOrder = '".$idOrd."'";
			$result = $conn->query($sql3);
			if($result->num_rows <= 0)	{
				$sql4 = "DELETE FROM Orders WHERE Email = '".$email."' AND IDOrder = '".$idOrd."'";
				$conn->query($sql4);
				return 1;
			}
		}
		return 0;
	}

	function getRoyalPrice($royal, $pank, $cof, $drink) {
		$conn =connect();
		$sql = "SELECT IDItem from ItemInRoyalPancake WHERE IDRoyalPancake =".$royal;
		$result = $conn->query($sql);
		$price = 0;
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$sql2 = "SELECT * from Item WHERE IDItem =".$row["IDItem"];
				$result2 = $conn->query($sql2);
				if($result2->num_rows > 0) {
					while($row2 = $result2->fetch_assoc()) {
						if (($row2["CategoryID"] == 1) && ( $pank==1)) {
							$price += $row2["Price"];
						}
						if (($row2["CategoryID"] == 2) && ( $cof==1)) {
							$price += $row2["Price"];
						}
						if (($row2["CategoryID"] == 2) && ( $drink==1)) {
							$price += $row2["Price"];
						}
					}
				}
			}
		}
		return $price;
	}

	function getRemainingItem($royal, $pank, $cof, $drink) { //TODO
		$conn =connect();
		$sql = "SELECT IDItem from ItemInRoyalPancake WHERE IDRoyalPancake =".$royal;
		$result = $conn->query($sql);
		$price = 0;
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$sql2 = "SELECT * from Item WHERE IDItem =".$row["IDItem"];
				$result2 = $conn->query($sql2);
				if($result2->num_rows > 0) {
					while($row2 = $result2->fetch_assoc()) {
						if (($row2["CategoryID"] == 1) && ( $pank==1)) {
							$price += $row2["Price"];
						}
						if (($row2["CategoryID"] == 2) && ( $cof==1)) {
							$price += $row2["Price"];
						}
						if (($row2["CategoryID"] == 2) && ( $drink==1)) {
							$price += $row2["Price"];
						}
					}
				}
			}
		}
		return $price;
	}

	function getItemInRoyal($royal) {
		$conn =connect();
		$sql = "SELECT IDItem from ItemInRoyalPancake WHERE IDRoyalPancake =".$royal;
		$result = $conn->query($sql);
		return $result;
	}

	function changeItemNotes($royal, $user, $oldNote, $newNote) { //chiamo questo da online
		updateRoyalInOrder($user, $royal, $newNote, 1);
		updateRoyalInOrder($user, $royal, $oldNote, -1);
	}

	function updateRoyalInOrder($email, $item, $note, $change) {
		$conn =connect();
		$idOrd= getOrderOfUserNotBought($email);
		$amount=getRoyalNoteAmount($email, $item, $note);
		$amount=$amount+$change;
		if($amount > 0) {
			if(getRoyalNoteAmount($email, $item, $note) > 0) {

			$sql = "UPDATE OrderRoyalPancake SET Amount = '".$amount."' WHERE Email = '".$email."' AND IDOrder = '".$idOrd."' AND IDRoyalPancake = '".$item."' AND Note= '".$note."'";
				$conn->query($sql);
			} else {
				$totPrice = updateRoyalPrice($item, $note);
				$sql = "INSERT INTO OrderRoyalPancake (Note,Price,Email,IDOrder,IDRoyalPancake,Amount) VALUES ('".$note."', '".$totPrice."', '".$email."', '".$idOrd."', '".$item."', '1')";
				$conn->query($sql);
			}

		} else {
			$sql2 = "DELETE FROM OrderRoyalPancake WHERE Email = '".$email."' AND IDOrder = '".$idOrd."' AND IDRoyalPancake = '".$item."' AND Note= '".$note."'";
			$conn->query($sql2);
			$sql3 = "SELECT * FROM OrderRoyalPancake WHERE Email = '".$email."' AND IDOrder = '".$idOrd."'";
			$result = $conn->query($sql3);
			if($result->num_rows < 1)	{
				$sql4 = "DELETE FROM Orders WHERE Email = '".$email."' AND IDOrder = '".$idOrd."'";
				$conn->query($sql4);
				return 1;
			}
		}
		return 0;
	}

	function getRoyalNoteAmount($email, $item, $note) {
		$conn =connect();
		$idOrd= getOrderOfUserNotBought($email);
		//SELECT Amount FROM orderroyalpancake WHERE Email = 'ef@gmail.com' AND IDRoyalPancake = '1' AND IDOrder = '3' AND Note='101';
		$sql = "SELECT Amount OrderRoyalPancake OrderRoyalPancake WHERE Email = '".$email."' AND IDRoyalPancake = ".$item." AND IDOrder = '".$idOrd."' AND Note= '".$note."'";
		$result = $conn->query($sql);
		if($result->num_rows >= 0)	{
			while($row = $result->fetch_assoc()) {
				return $row["Amount"];
			}
		}
		return 0;
	}

	function updateRoyalInOrderAmount($email, $item, $note, $amount) {
		$conn =connect();
		$idOrd= getOrderOfUserNotBought($email);
		if($amount > 0) {
			$sql = "UPDATE OrderRoyalPancake SET Amount = '".$amount."' WHERE Email = '".$email."' AND IDOrder = '".$idOrd."' AND IDRoyalPancake = '".$item."' AND Note= '".$note."'";
				$conn->query($sql);

		} else {
			$sql2 = "DELETE FROM OrderRoyalPancake WHERE Email = '".$email."' AND IDOrder = '".$idOrd."' AND IDRoyalPancake = '".$item."' AND Note= '".$note."'";
			$conn->query($sql2);
			$sql3 = "SELECT * FROM OrderRoyalPancake WHERE Email = '".$email."' AND IDOrder = '".$idOrd."'";
			$result = $conn->query($sql3);
			if($result->num_rows < 1)	{
				$sql4 = "DELETE FROM Orders WHERE Email = '".$email."' AND IDOrder = '".$idOrd."'";
				$conn->query($sql4);
				return 1;
			}
		}
		return 0;
	}

	function updateRoyalPrice($item, $note) {
		$conn =connect();
		$notes = array(substr($note, 0, 1), substr($note, 1, 1), substr($note, 2, 1) );
		$totalPrice = 0;
		$sql = "SELECT * FROM ItemInRoyalPancake WHERE IDRoyalPancake = '".$item."'";
		$result = $conn->query($sql);
		if($result->num_rows >= 0)	{
			while($row = $result->fetch_assoc()) {
				$sql2 = "SELECT Price, CategoryID FROM Item WHERE IDItem = '".$row["IDItem"]."'";
				$result2 = $conn->query($sql2);
				if($result2->num_rows >= 0)	{
					while($row2 = $result2->fetch_assoc()) {
						$idArr = $row2["CategoryID"] -1;

						if(intval($notes[$idArr]) == 1) {
							$totalPrice += $row2["Price"];
						}
					}
				}
			}
		}

		if ($notes[0] + $notes[1] + $notes[2] > 1) {
			$totalPrice = ($totalPrice * 70) / 100;
		}
		$totalPrice = number_format((float)$totalPrice, 2, '.', '');
		return $totalPrice;
	}

	function cartEmpty($email) {
		$conn =connect();
		$amounts = 0;
		$idOrd= getOrderOfUserNotBought($email);
		$sql = "SELECT * FROM OrderRoyalPancake WHERE Email = '".$email."' AND IDOrder = '".$idOrd."'";
		$result = $conn->query($sql);
		$amounts += $result->num_rows;

		$sql2 = "SELECT * FROM ItemInOrder WHERE Email = '".$email."' AND IDOrder = '".$idOrd."'";
		$result2 = $conn->query($sql2);
		$amounts += $result2->num_rows;
		return $amounts;
	}

	function itemOwned( $note, $categoryItem) {
		return substr($note, $categoryItem - 1, 1);
	}
	function sendNotification($email) {
		$conn =connect();
		$sql = "SELECT MAX(IDOrder) AS max FROM Orders WHERE Email = '".$email."'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$title = "There's a new Order!!";
		$description = "A new order has to be prepared.";
		$sql2 = 'INSERT INTO AdminNotification(Title,Description,Email,IDOrder) VALUES ("'.$title.'", "'.$description.'", "'.$email.'", "'.$row["max"].'");';
		$conn->query($sql2);
}

function isStudent($email) {
	$conn =connect();
	$sql = "SELECT IsStudent FROM Users WHERE Email = '".$email."'";
		$result = $conn->query($sql);
		if($result->num_rows >= 0)	{
			while($row = $result->fetch_assoc()) {
				if($row["IsStudent"] == "1") {return 1; }
			}
		}
	return 0;
}

function getTotalPrice($email) {
		$conn =connect();
		$idOrd= getOrderOfUserNotBought($email);
		$tot = 0;
		$sql = "SELECT * FROM OrderRoyalPancake WHERE Email = '".$email."' AND IDOrder = '".$idOrd."'";
		$result = $conn->query($sql);
		if($result->num_rows >= 0)	{
			while($row = $result->fetch_assoc()) {
				$tot += $row["Amount"] *  $row["Price"];
			}
		}
		$sql2 = "SELECT Price, Amount FROM Item i, ItemInOrder io WHERE i.IDItem=io.IDItem AND Email = '".$email."' AND IDOrder = '".$idOrd."'";
		$result2 = $conn->query($sql2);
		if($result2->num_rows >= 0)	{
			while($row2 = $result2->fetch_assoc()) {
				$tot += $row2["Amount"] *  $row2["Price"];
			}
		}
		if(isStudent($email) == 1) {
			$tot = $tot - ($tot/10);
			$tot = number_format($tot, 2, '.', '');
		}
		return $tot;
}

function getFullPriceNotStudent($email) {
		$conn =connect();
		$idOrd= getOrderOfUserNotBought($email);
		$tot = 0;
		$sql = "SELECT * FROM OrderRoyalPancake WHERE Email = '".$email."' AND IDOrder = '".$idOrd."'";
		$result = $conn->query($sql);
		if($result->num_rows >= 0)	{
			while($row = $result->fetch_assoc()) {
				$tot += $row["Amount"] *  $row["Price"];
			}
		}
		$sql2 = "SELECT Price, Amount FROM iIem i, ItemInOrder io WHERE i.IDItem=io.IDItem AND Email = '".$email."' AND IDOrder = '".$idOrd."'";
		$result2 = $conn->query($sql2);
		if($result2->num_rows >= 0)	{
			while($row2 = $result2->fetch_assoc()) {
				$tot += $row2["Amount"] *  $row2["Price"];
			}
		}
		return $tot;
}

function updateOrderTotalPrice($email) {
		$conn =connect();
		$tot = getTotalPrice($email);
		$idOrd= getOrderOfUserNotBought($email);
		$sql = "UPDATE Orders SET TotalPrice = '".$tot."' WHERE Email = '".$email."' AND IDOrder = '".$idOrd."'";
		$conn->query($sql);
}

function getCategoryItems() {
	$conn =connect();
		$sql = "SELECT * FROM CategoryItem ORDER BY CategoryID";
		$result = $conn->query($sql);
		return $result;
}

function getUnderCategoryItems($categoryID) {
	$conn =connect();
	$sql = "SELECT DISTINCT i.UnderCategoryID, UnderCategoryName FROM Item i, UnderCategoryItem ui WHERE i.UnderCategoryID = ui.UnderCategoryID AND CategoryID= '".$categoryID."'";
		$result = $conn->query($sql);
		return $result;
}

function getRandomItems() {
	$conn =connect();
	$sql = "SELECT * FROM Item ORDER BY RAND() LIMIT 5";
	$result = $conn->query($sql);
	return $result;
}

function getCategoryRoyals() {
	$conn =connect();
		$sql = "SELECT * FROM CategoryRoyalPancakes ORDER BY CategoryID";
		$result = $conn->query($sql);
		return $result;
}

function getSeasoningOfItem($item) {
	$conn =connect();
	$sql = "SELECT * FROM SeasoningInItem si, Seasoning s WHERE si.IDSeasoning = s.IDSeasoning AND si.IDItem = '".$item."'";
	$result = $conn->query($sql);
	return $result;
}


//$cart= new ShoppingCart();
//$item= new Item(1,"pomodoro", "2.40");
//$item2= new Item(2,"susina", "2.2");
//$item3= new Royal(2,"susina", "2.3");

//$cart->addItem($item,1);
//$cart->addItem($item,3);
//$cart->addItem($item2,2);
//$cart->addItem(new Royal(2,"susina", "2.3"),2);
//$cart->printItems();

//$cart->addItem($item2,-22);
//$cart->addItem($item,-2);
//$cart->printItems();
?>
