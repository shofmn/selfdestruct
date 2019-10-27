<?php

function delTree($dir) {
  $files = array_diff(scandir($dir), array('.','..'));
  foreach ($files as $file) {
    (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
  }
  return rmdir($dir);
}

$deleteList = fopen("deletelist.txt", "r") or die("Unable to open file");

while(!feof($deleteList)) {
  list($folder, $creationdate, $deletiondate, $comment) = explode(';', fgets($deleteList));
  if ($folder == "" || substr($folder, 0, 1) == "#") { continue; }
  if (date("Y-m-d") >= $deletiondate) echo "Deletion job of " . $folder . ": " . (delTree("../" . $folder) ? "Successful" : "Error or already deleted, see PHP error log") . "\r\n";
}

fclose($deleteList);
?> 
