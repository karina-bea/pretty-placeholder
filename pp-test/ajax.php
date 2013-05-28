<?php

include_once 'db_connection.php';



if (isset($_POST['action']) && $_POST['action'] == 'save_gallery') {

    $gallery_name = $_POST['gallery_name'];
    $image_list = substr($_POST['image_list'], 0, -1);

    $sql_select = "select * from gallery_groups where group_name = '$gallery_name'";
    $result = mysql_query($sql_select);
    if (mysql_num_rows($result) == 0) {
        $sql = "insert into gallery_groups(group_name,group_images) values('$gallery_name','$image_list')";
        $result = mysql_query($sql);

        echo mysql_insert_id();
    } else {
        echo "invalid";
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'load_gallery') {



    $gallery_id = $_POST['gallery_id'];
    if ($gallery_id != 'all_gallery') {
        $sql = "select * from gallery_groups where id='$gallery_id'";
        $result = mysql_query($sql);
        $gallery = mysql_fetch_object($result);

        echo $gallery->group_images;
    } else {
        $sql = "select * from gallery_groups ";

        $result = mysql_query($sql);

        $tags = array();
        
        while ($row = mysql_fetch_array($result)) {
            $data = array('ids' => $row['id'], 'tags' => $row['group_name']);
            array_push($tags, $data);
        }

        $json = array("data" => $tags);
        echo json_encode($json);
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'update_gallery') {



    $gallery_id = $_POST['gallery_id'];
    $image_list = substr($_POST['image_list'], 0, -1);


    $sql = "update gallery_groups set group_images='$image_list' where id='$gallery_id'";
    $result = mysql_query($sql);
}

if (isset($_POST['action']) && $_POST['action'] == 'delete_gallery') {



    $gallery_id = $_POST['group_id'];

    $sql = "delete from gallery_groups where id='$gallery_id'";
    $result = mysql_query($sql);
    if ($result) {
        echo "success";
    }
}
?>
