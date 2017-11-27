<?php
require "../models/book.php";
$thebook = new book();
if($_REQUEST["search"]["value"] != "")
   $thebook->getBookSearch(); 
elseif(isset($_POST["param"]) && $_POST["param"] == "notes")
    $thebook->updateNotes();
else
    $thebook->getBook();