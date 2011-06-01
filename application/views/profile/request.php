<table width="100%" cellpadding="5" ><tr><td width="17%" align="left"><div style="overflow:hidden; height:50px;"><?php echo $request->from->getProfileImage() ?></div></td>
    <td width="83%"><a href="/<?php echo $request->from->username ?>"><?php echo $request->from->getName() ?></a> wants to be your Friend!<br /><br />
    <span id="req<?php echo $request->id ?>">
    	<a href="#" onclick="return false" onmousedown="javascript:acceptFriendRequest(<?php echo $request->id ?>);" >Accept</a>
    	&nbsp; &nbsp; OR &nbsp; &nbsp;
    	<a href="#" onclick="return false" onmousedown="javascript:denyFriendRequest(<?php echo $request->id ?>);" >Deny</a>
    </span></td>
    </tr>
</table>