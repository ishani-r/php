// $limit = 5;

  //       if (isset($_POST['page_no'])) {
  //           $page_no = $_POST['page_no'];
  //       } else {
  //           $page_no = 1;
  //       }
  //       $offset = ($page_no - 1) * $limit;

  //       $query = "SELECT * FROM modal order by id desc LIMIT $offset, $limit  ";
  //       $query_run = mysqli_query($conn, $query);
  //       $output = "";

  //       if (mysqli_num_rows($query_run) > 0) {
  //        $output .= "<tr><th><button id='deletes' class='btn btn-danger'>Delete</button></th>
        //                  <th>Id</th>
        //                  <th>Full Name</th>
        //                  <th>Email</th>
        //                  <th>Mobile No</th>
        //                  <th>DOB</th>
        //                  <th>Gender</th>
        //                  <th>Image</th>
        //                  <th>Update</th>
        //              </tr>";
  //           while ($row = mysqli_fetch_assoc($query_run)) {

  //               $output .= "<tr>
  //                            <td><input type='checkbox' value=''{$row['id']}''></td>
  //                            <td align='center'>{$row["id"]}</td>
  //                            <td>{$row['firstname']} {$row['lastname']}</td>
  //                            <td>{$row['email']}</td>
  //                            <td>{$row['mobile']}</td>
  //                            <td>{$row['dob']}</td>
  //                            <td>{$row['gender']}</td>
                                
  //                            <td> <img src='images/'{$row['image']}'' height='50px'> </td>
  //                            <td><button type='button' class='edit' data-id=''{$row['id']}''>Edit</button></td>
  //                        </tr>";
  //           }
  //           // echo $output;

  //           $sql = "SELECT * FROM `modal`";
  //           // echo $sql;

  //           $records = mysqli_query($conn, $sql);

  //           $totalRecords = mysqli_num_rows($records);

  //           $totalPage = ceil($totalRecords / $limit);

  //           $pagination = "<ul class='pagination justify-content-center' style='margin:20px 0'>";

  //           for ($i = 1; $i <= $totalPage; $i++) {
  //               if ($i == $page_no) {
  //                   $active = "active";
  //               } else {
  //                   $active = "";
  //               }

  //               $pagination .= "<li class='page-item $active'><a class='page-link' id='$i' href=''>$i</a></li>";
  //           }

  //           $pagination .= "</ul>";

  //           // echo $output;
  //           $resopnse = ['status' => true, 'data' => $output, 'pagination' => $pagination];
  //           echo json_encode($resopnse);
  //       }
----------------------------
$output .= "<tr>
                <td><input type='checkbox' value=''{$row['id']}''></td>
                <td>{$row['id']}</td>
                <td> {$row['firstname']}  {$row['lastname']}</td>
                <td>{$row['email']}</td>
                <td>{$row['mobile']}</td>
                <td>{$row['dob']}</td>
                <td>{$row['gender']}</td>
                <td class='image'><img src='images/{$row['image']}' class='img-thumbnail' alt='no img' width='100px' height='90px'></td>
                <td><button type='button' class='edit' data-id=''{$row['id']}''>Edit</button></td>
         </tr>";