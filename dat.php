

<?php
$date1 = "2012-01-12";
$date2 = "2011-10-12";
$dateTimestamp1 = strtotime($date1);
$dateTimestamp2 = strtotime($date2);
 
if ($dateTimestamp1 < $dateTimestamp2)
 echo "$date1 is newer than $date2";
else
 echo "$date1 is older than $date2";
?>