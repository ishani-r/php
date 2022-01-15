<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Check if Enter Key is Pressed with jQuery</title>
<h1>Press Enter Key</h1>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
   $(document).on("keypress", function(i){
       if(i.which == 13){
           $("body").append("<p>You've pressed the enter key!</p>");
       }
   });
</script>
</head>