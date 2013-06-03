<?php

include_once 'db_connection.php';

?>
<html>
    <head>
        <title>Pretty Placeholder</title>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" ></script>

        <script src="ui/jquery.ui.core.js" type="text/javascript"></script>
        <script src="ui/jquery.ui.widget.js" type="text/javascript"></script>
        <script src="ui/jquery.ui.mouse.js" type="text/javascript"></script>
        <script src="ui/jquery.ui.sortable.js" type="text/javascript"></script>
        <link rel="stylesheet" href="demos.css">
        <script type="text/javascript" src="//use.typekit.net/odl0tpz.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>

        <script src="gallery.js" type="text/javascript"></script>
        <link rel="stylesheet" href="gallery.css">
        
        <script>
         function getUserInformation ()
        {
           var nameElement = document.getElementById("usernameInput");
           theName = nameElement.value;
        
           //writes in headr box
           $("#Header").append(theName + " ");
        
           //assign your api key equal to a variable
           var apiKey = '4ef2fe2affcdd6e13218f5ddd0e2500d';
        
           var flickerAPI = "http://api.flickr.com/services/feeds/photos_public.gne?jsoncallback=?";
        
           $.getJSON( flickerAPI, {
             tags: theName,
             tagmode: "any",
             format: "json"
           }).done(function( data ) {
             $.each( data.items, function( i, item ) {
                console.log(data);

                $("#group_items_panel").append("<div id='"+i+ "' class='item_box'><img src='"+item.media.m+"' /></div>");

               if ( i === 9 ) {
                 return false;
                }
             });
           });
        
        }
        </script>


    </head>
    
    <div id='group_container'>

        <div id='group_panel'>
           <h1>Pretty Placeholder</h2>
            <input id="usernameInput" type="text"  placeholder="Search Flickr to create lists of images for placeholder spec for your next web project." ><input id="search-btn" type="button" value="Search" onclick="getUserInformation()">

                   

        </div>
        <div id="group_items_panel">
             <input type='button' onclick='delete_images()' value='Delete Images' />


            <?php
            
            $result = mysql_query("select * from gallery_groups LIMIT 1");


            $count = 0;
            while ($row = mysql_fetch_array($result)) {
                $count++;
                echo "<div id='" . $row['img_name'] . "' class='item_box'><img src='" . $row['src'] . "' /></div>";
            }
            ?>


        </div>
        <div id="group_list">
             <input type="text" id="group_name" placeholder="New"><input  type="button" id="group_creation" value="+" onclick="group_elements()">
                 <a onclick='delete_group()'>Delete Group </a>
            <div class='group_item' id='all_gallery' >All</div>


            <?php
            $result = mysql_query("select * from gallery_groups");
            while ($row = mysql_fetch_array($result)) {
                $count++;
                echo "<div class='group_item' id='" . $row['id'] . "' >" . $row['group_name'] . "</div>";
            }
            ?>
           
        </div>
        
        <div style='clear:both'></div>

    </div>

</body>
</html>
