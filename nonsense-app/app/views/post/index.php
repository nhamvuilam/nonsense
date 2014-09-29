<div class="badge-page page ">
	<section id="upload-file">
		<form onsubmit="return GAG.UploadController.validateForm();" method="POST" enctype="multipart/form-data" action="/submit" class="modal" id="form-modal-post-image">
			<input type="hidden" value="Photo" name="type">
			<input type="hidden" value="12d87d1c6e88194d2bf1fc7169d8a83b" name="csrftoken" id="csrftoken">
			<input type="hidden" value="Photo" name="post_type" id="post_type">

			<div id="jsid-disable-mask">
				<h2>Post a fun</h2>
				<p class="lead">
					Upload funny pictures, paste pictures URL, accepting GIF/JPG/PNG (Max size: 3MB)
				</p>
				<div class="field photo">
					<label style="display:none;"> <a href="javascript:void(0);" class="" id="jsid-upload-url-btn">Paste URL</a> / <a href="javascript:void(0);" class="upload-selected" id="jsid-upload-file-btn">Upload File</a> </label>
					<input type="url" value="" placeholder="http://" name="url" class="hide" id="jsid-upload-url-input">
					<div class="file-field " id="jsid-upload-file-input">
						<input type="file" accept="image/gif,image/jpeg,image/jpg,image/png" name="image" class="file text">
					</div>
					<p class="error-message hide" id="jsid-upload-content-error"></p>
				</div>
				<div class="field title">
					<label>Title</label>
					<p class="count " id="jsid-char-count">
						120
					</p>
					<textarea data-maxlength="120" name="title" id="jsid-upload-title"></textarea>
					<p class="error-message hide" id="jsid-upload-title-error"></p>
				</div>

				<div class="field section-picker">
					<ul data-sections-count-max="5" class="section-list" id="jsid-section-list"></ul>
					<p class="error-message hide" id="jsid-upload-section-error"></p>
				</div>

				<div class="field checkbox">
					<label id="jsid-source-checkbox-label">
						<input type="checkbox" id="jsid-source-checkbox">
						Attribute original creator</label>
					<input type="text" placeholder="http://" value="" name="source" class="text hide" id="jsid-source-input">
				</div>

				<div class="btn-container">
					<input type="submit" value="Upload" id="jsid-submit-btn">
				</div>

				<div class="disabled-mask" id="spinner-here"></div>
			</div>

		</form>
	</section>

	<section id="sidebar"></section>

	<div class="clearfix"></div>
</div>