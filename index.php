<?php
    include_once("template/header.php");// header template
    include_once("template/footer.php");// footer template
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>imageShare.com</title>

    <!-- bootstrap and jquery cdns start -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- bootstrap and jquery cdns end -->

    <!-- animate.stye cdn start -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- animate.stye cdn end -->
    
    <!-- material and fa fa icon cdn start -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- material and fa fa icon cdn end-->

    <!-- custom css link start -->
    <link rel="stylesheet" href="css/main.css?cache=<?php echo time();?>">
    <link rel="stylesheet" href="css/frame.css?cache=<?php echo time();?>">
    <!-- custom css link end -->

    <!-- custom js source start -->
    <script src="js/main.js?cache=<?php echo time(); ?>"></script>
    <!-- custom js source end -->
</head>
<body>

<div class="container-fluid p-0">
<?php
    echo $header;// header form header template
?>

<!-- content code start -->
    <div class="content">
        <div class="tagBar">
            <ul>
                <li><button>loading..</button></li>
                <li><button>loading..</button></li>
                <li><button>loading..</button></li>
            </ul>
        </div>
        <div class="page">
            <div class="container imageCon">
                <div class="row">

                </div>
            </div>
        </div>
    </div>
<!-- content code end -->

<?php
    echo $footer;// header form header template
?>

</div>

<!-- upload image modal start -->
    <div class="modal fade" id="uplodaImage">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body p-3">
                    <div class="uplodaCon">
                        <div>
                            <span class="btn material-icons close" target="#uplodaImage" data-dismiss="modal">close</span>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                            <h5 class="headFont mb-3">Upload Image</h5>
                                <form id="uploadForm" enctype="multipart/form-data" method="POST">
                                    <div class="formCon mb-3">
                                        <select name="imageGroup" class="form-control required" id="uGroup">
                                            <option value=" ">Select Group</option>
                                        </select>
                                    </div>

                                    <div class="formCon mb-3">
                                        <input type="text" placeholder="Image Name" class="required form-control" name="imageName" id="uImageName">
                                    </div>

                                    <div class="formCon mb-3">
                                        <input type="file" class="form-control required" name="image" id="uImage" accept="image/*">
                                    </div>

                                    <div class="imagePreview mb-3">
                                    </div>
                                    <div class="ualert mb-3">
                                    </div>

                                    <div class="linear-activity d-none uLoader">
                                        <div class="indeterminate"></div>
                                    </div>

                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary uploadBtn">Upload</button>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-5">
                                <h5 class="headFont mb-3">Create Image Group</h5>
                                <form id="createGroup" method="POST">
                                    <div class="formCon mb-3">
                                        <input type="text" class="form-control" name="group" required placeholder="group name">
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-success">Create Group</button>
                                    </div>
                                    <div class="groupAlert"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- upload image modal end -->

<!-- logging modal start -->
    <div class="modal fade" id="logModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal body -->
                <div class="modal-body">
                    <div>
                        <span class="btn material-icons close" target="#uplodaImage" data-dismiss="modal">close</span>
                    </div>
                    <div class="tabBtns btn-group">
                        <button class="loginTabBtn active" data="login">Login</button>
                        <button class="signinTabBtn" data="signin">Sign In</button>
                    </div>
                    <div class="tabCons mt-4">
                        <div class="loginCon">
                            <form enctype="multipart/form-data" method="get" id="loginForm">
                                <div class="from-group">
                                    <input type="text" class="form-control required" name="uname" id="lUname" placeholder="Username">
                                </div>

                                <div class="from-group mt-3 d-flex align-items-center">
                                    <input type="password" class="form-control required" name="pass" id="lPass" placeholder="Password">
                                    <span class="material-icons position-absolute btn p-0 showLogPass" style="right: 20px;cursor:pointer;" status="0">visibility</span>
                                </div>

                                <div class="text-right mt-3">
                                    <input type="submit" class="btn btn-primary" value="Login">
                                </div>
                            </form>
                        </div>
                        
                        <div class="signCon d-none">
                            <form enctype="multipart/form-data" method="post" id="signForm">
                                <div class="from-group">
                                    <input type="text" class="form-control required" name="name" id="name" placeholder="First Name">
                                </div>
                                <div class="from-group mt-3">
                                    <input type="text" class="form-control required" name="username" id="sUname" placeholder="Username">
                                </div>
                                <div class="from-group mt-3 d-flex align-items-center">
                                    <input type="password" class="form-control required" name="password" id="sPass" placeholder="Password">
                                    <span class="material-icons position-absolute btn p-0 showSignPass" style="right: 20px;cursor:pointer;" status="0">visibility</span>
                                </div>

                                <div class="text-right mt-3">
                                    <input type="submit" class="btn btn-primary" value="Sign Up">
                                </div>
                                <div class="signAlert"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- logging modal end -->

</body>
</html>