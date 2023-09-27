<?php
   // connect to mongodb
   $m = new MongoClient("mongodb://my-mongo:27017");
	
   echo "Connection to database successfully";
   // select a database
   $db = $m->ugurdb;
	
   echo "Database ugurdb selected";
?>
