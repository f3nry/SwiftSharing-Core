<style type="text/css">

    div.heading {
        font-size: 14px;
        font-weight: bold;
        padding: 10px 0 3px 0;
        border-bottom: 1px black dotted;
    }

    div.item {
        clear: both;
        font-size: 14px;
        padding: 10px 0 3px 0;
        border-bottom: 1px black dotted;
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
    Register
</div>
<div id="items">
    <table class="mainBodyTable" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td width="738" valign="top">


                <table width="580" align="center" cellpadding="8" cellspacing="1">
                    <form action="/register" method="post">
                        <tr>
                            <td colspan="2">
                                <font color="#FF0000">
                                    <?php if (isset($errors)): ?>
                                    <?php foreach ($errors as $error): ?>
                                    <?php echo $error ?><br/>
                                    <?php endforeach; ?>
                                            <br/>
                                    <?php endif; ?>
                                        </font>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="130" bgcolor="#FFFFFF">User Name<span class="brightRed"></td>
                                    <td width="402" bgcolor="#FFFFFF"><input name="username" type="text" class="formFields" id="username"
                                                                             value="<?php echo @$data['username'] ?>" size="32" maxlength="20"/>
                                        <span id="nameresponse"><span class="textSize_9px"><span
                                                    class="greyColor">Alphanumeric Characters Only</span></span></span></td>
                                </tr>
                                <tr>
                                    <td bgcolor="#EFEFEF">First Name</td>
                                    <td bgcolor="#EFEFEF"><input name="firstname" type="text" class="formFields" id="firstname" value="<?php echo @$data['firstname'] ?>"
                                               size="32"
                                               maxlength="20"/></td>
                                </tr>
                                <tr>
                                    <td>Last Name</td>
                                    <td><input name="lastname" type="text" class="formFields" id="lastname" value="<?php echo @$data['lastname'] ?>"
                                               size="32"
                                               maxlength="20"/></td>
                                </tr>
                                <tr>
                                    <td bgcolor="#EFEFEF">Gender<span class="brightRed"></td>
                                    <td bgcolor="#EFEFEF"><label>
                                            <input type="radio" name="gender" id="gender" value="m" <?php
                                            if (@$data['gender'] == 'm') {
                                                echo "selected=\"selected\"";
                                            }
                                    ?>/>Male &nbsp;
                                            <input type="radio" name="gender" id="gender" value="f" <?php
                                            if (@$data['gender'] == 'f') {
                                                echo "selected=\"selected\"";
                                            }
                                    ?>/>Female
                                 </label></td>
                         </tr>
                         <tr>
                             <td bgcolor="#FFFFFF">Date of Birth <span class="brightRed"></td>
                             <td bgcolor="#FFFFFF">
                                 <select name="birth_month" class="formFields" id="birth_month">
                                     <option value="<?php echo $data['birth_month'] ?>"><?php echo $data['birth_month_text'] ?></option>
                                     <option value="01">January</option>
                                     <option value="02">February</option>
                                     <option value="03">March</option>
                                     <option value="04">April</option>
                                     <option value="05">May</option>
                                     <option value="06">June</option>
                                     <option value="07">July</option>
                                     <option value="08">August</option>
                                     <option value="09">September</option>
                                     <option value="10">October</option>
                                     <option value="11">November</option>
                                     <option value="12">December</option>
                                 </select>
                                 <select name="birth_day" class="formFields" id="birth_day">
                                     <option value="<?php echo $data['birth_date'] ?>"><?php echo $data['birth_date'] ?></option>
                                     <option value="01">1</option>
                                     <option value="02">2</option>
                                     <option value="03">3</option>
                                     <option value="04">4</option>
                                     <option value="05">5</option>
                                     <option value="06">6</option>
                                     <option value="07">7</option>
                                     <option value="08">8</option>
                                     <option value="09">9</option>
                                     <option value="10">10</option>
                                     <option value="11">11</option>
                                     <option value="12">12</option>
                                     <option value="13">13</option>
                                     <option value="14">14</option>
                                     <option value="15">15</option>
                                     <option value="16">16</option>
                                     <option value="17">17</option>
                                     <option value="18">18</option>
                                     <option value="19">19</option>
                                     <option value="20">20</option>
                                     <option value="21">21</option>
                                     <option value="22">22</option>
                                     <option value="23">23</option>
                                     <option value="24">24</option>
                                     <option value="25">25</option>
                                     <option value="26">26</option>
                                     <option value="27">27</option>
                                     <option value="28">28</option>
                                     <option value="29">29</option>
                                     <option value="30">30</option>
                                     <option value="31">31</option>
                                 </select>
                                 <select name="birth_year" class="formFields" id="birth_year">
                                     <option value="<?php echo $data['birth_year'] ?>"><?php echo $data['birth_year'] ?></option>
                                     <option value="2010">2010</option>
                                     <option value="2009">2009</option>
                                     <option value="2008">2008</option>
                                     <option value="2007">2007</option>
                                     <option value="2006">2006</option>
                                     <option value="2005">2005</option>
                                     <option value="2004">2004</option>
                                     <option value="2003">2003</option>
                                     <option value="2002">2002</option>
                                     <option value="2001">2001</option>
                                     <option value="2000">2000</option>
                                     <option value="1999">1999</option>
                                     <option value="1998">1998</option>
                                     <option value="1997">1997</option>
                                     <option value="1996">1996</option>
                                     <option value="1995">1995</option>
                                     <option value="1994">1994</option>
                                     <option value="1993">1993</option>
                                     <option value="1992">1992</option>
                                     <option value="1991">1991</option>
                                     <option value="1990">1990</option>
                                     <option value="1989">1989</option>
                                     <option value="1988">1988</option>
                                     <option value="1987">1987</option>
                                     <option value="1986">1986</option>
                                     <option value="1985">1985</option>
                                     <option value="1984">1984</option>
                                     <option value="1983">1983</option>
                                     <option value="1982">1982</option>
                                     <option value="1981">1981</option>
                                     <option value="1980">1980</option>
                                     <option value="1979">1979</option>
                                     <option value="1978">1978</option>
                                     <option value="1977">1977</option>
                                     <option value="1976">1976</option>
                                     <option value="1975">1975</option>
                                     <option value="1974">1974</option>
                                     <option value="1973">1973</option>
                                     <option value="1972">1972</option>
                                     <option value="1971">1971</option>
                                     <option value="1970">1970</option>
                                     <option value="1969">1969</option>
                                     <option value="1968">1968</option>
                                     <option value="1967">1967</option>
                                     <option value="1966">1966</option>
                                     <option value="1965">1965</option>
                                     <option value="1964">1964</option>
                                     <option value="1963">1963</option>
                                     <option value="1962">1962</option>
                                     <option value="1961">1961</option>
                                     <option value="1960">1960</option>
                                     <option value="1959">1959</option>
                                     <option value="1958">1958</option>
                                     <option value="1957">1957</option>
                                     <option value="1956">1956</option>
                                     <option value="1955">1955</option>
                                     <option value="1954">1954</option>
                                     <option value="1953">1953</option>
                                     <option value="1952">1952</option>
                                     <option value="1951">1951</option>
                                     <option value="1950">1950</option>
                                     <option value="1949">1949</option>
                                     <option value="1948">1948</option>
                                     <option value="1947">1947</option>
                                     <option value="1946">1946</option>
                                     <option value="1945">1945</option>
                                     <option value="1944">1944</option>
                                     <option value="1943">1943</option>
                                     <option value="1942">1942</option>
                                     <option value="1941">1941</option>
                                     <option value="1940">1940</option>
                                     <option value="1939">1939</option>
                                     <option value="1938">1938</option>
                                     <option value="1937">1937</option>
                                     <option value="1936">1936</option>
                                     <option value="1935">1935</option>
                                     <option value="1934">1934</option>
                                     <option value="1933">1933</option>
                                     <option value="1932">1932</option>
                                     <option value="1931">1931</option>
                                     <option value="1930">1930</option>
                                     <option value="1929">1929</option>
                                     <option value="1928">1928</option>
                                     <option value="1927">1927</option>
                                     <option value="1926">1926</option>
                                     <option value="1925">1925</option>
                                     <option value="1924">1924</option>
                                     <option value="1923">1923</option>
                                     <option value="1922">1922</option>
                                     <option value="1921">1921</option>
                                     <option value="1920">1920</option>
                                     <option value="1919">1919</option>
                                     <option value="1918">1918</option>
                                     <option value="1917">1917</option>
                                     <option value="1916">1916</option>
                                     <option value="1915">1915</option>
                                     <option value="1914">1914</option>
                                     <option value="1913">1913</option>
                                     <option value="1912">1912</option>
                                     <option value="1911">1911</option>
                                     <option value="1910">1910</option>
                                     <option value="1909">1909</option>
                                     <option value="1908">1908</option>
                                     <option value="1907">1907</option>
                                     <option value="1906">1906</option>
                                     <option value="1905">1905</option>
                                     <option value="1904">1904</option>
                                     <option value="1903">1903</option>
                                     <option value="1902">1902</option>
                                     <option value="1901">1901</option>
                                     <option value="1900">1900</option>
                                 </select>
                         </tr>
                         <tr>
                             <td bgcolor="#EFEFEF">Email Address <span class="brightRed"</td>
                             <td bgcolor="#EFEFEF"><input name="email1" type="text" class="formFields" id="email1"
                                                          value="<?php echo @$data['email1'] ?>" size="32" maxlength="48"/></td>
                         </tr>
                         <tr>
                             <td bgcolor="#FFFFFF">Confirm Email<span class="brightRed"></td>
                             <td bgcolor="#FFFFFF"><input name="email2" type="text" class="formFields" id="email2"
                                                          value="<?php echo @$data['email2'] ?>" size="32" maxlength="48"/></td>
                        </tr>
                        <tr>
                            <td bgcolor="#EFEFEF">Create Password<span class="brightRed"></td>
                            <td bgcolor="#EFEFEF"><input name="pass1" type="password" class="formFields" id="pass1" size="32" maxlength="16"/>
                                <span class="textSize_9px"><span class="greyColor">Alphanumeric Characters Only</span></span></td>
                        </tr>
                        <tr>
                            <td bgcolor="#FFFFFF">Confirm Password<span class="brightRed"> *</span></td>
                            <td bgcolor="#FFFFFF"><input name="pass2" type="password" class="formFields" id="pass2" size="32" maxlength="16"/>
                                <span class="textSize_9px"><span class="greyColor">Alphanumeric Characters Only</span></span></td>
                        </tr>
                        <tr>
                            <td bgcolor="#EFEFEF">Human Check <span class="brightRed">*</span></td>
                            <td bgcolor="#EFEFEF"><input name="humancheck" type="text" class="formFields" id="humancheck"
                                                         value="Please remove all of this text" size="32" maxlength="32"/>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#FFFFFF">Network <span class="brightRed"></td>
                            <td bgcolor="#FFFFFF"><input name="network" type="text" class="formFields" id="network" size="32" />
                                <span class="textSize_9px"><span class="greyColor">Enter a College or High School</span></span>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#FFFFFF">&nbsp;</td>
                            <td bgcolor="#FFFFFF"><p><br/>
                                    <input type="submit" name="Submit" value="Sign Up!"/>
                                </p></td>
                        </tr>
                    </form>
                </table>
                <br/>
                <br/></td>
            <td width="160" valign="top"></td>
        </tr>
    </table>

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