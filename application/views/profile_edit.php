<!--<table class="mainBodyTable" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td width="738" valign="top">
            <?php if (isset($success_msg)): ?>
                <p><?php echo $success_msg ?></p>
            <?php endif; ?>
                <h2>Profile Pic</h2>
                <div class="editBox" id="picBox">
                    <table width="700" align="center" cellpadding="10" cellspacing="0" style="border:#999 1px solid; background-color:#FBFBFB;">
                        <form action="/profile/edit" method="post" enctype="multipart/form-data">
                            <tr>
                                <td width="61"><?php echo Images::getImage(Session::instance()->get('user_id'), 'image01.jpg', 50, 0, true, true) ?></td>
                                <td width="521"><input name="fileField" type="file" class="formFields" id="fileField" size="42" />
                                    5 mb max </td>
                                <td width="56"><input name="updateBtn1" type="submit" value="Update" />
                                    <input name="parse_var" type="hidden" value="pic" />
                                    <input name="thisWipit" type="hidden" value="<?php echo @$thisRandNum; ?>" />
                                </td>
                            </tr>
                        </form>
                    </table>
                </div>
                <div class="editBox" id="locationBox">
                    <h2>Account Information</h2>
                    <table width="700" align="center" cellpadding="10" cellspacing="0" style="border:#999 1px solid; background-color:#FBFBFB;">
                        <form action="/profile/edit" method="post" enctype="multipart/form-data">
                            <tr>
                                <td width="602"><table width="100%" border="0" align="center">
                                        <tr>
                                            <td width="34%"><strong>First Name</strong></td>
                                            <td width="33%"><strong>Last Name</strong></td>
                                            <td width="33%"><strong>Gender</strong></td>
                                        </tr>
                                    </table>
                                    <table width="100%" border="0" align="center">
                                        <tr>
                                            <td width="34%"><input name="firstname" type="text" class="formFields" id="firstname" value="<?php echo @$member->firstname; ?>" style="width:99%" maxlength="32" /></td>
                                            <td width="33%"><input name="lastname" type="text" class="formFields" id="lastname" value="<?php echo @$member->lastname; ?>" style="width:99%" maxlength="32" /></td>
                                            <td width="33%">
                                                <select name="gender">
                                                    <option value="m" <?php if($member->gender == "m"): ?>selected="selected"<?php endif; ?>>Male</option>
                                                    <option value="f" <?php if($member->gender == "f"): ?>selected="selected"<?php endif; ?>>Female</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <table width="100%" border="0" align="center">
                                        <tr>
                                            <td width="34%"><strong>Country</strong></td>
                                            <td width="33%"><strong>State</strong></td>
                                            <td width="33%"><strong>City</strong></td>
                                        </tr>
                                    </table>
                                    <table width="100%" border="0" align="center">
                                        <tr>
                                            <td width="34%">
                                                <select name="country" class="formFields">
                                                    <option value="<?php print @$member->country; ?>"><?php print @$member->country; ?></option>
                                                    <option value="United States of America">United States of America</option>
                                                    <option value="Afghanistan">Afghanistan</option>
                                                    <option value="Albania">Albania</option>
                                                    <option value="Algeria">Algeria</option>
                                                    <option value="American Samoa">American Samoa</option>
                                                    <option value="Andorra">Andorra</option>
                                                    <option value="Angola">Angola</option>
                                                    <option value="Anguilla">Anguilla</option>
                                                    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                                    <option value="Argentina">Argentina</option>
                                                    <option value="Armenia">Armenia</option>
                                                    <option value="Aruba">Aruba</option>
                                                    <option value="Australia">Australia</option>
                                                    <option value="Austria">Austria</option>
                                                    <option value="Azerbaijan">Azerbaijan</option>
                                                    <option value="Bahamas">Bahamas</option>
                                                    <option value="Bahrain">Bahrain</option>
                                                    <option value="Bangladesh">Bangladesh</option>
                                                    <option value="Barbados">Barbados</option>
                                                    <option value="Belarus">Belarus</option>
                                                    <option value="Belgium">Belgium</option>
                                                    <option value="Belize">Belize</option>
                                                    <option value="Benin">Benin</option>
                                                    <option value="Bermuda">Bermuda</option>
                                                    <option value="Bhutan">Bhutan</option>
                                                    <option value="Bolivia">Bolivia</option>
                                                    <option value="Bonaire">Bonaire</option>
                                                    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                                    <option value="Botswana">Botswana</option>
                                                    <option value="Brazil">Brazil</option>
                                                    <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                                    <option value="Brunei">Brunei</option>
                                                    <option value="Bulgaria">Bulgaria</option>
                                                    <option value="Burkina Faso">Burkina Faso</option>
                                                    <option value="Burundi">Burundi</option>
                                                    <option value="Cambodia">Cambodia</option>
                                                    <option value="Cameroon">Cameroon</option>
                                                    <option value="Canada">Canada</option>
                                                    <option value="Canary Islands">Canary Islands</option>
                                                    <option value="Cape Verde">Cape Verde</option>
                                                    <option value="Cayman Islands">Cayman Islands</option>
                                                    <option value="Central African Republic">Central African Republic</option>
                                                    <option value="Chad">Chad</option>
                                                    <option value="Channel Islands">Channel Islands</option>
                                                    <option value="Chile">Chile</option>
                                                    <option value="China">China</option>
                                                    <option value="Christmas Island">Christmas Island</option>
                                                    <option value="Cocos Island">Cocos Island</option>
                                                    <option value="Columbia">Columbia</option>
                                                    <option value="Comoros">Comoros</option>
                                                    <option value="Congo">Congo</option>
                                                    <option value="Cook Islands">Cook Islands</option>
                                                    <option value="Costa Rica">Costa Rica</option>
                                                    <option value="Cote D'Ivoire">Cote DIvoire</option>
                                                    <option value="Croatia">Croatia</option>
                                                    <option value="Cuba">Cuba</option>
                                                    <option value="Curacao">Curacao</option>
                                                    <option value="Cyprus">Cyprus</option>
                                                    <option value="Czech Republic">Czech Republic</option>
                                                    <option value="Denmark">Denmark</option>
                                                    <option value="Djibouti">Djibouti</option>
                                                    <option value="Dominica">Dominica</option>
                                                    <option value="Dominican Republic">Dominican Republic</option>
                                                    <option value="East Timor">East Timor</option>
                                                    <option value="Ecuador">Ecuador</option>
                                                    <option value="Egypt">Egypt</option>
                                                    <option value="El Salvador">El Salvador</option>
                                                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                    <option value="Eritrea">Eritrea</option>
                                                    <option value="Estonia">Estonia</option>
                                                    <option value="Ethiopia">Ethiopia</option>
                                                    <option value="Falkland Islands">Falkland Islands</option>
                                                    <option value="Faroe Islands">Faroe Islands</option>
                                                    <option value="Fiji">Fiji</option>
                                                    <option value="Finland">Finland</option>
                                                    <option value="France">France</option>
                                                    <option value="French Guiana">French Guiana</option>
                                                    <option value="French Polynesia">French Polynesia</option>
                                                    <option value="French Southern Ter">French Southern Ter</option>
                                                    <option value="Gabon">Gabon</option>
                                                    <option value="Gambia">Gambia</option>
                                                    <option value="Georgia">Georgia</option>
                                                    <option value="Germany">Germany</option>
                                                    <option value="Ghana">Ghana</option>
                                                    <option value="Gibraltar">Gibraltar</option>
                                                    <option value="Great Britain">Great Britain</option>
                                                    <option value="Greece">Greece</option>
                                                    <option value="Greenland">Greenland</option>
                                                    <option value="Grenada">Grenada</option>
                                                    <option value="Guadeloupe">Guadeloupe</option>
                                                    <option value="Guam">Guam</option>
                                                    <option value="Guatemala">Guatemala</option>
                                                    <option value="Guinea">Guinea</option>
                                                    <option value="Guyana">Guyana</option>
                                                    <option value="Haiti">Haiti</option>
                                                    <option value="Hawaii">Hawaii</option>
                                                    <option value="Honduras">Honduras</option>
                                                    <option value="Hong Kong">Hong Kong</option>
                                                    <option value="Hungary">Hungary</option>
                                                    <option value="Iceland">Iceland</option>
                                                    <option value="India">India</option>
                                                    <option value="Indonesia">Indonesia</option>
                                                    <option value="Iran">Iran</option>
                                                    <option value="Iraq">Iraq</option>
                                                    <option value="Ireland">Ireland</option>
                                                    <option value="Isle of Man">Isle of Man</option>
                                                    <option value="Israel">Israel</option>
                                                    <option value="Italy">Italy</option>
                                                    <option value="Jamaica">Jamaica</option>
                                                    <option value="Japan">Japan</option>
                                                    <option value="Jordan">Jordan</option>
                                                    <option value="Kazakhstan">Kazakhstan</option>
                                                    <option value="Kenya">Kenya</option>
                                                    <option value="Kiribati">Kiribati</option>
                                                    <option value="Korea North">Korea North</option>
                                                    <option value="Korea South">Korea South</option>
                                                    <option value="Kuwait">Kuwait</option>
                                                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                    <option value="Laos">Laos</option>
                                                    <option value="Latvia">Latvia</option>
                                                    <option value="Lebanon">Lebanon</option>
                                                    <option value="Lesotho">Lesotho</option>
                                                    <option value="Liberia">Liberia</option>
                                                    <option value="Libya">Libya</option>
                                                    <option value="Liechtenstein">Liechtenstein</option>
                                                    <option value="Lithuania">Lithuania</option>
                                                    <option value="Luxembourg">Luxembourg</option>
                                                    <option value="Macau">Macau</option>
                                                    <option value="Macedonia">Macedonia</option>
                                                    <option value="Madagascar">Madagascar</option>
                                                    <option value="Malaysia">Malaysia</option>
                                                    <option value="Malawi">Malawi</option>
                                                    <option value="Maldives">Maldives</option>
                                                    <option value="Mali">Mali</option>
                                                    <option value="Malta">Malta</option>
                                                    <option value="Marshall Islands">Marshall Islands</option>
                                                    <option value="Martinique">Martinique</option>
                                                    <option value="Mauritania">Mauritania</option>
                                                    <option value="Mauritius">Mauritius</option>
                                                    <option value="Mayotte">Mayotte</option>
                                                    <option value="Mexico">Mexico</option>
                                                    <option value="Midway Islands">Midway Islands</option>
                                                    <option value="Moldova">Moldova</option>
                                                    <option value="Monaco">Monaco</option>
                                                    <option value="Mongolia">Mongolia</option>
                                                    <option value="Montserrat">Montserrat</option>
                                                    <option value="Morocco">Morocco</option>
                                                    <option value="Mozambique">Mozambique</option>
                                                    <option value="Myanmar">Myanmar</option>
                                                    <option value="Nambia">Nambia</option>
                                                    <option value="Nauru">Nauru</option>
                                                    <option value="Nepal">Nepal</option>
                                                    <option value="Netherland Antilles">Netherland Antilles</option>
                                                    <option value="Netherlands">Netherlands</option>
                                                    <option value="Nevis">Nevis</option>
                                                    <option value="New Caledonia">New Caledonia</option>
                                                    <option value="New Zealand">New Zealand</option>
                                                    <option value="Nicaragua">Nicaragua</option>
                                                    <option value="Niger">Niger</option>
                                                    <option value="Nigeria">Nigeria</option>
                                                    <option value="Niue">Niue</option>
                                                    <option value="Norfolk Island">Norfolk Island</option>
                                                    <option value="Norway">Norway</option>
                                                    <option value="Oman">Oman</option>
                                                    <option value="Pakistan">Pakistan</option>
                                                    <option value="Palau Island">Palau Island</option>
                                                    <option value="Palestine">Palestine</option>
                                                    <option value="Panama">Panama</option>
                                                    <option value="Papua New Guinea">Papua New Guinea</option>
                                                    <option value="Paraguay">Paraguay</option>
                                                    <option value="Peru">Peru</option>
                                                    <option value="Philippines">Philippines</option>
                                                    <option value="Pitcairn Island">Pitcairn Island</option>
                                                    <option value="Poland">Poland</option>
                                                    <option value="Portugal">Portugal</option>
                                                    <option value="Puerto Rico">Puerto Rico</option>
                                                    <option value="Qatar">Qatar</option>
                                                    <option value="Reunion">Reunion</option>
                                                    <option value="Romania">Romania</option>
                                                    <option value="Russia">Russia</option>
                                                    <option value="Rwanda">Rwanda</option>
                                                    <option value="St Barthelemy">St Barthelemy</option>
                                                    <option value="St Eustatius">St Eustatius</option>
                                                    <option value="St Helena">St Helena</option>
                                                    <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                                                    <option value="St Lucia">St Lucia</option>
                                                    <option value="St Maarten">St Maarten</option>
                                                    <option value="St Pierre and Miquelon">St Pierre and Miquelon</option>
                                                    <option value="St Vincent and Grenadines">St Vincent and Grenadines</option>
                                                    <option value="Saipan">Saipan</option>
                                                    <option value="Samoa">Samoa</option>
                                                    <option value="Samoa American">Samoa American</option>
                                                    <option value="San Marino">San Marino</option>
                                                    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                                    <option value="Senegal">Senegal</option>
                                                    <option value="Seychelles">Seychelles</option>
                                                    <option value="Serbia and Montenegro">Serbia and Montenegro</option>
                                                    <option value="Sierra Leone">Sierra Leone</option>
                                                    <option value="Singapore">Singapore</option>
                                                    <option value="Slovakia">Slovakia</option>
                                                    <option value="Slovenia">Slovenia</option>
                                                    <option value="Solomon Islands">Solomon Islands</option>
                                                    <option value="Somalia">Somalia</option>
                                                    <option value="South Africa">South Africa</option>
                                                    <option value="Spain">Spain</option>
                                                    <option value="Sri Lanka">Sri Lanka</option>
                                                    <option value="Sudan">Sudan</option>
                                                    <option value="Suriname">Suriname</option>
                                                    <option value="Swaziland">Swaziland</option>
                                                    <option value="Sweden">Sweden</option>
                                                    <option value="Switzerland">Switzerland</option>
                                                    <option value="Syria">Syria</option>
                                                    <option value="Tahiti">Tahiti</option>
                                                    <option value="Taiwan">Taiwan</option>
                                                    <option value="Tajikistan">Tajikistan</option>
                                                    <option value="Tanzania">Tanzania</option>
                                                    <option value="Thailand">Thailand</option>
                                                    <option value="Togo">Togo</option>
                                                    <option value="Tokelau">Tokelau</option>
                                                    <option value="Tonga">Tonga</option>
                                                    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                                    <option value="Tunisia">Tunisia</option>
                                                    <option value="Turkey">Turkey</option>
                                                    <option value="Turkmenistan">Turkmenistan</option>
                                                    <option value="Turks and Caicos Is">Turks and Caicos Is</option>
                                                    <option value="Tuvalu">Tuvalu</option>
                                                    <option value="Uganda">Uganda</option>
                                                    <option value="Ukraine">Ukraine</option>
                                                    <option value="United Arab Emirates">United Arab Emirates</option>
                                                    <option value="United Kingdom">United Kingdom</option>
                                                    <option value="United States of America">United States of America</option>
                                                    <option value="Uruguay">Uruguay</option>
                                                    <option value="Uzbekistan">Uzbekistan</option>
                                                    <option value="Vanuatu">Vanuatu</option>
                                                    <option value="Vatican City State">Vatican City State</option>
                                                    <option value="Venezuela">Venezuela</option>
                                                    <option value="Vietnam">Vietnam</option>
                                                    <option value="Virgin Islands (Brit)">Virgin Islands Brit</option>
                                                    <option value="Virgin Islands (USA)">Virgin Islands USA</option>
                                                    <option value="Wake Island">Wake Island</option>
                                                    <option value="Wallis and Futana Is">Wallis and Futana Is</option>
                                                    <option value="Yemen">Yemen</option>
                                                    <option value="Zaire">Zaire</option>
                                                    <option value="Zambia">Zambia</option>
                                                    <option value="Zimbabwe">Zimbabwe</option>
                                                </select></td>
                                            <td width="33%"><input name="state" type="text" class="formFields" id="state" value="<?php echo @$member->state; ?>" style="width:99%" maxlength="32" /></td>
                                            <td width="33%"><input name="city" type="text" class="formFields" id="city" value="<?php echo @$member->city; ?>" style="width:99%" maxlength="32" /></td>
                                        </tr>
                                    </table>
                                    <table width="100%" border="0" align="center">
                                        <tr>
                                            <td style="width:17.8%;"><strong>Date of Birth</strong></td>
                                            <td width="34%"><strong>Password</strong></td>
                                        </tr>
                                    </table>
                                    <table width="100%" border="0" align="center">
                                        <tr style="width:34%;">
                                            <td style="width:17.8%;">
                                                <?php

                                                $month = date("m", strtotime($member->birthday));
                                                $month_text = date('F', mktime(0, 0, 0, $month));

                                                $day = date('d', strtotime($member->birthday));

                                                $year = date('Y', strtotime($member->birthday));

                                                ?>
                                                <select name="birth_month" class="formFields" id="birth_month">
                                                     <option value="<?php echo $month ?>"><?php echo $month_text ?></option>
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
                                                     <option value="<?php echo $day ?>"><?php echo $day ?></option>
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
                                                     <option value="<?php echo $year ?>"><?php echo $year ?></option>
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
                                            </td>
                                            <td style="width:34%;"><input name="password" type="password" class="formFields" id="password" style="width:49%" maxlength="32" /></td>
                                        </tr>
                                    </table></td>
                                <td width="56" valign="top"><input name="updateBtn2" type="submit" id="updateBtn2" value="Update" />
                                    <input name="parse_var" type="hidden" value="location" />
                                    <input name="thisWipit" type="hidden" value="<?php echo @$thisRandNum; ?>" /></td>
                            </tr>
                        </form>
                    </table>
                </div>
                <div class="editBox" id="linksBox">
                    <h2>Profile Links</h2>
                    <table width="700" align="center" cellpadding="10" cellspacing="0" style="border:#999 1px solid; background-color:#FBFBFB;">
                        <form action="/profile/edit" method="post" enctype="multipart/form-data">
                            <tr>
                                <td width="170">Your Website: <span class="brightRed">*</span></td>
                                <td width="471"><strong>http://</strong>
                                    <input name="website" type="text" class="formFields" id="website" value="<?php echo @$member->website; ?>" size="36" maxlength="32" /></td>
                                <td width="56" rowspan="3" valign="top"><input name="updateBtn3" type="submit" value="Update" />
                                    <input name="parse_var" type="hidden" value="links" />
                                    <input name="thisWipit" type="hidden" value="<?php echo @$thisRandNum; ?>" /></td>
                            </tr>
                            <tr>
                                <td>Youtube Channel: <span class="brightRed">*</span></td>
                                <td><strong>http://www.youtube.com/user/</strong>
                                    <input name="youtube" type="text" class="formFields" id="youtube" value="<?php echo @$member->youtube; ?>" size="20" maxlength="40" /></td>
                            </tr>
                            <tr>
                                <td>Facebook:<span class="brightRed"> *</span></td>
                                <td><strong>http://facebook.com/</strong>
                                    <input name="facebook" type="text" class="formFields" id="facebook" value="<?php echo @$member->facebook; ?>" size="20" maxlength="40" /></td>
                            </tr>
                            <tr>
                                <td>Twitter Username:<span class="brightRed"> *</span></td>
                                <td><strong>http://twitter.com/</strong>
                                    <input name="twitter" type="text" class="formFields" id="twitter" value="<?php echo @$member->twitter; ?>" size="20" maxlength="40" /></td>
                            </tr>
                        </form>
                    </table>
                </div>

                <div class="editBox" id="bioBox">
                    <h2>Profile Description</h2>
                    <table width="700" align="center" cellpadding="10" cellspacing="0" style="border:#999 1px solid; background-color:#FBFBFB;">
                        <form action="/profile/edit" method="post" enctype="multipart/form-data">
                            <tr>
                                <td width="602" valign="top">
                                    <textarea name="bio_body" cols="" rows="3" class="formFields" style="width:80%;"><?php echo @$member->bio_body; ?></textarea>
                                </td>
                                <td width="56" valign="top"><input name="updateBtn4" type="submit" id="updateBtn4" value="Update" />
                                    <input name="parse_var" type="hidden" value="bio" />
                                    <input name="thisWipit" type="hidden" value="<?php echo @$thisRandNum; ?>" /></td>
                            </tr>
                        </form>
                    </table>
                </div>

                <div class="editBox" id="bgBox">
                    <table width="700" align="center" cellpadding="10" cellspacing="0" style="border:#999 1px solid; background-color:#FBFBFB;">
                        <h2>Profile Background</h2>
                        <form action="/profile/edit" method="post" enctype="multipart/form-data">
                            <tr>
                                <td width="61"></td>
                                <td width="521"><input name="bgField" type="file" class="formFields" id="bgField" size="42" />
                                    5 mb max </td>
                                <td width="56"><input name="updateBtn1" type="submit" id="updateBtn1" value="Update" />
                                    <input name="parse_var" type="hidden" value="bg" />
                                    <input name="thisWipit" type="hidden" value="<?php echo @$thisRandNum; ?>" />
                                </td>
                            </tr>
                        </form>
                    </table>
                </div>
                <div class="editBox" id="bgBox">
                    <table width="700" align="center" cellpadding="10" cellspacing="0" style="border:#999 1px solid; background-color:#FBFBFB;">
                        <h2>Your Interests</h2>
                        <table width="700" align="center" cellpadding="10" cellspacing="0" style="border:#999 1px solid; background-color:#FBFBFB;">
                            <form action="/profile/edit" method="post" enctype="multipart/form-data">
                                <tr>
                                    <td width="111">Music</span></td>
                                    <td width="471">
                                        <input name="music" type="text" class="formFields" id="musicField" value="<?php echo @$member->music ?>" size="60" maxlength="300" /></td>
                                    <td width="56" rowspan="3" valign="top"><input name="updateBtn3" type="submit" value="Update" />
                                        <input name="parse_var" type="hidden" value="interests" />
                                        <input name="thisWipit" type="hidden" value="<?php echo @$thisRandNum; ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Movies:</span></td>
                                    <td>
                                        <input name="movies" type="text" class="formFields" id="movieField" value="<?php echo @$member->movies ?>" size="60" maxlength="300" /></td>
                                </tr>
                                <tr>
                                    <td>TV:</span></td>
                                    <td>
                                        <input name="tv" type="text" class="formFields" id="tvField" value="<?php echo @$member->tv ?>" size="60" maxlength="300" /></td>
                                </tr>
                                <tr>
                                    <td>Books:</span></td>
                                    <td>
                                        <input name="books" type="text" class="formFields" id="bookField" value="<?php echo @$member->books ?>" size="60" maxlength="300" /></td>
                                </tr>
                            </form>
                        </table>
                </div>
                <div class="editBox" id="bgBox">
                    <h2>Your Privacy</h2>
                    <table width="700" align="center" cellpadding="5" cellspacing="0" style="border:#999 1px solid; background-color:#FBFBFB;">
                        <form action="/profile/edit" method="post" enctype="multipart/form-data">
                            <tr>
                                <td width="150"><input type="radio" name="privacy_option" value="public" <?php if (empty($member->privacy_option) || @$member->privacy_option == "public") {
                    echo "checked=\"checked\"";
                } ?>>Public</span></td>
                                <td>(View all site content, and everyone can see your content)</td>
                                <td width="" align="right">
                                <td width="56" rowspan="3" valign="top"><input name="updateBtn3" type="submit" id="updateBtn3" value="Update" />
                                    <input name="parse_var" type="hidden" value="privacy" />
                                    <input name="thisWipit" type="hidden" value="<?php echo @$thisRandNum; ?>" /></td>
                            </tr>
                            <tr>
                                <td><input type="radio" value="limited" name="privacy_option" <?php if (@$member->privacy_option == "limited") {
                    echo "checked=\"checked\"";
                } ?>>Limited Profile </span></td>
                                <td>
                                    (View all site content, but only friends can view your content)
                            </tr>
                            <tr>
                                <td><input type="radio" value="locked" name="privacy_option" <?php if (@$member->privacy_option == "locked") {
                    echo "checked=\"checked\"";
                } ?>>Locked Profile</span></td>
                            <td>
                                (Only view friend content , and only friends can view your content)
                        </tr>
                    </form>
                </table>
                </div>
        </td>
    </tr>
        </table>
                <script type="text/javascript" src="/content/tinymce/jscripts/tiny_mce/tiny_mce.js" ></script>
                <script type="text/javascript">
                    tinyMCE.init({
                        mode: "textareas",
                        theme: "advanced",
                        theme_advanced_buttons1 : "font,fontselect,fontsizeselect,formatselect,bold,italic,underline,separator,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,undo,redo,forecolor,backcolor",
                        theme_advanced_buttons2 : "",
                        theme_advanced_buttons3 : "",
                        theme_advanced_toolbar_location: "top",
                        theme_advanced_toolbar_align: "left",
                        theme_advanced_statusbar_location: "bottom"
                    });

                </script>
                <script type="text/javascript" src="http://ajax.googleapis.com/
