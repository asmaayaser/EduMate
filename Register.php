<?php 
require 'connect.php';
function checkItem ($select, $from, $value) {
    global $con; 
    $stmt = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
    $stmt->execute(array($value));
    $count = $stmt->rowCount();
    return $count;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/all.min.css">
    <link rel="stylesheet" href="./css/Style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,700;1,400&display=swap"
        rel="stylesheet">
    <title>Register</title>
</head>

<body>
    <div class="login_page d-flex align-items-center justify-content-center">
        <div class="container">
            <form method="post" action="" enctype="multipart/form-data" class="register_form">
                <h2>Register</h2>
                <?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['sign'])) {
        $choice   = $_POST['flexRadioDefault'];
        $name = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
        $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
        $email    = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
        $job      = filter_var($_POST['job'],FILTER_SANITIZE_STRING);
        $star       = filter_var($_POST['stars'], FILTER_SANITIZE_NUMBER_INT);
        $imgNam  = $_FILES['imag']['name'];
        $imgSiz  = $_FILES['imag']['size'];
        $imgTm	  = $_FILES['imag']['tmp_name'];
        $imgTyp  = $_FILES['imag']['type'];
        // List Of Allowed File Typed To Upload
        $imgAllowedExtensio = array("jpg", "png", "gif","jpeg");
        // Get Avatar Extension
        $imgsx = explode('.', $imgNam);
        $imgExtensio = strtolower(end($imgsx));
        if (! empty($imgNam) && ! in_array($imgExtensio, $imgAllowedExtensio)) {
            $formErrors[] = 'image extensions is not available';
        }
        $imgx = rand(0, 100000) . '_' . $imgNam;
        if($choice == 'head'){
        $uploads_dirx = 'heads/uploads';}
        if($choice == 'membr'){
            $uploads_dirx = 'members/uploads';}
        move_uploaded_file($imgTm, "$uploads_dirx/$imgx");
        if (empty($name)) {
            $formErrors[] = 'please entre the name';
        }
        if (isset($password)) {
            if (strlen($password) < 6) {$formErrors[] = 'password must be greater than 6 characters or numbers';}
        }else{
            $formErrors[] = 'please entre the password';
        }
        if (empty($email)) {
            $formErrors[] = 'please entre the email';
        }
        if (empty($job)) {
            $formErrors[] = 'please entre the job';
        }
        if (empty($formErrors)) {
            if($choice == 'head'){
            $check = checkItem("email", "heads", $email);
            if ($check == 1) {
            echo '
            <div class="alert alert-danger text-center alert-dismissible fade show text-light" role="alert">
            this email already exists, use another one
            </div>
        ';
        }
        else {
            // Insert Userinfo In Database
            $stmt = $con->prepare("INSERT INTO 
                        heads(name, photo, 	phoneNum, email, password, committe_id)
                        VALUES(:zuser, :zimg, :zphone, :zemail, :zpass, :zcom)");
            $stmt->execute(array(
                'zuser'     => $name,
                'zimg'      => $imgx,
                'zphone'    => $job,
                'zemail'    => $email,
                'zpass'     => sha1($password),
                'zcom'      => $star
                
            ));
            header('Location: login.php');
            exit();
        }
    }elseif($choice == 'membr'){
        $check = checkItem("email", "users", $email);
        if ($check == 1) {
        echo '
        <div class="alert alert-danger text-center alert-dismissible fade show text-light" role="alert">
        this email already exists, use another one
        </div>
    ';
    }
    else {
        // Insert Userinfo In Database
        $stmt = $con->prepare("INSERT INTO 
                    users(name, email, password, photo, phone, committe_id)
                    VALUES(:zuser, :zemail, :zpass, :zimg, :zphone, :zcom)");
        $stmt->execute(array(
            'zuser'     => $name,
            'zemail'    => $email,
            'zpass'     => sha1($password),
            'zimg'      => $imgx,
            'zphone'    => $job,
            'zcom'      => $star
            
        ));
        header('Location: login.php');
        exit();
    }
}
    } else {
        foreach ($formErrors as $error) {
            echo '
                <div class="alert alert-danger text-center alert-dismissible fade show text-light" role="alert">
                ' . $error . '
                </div>
            ';
        }
    }
}
}
?>
                <div class="row">
                    <div class="group-one col">
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" id="username" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                    </div>
                    <div class="group-two col">
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="job">Phone:</label>
                            <input type="text" id="job" name="job" class="form-control" required>
                        </div>
                    </div>
                    <div class="group-three col">
                        <div class="form-group col-md-6">
                            <label>committe</label>
                            <select class="custom-select mr-sm-2" name="stars" id="inlineFormCustomSelect">
                            <?php
                                $select = $con->prepare('select * from committes');
                                $select->execute();
                                $stars = $select->fetchAll();
                                foreach($stars as $stars){
                                    echo '<option value="'.$stars['id'].'">'.$stars['name'].'</option>';
                                }
                            ?>
                            </select>
                        </div> 
                        <div class="form-group">
                            <label>photo</label>
                            <input name="imag" type="file" id="formFile" class="form-control" >
                        </div>
                    </div>
                    <div class="Position-reg mt-3 mb-3 col">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" value="head" id="flexRadioDefault2" checked>
                            <label class="form-check-label" for="flexRadioDefault2">Head</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" value="membr" id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault3">Member</label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" name="sign">Register</button>
                <div class="form-group">
                    <p class="text-center">Already have an account? <a href="./Login.php">Login</a></p>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
