<div id="comment-dialog-blab"><?php echo $blab ?></div>
    <input type="text" name="blab_field" style="width:98%" id="comment_text" />
    <input name="submit" type="submit" value="Comment!" class="button" id="new_comment" onclick="postComment(<?php echo $blab_data->id ?>, '#comment_text')"/>
<div id="comment-dialog-comments">

</div>