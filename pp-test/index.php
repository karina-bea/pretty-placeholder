<?php

include_once 'db_connection.php';

?>
<html>
    <head>
        <title>Creating Sortable Image Groups</title>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" ></script>

        <script src="ui/jquery.ui.core.js" type="text/javascript"></script>
        <script src="ui/jquery.ui.widget.js" type="text/javascript"></script>
        <script src="ui/jquery.ui.mouse.js" type="text/javascript"></script>
        <script src="ui/jquery.ui.sortable.js" type="text/javascript"></script>
        <link rel="stylesheet" href="demos.css">

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
           })
        
        
           .done(function( data ) {
             $.each( data.items, function( i, item ) {
               $( "<img/>" ).attr( "src", item.media.m ).appendTo( "#images" );
               if ( i === 3 ) {
                 return false;
                }
             });
           });
        
        }
        </script>


    </head>
    <div id="Header">
      Tags:
    </div>
    
    <br><br>
    
    <input id="usernameInput" type="text">
    <input type="button" value="Search" onClick="getUserInformation()">
    
    <br>  
    
    <div id="images"></div>
    
    <div id='group_container'>

        <div id='group_panel'>
            <div id='group_panel_header'>Create Group</div>
            <table>
                <tbody><tr>
                        <td>Group Name</td><td><input type="text" id="group_name"></td><td><input type="button" id="group_creation" value="Create" onclick="group_elements()"></td>
                    </tr>
                    <tr>
                        <td></td><td></td>
                    </tr>
                </tbody></table>
        </div>
        <div id="group_items_panel">


            <?php
            
            $result = mysql_query("select * from gallery_items");


            $count = 0;
            while ($row = mysql_fetch_array($result)) {
                $count++;
                echo "<div id='" . $row['img_name'] . "' class='item_box'><img src='" . $row['src'] . "' /></div>";
            }
            ?>


        </div>
        <div id="group_list">
            <div id='group_list_header'>Group List</div>

            <div class='group_item act' id='all_gallery' >All</div>

            <?php
            $result = mysql_query("select * from gallery_groups");
            while ($row = mysql_fetch_array($result)) {
                $count++;
                echo "<div class='group_item' id='" . $row['id'] . "' >" . $row['group_name'] . "</div>";
            }
            ?>
        </div>
        <div style='float: left;margin: 10px 0;text-align: center;width: 315px;'>
            <input type='button' onclick='delete_group()' value='Delete Group' />
        </div>
        <div style='float: left;margin: 10px 0;text-align: center;width: 315px;'>
		<input type='button' onclick='delete_images()' value='Delete Images' />
	</div>
        <div style='clear:both'></div>

    </div>

</body>
</html>