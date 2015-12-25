<?php
session_start();

include 'header_valid.php';
include 'upload_mobile_config.php';

function mysql_fetch_alias_array($result)
{
    if (!($row = mysql_fetch_array($result)))
    {
        return null;
    }

    $assoc = Array();
    $rowCount = mysql_num_fields($result);
   
    for ($idx = 0; $idx < $rowCount; $idx++)
    {
        $table = mysql_field_table($result, $idx);
        $field = mysql_field_name($result, $idx);
        echo $assoc["$table.$field"] = $row[$idx]."<BR />";
    }
   
    return $assoc;
}


function mysql_fetch_table($result)
{
    if (!($row = mysql_fetch_array($result)))
    {
        return null;
    }

    $assoc = Array();
    $rowCount = mysql_num_fields($result);
   
    for ($idx = 0; $idx < $rowCount; $idx++)
    {
        $table = mysql_field_table($result, $idx);
        $field = mysql_field_name($result, $idx);
        echo $assoc["$table.$field"] = $row[$idx]."<BR />";
    }
   
    return $assoc;
}

function show($show)
{
    echo "<BR />".$show;
}
function redirect($gdzie, $czas)
{
    echo "<head><meta http-equiv=\"Refresh\" content=\"$czas; URL=$gdzie\" /></head>";
}
 $origin_id;

function add_db($sql)
{
	 
	 
   $result=mysql_query($sql) or die(mysql_error());
	return $result;
}

function get_site_id($siteid)
{
   $select="SELECT * FROM site WHERE site_id='$siteid'";
   $result=mysql_query($select)or die(mysql_error());
   $rek=mysql_fetch_array($result);
   global $origin_id;
   $origin_id=$rek['Origin_origin_id'];
    return $rek['site_ref_number'];
}

function get_origin_id($originid)
{
   $select="SELECT * FROM origin WHERE origin_id='$originid'";
   $result=mysql_query($select)or die(mysql_error());
   $rek=mysql_fetch_array($result);
    return $rek['town'];
}

function get_user_id($userid)
{
        
   $select="SELECT * FROM user_2 WHERE id_user='$userid'";
   $result=mysql_query($select)or die(mysql_error());
   $rek=mysql_fetch_array($result);
    return $rek['name'];
}


function connect_tablet()
{
    
$connect=mysql_connect($host_out,'root','krasnal')
  or die(mysql_error());

mysql_select_db($dbs3_out);

return $connect;
    
}

function connect_dbs3()
{
    
$connect=mysql_connect($host_in,'root','krasnal')
  or die(mysql_error());

mysql_select_db($dbs3_in);
    
}

function roll_back_manifest($id_mani)
{
    global $host_out;
    global $dbs3_out;
 $connect=mysql_connect($host_out,'root','krasnal')
            or die(mysql_error());
     mysql_select_db($dbs3_out);
    // $id_manif=$_POST['id_manif_id'];
    //echo $id_manif;
    $update_closed="UPDATE manifest_reg SET closed=0 WHERE idmanifest_reg='$id_mani'";
    $rek=mysql_query($update_closed) or die(mysql_error());
    $import_details=$id_mani;
    mysql_close();
    if($rek)
    return $import_details;
}

function roll_back_insert_manifest_details_root($id_mani)
{
    global $host_in;
    global $dbs3_in;
    
    echo "<BR />Cleaning main root system from specifics and details. Rolling back to previous state.";
                            $connect=mysql_connect($host_in,'root','krasnal') or die(mysql_error());
                             mysql_select_db($dbs3_in);
                             $update_closed="DELETE FROM manifest_reg WHERE idmanifest_reg='$id_mani'";
                             $rek_details=mysql_query($update_closed);
                             if(!$rek_details)
                             {
                             echo "Error:#1 ".mysql_error($connect);
                             //$import_details=$id_manif;
                             }
                             echo "<BR />Cleaning Specifics";
                            
                             $update_closed="DELETE FROM manifest_counter WHERE manifest_reg_idmanifest_reg='$id_mani'";
                             
                            $rek_specifics=mysql_query($update_closed);
                            if(!$rek_specifics)
                            {
                                echo "Error:#2 ".mysql_error($connect);
                            }
                              
                             mysql_close();
                             if($rek_details AND $rek_specifics)
                             return "<BR />Manifest cleaned ".$id_mani;
}





function roll_back_insert_site_cat($id_site)
{
    global $host_in;
    global $dbs3_in;
    
    echo "<BR />Cleaning main root system from specifics and details. Rolling back to previous state.";
                            $connect=mysql_connect($host_in,'root','krasnal') or die(mysql_error());
                             mysql_select_db($dbs3_in);
                             $update_closed="DELETE FROM site_has_cat WHERE Site_site_id='$id_site'";
                             $rek_details=mysql_query($update_closed);
                             if(!$rek_details)
                             {
                             echo "Error:#1 ".mysql_error($connect);
                             //$import_details=$id_manif;
                             }
                             echo "<BR />Cleaning site categories";
                            
                             $update_closed="DELETE FROM site WHERE site_id='$id_site'";
                             
                            $rek_specifics=mysql_query($update_closed);
                            if(!$rek_specifics)
                            {
                                echo "Error:#2 ".mysql_error($connect);
                            }
                              
                             mysql_close();
                             if($rek_details AND $rek_specifics)
                             return "<BR />Site and site_cat cleaned successfuly ".$id_mani;
}










//end of rooling back definition

function check_competence($connect)
{
    //it takes from tablet all those manifest not yet closed
    
}

function conv_max_site_id()
{
    global $host_in;
    global $dbs3_in;
    $connect=mysql_connect($host_out,'root','krasnal');
    mysql_select_db($dbs3_in);
    $last_id="SELECT MAX(site_id) as smax FROM site ORDER BY site_id DESC LIMIT 1;";
    $result_id=mysql_query($last_id,$connect);
    $rek=mysql_fetch_array($result_id);
    if($result_id)
      return $rek['smax'];  
    else return -1;
}


function get_weight($weightid)
{
   global $host_out;
   global $dbs_out;
   
   $connect=mysql_connect($host_out,'root','krasnal');
   mysql_select_db($dbs3_out);
    
   $select="SELECT * FROM weight WHERE id='$weightid'";
   $result=mysql_query($select)or die(mysql_error());
   $rek=mysql_fetch_array($result);
   mysql_close();
    return $rek;
}
               

function get_category($categoryid)
{
    global $host_out;
   global $dbs_out;
   
   $connect=mysql_connect($host_out,'root','krasnal');
   mysql_select_db($dbs3_out);
   
   $select="SELECT * FROM category WHERE id='$categoryid'";
   $result=mysql_query($select)or die(mysql_error());
   $rek=mysql_fetch_array($result);
   mysql_close();
   return $rek;
}
   