ajax/libs/jquery/1.4.2/jquery.min.js"></script> 
<script> 
$(document).ready(function() {
 
  
   $('.block').click(function()
   {
   var id= $(this).attr('id');
   var data_id= $(".data").html();
  
    var panel= $('.panel');
	var panel_width=$('.panel').css('left');
	
	
	if(data_id==id)
	{
	panel.animate({left: parseInt(panel.css('left'),0) == 0 ? +panel.outerWidth() : 0});
	}
	else
	{
	
	
	if(panel_width=='341px')
	{
	
	}
	else
	{
	
    panel.animate({left: parseInt(panel.css('left'),0) == 0 ? +panel.outerWidth() : 0});
	
	}
	
	}
	$('.data').html(id);
	return false;
	
  });
  
 
  
  $('.close').click(function() 
   {
   
    var panel= $('.panel');
    panel.animate({left: parseInt(panel.css('left'),0) == 0 ? +panel.outerWidth() : 0});
	return false;
	
  });
  
  
  
});
 
</script> 
<style> 
h4{
	padding:5px;
                </script>

<style type="text/css">
#right{
	border-left: 1px solid;
	height:650px;
}
a{ 
	color:#333 
}
a:hover {color:#cc0000
}
#profile-options{
	width:900px;
	margin:0 auto; 
	background-color:#fff; 
	min-height:420px; 
	overflow:auto;
 	-moz-border-radius:5px;
 	-webkit-border-radius:6px;
	border:solid 1px #999999;
	margin-top:50px;
}
.edit-right{
	float:right; 
	width:450px;
	text-align:center;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
}
.edit-left{
	float:left; 
	background-color:#fff; 
	width:441px; 
	min-height:300px;
 	position:relative;
 	
}
.block{
	border-bottom: solid 1px #999999;
	padding:15px;
	border-right:solid 1px #999999;
	height:30px;
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
}
 .block:hover{
 	background-color:#f2f2f2;
	cursor:pointer;
}
#panel-frame{
	position:relative; 
	max-width:700px; 
	position:fixed;
}
.panel{
	background-color:#f2f2f2; 
	width:440px; 
	height:400px;
	margin-top:20px;
	position:relative;
	position:absolute;
	border:solid 1px #999999;
	border-left:0px;
	left:0;
}
.data{
	font-size:30px
}
.head{
	background-color:#a9a9a9;
	padding:10px;
	text-align:right;
}
</style> 
<div id="profile-options"> 
 
