
<html>
<head>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form method="post" id="userRegister" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="fname"> First Name </label>
                        <input id="fname" name="fname" type="text" class="form-control">
                        <?php echo isset($error['fname']) ? $error['fname'] : ''; ?>
                    </div>
                    <div class="form-group">
                        <label for="lname">Last Name </label>
                        <input id="lname" name="lname" type="text" class="form-control">
                        <?php echo isset($error['lname']) ? $error['lname'] : ''; ?>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender : </label>
                        Male<input type="radio" value="Male" name="gender">
                        Female<input type="radio" value="Female" name="gender">
                        <?php echo isset($error['gender']) ? $error['gender'] : ''; ?>
                    </div>
                    <div class="form-group">
                        <label for="dob"> DOB </label>
                        <input id="dob" type="date" name="dob" class="form-control">
                        <?php echo isset($error['dob']) ? $error['dob'] : ''; ?>
                    </div>
                    <div class="form-group">
                        <label for="mob"> Mobile No. </label>
                        <input id="mob" type="text" name="mob" class="form-control">
                        <?php echo isset($error['mob']) ? $error['mob'] : ''; ?>
                    </div>
                    <div class="form-group">
                        <label for="hobi"> Hobbies </label>
                        <input type="text" name="hobi[0]" class="form-control"><input type="button" id="add" value="+">
                    </div>
                    <div id="hobbieDiv"></div>

                    <div class="form-group">
                        <label for="ima"> Image </label>
                        <input id="ima" type="file" name="ima" value="">
                        <?php echo isset($error['ima']) ? $error['ima'] : ''; ?>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

    <script>
        $(document).ready(function() {
           var numberIncr = 1; // used to increment name of the inputs
            $('#userRegister').validate({
                rules: {
                    fname: {
                        required: true,
                    },
                    lname: {
                        required: true,
                    },
                    gender: {
                        required: true,
                    },
                    dob: {
                        required: true,
                    },
                    mob: {
                        required: true,
                    },
                    'hobi[]': {
                        required: true,
                    }
                },

                messages: {
                    fname: '</br>Please enter First Name.',
                    lname: '</br>Please enter last Name.',
                    gender: '</br>Please your gender.',
                    dob: '</br>Please your Birth Date.',
                    mob: '</br>Please Enter your Mobile Number.',
                    'hobi[]': 'Enter Your Hobbie',

                },
                submitHandler: function(form) {
                    console.log('test');
                    // adding rules for inputs with class 'comment'
                    $('input.comment').each(function() {
                        $(this).rules("add", {
                            required: true
                        })
                    });
                    if ($('#userRegister').validate().form()) {
                        console.log("validate");
                        return true;
                    } else {
                        console.log("does not validate");
                        return false;
                    }
                    form.submit();
                }
            });
            $('#add').click(function() {
                $('#hobbieDiv').append(`<div><input type="text" class="form-control comment" name="hobi[${numberIncr}]" ><input type="button" id="remove" value="-"></div>`);
                numberIncr++;
            });
            $(document).on('click', '#remove', function() {
                $(this).parent('div').remove();
            });
        });
    </script>
    </body>
</html>