$import_details=0;
$imported=0;
$site_place=0;
$existing_mani_id=0;
?>




<HTML>
<HEAD>

<link rel="stylesheet" href="layout.css " type="text/css">
<link rel="stylesheet" href="form_cat.css " type="text/css">
</HEAD>
<BODY>

<div id="banner">

<IMG SRC="weee/WEEE%20Collection%20v3_html_m5ab1a91a.jpg" WIDTH=180 HEIGHT=151 align="right">
<BR><BR>
<IMG SRC="weee/WEEE%20Collection%20v3_html_m6a98edc9.jpg" WIDTH=449 HEIGHT=51 HSPACE=3 VSPACE=3>
<BR>
</div>
</BR></BR>

<div id="tabel_wrap_out"></BR>
    </br>
    <center><p style=""><h3>Mobile Device Settings and Synchronisation - Mobile Device System Communicator</h3></p></center>
    </br>
    
  
    
    
    
    
    
<table id="tabel_out" border="1"  >

<?php
echo "<a href=upload_mobile.php> Re-connect </a><BR />";

$stime = microtime();  
    $stime = explode(" ",$stime);  
    $stime = $stime[1] + $stime[0];  



$connect=mysql_connect($host_out,'root','krasnal')
  or die(mysql_error());

mysql_select_db($dbs3_out);


//if($connect1=connect_dbs3())
//{
   // echo "<BR/>The Root System is Ready for transfer";
//}

if(isset($_POST['Submit']))
{
    
    //echo "Imported";
    
    $id_manif=$_POST['id_manif_id'];
    //echo $id_manif;
    $update_closed="UPDATE manifest_reg SET closed=1 WHERE idmanifest_reg='$id_manif'";
    $rek=mysql_query($update_closed) or die(mysql_error());
   echo "Import ". $import_details=$id_manif;
    
}



echo "<table style='width:350px' border='1'>";
if($connect)
{
    
    echo "<tr><td>Mobile Device: <b>Detected</b></td></tr><BR />";
    echo "<tr><td>Device: <b>".$host_out."</b><BR /> in range.</td></tr><BR />";
    echo "<tr><td>Connection: <b>Established</b></td></tr>";
   echo "<BR/><BR/><tr><td>--------------------------------------------</td></tr><tr><td><b>Warning: Parameters of the device not known</b></td><BR/>";
}
  $sstime = microtime();  
    $sstime = explode(" ",$sstime);  
    $sstime = $sstime[1] + $sstime[0]; 
         $totaltime = ($sstime - $stime);
   //echo $totaltime;
    echo "<BR /><tr><td>--------------------------------------------</td></tr><tr><td>Connection channal delay: ".$totaltime;
    echo "<BR /> </td></tr><tr><td>System communication status: ";
    if($totaltime<0.2)
        echo "good";
    else
        echo "weak";
        

    echo "</td></tr></table>";
    echo "<BR/><BR/><BR />";
    echo "<h3>System Flags: <BR/><BR/></h3>";
    
    //$sql='SELECT DISTINCT idmanifest_reg, manifest_unq_num,driver_num,date_manifest,siteid FROM manifest_reg INNER JOIN manifest_counter ON idmanifest_reg=manifest_reg_idmanifest_reg WHERE manifest_counter.finished=1 AND closed=0';

//$result=add_db($sql);


$tab = array();
for($z=0;$z<=1000;$z++)
   $tab[$z]=0;
echo '<table>';
/*
while($rek = mysql_fetch_array($result,MYSQL_BOTH)) { //changed from 1 
   $i++;  
   $id_manif_id=$rek['idmanifest_reg'];
   //if($tab[$rek["id_test"]]<'1')
   //{
   //echo '<tr><td>'.$rek["Name_sub"].'</td>'; 
	// echo '<td>'.$rek["kind"].'</td>';
	 //echo '<td>'.$rek["weight"].'</td>';
	 echo '<tr><td>'.$rek["idmanifest_reg"].'</td>';
	   echo '<td>'.$rek["manifest_unq_num"].'</td>';
           echo '<td>'.$rek["date_manifest"].'</td>';
          
           echo '<td>'.$rek["closed"].'</td>';
              echo '<td>'.get_site_id($rek["siteid"]).'</td>';
              echo '<td>'.get_origin_id($origin_id).'</td>';
              echo '<td>'.$rek['driver_num'].'</td>';
              echo '<td>collected by '.get_user_id($rek['driver_num']).'</td>';
            echo '<td> <form action="upload_mobile.php" method="POST">';
           
            
            echo $rek['driver_num'];
            $name_sub_cat=$rek['id'];   
            echo '</td><td><input type="checkbox" name="att_ck" value="';
            if(isset($_POST['att_ck'])) echo 'checked';
            echo '">'.$rek[type_2].'<br>';
  
*/
//echo '</td><td><input style="padding:10px;margin:10px" type="text"  name="batch_date" value="'.htmlentities($weight).'">';

            
echo "<form action='upload_mobile.php' method='POST'>";            
            
echo '<input type="checkbox" name="option1" value=""> Set Device in QuickSilver Mode!<br>';

echo '<input type="checkbox" name="option3" value=""> Synchronise device<br>';    
echo '<input type="checkbox" name="rest_set" value="1" checked> Restructure System <br>';
echo '<input type="checkbox" name="init_set" value="1" checked> Initialization <br>';
echo '<input type="checkbox" name="restoration_set" value="1" checked> Restoration system <br>';
echo '<input type="checkbox" name="vert_set" value="1" checked>Vertical orientation <br>';
echo '<BR /><BR />Manifest: <BR/ ><BR/>';
echo '<input type="input" name="cartezian" maxlenght="2" size="3" style="width: 30px;">   Cartesian Set<br>';
echo '<input type="input" name="sizBut" maxlenght="2" size="3" style="width: 30px;">   Sensitivity<br>';
echo '<input style="padding:10px;margin:10px" type="hidden" placeholder="Item type" name="name_sub_cat" value="'.htmlentities($name_sub_cat).'">';


echo '<input type="hidden" name="submitted" value="1" >';

echo '<input type="hidden" name="id_manif_id" value="'.$id_manif_id.'" >';

echo "<input style='padding:10px;margin:10px' type='submit' name='Submit_pro' value='Program device' align='right'>";

	//echo '</tr>';
	 //echo '<td>'.$rek["sum_weight"].'</td>';
	// echo '<td>'.$rek["Name_sub"].'</td>';
	 
     //}
  
        echo "</form></td>"; 
	  //$tab[$rek["id_test"]]+=1;

  
echo '</tr></table><BR />';


