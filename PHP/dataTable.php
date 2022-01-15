<html>
<head>
  <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
</head>
<body>
  <table id="example">
    <thead>
      <tr><th>Sites</th></tr>
    </thead>
    <tbody>
      <tr><td>SitePoint</td></tr>
      <tr><td>Learnable</td></tr>
      <tr><td>Flippa</td></tr>
    </tbody>
  </table>
  <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
  <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
  <script>
  $(function(){
    $("#example").dataTable();
  })
  </script>
</body>
</html>
<!-- 
<html><head>
  <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
</head>
<body>
  <div id="example_wrapper" class="dataTables_wrapper" role="grid">
    <div id="example_length" class="dataTables_length">
      <label>Show <select size="1" name="example_length" aria-controls="example"><option value="10" selected="selected">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label>
    </div>
    <div class="dataTables_filter" id="example_filter">
      <label>Search: <input type="text" aria-controls="example"></label>
    </div><table id="example" class="dataTable" aria-describedby="example_info">
    <thead>
      <tr role="row">
        <th class="sorting_desc" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="descending" aria-label="Sites: activate to sort column ascending" style="width: 1489px;">Sites</th>
      </tr>
    </thead>
    
  <tbody role="alert" aria-live="polite" aria-relevant="all"><tr class="odd"><td class="  sorting_1">SitePoint</td></tr><tr class="even"><td class="  sorting_1">Learnable</td></tr><tr class="odd"><td class="  sorting_1">Flippa</td></tr></tbody></table><div class="dataTables_info" id="example_info">Showing 1 to 3 of 3 entries</div><div class="dataTables_paginate paging_two_button" id="example_paginate"><a class="paginate_disabled_previous" tabindex="0" role="button" id="example_previous" aria-controls="example">Previous</a><a class="paginate_disabled_next" tabindex="0" role="button" id="example_next" aria-controls="example">Next</a></div>
  </div>
  <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
  <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
  <script>
  $(function(){
    $("#example").dataTable();
  })
  </script>

</body></html> -->