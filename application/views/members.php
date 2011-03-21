<h2>SwiftSharing Members: <?php echo $totalMembers ?></h2>
<?php foreach ($members as $member): ?>
    <table width="100%">
        <tr>
            <td width="13%" rowspan="2"><div style=" height:50px; overflow:hidden;"><a href="/<?php echo $member->username ?>" target="_self"><?php echo $member->getProfileImage() ?></a></div></td>
            <td width="14%" class="style7"><div align="right">Name:</div></td>
            <td width="73%"><a href="/<?php echo $member->username ?>" target="_self"><?php echo $member->firstname . ' ' . $member->lastname ?></a> </td>
        </tr>
        <tr>
            <td class="style7"><div align="right">Website:</div></td>
            <td><a href="http://<?php echo $member->website ?>" target="_blank"><?php echo $member->website ?></a> </td>
        </tr>
    </table>
    <hr />
<?php endforeach; ?>
<?php echo $pager ?>