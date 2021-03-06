App.Photo = function() {

}

App.Photo.gotoPhoto = function(id) {
	window.location = "/photos/" + id;
}

App.PhotoAlbum = function() {
	this.collection_id = 0;
	this.name = "";
	this.div = null;
	this.uploader = null;

	var album = this;

	this.startUploadProcess = function() {
		this.div = $("#create_photo_album").clone();

		$(this.div).attr('id', App.uniqid(10));
		$(this.div).addClass('modal');

		$(this.div).css({
			width: '800px',
			height: '470px',
			padding: '0'
		});

		$(this.div).find("#file-uploader")
						.attr('id', 'file-uploader-' + $(this.div).attr('id'));

		$(this.div).find('.album_name')
						.blur(function() {
							album.initialize();
						});

		$(this.div).find('.share_album')
						.button()
						.click(function() {
							App.post('/photos/collections/publish',
											{ collection_id: album.collection_id }, function(response) {
												if (response.success) {
													App.Modal.close();

													location.reload(true);
												}
											});
						});

		$(this.div).find('.album_name')
						.attr('id', 'album_name' + $(this.div).attr('id'));

		$("body").append(this.div);

		this.uploader = new qq.FileUploader({
			element: $("#file-uploader-" + $(this.div).attr('id'))[0],
			action: "/photos/collections/add",
			params: {
				collection_id: this.collection_id
			},
			onSubmit: function(id, fileName) {
				var initialize = album.initialize();

				if (!initialize) {
					return false;
				} else {
					album.uploader.setParams({
						collection_id: album.collection_id
					})
				}
			},
			onComplete: function(id, fileName, responseJSON) {
				if (responseJSON.success) {
					var img = $("<img>");

					$(img).attr('src', responseJSON.url);
					$(img).attr('width', 100);
					$(img).attr('height', 100);

					$("#" + $(album.div).attr('id') + " .photos").append(img);
				}
			}
		});

		App.Modal.open("#" + this.div.attr('id'));
	}

	this.initialize = function() {
		var album_name = jQuery("#album_name" + $(this.div).attr('id')).val();

		if (album_name == "") {
			return false;
		} else if (this.collection_id > 0) {
			if (this.name != album_name) {

				App.post('/photos/collections/update',
								{ name: album_name, collection_id: this.collection_id },
								function(response) {

								});
			}

			return true;
		}

		this.name = album_name;

		App.post('/photos/collections/new',
						{ name: this.name },
						function(response) {
							album.collection_id = response.collection_id;
						},
						function(response) {
						}
		);

		return false;
	}

	return true;
}

App.PhotoAlbum.create = function() {
	var album = new App.PhotoAlbum();

	album.startUploadProcess();

	return false;
}

App.PhotoAlbum.loadProfile = function() {
	$.get("/" + $("#username").text() + "/albums", {}, function(data) {
		$("div.profile_photos").html(data);

		$.fancybox.hideActivity();

		bindThumbsUp();
	});
}