<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Blogs();
  $event = $data->getBlogById($_POST['dataId']);
  $imgs = explode(", ", $event['images']);
  $image = '';
  foreach ($imgs as $img) {
    $image .= '<img src="../assets/img/events/'.$img.'" alt="Event Image" class="w-25 img-thumbnail">';
  }
  
  
  echo "<h4>".$event['title']." <small>- By ".$event['hosts']."</small></h4>";
  echo "<p><b>Date: </b>".dates($event['event_date'])."</p>";
  echo "<p><b>Type: </b>".dates($event['types'])."</p>";
  echo "<p><b>Images: </b><br>".$image."</p>";
  echo $event['body'];