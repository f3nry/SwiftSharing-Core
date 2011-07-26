<button name="photo_album" onclick="App.PhotoAlbum.create();return false;">Create Photo Album</button><br/><br/>
<div class="albums">
	<?php if(!empty($collections)): ?>
		<?php foreach($collections as $collection): ?>
			<div class="album" id="album_<?= $collection->id ?>">
				<?php $i = 0; ?>
					<div class="album_photo">
						<a href="/photos/<?= $collection->first() ?>">
							<?php foreach($collection->getPhotos(false) as $photo): ?>
							<img class="album_<?=$i ?>" src="<?php echo $photo->getUrl() ?>" width="180" height="180"/>
							<?php $i++; if($i >= 3) { break; } ?>
							<?php endforeach; ?>
							<div style="clear:both;"></div>
						</a>
					</div>
				<span class="album_name"><?= $collection->getName() ?></span>
				<span class="likes">
					<?= Model_Like::generateLikeBox($collection->id, $collection->likes, true, 'ALBUM'); ?>
				</span>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
<div style="clear:both"></div>