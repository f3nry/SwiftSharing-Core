<link href="/content/css/login.css" rel="stylesheet" type="text/css"/>
<div id="login_join_form">
    <?php if (@$message): ?>
        <p style="color:red;"><?php echo $message ?></p>
    <?php endif; ?>
        <form action="/login/facebook" method="post" enctype="multipart/form-data" name="signinform" id="signinform">
            <p><b>You are trying to login to this account, using Facebook. Please confirm with your password.</b></p>
            <table style="width:300px;margin-left:auto;margin-right:auto;">
                <tr>
                    <td width="13%" rowspan="2"><div style=" height:50px; overflow:hidden;"><a href="/<?php echo $member->username ?>" target="_self"><?php echo $member->getProfileImage() ?></a></div></td>
                </tr>
                <tr>
                    <td width="14%" class="style7"><div align="right">Name:</div></td>
                    <td width="73%"><a href="/<?php echo $member->username ?>" target="_self"><?php echo $member->firstname . ' ' . $member->lastname ?></a> </td>
            </tr>
        </table>
        <p>
            <label for="password">Password:</label>
            <input name="pass" type="password" id="pass" maxlength="24"/>
        </p>
        <p>
            <label for="login">&nbsp;</label>
            <input type="submit" value="Confirm" name="login"/>
        </p>
    </form>
</div>
<script src="/content/js/login.js" type="text/javascript"></script>