<div class="edit-right"> 
<h4>(To Edit Your Profile, Select an Option on the left)</h4> 

</div> 
<div id="panel-frame"> 
<div class="panel"> 
<div class="head"> 
<a href="#" class="close">Done</a> 
</div> 
<div class="data" style="padding:20px"></div> 
</div> 
</div> 
 
<div class="edit-left"> 
<div class="block" id="">Profile Photo</div>
<div class="block" id="">Profile Description</div>  
<div class="block" id="<form>
	First name: <input type='text' name='firstname' /><br />
	Last name: <input type='text' name='lastname' />
</form>">Your Infomation</div>
<div class="block" id="">Profile Links</div> 
<div class="block" id="">Profile Background</div> 
<div class="block" id="">Interests</div>
<div class="block" id="">Privacy</div> 
</div> 
 
 
 
</div> 
	</div>
-->
<script> 
$(document).ready(function() {
 
  
   $('.block').click(function() {
		var id= $(this).attr('id');
		var data_id= $(".initial_data").html();
  
		var panel= $('.panel');
		var panel_width=$('.panel').css('left');
	
	
	if(data_id == id) {
		panel.animate({left: parseInt(panel.css('left'),0) == 0 ? +panel.outerWidth() : 0});
	} else {	
		if(panel_width=='341px') {
		
		} else {
			panel.animate({left: parseInt(panel.css('left'),0) == 0 ? +panel.outerWidth() : 0});
		}	
	}
	
	$('.data').html(id);
	
	return false;
	
  });
  
 
  
  $('.close').click(function() 
   {
   
    var panel= $('.panel');
    panel.animate({left: parseInt(panel.css('left'),0) == 0 ? +panel.outerWidth() : 0});
	return false;
	
  });
  
  
  
});
 
