<?php
$message='';
function truncateAllTables($conn, $dbname) {
    // Fetch all tables in the database
    $result = $conn->query("SHOW TABLES");
    if (!$result) {
        die("Error fetching tables: " . $conn->error);
    }

    // Loop through each table and truncate it
    while ($row = $result->fetch_array()) {
        $table = $row[0];
        $truncateQuery = "DROP TABLE $table";
        if ($conn->query($truncateQuery) === FALSE) {
            // echo "Error truncating table $table: " . $conn->error . "\n";
        } else {
            // echo "Truncated table $table successfully.\n";
        }
    }
}
// Database configuration
if (isset($_POST['username']) &&
isset($_POST['password']) &&
isset($_POST['name'])){


    $servername = "localhost";
    $username = $_POST['username'];
    $password = $_POST['password'];
    $dbname = $_POST['name']; // Change this to your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        $message = ("Connection failed: " . $conn->connect_error);
        goto end;
    }

    // Path to your SQL file
    $sqlFile = 'fyp.sql';

    // Read the SQL file content
    $sql = file_get_contents($sqlFile);

    // Check if the file was read successfully
    if ($sql === false) {
        $message = ("Error reading the SQL file.");
        goto end;
    }
    truncateAllTables($conn, $dbname);
    // die();

    // Split the SQL file into individual queries (assuming each query is separated by a semicolon)
    $queries = explode(";", $sql);
    
    // Execute each query individually
    foreach ($queries as $query) {
        $query = trim($query);
        if (!empty($query)) {
            // $query .= ';';
            // $query = str_replace("\n", " ", $query);
            // echo $query."\n";
            if ($conn->query($query) === FALSE) {
                $message =  "Error executing query: " . $conn->error . "\n";
                goto end;
            }
        }
    }

    unlink('install');
    file_put_contents('../.env', 'APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:xeHFmyye9t5CkYj/C++JwXuHRmuJFuDsy9gzT0zNgvA=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE="'.$dbname.'"
DB_USERNAME="'.$username.'"
DB_PASSWORD="'.$password.'"

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
');

    $message = "Database file imported successfully.<br> Admin Details <br> Email: superadmin@gmail.com <br> Password: password";

    // Close the connection
    $conn->close();

}
end:
?>
<!-- Session Status -->

<!DOCTYPE html>
<html lang="en"
    dir="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="WorkDo.io" />

    <meta name="title" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="http://localhost">
    <meta property="og:title" content="">
    <meta property="og:description" content=" ">
    <meta property="og:image" content="?1735131787">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="http://localhost">
    <meta property="twitter:title" content="">
    <meta property="twitter:description" content=" ">
    <meta property="twitter:image" content="?1735131787">

    <meta name="csrf-token" content="mVsphGUB1XuGOYhDnvZB9BYkFtsccPY6MceVb0Xy">

    <title>Laravel-    Login
