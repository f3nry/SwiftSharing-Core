<link href="/content/css/login.css" rel="stylesheet" type="text/css"/>
<div id="login_join_form">
    <?php if(@$message): ?>
        <p style="color:red;"><?php echo $message ?></p>
    <?php endif; ?>
    <form action="/admin/login" method="post" enctype="multipart/form-data" name="signinform" id="signinform">
        <p>
            <label for="email">Email:</label>
            <input name="email" type="text" id="email" value="<?php echo @$email ?>"/>
        </p>

        <p>
            <label for="password">Password:</label>
            <input name="pass" type="password" id="pass" maxlength="24"/>
        </p>

        <p>
            <label for="remember_me">Remember Me:</label>
            <input type="checkbox" name="remember_me" value="true" checked/>
        </p>

        <p>
            <label for="login">&nbsp;</label>
            <input type="submit" value="Login" name="login"/>
        </p>
    </form>
</div>