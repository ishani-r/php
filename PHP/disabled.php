<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $(":disabled").css("background-color");
});
</script>
</head>
<body>

<form action="">
Name: <input type="text" name="user"><br>
ID:<input type="text" name="id">

<input type="submit" disabled="disabled">
</form>

</body>
</html>
