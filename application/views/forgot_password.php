<h2>Forgot your password?</h2>
<p>Enter your email address, and we'll send you a new one.</p>
<?php echo @$output ?>
<form action="/login/forgot" method="post">
    <label for="email">Email Address:</label>
    <input type="text" size="20" name="email" /><br/>
    <input type="submit" value="Submit" />
</form>