</script> 
<style> 
 
h4{
	padding:5px;
}
#editprofilecontainer{
	width:900px;
	margin:0 auto; 
	background-color:#fff; 
	min-height:500px; 
	overflow:auto;
	-moz-border-radius: 20px;
    -webkit-border-radius: 20px;
    -khtml-border-radius: 20px;
    border-radius: 20px;
	
 
} 
.right{
	float:right; 
	width:450px;
	text-align:cetner;
	font-family: "Helvetica", Arial, sans-serif;
	font-size:10px;
}
.left{
	float:left; 
	background-color:#fff; 
	width:450px; 
	min-height:300px;
	position:relative;
}
.block{
	border-bottom: solid 1px #999999;
	padding:15px;
	border-right:solid 1px #999999;
	
}
.block:hover{
	background-color:#A3A3A3; 
}
 
#panel-frame{
	position:relative; 
	max-width:700px; 
	position:fixed;
	margin-left:98px;
}
.panel{
	background-color:#f2f2f2; 
	width:350px; 
	height:465px;
	margin-top:20px;
	position:relative;
	position:absolute;
	border:solid 1px #999999;
	border-left:0px;
	left:0;
}
.data{
	font-size:15px
}
.head{
	background-color:#A3A3A3;
	padding:10px;
t	ext-align:right;
}

</style> 
</head> 
 
<body> 
 
 
 
 
<div id='editprofilecontainer'> 
 
<div class='right'> 
<h4>(Select an Option on the Left)</h4> 

</div> 
<div id="panel-frame"> 
<div class="panel"> 
<div class="head"> 
<a href="#" class="close">Done</a> 
</div> 
<div class="data" style="padding:20px"></div> 
</div> 
</div> 
 
<div class="left"> 
<div class="block" id="1"> 
	Profile Photo
	<div class="intial_data"><?php echo Images::getImage(Session::instance()->get('user_id'), 'image01.jpg', 50, 0, true, true) ?></div>
</div> 
<div class="block" id="2"> 
	Name
</div> 
<div class="block" id="3"> 
	Location
</div> 
<div class="block" id="4"> 
	Profile Links
</div> 
<div class="block" id="5"> 
	About Me
</div> 
<div class="block" id="6"> 
	Interests
</div> 
<div class="block" id="7"> 
	Profile Background
</div> 
<div class="block" id="8"> 
	Relationships
</div> 
<div class="block" id="9"> 
	Password
</div> 
<div class="block" id="10"> 
	Privacy
</div> 

</div>
 
 
 
</div> 
 
</body> 
</html> 