</title>

    <!-- Favicon icon -->
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/fonts/tabler-icons.min.css">
    <link rel="stylesheet" href="/assets/fonts/feather.css">
    <link rel="stylesheet" href="/assets/fonts/fontawesome.css">
    <link rel="stylesheet" href="/assets/fonts/material.css">

    <!-- vendor css -->
        <!-- <link rel="stylesheet" href="/assets/css/style-dark.css" id="main-style-link"> -->
        <link rel="stylesheet" href="/assets/css/style-rtl.css" id="main-style-link">
        <link rel="stylesheet" href="/css/rtl-loader.css?v=1735131787">
        <!-- <link rel="stylesheet" href="/assets/css/style-dark.css" id="main-style-link"> -->
        <link rel="stylesheet" href="/css/loader.css?v=1735131787">
        <link rel="stylesheet" href="/assets/css/style-rtl.css" id="main-style-link">
        <link rel="stylesheet" href="/css/rtl-loader.css?v=1735131787">
        <link rel="stylesheet" href="/assets/css/style.css" id="main-style-link">
        <link rel="stylesheet" href="/css/loader.css?v=1735131787">
    <link rel="stylesheet" href="/assets/css/style.css" id="main-style-link">

    <!-- Scripts -->
    <link rel="stylesheet" href="/assets/css/customizer.css">

    <link rel="stylesheet" href="/css/custom.css?v=1735131787">
    <link rel="stylesheet" href="/css/custom-color.css">

    <style>
        :root {
            --color-customColor: ;
        }
    </style>
    <style>
        .lnding-menubar {
            display: flex;
            align-items: center;
            color: #000000;
        }

        .lnding-menubar li {
            list-style-type: none;

        }

        .lnding-menubar li a {
            color: #000000;
            text-transform: capitalize;
        }

        .lnding-menubar li.has-item>a {
            padding-right: 20px;
        }

        .lnding-menubar li.has-item .menu-dropdown {
            position: absolute;
            top: 100%;
            background-color: #ffffff;
            transform-origin: top;
            box-shadow: 0px 10px 40px rgb(0 0 0 / 5%);
            opacity: 0;
            visibility: hidden;
            min-width: 220px;
            z-index: 2;
            padding: 20px;
            -moz-transition: all ease-in-out 0.3s;
            -ms-transition: all ease-in-out 0.3s;
            -o-transition: all ease-in-out 0.3s;
            -webkit-transition: all ease-in-out 0.3s;
            transition: all ease-in-out 0.3s;
            -moz-transform: scaleY(0);
            -ms-transform: scaleY(0);
            -o-transform: scaleY(0);
            -webkit-transform: scaleY(0);
            transform: scaleY(0);
        }
        .lnding-menubar li.has-item:hover .menu-dropdown {
            opacity: 1;
            visibility: visible;
            -webkit-transform: scaleY(1);
            -moz-transform: scaleY(1);
            -ms-transform: scaleY(1);
            -o-transform: scaleY(1);
            transform: scaleY(1);
        }

        .lnding-menubar li.has-item .menu-dropdown li.lnk-itm>.dropdown-item {
            margin-bottom: 7px;
        }

        .lnding-menubar li.has-item .menu-dropdown li.lnk-itm:not(:last-of-type) {
            margin-bottom: 15px;
        }

        .lnding-menubar li.has-item .menu-dropdown li.lnk-itm .lnk-child li:not(:last-of-type) {
            margin-bottom: 10px;
        }

        .lnding-menubar li.has-item .menu-dropdown li.lnk-itm .lnk-child li {
            list-style-type: disc;
        }
    </style>
</head>

<body class="" style="background-image: url('/front/img/carousel-1.jpg') !important;background-size: cover !important;" >

    <div class="register-page auth-wrapper auth-v3">
        <!-- <div class="login-back-img">
            <img src="/assets/images/auth/img-bg-1.svg" alt="" class="img-fluid login-bg-1" />
            <img src="/assets/images/auth/img-bg-2.svg" alt="" class="img-fluid login-bg-2" />
            <img src="/assets/images/auth/img-bg-3.svg" alt="" class="img-fluid login-bg-3" />
            <img src="/assets/images/auth/img-bg-4.svg" alt="" class="img-fluid login-bg-4" />
        </div> -->
        <div class="bg-auth-side bg-primary login-page"></div>
        <div class="auth-content">
            <nav class="navbar navbar-expand-md navbar-light default">
                <div class="container-fluid pe-2">

                    <a class="navbar-brand" href="">
                        <img src="/storage/uploads/logo/logo-light.png"
                            alt="logo" class="brand_icon" />
                    </a>

                    
                </div>
            </nav>
            <div class="card">
                <div class="row align-items-center justify-content-center text-start">
                    <div class="col-xl-12">
                        <div class="card-body mx-auto my-4 new-login-design">
                                <div class="">
        <h2 class="mb-3 f-w-600">Install</h2>
    </div>
    <div class="">
        <!-- Session Status -->
        

        <!-- Validation Errors -->
        <?php
        echo $message

        ?>
        <?php
        if ($message == ''){
        ?>
        <form method="POST" action="" id="form_data">
            <input type="hidden" name="_token" value="mVsphGUB1XuGOYhDnvZB9BYkFtsccPY6MceVb0Xy" autocomplete="off">       <div class="form-group mb-3">
                <label class="form-label">Database Name</label>
                <input id="name" class="form-control" type="name" name="name"  placeholder="Database Name" required
                    autofocus />
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Database UserName</label>
                <input id="username" class="form-control" type="username" name="username"  placeholder="Database UserName" required
                    autofocus />
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Database Password</label>
                <input id="password" class="form-control" type="password" name="password" 
                    autocomplete="current-password" placeholder="Database Password"/>
            </div>

            
            <div class="d-grid">
                
                <button class="btn btn-primary btn-block mt-2 login_button" type="submit"> Install Now </button>
            </div>
            
            
            
        </form>
    <?php } ?>
    </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="auth-footer">
                <div class="container-fluid text-center">
                    <div class="row">
                        <div class="col-12">
                            <p class="text-black">
                                                                    &copy;
                                
                                2024
                                
                            </p>
                        </div>
                        <div class="col-6 text-end">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="loader" class="loader-wrapper" style="display: none;">
        <span class="site-loader"> </span>
        <h3 class="loader-content"> Loading . . . </h3>
    </div>
    
    
</body>

</html>
