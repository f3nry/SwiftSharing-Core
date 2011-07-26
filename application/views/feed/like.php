<div id="thumbsup_<?= $id ?>" class="thumbsup_template_mini-thumbs">
		<form method="post">
				<input type="hidden" name="thumbsup_id" value="<?= $id ?>" />
				<input type="hidden" name="type" value="<?= $type ?>" />

				<span class="thumbsup_hide">Score:</span>
				<?php if($delete): ?>
						<a href="javascript:void" onclick="deleteBlab(<?=$id ?><?php if($type == 'ALBUM'): ?>, 'ALBUM'<?php endif; ?>)" style="float:right;padding-left:5px;"><img src="/content/images/notifications/icon_close.png" width="16" height="16" /></a>
				<?php endif; ?>
				<input class="vote_up" name="thumbsup_rating" value="+1" type="submit" title="Vote up" />
				<input class="vote_down" name="thumbsup_rating" value="-1" type="submit" title="Vote down" />
				<strong class="votes_balance"><?= $likes ?></strong>
		</form>
</div>