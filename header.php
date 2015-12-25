<?php
//Header File
$header_space="</BR>";

echo '<img src="weee/WEEE Collection v3_html_m5ab1a91a.jpg" width="205" height="162" />';

function head($header_space,$ile)
{
  for($i=0;$i<$ile;$i++)
     $header_space.=$header_space;
     echo $header_space."</BR></BR>";
}

// USE

//head($header_space,2);



?>