if(isset($_POST['Submit_pro']))
{
    if(!empty($_POST['cartezian']))
    {
        echo "<BR/>Setting Cartesian ";
       mysql_connect($host_out,$username,$password);        
       mysql_select_db($dbs3_out);
       echo $cartesian=$_POST['cartezian'];
          if($cartesian>3)
            "<BR />OUT OF RANGE OF Cartesian SET";
       $query="UPDATE manifest_config SET cartesian='$cartesian' WHERE idmanifest_config=1";
       $result=mysql_query($query) or die(mysql_error());
       
        if($result)
            "<BR />Cartesian range for manifest set ".$cartesian;
     
        
        
    }
    
}


if(isset($_POST['Submit_pro']))
{
    if(!empty($_POST['sizBut']))
    {
        echo "<BR/>Setting Sensitivity ";
       mysql_connect($host_out,$username,$password);        
       mysql_select_db($dbs3_out);
       echo $zoom_size=$_POST['sizBut'];
          if($zoom_size)
            "<BR />";
        
       $query="UPDATE manifest_config SET zoom_size='$zoom_size' WHERE idmanifest_config=1";
       $result=mysql_query($query) or die(mysql_error());
       
        if($result)
            "<BR />Sensitivity for manifest set ".$zoom_size;
     
        
        
    }
    
}



