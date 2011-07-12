<style type="text/css">
    label {
        font-weight: bold;
        font-size: 1.1em;
    }
    
    div.heading {
        font-size: 18px;
        font-weight: bold;
        padding: 10px 0 3px 0;
        border-bottom: 1px #BFBFBF solid;
        margin-bottom: 8px;
    }

    div.item {
        clear: both;
        font-size: 14px;
        padding: 10px 0 3px 0;
        border-bottom: 1px black solid;
    }

    div.i_img {
        float: left;
        width: 51px;
        margin-right: 10px;
    }

    div.i_img img {
        padding: 2px;
        border: 1px #999999 solid;
    }

    div.i_con {
        float: left;
        width: 391px;
    }

    div.i_icn {
        float: left;
        width: 57px;
        margin-left: 10px;
    }

    #header {
        margin-left: 0px;
        text-align: left;
        width: 948px;
    }
    #right {
        float:right;
        background-color:white;
        width:255px;
        height:670px;
        -moz-border-radius: 20px;
        -webkit-border-radius: 20px;
        -khtml-border-radius: 20px;
        margin-right:25px;
    }
    .info {
        text-align:center;

    }

</style>

<div class="heading">
    Register or <a href="/login">Login</a>
</div>
<div id="items">
    <?php if(!empty($errors)): ?>
        <?php foreach($errors as $error) :?>
            <p class="error"><?php echo $error ?></p>
        <?php endforeach; ?>
    <?php endif; ?>
    <form method="post" action="/register" id="registration">
        <label>username</label>
        <span>
            <input type="text" name="username" id="username" class="title validate[required,custom[onlyLetterNumber],maxSize[30],ajax[ajaxUsernameCall]]" value="<?php echo @$data['username'] ?>"/>
        </span>
        
        <label>first name</label>
        <span>
            <input type="text" name="first_name" id="first_name" class="title validate[required,maxSize[80]]" value="<?php echo @$data['first_name'] ?>"/>
        </span>
        
        <label>last name</label>
        <span>
            <input type="text" name="last_name" id="last_name" class="title validate[required,maxSize[80]]" value="<?php echo @$data['last_name'] ?>"/>
        </span>
        
        <label>email</label>
        <span>
            <input type="text" name="email" id="email" class="title validate[required,custom[email],ajax[ajaxEmailCall]]" value="<?php echo @$data['email'] ?>"/>
        </span>
        
        <label>password</label>
        <span>
            <input type="password" name="password" id="password" class="title validate[required,minSize[4],maxSize[16]]" />
        </span>
        
        <label>confirm password</label>
        <span>
            <input type="password" name="confirm_password" id="confirm_password" class="title validate[required,equals[password]]"/>
        </span>
        
        <label>birthday</label>
        <span>
            <input type="text" name="birthday" id="birthday" class="title validate[required]" value="<?php echo @$data['birthday'] ?>"/>
        </span>

        <div id="gender_radios" style="font-size:1.1em">
            <input type="radio" name="gender" id="gender1" value="m" <?php if(@$data['gender'] == "m"): ?>selected="selected"<?php endif; ?>/><label for="gender1">Male</label>
            <input type="radio" name="gender" id="gender2" value="f" <?php if(@$data['gender'] == "f"): ?>selected="selected"<?php endif; ?>/><label for="gender2">Female</label>
        </div>
        <br/>
        <?php echo $recaptcha ?>
        
        <br/><input type="submit" value="Join Now!" style="font-size:1.5em"/>
    </form>
</div>
</div>
<div id="right">
    <div class="info">
        <h1>Why Join?</h1>
        <h2>Share Activites<img src="content/images/share.jpg" style="margin-left:5px;"></img></h2>
        <p>Share the things that matter to you in one of the default feeds. Music, TV, Movies, Thoughts, Photos, Videos, Reading, Games, and Location.
        <h2>Find Friends<img src="content/images/friends.png" style="margin-left:5px;"></img></h2>
        <p>Find friends from your High School, College, or Work. There are thousands of networks within SwiftSharing.</p>
        <h2>Customization<img src="content/images/settings.png"></img></h2>
        <p>Add a photo of yourself, a background image to your profile, and music to show people the type of person you are.</p>
    </div>
</div>
</div>
<link rel="stylesheet" href="/content/css/validationEngine.jquery.css" type="text/css" />
<script type="text/javascript" src="/content/js/languages/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="/content/js/jquery.validationEngine.js"></script>
<script type="text/javascript">
    $("#registration").validationEngine({ 
        promptPosition: "centerRight" 
    });
    
    $("#birthday").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "mm/dd/yy",
        minDate: (new Date(1940, 1, 1)),
        maxDate: "-13Y",
        "yearRange": "1940:1997",
        showAnim: "fade"
    });
    
    $("#gender_radios").buttonset();
</script>