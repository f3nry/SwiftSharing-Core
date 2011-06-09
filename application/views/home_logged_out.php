<div id="wrapper">
    <div id="middle">
        <div class="left">
            <img src="/content/images/face.jpg"></img>
        </div>
        <div id="right_half">
            <div id="login_join_form">
                <?php if (@$message): ?>
                    <p style="color:red;"><?php echo $message ?></p>
                <?php endif; ?>
                <form action="/login" method="post" enctype="multipart/form-data" name="signinform" id="signinform">
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
                        <label style="width:152px;"><fb:login-button on-login="facebookLogin()" perms="email,publish_stream">Login with Facebook</fb:login-button></label>
                        <input type="submit" value="Login" name="login" id="submit"/>
                        <div id="fb-root"></div>
                        <script src="http://connect.facebook.net/en_US/all.js"></script>
                        <script>
                            FB.init({
                            appId:'204162316278860', cookie:true,
                            status:true, xfbml:true
                        });
                        </script>
                    </p>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="fb">
            <h2 style="color:white;">Spread the Word</h2>
            <p>SwiftSharing is a growing social network. It allows you to share what YOU want, in a way you'd like to. Share what you're listening to in Music, and what you're thinking in thoughts.</p>
        	<h2 style="color:white;">Tell Your Friends</h2>
        	<p>SwiftSharing is growing, fast. Tell everyone you know to join the site, so we can be the latest and greatest network of your friends!</p>
        	<h2 style="color:white;">Contact</h2>
        	<p>The Creators and Developers of SwiftSharing are always online. So, have a question? Ask!</p>
        </div>
        <div id="tweet">
            <object width="425" height="344"><param name="movie" value="http://www.youtube.com/v/Vsr3z5x8yNg?fs=1&hl=en_US&rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/Vsr3z5x8yNg?fs=1&hl=en_US&rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="446" height=300"></embed></object>
        </div>
    </div>
</div>
<script src="/content/js/login.js" type="text/javascript"></script>