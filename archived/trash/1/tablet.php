<?php


?>


<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1">
        <link rel="stylesheet" href="jquery.mobile/jquery.mobile-1.4.4.min.css"/>
        <script src="jquery-2.1.1.js"></script>
        <script src="jquery.mobile/jquery.mobile-1.4.4.min.js"></script>
    </head>
    <body>
        
        
        <div id="site-details" data-role="page">
            <div data-role="header">
                <h1>Green Resource Recycling Ltd.</h1>
                <a href="#" data-role="button" data-transition="flip">Log me in</a>
                <a href="#manifest" data-transition="flip" >Start Manifest</a>
                
            </div>
            
        <p>Login Into the system. Specify Site. Give first sticker. </p>
        <a herf="#" data-transition="flip" data-role="button" data-mini="true" > Collection site</a>
         <a herf="#" data-transition="flip" data-role="button" data-mini="true" >First sticker </a>
        </div>
        <div id="manifest" data-role="page">
            <div data-role=header>
                <h1>Green Resource Recycling Ltd.</h1>
                <a href="#site-details" data-icon="back">Collection details</a>
                 <a href="#site-details" data-icon="grid">Options</a>
            </div>
            
            <p>Manifest</p>
            
        </div>
    </body>
</html>
