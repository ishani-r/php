<!DOCTYPE html>
<html>
<head>
<style>
.ancestors * { 
  display: block;
  border: 2px solid lightgrey;
  color: lightgrey;
  padding: 5px;
  margin: 15px;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $("ul").find("span").css({"color": "red", "border": "2px solid red"});
});
</script>
</head>

<body class="ancestors">body (great-grandparent)
  <div style="width:500px;">div (grandparent)
    <ul>ul (direct parent)  
      <li><span>li (child)</span>
        <span>span (grandchild)</span>
      </li>
    </ul>   
  </div>
</body>

</html>
