<?php

/**
 * @author gencyolcu
 * @copyright 2013
 */
error_reporting(E_ALL); ini_set('display_errors','off');
 
function show_menu()
{ 
 
     
  if($_SESSION['logged']!=1)
  { 
    $czas=0;
    $gdzie="login.php";  
   echo "<head><meta http-equiv=\"Refresh\" content=\"$czas; URL=$gdzie\" /></head>";   
  }    


if(isset($_SESSION['priv'])AND ($_SESSION['priv']==0))
{
    
echo <<<ALL

<script>
    function closeWindow() {
        window.open('','_parent','');
        window.close();
    }
</script> 

<div class="horizontalcssmenu">
<ul id="cssmenu1">
<li style="border-left: 1px solid #202020;"><a href="http:index.php">Main</a></li>
<li><a href="" >System</a>
<ul>
    <li><a href="">System Configuration</a></li>
    <li><a href="revision.php">Manifest Set-up</a></li>
    <li><a href="revision_man_def.php">Manifest Definition</a></li>
    <li><a href="revision_stream.php">Stream Set-up</a></li>
     <li><a href="revision_att1.php">ATT Set-up</a></li>
     <li><a href="import_mobile_new.php">Import from Tablet</a></li>
      <li><a href="upload_mobile.php">Upload Mobile Device</a></li>
    <li><a href="revision_user.php">Add a new System User</a></li>
    <li><a href="">Change User </a> </a></li>
    <li><a href=""></a></li>
     <li><a href="login.php">Logout</a></li>
    <!--
<li><a href="javascript:closeWindow();">Shut down</a></li>
-->
    <li><a href="javascript:window.open('','_self').close();">Shut down</a></li>
    </ul></li>

<li><a href="index.php">Stock</a>
    <ul>
    <!--
<li><a href="add_stock.php">Add a random item</a></li>
-->
    <!--<li><a href="add_stock.php">Add on Stock</a></li>-->
    <li><a href="search_all_inv.php">Show Inventory</a></li>
    <li><a href="test1/add_stock.php">Stock-Test (Testing module)</a></li>
        <li><a href="test7/add_stock.php">Stocking-Testing Module 2 (TESTING!)</a></li>
    <!--
<li><a href="">Search an Item</a></li>
     <li><a href="">Genereate Report for Stock</a></li>
-->
    </ul></li>
<li><a href="">Tests</a>
    <ul>
    <li><a href="search_broken.php">List faulty items</a></li>
    <li><a href="search_good.php">List working items</a></li>
    <li><a href="search_all.php">All items tested</a></li>
    <li><a href="add_barcode.php">Test Item</a></li>
    <li><a href="search_rep.php">Repairs</a></li>
    </ul>
</li>
<li><a href="">Search</a>
<ul>
    <li><a href="search_adv.php">Advanced Search</a></li>
    <li><a href="search_da_f.php">By Date</a></li>
    <li><a href=""></a></li>
    </ul>
    </li>
<li><a href="reports_sum.php">Reports</a>
    <ul>
    <li><a href="reports_sum.php">Items Summary</a></li>
    <!--
<li><a href="search_report.php">Generate Reports</a></li>
-->
     <li><a href="reports_sum_time.php">Category overview</a></li>
    <li><a href="search_report_pro.php">Items tested</a></li>
    <li><a href="search_report_pro.php?token=1">Items to be tested</a></li>
    <li><a href="searchin.php">Searching Barcode</a></li>
    <li><a href="barcode_show_det.php">Barcode Origins</a></li>
    </ul>
</li>



<li><a href="">Sell</a>
    <ul>
   <!-- <li><a href="sell_item.php"> Sell Items</a></li> -->
    <li><a href="buyer_new.php">Add a new wholesale buyer</a></li>
    <!-- <li><a href="six.php">Ebay Sell</a></li> -->
    <li><a href="six_manual.php">Ebay transaction</a></li>
    <li><a href="sell_item.php">Wholesale transaction</a></li>  <!-- sell_trans.php -->
    <li><a href="print_invoice_s_buyer.php">Print previous invoice</a></li>
     <li><a href="trans_origin.php">Show wholesale purchases</a></li>
    <li><a href="search_all_inv_sell.php">Sell inventory</a></li>
    <!--
 <li><a href="trans_origin_test.php">Show Sells origin (Test modul)</a></li>
-->
   <!--
 <li><a href="">Show Recent transactions</a></li>
-->
    </ul>
</li>

<li><a href="">Office</a>
    <ul>
    <li><a href="site_new.php">Add a new Site Place</a></li>
   <!-- 
   <li><a href="buyer_new.php">Add a new Buyer</a></li>
    
<li><a href="show_att.php">Report for Council</a></li>

    <li><a href="cat_assign.php">Items Assignment</a></li>
    -->
    <li><a href="active_weights.php">Check Active Weights</a></li>
    <li><a href="manifest_rep.php">Collection Reports</a></li>
    <li><a href="manifest_rep_detail.php"> Reports</a></li>
    <li><a href="six_show.php">Six Bit Sales</a></li>
     <li><a href="office.php">Generate Office Reports</a></li>
    <li><a href="office_sql.php">OfficeSQL</a></li>
    </ul>
</li>

<li><a href="">Site Collection</a>
    <ul>
    <li><a href="scm/index.php">Fill Manifest</a></li>
    <li><a href="categories.php">Add a new manifest categories</a></li>
    <li><a href="show_att.php">Show Raport</a></li>
   
    </ul>
</li>

</ul>
<br style="clear: left;" />
</div>


ALL;

}





if(isset($_SESSION['priv'])AND ($_SESSION['priv']==6))
{
    
    


echo <<<STOCK

<div class="horizontalcssmenu">
<ul id="cssmenu1">
<li style="border-left: 1px solid #202020;"><a href="http:index.php">Main</a></li>
<li><a href="login.php" >System</a>
<ul>
     <li><a href="login.php">Logout</a></li>
    <!--
<li><a href="javascript:closeWindow();">Shut down</a></li>
-->
    <li><a href="javascript:window.open('','_self').close();">Shut down</a></li>
    </ul></li>

<li><a href="index.php">Stock</a>
    <ul>
    
    
    
    <li><a href="mark_strip.php">Dismantle item</a></li>
    
    </ul></li>

<li><a href="">Search</a>
<ul>
    <li><a href="barcode_show_status.php">Item status</a></li>
    
    </ul>
    </li>






</li>

</ul>
<br style="clear: left;" />
</div>

STOCK;

    
    
    
    
    
}












if(isset($_SESSION['priv'])AND ($_SESSION['priv']==1)OR($_SESSION['priv']==2))
{
    
    


echo <<<STOCK

<div class="horizontalcssmenu">
<ul id="cssmenu1">
<li style="border-left: 1px solid #202020;"><a href="http:index.php">Main</a></li>
<li><a href="login.php" >System</a>
<ul>
     <li><a href="login.php">Logout</a></li>
    <!--
<li><a href="javascript:closeWindow();">Shut down</a></li>
-->
    <li><a href="javascript:window.open('','_self').close();">Shut down</a></li>
    </ul></li>

<li><a href="index.php">Stock</a>
    <ul>
    <!--
<li><a href="add_stock.php">Add a random item</a></li>
-->
    <!--<li><a href="add_stock.php">Add on Stock</a></li>
    <li><a href="search_all_inv.php">Show Inventory</a></li>-->
    <!--<li><a href="test1/add_stock.php">Stock-Test (Testing module)</a></li>-->
    <li><a href="test7/add_stock.php">Test Item</a></li>
    
    </ul></li>
<li><a href="index.php">Tests</a>
    <ul>
    <!--<li><a href="search_broken.php">List faulty items</a></li>
    <li><a href="search_good.php">List working items</a></li>-->
    <li><a href="search_all.php">All items tested</a></li>
    <li><a href="add_barcode.php">Tests</a></li>
    <li><a href="search_rep.php">Repairs</a></li>
    </ul>
</li>
<li><a href="">Search</a>
<ul>
    <li><a href="search_adv.php">Advanced Search</a></li>
   <!-- <li><a href="search_da_f.php">By Date</a></li>-->
    <li><a href=""></a></li>
    </ul>
    </li>
<li><a href="index.php">Reports</a>
    <ul>
   <!-- <li><a href="reports_sum.php">Items Summary</a></li>
    
<li><a href="search_report.php">Generate Reports</a></li>
-->
    <!--
    <li><a href="search_report_pro.php">Items tested</a></li>
    <li><a href="search_report_pro.php?token=1">Items to be tested</a></li>
   --> 
        <li><a href="searchin.php">Searching Barcode</a></li>
    <li><a href="barcode_show_det.php">Barcode Origins</a></li>
    <li><a href="barcode_show_status.php">Item status</a></li>
    
   </ul>
</li>



<li><a href="">Sell</a>
    <ul>
  
    <li><a href="print_invoice_s.php">Print Invoice</a></li>
     <li><a href="trans_origin.php">Show Sells origin</a></li>
    <!--
 <li><a href="trans_origin_test.php">Show Sells origin (Test modul)</a></li>
-->
   
    </ul>
</li>




</li>

</ul>
<br style="clear: left;" />
</div>

STOCK;

    
    
    
    
    
}




if(isset($_SESSION['priv'])AND ($_SESSION['priv']==3))
{
    
echo <<<ALL

<script>
    function closeWindow() {
        window.open('','_parent','');
        window.close();
    }
</script> 

<div class="horizontalcssmenu">
<ul id="cssmenu1">
<li style="border-left: 1px solid #202020;"><a href="http:index.php">Main</a></li>
<li><a href="" >System</a>
<ul>
    
     <li><a href="login.php">Logout</a></li>
    <!--
<li><a href="javascript:closeWindow();">Shut down</a></li>
-->
    <li><a href="javascript:window.open('','_self').close();">Shut down</a></li>
    </ul></li>

<li><a href="index.php">Stock</a>
    <ul>
   
    <li><a href="test7/add_stock.php">Test item</a></li>
    </ul></li>
<li><a href="">Tests</a>
    <ul>
    <li><a href="search_broken.php">List faulty items</a></li>
    <li><a href="search_good.php">List working items</a></li>
    <li><a href="search_all.php">All items tested</a></li>
    <li><a href="add_barcode.php">Test Item</a></li>
    <li><a href="search_rep.php">Repairs</a></li>
    </ul>
</li>
<li><a href="">Search</a>
<ul>
    <li><a href="search_adv.php">Advanced Search</a></li>
   
    <li><a href=""></a></li>
    </ul>
    </li>
<li><a href="reports_sum.php">Reports</a>
    <ul>
    <li><a href="reports_sum.php">Items Summary</a></li>
    <!--
<li><a href="search_report.php">Generate Reports</a></li>
-->
     <li><a href="reports_sum_time.php">Category overview</a></li>
    <li><a href="search_report_pro.php">Items tested</a></li>
    <li><a href="search_report_pro.php?token=1">Items to be tested</a></li>
    <li><a href="searchin.php">Searching Barcode</a></li>
    <li><a href="barcode_show_status.php">Item status</a></li>
    </ul>
</li>



<li><a href="">Sell</a>
    <ul>
   <!-- <li><a href="sell_item.php"> Sell Items</a></li> -->
    <li><a href="buyer_new.php">Add a new wholesale buyer</a></li>
<!--    <li><a href="six.php">Ebay Sell</a></li> -->
    <li><a href="six_manual.php">Ebay transaction</a></li>
      <li><a href="six_man.php">NEW!! Ebay sell transaction </a></li>
    <li><a href="sell_item.php">Wholesale transaction</a></li>  <!-- sell_trans.php -->
   <li><a href="sell_item_waste1.php">Wee Waste </a></li> 
   <li><a href="print_invoice_s_buyer.php">Print previous invoice</a></li>
     <li><a href="trans_origin.php">Show wholesale purchases</a></li>
    <li><a href="search_all_inv_sell.php">Sell inventory</a></li>
    <!--
 <li><a href="trans_origin_test.php">Show Sells origin (Test modul)</a></li>
-->
   <!--
 <li><a href="">Show Recent transactions</a></li>
-->
    </ul>
</li>

<li><a href="">Office</a>
    <ul>
    <li><a href="site_new.php">Add a new Site Place</a></li>
   <!-- 
   <li><a href="buyer_new.php">Add a new Buyer</a></li>
    
<li><a href="show_att.php">Report for Council</a></li>

    <li><a href="cat_assign.php">Items Assignment</a></li>
    -->
    <li><a href="active_weights.php">Check Active Weights</a></li>
    <li><a href="manifest_rep.php">Collection Reports</a></li>
    <li><a href="manifest_rep_detail.php">Reports</a></li>
    <li><a href="six_show.php">Six Bit Sales</a></li>
     <li><a href="office.php">Generate Office Reports</a></li>
    <li><a href="office_sql.php">OfficeSQL</a></li>
    <li><a href="pre_processed_good_process.php">Post processing</a></li>
    </ul>
</li>

<li><a href="">Site Collection</a>
    <ul>
    <li><a href="scm/index.php">Fill Manifest</a></li>
    <li><a href="categories.php">Add a new manifest categories</a></li>
     <li><a href="categories_add.php">NEW manifest categories</a></li>
    <li><a href="show_att.php">Show Raport</a></li>
   
    </ul>
</li>

</ul>
<br style="clear: left;" />
</div>


ALL;

}


if(isset($_SESSION['priv'])AND ($_SESSION['priv']==5)) //lukasz
{
    
echo <<<ALL

<script>
    function closeWindow() {
        window.open('','_parent','');
        window.close();
    }
</script> 

<div class="horizontalcssmenu">
<ul id="cssmenu1">
<li style="border-left: 1px solid #202020;"><a href="http:index.php">Main</a></li>
<li><a href="" >System</a>
<ul>
    <li><a href="">System Configuration</a></li>
    <li><a href="revision.php">Manifest Set-up</a></li>
    <li><a href="revision_man_def.php">Manifest Definition</a></li>
    <li><a href="revision_stream.php">Stream Set-up</a></li>
     <li><a href="revision_att1.php">ATT Set-up</a></li>
     <li><a href="import_mobile_new.php">Import from Tablet</a></li>
     <li><a href="tablet/login.php">Add manifest paperwork</a></li>
      <li><a href="upload_mobile.php">Upload Mobile Device</a></li>
    <li><a href="revision_user.php">Add a new System User</a></li>
       <li><a href="system_check_dbs.php">Sticker Checkup</a></li>
      
    <li><a href="">Change User </a> </a></li>
    <li><a href=""></a></li>
     <li><a href="login.php">Logout</a></li>
    <!--
<li><a href="javascript:closeWindow();">Shut down</a></li>
-->
    <li><a href="javascript:window.open('','_self').close();">Shut down</a></li>
    </ul></li>

<li><a href="index.php">Stock</a>
    <ul>
        <li><a href="test7/add_stock.php">Test Item</a></li>
    <li><a href="mark_strip.php">Dismantle item</a></li>
    <li><a href="mark_dismantle.php">Remove from stock</a></li>
  
    </ul></li>
<!--<li><a href="">Tests</a>
    <ul>
    <li><a href="search_broken.php">List faulty items</a></li>
    <li><a href="search_good.php">List working items</a></li>
    <li><a href="search_all.php">All items tested</a></li>
    <li><a href="add_barcode.php">Test Item</a></li>
    <li><a href="search_rep.php">Repairs</a></li>
    </ul>
</li>
    -->
<li><a href="">Search</a>
<ul>
    <li><a href="search_adv.php">Advanced Search</a></li>
  
 
    </ul>
    </li>
<li><a href="reports_sum.php">Reports</a>
    <ul>
    <li><a href="reports_sum.php">Items Summary</a></li>
    <!--
<li><a href="search_report.php">Generate Reports</a></li>
-->
     <li><a href="reports_sum_time.php">Category overview</a></li>
    <li><a href="search_report_pro.php">Items tested</a></li>
    <li><a href="search_report_pro.php?token=1">Items to be tested</a></li>
    <li><a href="searchin.php">Searching Barcode</a></li>
    <li><a href="barcode_show_det.php">Barcode Origins</a></li>
    <li><a href="barcode_show_status.php">Item status</a></li>
    <li><a href="search_rep.php">Repairs</a></li>
    
    </ul>
</li>



<li><a href="">Sell</a>
    <ul>
   <!-- <li><a href="sell_item.php"> Sell Items</a></li> -->
    <li><a href="buyer_new.php">Add a new wholesale buyer</a></li>
    <!-- <li><a href="six.php">Ebay Sell</a></li> -->
    <li><a href="six_manual.php">Ebay transaction</a></li>
    <li><a href="six_man.php">NEW!! Ebay sell transaction </a></li>
    <li><a href="sell_item.php">Wholesale transaction</a></li>  <!-- sell_trans.php -->
     <li><a href="sell_item_waste1.php">Wee Waste </a></li>
    <li><a href="print_invoice_s_buyer.php">Print previous invoice</a></li>
     <li><a href="trans_origin.php">Show wholesale purchases</a></li>
    <li><a href="search_all_inv_sell.php">Sell inventory</a></li>
    <!--
 <li><a href="trans_origin_test.php">Show Sells origin (Test modul)</a></li>
-->
   <!--
 <li><a href="">Show Recent transactions</a></li>
-->
    </ul>
</li>

<li><a href="">Office</a>
    <ul>
    <li><a href="site_new.php">Add a new Site Place</a></li>
   <!-- 
   <li><a href="buyer_new.php">Add a new Buyer</a></li>
    
<li><a href="show_att.php">Report for Council</a></li>

    <li><a href="cat_assign.php">Items Assignment</a></li>
    -->
    <li><a href="active_weights.php">Check Active Weights</a></li>
    <li><a href="manifest_rep.php">Collection Reports</a></li>
    <li><a href="manifest_rep_detail.php"> Reports</a></li>
    <li><a href="six_show.php">Six Bit Sales</a></li>
     <li><a href="office.php">Generate Office Reports</a></li>
    <li><a href="office_sql.php">OfficeSQL</a></li>
    <li><a href="pre_processed_good_process.php">Post processing</a></li>
    </ul>
</li>

<li><a href="">Site Collection</a>
    <ul>
    <li><a href="scm/index.php">Fill Manifest</a></li>
    <li><a href="categories.php">Add a new manifest categories</a></li>
     <li><a href="categories_add.php"> NEW Categories engine</a></li>
    <li><a href="show_att.php">Show Raport</a></li>
   
    </ul>
</li>

</ul>
<br style="clear: left;" />
</div>


ALL;

}

if(isset($_SESSION['priv'])AND ($_SESSION['priv']==4))
{
    
echo <<<ALL

<script>
    function closeWindow() {
        window.open('','_parent','');
        window.close();
    }
</script> 

<div class="horizontalcssmenu">
<ul id="cssmenu1">
<li style="border-left: 1px solid #202020;"><a href="http:index.php">Main</a></li>
<li><a href="" >System</a>
<ul>
    
     <li><a href="login.php">Logout</a></li>
    <!--
<li><a href="javascript:closeWindow();">Shut down</a></li>
-->
    <li><a href="javascript:window.open('','_self').close();">Shut down</a></li>
    </ul></li>

<li><a href="index.php">Stock</a>
    <ul>
    
    <!--<li><a href="test1/add_stock.php">Stock-Test (Testing module)</a></li>-->
        <li><a href="test7/add_stock.php">Test item</a></li>
    
    </ul></li>


<li><a href="reports_sum.php">Reports</a>
    <ul>
    <li><a href="reports_sum.php">Items Summary</a></li>
    <!--
<li><a href="search_report.php">Generate Reports</a></li>
-->
  
    <li><a href="searchin.php">Searching Barcode</a></li>
    <li><a href="barcode_show_det.php">Barcode Origins</a></li>
    <li><a href="barcode_show_status.php">Item status</a></li>
    
    </ul>
</li>



<li><a href="">Sell</a>
    <ul>
   
     <li><a href="six_manual.php">Ebay transaction</a></li>
    <li><a href="six_man.php">NEW!! Ebay sell transaction </a></li>
    </ul>
</li>

<li><a href="">Office</a>
    <ul>
  
   
    <li><a href="six_show.php">Six Bit Sales</a></li>
    
    </ul>
</li>


</li>

</ul>
<br style="clear: left;" />
</div>


ALL;

}
























}

?>