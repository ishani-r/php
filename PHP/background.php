<html lang="en">
<head>
<title>jQuery Setting background-image CSS Property</title>
<style>
    .box{
        width: 500px;
        height: 300px;
        border: 5px solid #333;
    }
</style>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function(){
    // Set background image of a div on click of the button
    $("button").click(function(){
        var imageUrl = "images/8_img1.jpg";
        $(".box").css("background-image", "url(" + imageUrl + ")");
    });    
});
</script>
</head>
<body>
    <div class="box"></div>
    <p><button type="button">Set Background Image</button></p>
</body>
</html>