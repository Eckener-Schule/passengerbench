<?php
class TripController
{
/**
 * the class processes data from the frontend and has 2 functions. insert trips into the database,
 * and return data about the offered trips from an to the frontend
**/

/**
 * basequery is a string for most of the sql statements. it contains all the data we want to show about a trip
 * without any specifying Where conditions. The Where condition follows in the functions.
**/
private $baseQuery= "SELECT `start_time`,`available_seats`, `trip`.`departure_latitude`,`trip`.`departure_longitude`,`trip`.`destination_latitude`,`trip`.`destination_longitude`,`person`.`firstname`,`person`.`lastname`,`person`.`license_plate`
					FROM trip
					INNER JOIN `person` ON `trip`.`id_driver` = `person`.`id_person` ";
private $DBConnection = null;	
					

function __construct()
{
	$this->DBConnection =  DBConnection::getInstance();
}
						
/**
 * this function shows all trips between the current time and the next 24 hours
**/
public function showCurrentTrips()
{
	$query=	 $this->baseQuery. "WHERE start_time BETWEEN Now() AND DATE_ADD(NOW(), INTERVAL 1 DAY)";
	$result = $this->DBConnection->executeQueryPrepared($query, array());
	return $result;
}
/**
 * this function shows all trips by one specified driver
**/
function getTripsByDriver($ID)
{
	$bindParameters= array($ID);
	$query= $this->baseQuery. "WHERE `person`.`id_person`= ?";
	$result = $this->DBConnection->executeQueryPrepared($query, $bindParameters);
	return $result;
}
/**
 * this function shows all trips between the two timestamps
**/
function getTripsBetween($startTime, $stopTime)
{
	$bindParameters= array($startTime, $stopTime);
	$query=$this->baseQuery. "WHERE start_time BETWEEN ? AND ?";
	$result = $this->DBConnection->executeQueryPrepared($query, $bindParameters);
	return $result;
}
/**
 * this function inserts a new trip into the table trip
**/
function createTrip($startTime,$driver,$departure_latitude,$departure_longitude,$destination_latitude, $destination_longitude,$avaiableSeats)
{
	$information = array($startTime,$driver,$departure_latitude,$departure_longitude,$destination_latitude,$destination_longitude,$avaiableSeats);
	$query=	"INSERT INTO
			`trip` (`start_time`, `id_driver`, `departure_latitude`, `departure_longitude`, `destination_latitude`, `destination_longitude`, `available_seats`)
			VALUES
			(?,?,?,?,?,?,?)";
	$result = $this->DBConnection->executeQueryPrepared($query, $information);
	return $result;	
}
/**
 * this function shows all trips by one specified driver
**/
// this function changes the driver of a trip
function setDriver($TripID, $id_driver)
{
	$bindParameters=array($id_driver,$TripID);
	$query = "UPDATE trip 
				SET id_driver = ?
				WHERE trip_id = ?";
	$result = $this->DBConnection->executeQueryPrepared($query, $bindParameters);
	return $result;
}
/**
 * this function deletes a trip denpending on the id
**/

function deleteTrip($TripID)
{
	$bindParameters=array($TripID);
	$query ="DELETE FROM trip
			WHERE id_trip =?";
	$result = $this->DBConnection->executeQueryPrepared($query, $bindParameters);
	return $result;
}	
}

?>