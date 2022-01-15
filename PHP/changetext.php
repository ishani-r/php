<html> 
<head>
    <title>
      Change the Text of a Button using jQuery
  </title>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js">
  </script>
</head>
  
    <h3>Change the Text of a Button using jQuery</h3>
    <p>
      Click on button to change text
      from "Click" to "Prop Click"
  </p>
    <input type="button" id="button" value="Click">
    <script>
        $(document).ready(function() {
            $("input").click(function() {
                $("#button").prop("value", "Prop Click");
            });
        });
    </script>
</body>
  
</html>