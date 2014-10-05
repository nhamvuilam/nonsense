<div id="overlay-container" class="overlay-scroll-container hide">
	<section id="modal-upload" class="modal upload hide">
		<a class="badge-overlay-close btn-close" href="javascript:void(0)">✖</a>
		<section id="upload-file">
			<form id="form-modal-post-image" class="modal" action="/post" enctype="multipart/form-data" method="POST" onsubmit="return valivateFormUpload();">
				<input type="hidden" name="type" value="image" />				
				<div id="jsid-disable-mask">
					<h2>Post a fun</h2>
					<p class="lead">
						Upload funny pictures, paste pictures URL, accepting GIF/JPG/PNG (Max size: 3MB)
					</p>
					<div class="field photo">						
						<input id="jsid-upload-url-input" class="hide" type="url" name="url" placeholder="http://" value="" />
						<div id="jsid-upload-file-input" class="file-field ">
							<input class="file text" type="file" name="image" accept="image/gif,image/jpeg,image/jpg,image/png" />
						</div>
						<p id="jsid-upload-content-error" class="error-message hide"></p>
					</div>
					<div class="field title">
						<label>Title</label>
						<p id="jsid-char-count" class="count">
							120
						</p>
						<textarea id="jsid-upload-title" name="title" data-maxlength="120"></textarea>
						<p id="jsid-upload-title-error" class="error-message hide"></p>
					</div>
					<div class="field section-picker">
						<ul id="jsid-section-list" class="section-list" data-sections-count-max="5"></ul>
						<p id="jsid-upload-section-error" class="error-message hide"></p>
					</div>
					<div class="field checkbox">
						<label id="jsid-source-checkbox-label">
							<input type="checkbox" id="jsid-source-checkbox" />
							Attribute original creator</label>
						<input id="jsid-source-input" type="text" class="text hide" name="source" value="" placeholder="http://" />
					</div>
					<div class="btn-container">
						<input id="jsid-submit-btn" type="submit" value="Upload" />
					</div>
					<div id="spinner-here" class="disabled-mask"></div>
				</div>
			</form>
		</section>
	</section>
	<section id="modal-report" class="badge-overlay-report modal report hide">
		<header>
			<h3>Report Post</h3>
			<p>
				What do you report this post for?
			</p>
			<a class="btn-close badge-overlay-close" href="javascript:void(0)">✖</a>
		</header>
		<form id="form-modal-report" class="popup-report" action="" onsubmit="return false;">
			<div class="field checkbox">
				<label>
					<input name="radio-report" type="radio" value="1">
					Contains a trademark or copyright violation</label>
			</div>
			<div class="field checkbox">
				<label>
					<input name="radio-report" type="radio" value="2">
					Spam, blatant advertising, or solicitation</label>
			</div>
			<div class="field checkbox">
				<label>
					<input name="radio-report" type="radio" value="3">
					Contains offensive materials/nudity</label>
			</div>
			<div class="field checkbox">
				<label>
					<input name="radio-report" type="radio" value="4">
					Repost of another post on 9GAG</label>
				<input id="jsid-repost-link" type="text" class="text" placeholder="http://nhamvl.com/gag/post_ID">
			</div>
			<div class="btn-container">
				<input type="submit" value="Submit" class="badge-report-submit-btn" data-text-loading="Please wait ...">
			</div>
		</form>
	</section>
 	<section class="modal signup badge-overlay-signin hide">
		<a class="btn-close badge-overlay-close" href="javascript:void(0);">&#10006;</a>
		<section id="signup">
			<h2>Login</h2>
			<p class="lead">
				Connect with a social network
			</p>
			<div class="social-signup">
				<a class="btn-connect-option facebook badge-facebook-connect" href="javascript:void(0);">Facebook</a>
				<span class="badge-gplus-connect"><a class="btn-connect-option google-plus" href="javascript:void(0);">Google</a></span>
			</div>
			<form id="login-email" class="badge-login-form" action="https://nhamvl.com/login" method="POST">
				<input type="hidden" id="jsid-login-form-csrftoken" name="csrftoken" value=""/>
				<input type="hidden" id="jsid-login-form-next-url" name="next" value=""/>
				<input type="hidden" name="location" value="1"/>
				<p class="lead">
					Log in with your email address
				</p>
				<div class="field">
					<label for="jsid-login-email-name">Email</label>
					<input id="jsid-login-email-name" type="text" name="username" value="" autofocus/>
				</div>
				<div class="field">
					<label for="login-email-password">Password</label>
					<input id="login-email-password" type="password" name="password" value="" />
				</div>
				<div class="btn-container">
					<input type="submit" value="Log in"/>
					<a class="forgot-password" href="https://nhamvl.com/recover" onclick="GAG.GA.track('login-signup', 'clicked', 'forgot-password');">Forgot Password</a>
				</div>
			</form>
		</section>
	</section>
	<section class="modal signup hide badge-overlay-signup-fb">
		<a class="badge-overlay-close btn-close" href="javascript:void(0);">&#10006;</a>
		<section id="signup">
			<div id="signup-fb" class="">
				<h2>Hey there!</h2>
				<p class="lead">
					NhamVL is your best source of fun. Share anything you find interesting, get real responses from people all over the world, and discover what makes you laugh.
				</p>
				<div class="social-signup">
					<a class="btn-connect-option facebook badge-facebook-connect" href="javascript:void(0);">Facebook</a>
					<span class="badge-gplus-connect"><a class="btn-connect-option google-plus" href="javascript:void(0);">Google</a></span>
				</div>
				<p class="alternative">
					Sign up with your <a href="javascript:void(0);" class="badge-signup-email-link">Email Address</a>
				</p>
				<p class="alternative">
					Have an account? <a href="https://nhamvl.com/login?ref=" class="badge-signup-login-link">Login</a>
				</p>
			</div>
			<div id="signup-email" class=" hide">
				<h2>Become a member</h2>
				<form id="signup-email" action="https://nhamvl.com/member/email-signup" autocomplete="off" method="post">
					<input type="hidden" id="jsid-login-form-next-url" name="next" value=""/>
					<div class="field">
						<label for="signup-email-name">Full Name</label>
						<input id="signup-email-name" type="text" name="fullname" class="badge-input-fullname badge-input-field" placeholder="" value="" maxlength="20"/>
					</div>
					<div class="field">
						<label for="signup-email-email">Email Address</label>
						<input type="email" name="email" id="signup-email-email" class="badge-input-email badge-input-field" placeholder="" value="" />
					</div>
					<div class="field">
						<label for="signup-email-password">Password</label>
						<input id="signup-email-password" type="password" name="password" value="">
					</div>
					<div class="field captcha">
						<div id='captchawrapper' style="display:none;">
							<h3 id='capchatitle'>Please enter the words below</h3>
							<div id='captchadiv' data-apiKey="6Lf0iMkSAAAAALGZpEfzpO13sqJNiEgr6znqfm9r">
								<div id="recaptcha_widget">
									<div id="recaptcha_image" style="width: 300px; height: 57px;"></div>
									<div class="recaptcha_function">
										<div class="recaptcha_reload">
											<a href="javascript:Recaptcha.reload()">Reload</a>
										</div>
										·
										<div class="recaptcha_only_if_image">
											<a href="javascript:Recaptcha.switch_type('audio')">Listen</a>
										</div>
										<div class="recaptcha_only_if_audio">
											<a href="javascript:Recaptcha.switch_type('image')">Image</a>
										</div>
										·
										<div>
											<a href="javascript:Recaptcha.showhelp()">Help</a>
										</div>
									</div>
									<span class="recaptcha_only_if_image">Enter the words above:</span><span class="recaptcha_only_if_audio">Type what you hear:</span>
									<input type="text" id="recaptcha_response_field" name="recaptcha_response_field" autocomplete="off" tabindex="1">
								</div>
							</div>
						</div>
						<p class="error-message red"></p>
					</div>
					<div class="btn-container">
						<input type="submit" value="Sign Up" onclick="GAG.GA.track('login-signup', 'signup', 'signup-form');"/>
					</div>
					<input type="hidden" name="tzo" class="badge-input-tzo" value="0" />
					<input type="hidden" name="next" value="" class="badge-signup-form-next-url"/>
					<input type="hidden" name="csrftoken" id="csrftoken" value=""/>
					<input type="hidden" name="src" value="" />
					<input type="hidden" name="ref" value="" />
					<input type="hidden" name="app" value="web" />
					<input type="hidden" name="recaptcha_challenge_field" value="" id="recaptcha_challenge"/>
					<input type="hidden" name="recaptcha_response_field" value="" id="recaptcha_response"/>
				</form>
			</div>
		</section>
	</section>
	<div id="jsid-modal-post-zoom" class="hide" style="height: 100%;">
		<div class="badge-post-zoom-img zoom-container"></div>
		<a class="badge-overlay-close close-button" href="javascript: void(0);">Close</a>
	</div>
</div>