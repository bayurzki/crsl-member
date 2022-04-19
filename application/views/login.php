<html>
    <head>
        <title>Form Login Tanpa Social Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="shortcut icon" href="<?php echo base_url() ?>assets/login_assets/img/logo.png"/>
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/login_assets/css/menu.css"/>
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/login_assets/css/main.css"/>
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/login_assets/css/bgimg.css"/>
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/login_assets/css/bgimg-nosocial.css"/>
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/login_assets/css/font.css"/>
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/login_assets/css/font-awesome.min.css"/>
        
    </head>
<body>
    
    <div class="background"></div>
    <div class="backdrop"></div>
    <div class="login-form-container" id="login-form">
        <div class="login-form-content">
            <div class="login-form-header">
                <div class="logo">
                    <img src="<?php echo base_url() ?>assets/login_assets/img/logo.png"/>
                </div>
                <h3>Login ke akun Anda</h3>
            </div>
            <form method="post" action="<?php echo base_url('login');?>" class="login-form">
                <div class="input-container">
                    <i class="fa fa-envelope"></i>
                    <input type="text" class="input" name="username" placeholder="Username"/>
                </div>
                <div class="input-container">
                    <i class="fa fa-lock"></i>
                    <input type="password"  id="login-password" class="input" name="password" placeholder="Password"/>
                    <i id="show-password" class="fa fa-eye"></i>
                    <input type="hidden" name="last_login" value="<?php date_default_timezone_set('Asia/Jakarta');
                    $date = date('Y-m-d h:i:s'); echo $date; ?>">
                </div>
                <div class="rememberme-container">
                    <input type="checkbox" name="rememberme" id="rememberme"/>
                    <label for="rememberme" class="rememberme"><span>Biarkan tetap masuk</span></label>
                    <a class="forgot-password" href="#">Lupa Password?</a>
                </div>
                <input type="submit" name="login" value="Login" class="button"/>
                <a href="#" class="register">Register</a>
            </form>
            <!-- <div class="resend-activation">
                Sudah terdaftar tapi belum menerima link aktivasi?<br/>
                <a href="#">Kirim ulang link aktivasi</a>
            </div> -->
        </div>
        <div class="attibution">
            &copy; Clearance Card
        </div>
    </div>
</body>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/login_assets/js/jquery-1.12.4.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/login_assets/js/main.js"></script>
</html>
            