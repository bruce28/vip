<?php
//Header File
$header_space="</BR>";

function head($header_space,$ile)
{
  for($i=0;$i<$ile;$i++)
     $header_space.=$header_space;
     echo $header_space."</BR></BR>";
}

// USE

head($header_space,3);



?>