if(isset($_POST['Submit_pro']))
{
    if($_POST['rest_set']==1)
    {
        mysql_connect($host_out,$username,$password);
        mysql_select_db($dbs3_out);
        
        $insert="SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `dbs3` DEFAULT CHARACTER SET utf8 ;
USE `dbs3` ;

-- -----------------------------------------------------
-- Table `dbs3`.`category`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dbs3`.`category` ;

CREATE TABLE IF NOT EXISTS `dbs3`.`category` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type_2` VARCHAR(45) NULL DEFAULT NULL,
  `name_cat` VARCHAR(255) NULL DEFAULT NULL,
  `kind` INT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbs3`.`source`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dbs3`.`source` ;

CREATE TABLE IF NOT EXISTS `dbs3`.`source` (
  `source_id` VARCHAR(20) NOT NULL,
  `name` VARCHAR(20) NULL DEFAULT NULL,
  `town_name` VARCHAR(20) NULL DEFAULT NULL,
  PRIMARY KEY (`source_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbs3`.`origin`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dbs3`.`origin` ;

CREATE TABLE IF NOT EXISTS `dbs3`.`origin` (
  `origin_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Source_source_id` VARCHAR(20) NOT NULL,
  `company_name` VARCHAR(255) NULL DEFAULT NULL,
  `name` VARCHAR(20) NULL DEFAULT NULL,
  `surname` VARCHAR(45) NULL DEFAULT NULL,
  `post_code` VARCHAR(20) NULL DEFAULT NULL,
  `house_number` VARCHAR(20) NULL DEFAULT NULL,
  `street` VARCHAR(255) NULL DEFAULT NULL,
  `town` VARCHAR(20) NULL DEFAULT NULL,
  `email` VARCHAR(45) NULL DEFAULT NULL,
  `phone` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`origin_id`),
  INDEX `Origin_FKIndex1` (`Source_source_id` ASC),
  CONSTRAINT `origin_ibfk_1`
    FOREIGN KEY (`Source_source_id`)
    REFERENCES `dbs3`.`source` (`source_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbs3`.`site`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dbs3`.`site` ;

CREATE TABLE IF NOT EXISTS `dbs3`.`site` (
  `site_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Origin_origin_id` INT(10) UNSIGNED NOT NULL,
  `site_ref_number` VARCHAR(255) NULL DEFAULT NULL,
  `Rep_Auth` INT(10) UNSIGNED NULL DEFAULT NULL,
  `Dest_Location` INT(10) UNSIGNED NULL DEFAULT NULL,
  `batch_date` DATE NULL DEFAULT NULL,
  `batch_id` INT(10) UNSIGNED NULL DEFAULT NULL,
  `closed` TINYINT(1) NULL DEFAULT NULL,
  PRIMARY KEY (`site_id`),
  INDEX `Site_FKIndex1` (`Origin_origin_id` ASC),
  CONSTRAINT `site_ibfk_1`
    FOREIGN KEY (`Origin_origin_id`)
    REFERENCES `dbs3`.`origin` (`origin_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbs3`.`trans_category`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dbs3`.`trans_category` ;

CREATE TABLE IF NOT EXISTS `dbs3`.`trans_category` (
  `Category_id` VARCHAR(20) NOT NULL,
  `name_1` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`Category_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbs3`.`delivery`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dbs3`.`delivery` ;

CREATE TABLE IF NOT EXISTS `dbs3`.`delivery` (
  `delivery_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Trans_Category_Category_id` VARCHAR(20) NOT NULL,
  `Site_site_id` INT(10) UNSIGNED NOT NULL,
  `date` DATE NULL DEFAULT NULL,
  `QtyPickedUp` DOUBLE NULL DEFAULT NULL,
  `picker1` VARCHAR(20) NULL DEFAULT NULL,
  `trans_ref_num` INT(10) UNSIGNED NULL DEFAULT NULL,
  `closed` TINYINT(1) NULL DEFAULT NULL,
  `QNum` DOUBLE NULL DEFAULT NULL,
  `att_num` INT(10) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`delivery_id`),
  INDEX `Delivery_FKIndex1` (`Site_site_id` ASC),
  INDEX `Delivery_FKIndex2` (`Trans_Category_Category_id` ASC),
  CONSTRAINT `delivery_ibfk_1`
    FOREIGN KEY (`Site_site_id`)
    REFERENCES `dbs3`.`site` (`site_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `delivery_ibfk_2`
    FOREIGN KEY (`Trans_Category_Category_id`)
    REFERENCES `dbs3`.`trans_category` (`Category_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbs3`.`weight`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dbs3`.`weight` ;

CREATE TABLE IF NOT EXISTS `dbs3`.`weight` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type_2` INT(10) UNSIGNED NULL DEFAULT NULL,
  `weight` DOUBLE NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbs3`.`sub_cat`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dbs3`.`sub_cat` ;

CREATE TABLE IF NOT EXISTS `dbs3`.`sub_cat` (
  `id_c` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Category_id` INT(10) UNSIGNED NOT NULL,
  `Weight_id` INT(10) UNSIGNED NOT NULL,
  `Name_sub` VARCHAR(45) NULL DEFAULT NULL,
  `kind` VARCHAR(20) NULL DEFAULT NULL,
  PRIMARY KEY (`id_c`),
  INDEX `Sub_cat_FKIndex1` (`Weight_id` ASC),
  INDEX `Sub_cat_FKIndex2` (`Category_id` ASC),
  CONSTRAINT `sub_cat_ibfk_1`
    FOREIGN KEY (`Weight_id`)
    REFERENCES `dbs3`.`weight` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `sub_cat_ibfk_2`
    FOREIGN KEY (`Category_id`)
    REFERENCES `dbs3`.`category` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbs3`.`site_has_cat`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dbs3`.`site_has_cat` ;

CREATE TABLE IF NOT EXISTS `dbs3`.`site_has_cat` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Sub_cat_id_c` INT(10) UNSIGNED NOT NULL,
  `Site_site_id` INT(10) UNSIGNED NOT NULL,
  `Quantity` INT(10) UNSIGNED NULL DEFAULT NULL,
  `sum_weight` DOUBLE NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `Site_has_Cat_FKIndex1` (`Site_site_id` ASC),
  INDEX `Site_has_Cat_FKIndex2` (`Sub_cat_id_c` ASC),
  CONSTRAINT `site_has_cat_ibfk_1`
    FOREIGN KEY (`Site_site_id`)
    REFERENCES `dbs3`.`site` (`site_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `site_has_cat_ibfk_2`
    FOREIGN KEY (`Sub_cat_id_c`)
    REFERENCES `dbs3`.`sub_cat` (`id_c`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbs3`.`user_2`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dbs3`.`user_2` ;

CREATE TABLE IF NOT EXISTS `dbs3`.`user_2` (
  `id_user` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(20) NULL DEFAULT NULL,
  `pass` VARCHAR(20) NULL DEFAULT NULL,
  `name` VARCHAR(20) NULL DEFAULT NULL,
  `priv` INT(10) UNSIGNED NULL DEFAULT NULL,
  `logged` TINYINT(1) NULL,
  `surname_user` VARCHAR(45) NULL,
  PRIMARY KEY (`id_user`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbs3`.`manifest_reg`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dbs3`.`manifest_reg` ;

CREATE TABLE IF NOT EXISTS `dbs3`.`manifest_reg` (
  `idmanifest_reg` INT NOT NULL AUTO_INCREMENT,
  `manifest_unq_num` VARCHAR(45) NULL,
  `date_manifest` DATE NULL,
  `driver_num` INT NULL,
  `hash_serial` VARCHAR(45) NULL,
  `group1` VARCHAR(45) NULL,
  `closed` INT NULL,
  `siteid` INT NULL,
  `start_dbs` VARCHAR(45) NULL,
  `end_dbs` VARCHAR(45) NULL,
  PRIMARY KEY (`idmanifest_reg`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbs3`.`manifest_counter`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dbs3`.`manifest_counter` ;

CREATE TABLE IF NOT EXISTS `dbs3`.`manifest_counter` (
  `id_manifest_counter` INT NOT NULL AUTO_INCREMENT,
  `manifest_counter` INT NULL,
  `sub_cat` INT NULL,
  `manifest_countercol` INT NULL,
  `manifest_reg_idmanifest_reg` INT NOT NULL,
  `finished` INT NULL,
  PRIMARY KEY (`id_manifest_counter`),
  INDEX `fk_manifest_counter_manifest_reg1_idx` (`manifest_reg_idmanifest_reg` ASC),
  CONSTRAINT `fk_manifest_counter_manifest_reg1`
    FOREIGN KEY (`manifest_reg_idmanifest_reg`)
    REFERENCES `dbs3`.`manifest_reg` (`idmanifest_reg`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbs3`.`Van`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dbs3`.`Van` ;

CREATE TABLE IF NOT EXISTS `dbs3`.`Van` (
  `idVan` INT NOT NULL,
  `registration` VARCHAR(45) NULL,
  `description` VARCHAR(45) NULL,
  PRIMARY KEY (`idVan`))
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `dbs3`.`manifest_reg` (
  `idmanifest_reg` INT NOT NULL AUTO_INCREMENT,
  `manifest_unq_num` VARCHAR(45) NULL,
  `date_manifest` DATE NULL,
  `driver_num` INT NULL,
  `hash_serial` VARCHAR(45) NULL,
  `group1` VARCHAR(45) NULL,
  `closed` INT NULL,
  `siteid` INT NULL,
  `start_dbs` VARCHAR(45) NULL,
  `end_dbs` VARCHAR(45) NULL,
  PRIMARY KEY (`idmanifest_reg`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbs3`.`manifest_counter`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbs3`.`manifest_counter` (
  `id_manifest_counter` INT NOT NULL AUTO_INCREMENT,
  `manifest_counter` INT NULL,
  `sub_cat` INT NULL,
  `manifest_cal` INT NULL,
  `manifest_reg_idmanifest_reg` INT NOT NULL,
  `finished` INT NULL,
  PRIMARY KEY (`id_manifest_counter`),
  INDEX `fk_manifest_counter_manifest_reg1_idx` (`manifest_reg_idmanifest_reg` ASC),
  CONSTRAINT `fk_manifest_counter_manifest_reg1`
    FOREIGN KEY (`manifest_reg_idmanifest_reg`)
    REFERENCES `dbs3`.`manifest_reg` (`idmanifest_reg`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
CREATE TABLE IF NOT EXISTS `dbs3`.`manifest_config` (
  `idmanifest_config` INT NOT NULL,
  `cartesian` INT NULL,
  `zoom_size` INT NULL,
  `vert` INT NULL,
  `restoration` INT NULL,
  PRIMARY KEY (`idmanifest_config`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbs3`.`device_config`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbs3`.`device_config` (
  `id_device_config` INT NOT NULL,
  `device_name` VARCHAR(45) NULL,
  `owner` VARCHAR(45) NULL,
  `quick_silver` INT NULL,
  `ip` VARCHAR(45) NULL,
  PRIMARY KEY (`id_device_config`))
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;   ";
        
        $mysqli = new mysqli($host_out, $username, $password);
        mysqli_select_db($mysqli, $insert);
        $result=mysqli_multi_query($mysqli,$insert) or die(mysqli_error());
        //$result=mysql_query($insert) or die(mysql_error());
        echo "<BR/>Restructing ";
        if($result){
            echo $result."<BR/>Done.";
        
            
        }
     }
    
    
}



//init
if(isset($_POST['Submit_pro']))
{
    if($_POST['init_set']==1)
    {
        //mysql_connect($host_out,$username,$password);
        //mysql_select_db($dbs3_out);
        $r=0;
        if($r==0)
        {
        $insert="-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2014 at 03:47 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET FOREIGN_KEY_CHECKS=0;
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = '+00:00';


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dbs3`
--
CREATE DATABASE IF NOT EXISTS `dbs3` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE dbs3;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_2` varchar(45) DEFAULT NULL,
  `name_cat` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) TYPE=InnoDB  AUTO_INCREMENT=17 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `type_2`, `name_cat`) VALUES
(1, '1', 'LDA''s; Large household appliances, washing machines, cookers etc.'),
(2, '2', 'SDA''s; Small household appliances, toasters, irons, hairdryers etc.'),
(3, '3', 'IT and communications equipement; printers, copiers, mobiles etc.'),
(4, '4', 'Consumer equipement'),
(5, '5', 'Lighting equipement;such as halogen lighting etc.'),
(6, '6', 'Electrical & electronics tools, lawnmowers, sewing machines etc.'),
(7, '7', 'TOYS, video games, electronics toys, slot machines etc.'),
(8, '8', 'Medical devices, excluding implanted and infected goods etc.'),
(9, '9', 'Monitoring & control instruments, smoke detectors, thermostats etc.'),
(10, '10', 'Automatic DISPENSERS; ATM''s, drinks/sweets dispensers etc'),
(11, '11', 'TV''s'),
(12, '12', 'Mobile Phones'),
(13, '13', 'CD''s and DVD''s'),
(14, '14', 'Printer Ink Toner/Cartridges'),
(15, '0', 'Brick-a-brack'),
(16, '0', 'Digital Signal Equipment');

-- --------------------------------------------------------

--
-- Table structure for table `origin`
--

CREATE TABLE IF NOT EXISTS `origin` (
  `origin_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Source_source_id` varchar(20) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `surname` varchar(45) DEFAULT NULL,
  `post_code` varchar(20) DEFAULT NULL,
  `house_number` varchar(20) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `town` varchar(20) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`origin_id`),
  KEY `Origin_FKIndex1` (`Source_source_id`)
) TYPE=InnoDB  AUTO_INCREMENT=19 ;

--
-- Dumping data for table `origin`
--

INSERT INTO `origin` (`origin_id`, `Source_source_id`, `company_name`, `name`, `surname`, `post_code`, `house_number`, `street`, `town`, `email`, `phone`) VALUES
(1, 'H022', 'AAG642', 'Herts', 'County', 'HP41TL', NULL, 'Northbridge Road', 'Berkhamsted', '', ''),
(2, 'H031', 'AAG644', 'Herts', 'County', 'SG99PA', NULL, 'Aspenden Road', 'Buntingford', '', ''),
(3, 'H101', 'AAG645', 'Herts', 'County', 'SG142NL', NULL, 'A414 BYPASS', 'Hatfield', '', ''),
(4, 'H041', 'AAG646', 'Herts', 'County', 'WD63LS', NULL, 'Randor Hall Allum Lane', 'Elstree', '', ''),
(5, 'H062', 'AAG647', 'Herts', 'County', 'AL51QB', NULL, 'Dark Lane', 'Harpenden', '', ''),
(6, 'H024', 'AAG648', 'Herts', 'County', 'HP27DU', NULL, 'Eastman Way', 'Hemel Hempstead', '', ''),
(7, 'H011', 'AAG649', 'Herts', 'County', 'EN110BZ', NULL, 'Pindar Road', 'Hoddesdon', '', ''),
(8, 'H042', 'AAG651', 'Herts', 'County', 'EN63JE', NULL, 'Cranbourne Road', 'Potters Bar', '', ''),
(9, 'H081', 'AAG652', 'Herts', 'County', 'WD31BN', NULL, 'Riverside Drive', 'Rickmansworth', '', ''),
(10, 'H052', 'AAG653', 'Herts', 'County', 'SG85HF', NULL, 'Beverly Close York Way', 'Royston', '', ''),
(11, 'H061', 'AAG654', 'Herts', 'County', 'AL14AP', NULL, 'Ronsons Way', 'St Albans', '', ''),
(12, 'H033', 'AAG657', 'Herts', 'County', 'SG120EL', NULL, 'Westmill Road', 'Ware', '', ''),
(13, 'H071', 'AGA122', 'Herts', 'County', 'SG12DF', NULL, 'Caxton Way', 'Stevenage', '', ''),
(14, 'H032', 'NIS933', 'Herts', 'County', 'CM235RG', NULL, 'Woodside Ind Est', 'Bishops Stortford', '', ''),
(15, 'H051', 'NIS940', 'Herts', 'County', 'SG61AB', NULL, 'Blackhorse Road', 'Letchworth', '', ''),
(16, 'H012', 'NIS948', 'Herts', 'County', 'EN80NP', NULL, 'Fairways Ind Est', 'Chesunt', '', ''),
(17, 'H083', 'NIS949', 'Herts', 'County', 'WD250PR', NULL, 'St Albans Road', 'Watford', '', ''),
(18, 'H011', 'GRR', 'GRR', 'Herts', 'GRR', NULL, 'County', 'Council', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `source`
--

CREATE TABLE IF NOT EXISTS `source` (
  `source_id` varchar(20) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `town_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`source_id`)
) TYPE=InnoDB;

--
-- Dumping data for table `source`
--

INSERT INTO `source` (`source_id`, `name`, `town_name`) VALUES
('H011', NULL, 'Hoddesdon'),
('H012', NULL, 'Turnford'),
('H022', NULL, 'Berkhamstead'),
('H024', NULL, 'Hemel Hempstead'),
('H031', NULL, 'Buntingford'),
('H032', NULL, 'Bishop Stortford'),
('H033', NULL, 'Ware'),
('H041', NULL, 'Elstree'),
('H042', NULL, 'Potter Bar'),
('H051', NULL, 'Letchworth'),
('H052', NULL, 'Royston'),
('H061', NULL, 'St. Albans'),
('H062', NULL, 'Harpenden'),
('H071', NULL, 'Stevenage'),
('H081', NULL, 'Rickmansworth'),
('H083', NULL, 'Waterdale'),
('H101', NULL, 'Cole Green');

-- --------------------------------------------------------

--
-- Table structure for table `sub_cat`
--

CREATE TABLE IF NOT EXISTS `sub_cat` (
  `id_c` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Category_id` int(10) unsigned NOT NULL,
  `Weight_id` int(10) unsigned NOT NULL,
  `Name_sub` varchar(45) DEFAULT NULL,
  `kind` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_c`),
  KEY `Sub_cat_FKIndex1` (`Weight_id`),
  KEY `Sub_cat_FKIndex2` (`Category_id`)
) TYPE=InnoDB  AUTO_INCREMENT=36 ;

--
-- Dumping data for table `sub_cat`
--

INSERT INTO `sub_cat` (`id_c`, `Category_id`, `Weight_id`, `Name_sub`, `kind`) VALUES
(1, 4, 1, 'Home Cin Spk', NULL),
(2, 11, 2, 'Large CRT TV', NULL),
(3, 11, 3, 'Small CRT TV', NULL),
(4, 4, 4, 'Sky Box', NULL),
(5, 4, 5, 'Sky+ Box', NULL),
(6, 4, 6, 'DVD', NULL),
(7, 7, 7, 'PS2', NULL),
(8, 4, 8, 'Hi-Fi', NULL),
(9, 4, 9, 'Micro Hi-Fi', NULL),
(10, 4, 10, 'Speakers pair', NULL),
(11, 3, 11, 'Complete Laptop', NULL),
(12, 4, 12, 'Sml Port/Radio', NULL),
(13, 4, 13, 'Lrg Port/Radio', NULL),
(14, 4, 14, 'Portable DVD', NULL),
(15, 4, 15, '5.1 Amp', NULL),
(16, 4, 16, 'A Amp', NULL),
(17, 4, 17, 'B Amp', NULL),
(18, 4, 18, 'Subwoofer', NULL),
(19, 3, 19, 'Complete PC', NULL),
(20, 3, 20, 'TFT Monitor', NULL),
(21, 4, 21, '20-27 TFT TV', NULL),
(22, 4, 22, '28-45 TFT TV', NULL),
(23, 4, 23, '46-60 TFT TV', NULL),
(24, 2, 24, 'Microwave', NULL),
(25, 6, 25, 'Power Tool', NULL),
(26, 6, 26, 'P/Tool Item', NULL),
(27, 4, 27, 'Car CD Player', NULL),
(28, 2, 28, 'Iron', NULL),
(29, 2, 29, 'Vacuum Cleaner', NULL),
(30, 12, 30, 'Mobile Phone', NULL),
(31, 13, 31, 'CD ', NULL),
(32, 16, 32, 'Monitor', NULL),
(33, 13, 33, 'DVD', NULL),
(34, 11, 34, 'TVT', NULL),
(35, 3, 35, 'bin mixed cable', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trans_category`
--

CREATE TABLE IF NOT EXISTS `trans_category` (
  `Category_id` varchar(20) NOT NULL,
  `name_1` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Category_id`)
) TYPE=InnoDB;

--
-- Dumping data for table `trans_category`
--

INSERT INTO `trans_category` (`Category_id`, `name_1`) VALUES
('18', 'Ferrous Metal'),
('19', 'Non Ferrous'),
('62', 'Rigid Plastic'),
('64', 'Plastic Bags'),
('65', NULL),
('66', 'LDA'),
('93', 'SDA'),
('94', 'Brick-a-Brack'),
('99', 'Toners'),
('A1', 'CDs'),
('A2', 'SDA'),
('TV', 'TV');

-- --------------------------------------------------------

--
-- Table structure for table `user_2`
--

CREATE TABLE IF NOT EXISTS `user_2` (
  `id_user` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(20) DEFAULT NULL,
  `pass` varchar(20) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `priv` int(10) unsigned DEFAULT NULL,
  `logged` tinyint(1) DEFAULT NULL,
  `surname_user` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) TYPE=InnoDB  AUTO_INCREMENT=15 ;

--
-- Dumping data for table `user_2`
--

INSERT INTO `user_2` (`id_user`, `login`, `pass`, `name`, `priv`, `logged`, `surname_user`) VALUES
(1, 'office', 'office', 'office', 3, NULL, NULL),
(2, 'admin', 'qwerty', 'admin', 0, NULL, NULL),
(3, 'tester1', 'tester1', 'tester', 1, NULL, NULL),
(4, 'tester2', 'tester2', 'tester2', 1, NULL, NULL),
(5, 'stock1', 'stock1', 'stock1', 2, NULL, NULL),
(6, 'stock2', 'stock2', 'stock2', 2, NULL, NULL),
(7, 'rob', 'qwerty', 'Robert Green', 3, NULL, NULL),
(8, 'adam', 'adam', 'Adam', 3, NULL, NULL),
(9, 'Lukas', 'qwerty', 'Lukasz Szmidt', 2, NULL, NULL),
(10, 'Dawid', 'ASDFG', 'Dawi', 1, NULL, NULL),
(11, 'lukasz', 'qwerty', 'Lukasz', 5, NULL, 'Szmidt'),
(12, 'loyd', 'loyd', 'Loyd', 4, NULL, NULL),
(13, 'lawrence', 'lawrence', 'Lawrence Parker', 2, NULL, NULL),
(14, 'mo', 'mo', 'Mohammed', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `weight`
--

CREATE TABLE IF NOT EXISTS `weight` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_2` int(10) unsigned DEFAULT NULL,
  `weight` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) TYPE=InnoDB  AUTO_INCREMENT=36 ;

--
-- Dumping data for table `weight`
--

INSERT INTO `weight` (`id`, `type_2`, `weight`) VALUES
(1, NULL, 0.8),
(2, NULL, 21.3),
(3, NULL, 8),
(4, NULL, 1.2),
(5, NULL, 2.2),
(6, NULL, 3),
(7, NULL, 1.8),
(8, NULL, 5.1),
(9, NULL, 2.1),
(10, NULL, 4.7),
(11, NULL, 2.6),
(12, NULL, 2),
(13, NULL, 3.5),
(14, NULL, 0.8),
(15, NULL, 3.8),
(16, NULL, 3.8),
(17, NULL, 3.8),
(18, NULL, 3.4),
(19, NULL, 9.5),
(20, NULL, 3.6),
(21, NULL, 5.5),
(22, NULL, 14.7),
(23, NULL, 24.4),
(24, NULL, 9.7),
(25, NULL, 10.6),
(26, NULL, 1.6),
(27, NULL, 1.6),
(28, NULL, 1.1),
(29, NULL, 6.9),
(30, NULL, 1),
(31, NULL, 0.1),
(32, NULL, 3.6),
(33, NULL, 12),
(34, NULL, 122),
(35, NULL, 15);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `origin`
--
ALTER TABLE `origin`
  ADD CONSTRAINT `origin_ibfk_1` FOREIGN KEY (`Source_source_id`) REFERENCES `source` (`source_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sub_cat`
--
ALTER TABLE `sub_cat`
  ADD CONSTRAINT `sub_cat_ibfk_1` FOREIGN KEY (`Weight_id`) REFERENCES `weight` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `sub_cat_ibfk_2` FOREIGN KEY (`Category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
 ";
      
        $mysqli = new mysqli($host_out, $username, $password);
        mysqli_select_db($mysqli, $insert);
        mysqli_multi_query($mysqli,$insert) or die(mysqli_error());
        //$result=mysql_query($insert) or die(mysql_error());
        echo "<BR/>Initialised ";
        if($result)
            echo $result;
        }
        
    }
    
    //
    
    
    if($r==1)
    {
    //export
        echo "<BR/>Special Init";
    $mysqlDatabaseName ='dbs3';
$mysqlUserName ='root';
$mysqlPassword ='krasnal';
$mysqlExportPath ='chooseFilenameForBackup.sql';
//mysqld --max_allowed_packet=34M
//DO NOT EDIT BELOW THIS LINE
$mysqlHostName ='localhost';
//Export the database and output the status to the page
$command='C:\xampp1\mysql\bin\mysqldump -u' .$mysqlUserName .' -S /kunden/tmp/mysql5.sock -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' > ~/' .$mysqlExportPath;
exec($command,$output=array(),$worked);
switch($worked){
    case 0:
        echo 'Database <b>' .$mysqlDatabaseName .'</b> successfully exported to <b>~/' .$mysqlExportPath .'</b>';
        break;
    case 1:
        echo 'There was a warning during the initialisation of <b>' .$mysqlDatabaseName .'</b> to <b>~/' .$mysqlExportPath .'</b>';
        break;
    case 2:
        echo 'There was an error during export. Please check your values:<br/><br/><table><tr><td>MySQL Database Name:</td><td><b>' .$mysqlDatabaseName .'</b></td></tr><tr><td>MySQL User Name:</td><td><b>' .$mysqlUserName .'</b></td></tr><tr><td>MySQL Password:</td><td><b>NOTSHOWN</b></td></tr><tr><td>MySQL Host Name:</td><td><b>' .$mysqlHostName .'</b></td></tr></table>';
        break;
    
    
    
    
    
    
    //import
    
    
    $mysqlDatabaseName =$dbs3_out;
$mysqlUserName =$username;
$mysqlPassword =$password;
$mysqlImportFilename ='chooseFilenameForBackup.sql';

//DO NOT EDIT BELOW THIS LINE
$mysqlHostName =$host_out;
//Export the database and output the status to the page
$command='mysql -u' .$mysqlUserName .' -S /kunden/tmp/mysql5.sock -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' < ' .$mysqlImportFilename;
exec($command,$output=array(),$worked);
switch($worked){
    case 0:
        echo 'Import file <b>' .$mysqlImportFilename .'</b> successfully imported to database <b>' .$mysqlDatabaseName .'</b>';
        break;
    case 1:
        echo 'There was an error during import. Please make sure the import file is saved in the same folder as this script and check your values:<br/><br/><table><tr><td>MySQL Database Name:</td><td><b>' .$mysqlDatabaseName .'</b></td></tr><tr><td>MySQL User Name:</td><td><b>' .$mysqlUserName .'</b></td></tr><tr><td>MySQL Password:</td><td><b>NOTSHOWN</b></td></tr><tr><td>MySQL Host Name:</td><td><b>' .$mysqlHostName .'</b></td></tr><tr><td>MySQL Import Filename:</td><td><b>' .$mysqlImportFilename .'</b></td></tr></table>';
        break;
}
}

    
    }
}



?>
      
 



</table>
    </BR>
    
    
    

    
    <table>
        
        
        <?php
        
        echo "<h3>System Data Upload</h3>";
        
        echo "<form action='upload_mobile.php' method='POST'>";            
            

echo '<input type="checkbox" name="user_set" value="1" checked> Root System users into device <br>';
echo '<input type="checkbox" name="category_set" value="1" checked> Root System categories into device <br>';   
echo '<input type="checkbox" name="trans_set" value="1" checked> Root System Trans Cat into Device <br>';
echo '<input type="checkbox" name="origin_set" value="1" checked> Root System origins into device <br>'; 
echo '<input style="padding:10px;margin:10px" type="hidden" placeholder="Item type" name="name_sub_cat" value="'.htmlentities($name_sub_cat).'">';


echo '<input type="hidden" name="submitted" value="1" >';

echo '<input type="hidden" name="id_manif_id" value="'.$id_manif_id.'" >';

echo "<input style='padding:10px;margin:10px' type='submit' name='Submit_data' value='Transfer data' align='right'>";

	echo '</tr>';
	 //echo '<td>'.$rek["sum_weight"].'</td>';
	// echo '<td>'.$rek["Name_sub"].'</td>';
	 
     //}
  
        echo "</form></td>"; 
        
        
        
         if(isset($_POST['Submit_data']))
       {
           if($_POST['trans_set']==1)
           {
               echo "<BR/ >Transfering Trans cat details";
               mysql_connect($host_in,$username,$password);
               mysql_select_db($dbs3_in);
               
   $select="SELECT * FROM trans_category";
   $result=mysql_query($select)or die(mysql_error());
   while($rek=mysql_fetch_array($result)){
       mysql_connect($host_out,$username,$password);
       mysql_select_db($dbs3_out);
       $id=$rek['Category_id'];
       $name=$rek['name_1'];
     
       
          $insert_user="INSERT INTO trans_category(Category_id,name_1) VALUES('$id','$name')";
          $result_in=mysql_query($insert_user);
          if($result_in)
              echo "1";
           }
               
               
           }
           
           
       }
        
        
         if(isset($_POST['Submit_data']))
       {
           if($_POST['origin_set']==1)
           {
               echo "<BR/ >Transfering Origins details";
               mysql_connect($host_in,$username,$password);
               mysql_select_db($dbs3_in);
               
   $select="SELECT * FROM source";
   $result=mysql_query($select)or die(mysql_error());
   while($rek=mysql_fetch_array($result)){
       mysql_connect($host_out,$username,$password);
       mysql_select_db($dbs3_out);
       $id=$rek['source_id'];
       $name=$rek['name'];
    $town=$rek['town_name'];
       
          $insert_user="INSERT INTO source(source_id,name,town_name) VALUES('$id','$name','$town')";
          $result_in=mysql_query($insert_user) or die(mysql_error());
          if($result_in)
              echo "1";
           }
           
           
           
           //DOING Origins now
           
           mysql_connect($host_in,$username,$password);
               mysql_select_db($dbs3_in);
            $select="SELECT * FROM origin";
   $result=mysql_query($select)or die(mysql_error());
   while($rek=mysql_fetch_array($result)){
       mysql_connect($host_out,$username,$password);
       mysql_select_db($dbs3_out);
       $id=$rek['origin_id'];
       $source=$rek['Source_source_id'];
    $comp=$rek['company_name'];
    $name=$rek['name'];
    $surname=$rek['surname'];
    $post_code=$rek['post_code'];
    $house=$rek['house_number'];
    $street=$rek['street'];
    $town=$rek['town'];
    $email=$rek['email'];
    $phone=$rek['phone'];
       
          $insert_user="INSERT INTO origin(origin_id,Source_source_id,company_name,name,surname,post_code,house_number,street,town,email,phone) "
                  . "VALUES('$id','$source','$comp','$name','$surname','$post_code','$house','$street','$town','$email','$phone')";
          $result_in=mysql_query($insert_user) or die(mysql_error());
          if($result_in)
              echo "1";
           }
           
               
               
           }
           
           
       }
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        //UND
        
       if(isset($_POST['Submit_data']))
       {
           if($_POST['user_set']==1)
           {
               echo "<BR/ >Transfering user details";
               mysql_connect($host_in,$username,$password);
               mysql_select_db($dbs3_in);
               
               //Lets set a manifest config row
               
               
               
               
   $select="SELECT * FROM user_2";
   $result=mysql_query($select)or die(mysql_error());
   while($rek=mysql_fetch_array($result)){
       mysql_connect($host_out,$username,$password);
       mysql_select_db($dbs3_out);
       $id=$rek['id_user'];
       $log=$rek['login'];
       $pas=$rek['pass'];
       $name=$rek['name'];
       $priv=$rek['priv'];
       $surname=$rek['surname_user'];
       
          $insert_user="INSERT INTO user_2(id_user,login,pass,name,priv,logged,surname_user) VALUES('$id','$log','$pas','$name','$priv',0,'$surname')";
          $result_in=mysql_query($insert_user);
          if($result_in)
              echo "1";
           }
              $INSERT="INSERT INTO manifest_config(idmanifest_config,cartesian,zoom_size,vert,restoration) VALUES('1','2','12','0','0')";
               $result=mysql_query($INSERT) or die(mysql_error());
               if($result)
                   echo "<BR />Manifest configured <BR/>"; 
               
           }
           
           
       }
       
        if(isset($_POST['Submit_data']))
       {
           if($_POST['category_set']==1)
           {
              echo "<BR/>Prepering device";
        
             //$insert="SET FOREIGN_KEY_CHECKS=0; truncate sub_cat; truncate weight; truncate category;SET FOREIGN_KEY_CHECKS=1;";
     $insert="SELECT concat('TRUNCATE TABLE ', TABLE_NAME, ';')
FROM INFORMATION_SCHEMA.TABLES
WHERE TABLE_NAME LIKE 'weight' AND TABLE_NAME Like 'category' AND TABLE_NAME='sub_cat';";
              $mysqli = new mysqli($host_out, $username, $password);
        mysqli_select_db($mysqli, $insert);
        
        echo $result=mysqli_multi_query($mysqli,$insert) or die(mysqli_error());
        //$result=mysql_query($insert) or die(mysql_error());
        if($result) echo "<BR/>Device prepared ";
        if ($result = mysqli_store_result($mysqli)) {
            while ($row = mysqli_fetch_row($result)) {
                printf("%s\n", $row[0]);
            }
        }
        mysqli_close($mysqli);
               mysql_connect($host_in,$username,$password);
               mysql_select_db($dbs3_in);
                
               //$trunk="truncate sub_cat";
              // mysql_query($trunk)or die(mysql_error());
               
               echo "<BR/ >Transfering category details";
   $select="SELECT * FROM sub_cat";
   $result=mysql_query($select)or die(mysql_error());
   
   
  
   mysql_connect($host_in,$username,$password);
       mysql_select_db($dbs3_in);
    $categ="SELECT * FROM category";
       $weig="SELECT * FROM weight";
       $res_cat=mysql_query($categ)or die(mysql_error());
       $res_wei=mysql_query($weig) or die(mysql_error());
       
       mysql_connect($host_out,$username,$password);
       mysql_select_db($dbs3_out);
       while($rek_cat=mysql_fetch_array($res_cat))
       {
          echo "<BR/>IN: ".$rek_cat['id']; 
            mysql_query("SET FOREIGN_KEY_CHECKS=0;");
            
           $id_category=$rek_cat['id'];
       $cat_type=$rek_cat['type_2'];
     echo  $cat_name_cat=addslashes($rek_cat['name_cat']);
       //modifiied
       
       
       $cat_kind=$rek_cat['kind'];
       //echo " ".$cat_name_cat;
            $insert_cat="INSERT INTO category(id,type_2,name_cat,kind) VALUES('$id_category','$cat_type','$cat_name_cat','$cat_kind')";
          $result_cat=mysql_query($insert_cat) or die(mysql_error());
         if($result_cat)
         {
           
              echo "Cat".$result_cat;
              echo "1";
         }   
         else
         {
             echo " ".mysql_error();
         }
          
             
       }
       
       
       while($rek_wei=mysql_fetch_array($res_wei))
       {
           
            mysql_query("SET FOREIGN_KEY_CHECKS=0;");
            $id_weight=$rek_wei['id'];
               echo $wei_type=$rek_wei['type_2'];
               $wei_weight=$rek_wei['weight'];
            $insert_wei="INSERT INTO weight(id,type_2,weight) VALUES('$id_weight','$wei_type','$wei_weight')";
          $result_wei=mysql_query($insert_wei)or die(mysql_error());
       }
       
       
               
             
       //out
       mysql_close();
       mysql_connect($host_out,$username,$password);
       mysql_select_db($dbs3_out);
   
   
   
   
   while($rek=mysql_fetch_array($result)){
       mysql_connect($host_in,$username,$password);
       mysql_select_db($dbs3_in);
       $id=$rek['id_c'];
       $log=$rek['Category_id'];
       $pas=$rek['Weight_id'];
       echo $name=$rek['Name_sub'];
       $priv=$rek['kind'];
       //$surname=$rek['surname_user'];
       
       
      
       mysql_connect($host_out,$username,$password);
       mysql_select_db($dbs3_out);
       
       
       
       
       
          
            mysql_query("SET FOREIGN_KEY_CHECKS=0;");
            
          
       
       
          $insert_user="INSERT INTO sub_cat(id_c,Category_id,Weight_id,Name_sub,kind) VALUES('$id','$log','$pas','$name','$priv')";
          $result_in=mysql_query($insert_user) or die(mysql_error());
          
   }
               
            mysql_query("SET FOREIGN_KEY_CHECKS=1;");   
           }
           
           
       }
        
        
        
        
        ?>
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        <?php 
      
        
        // We come to the point where we import manifest data both details and specifics
        //echo $import_details;
        
            
   
        
        //prepering to import att delivery site and categories
       
        
        
        ?>
        
        
        
    </table>   
    
    
    
    
    
    
    
</div> 

  

    
    
    
    
    
    
    
    
    
    
    
<div id="buttons_out"> 
  <h4>
  
  
 <p class="submit">  
      <a href="index.php"> <button class="submit">Return</button> </a> 
       <!--
 <button class="submit"><a href="add.php">Another Test</a> </button> 
-->
    </p>  


</h4>       
</div>

<BR><BR>

</BODY>
</HTML>