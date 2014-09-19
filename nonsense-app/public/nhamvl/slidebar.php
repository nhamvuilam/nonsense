<section id="sidebar">
  <form method="post" action="/profile/setcustomize" id="jsid-personalise-form">
    <section class="section-control" id="jsid-personalise-selector" style="display: none;">
      <div class="title">
        <h3>Personalise 9GAG <em>Beta</em></h3>
      </div>
      <ul>
        <li>
          <p> <span class="cell-title">Auto Play GIFs</span> </p>
          <span class="toggle badge-personalise-options"> <span class="on">On</span> <span class="off">Off</span> <span class="switch"></span>
          <input type="hidden" name="auto_animated" />
          </span> </li>
        <li>
          <p> <span class="cell-title">Show NSFW Posts</span> </p>
          <span class="toggle badge-personalise-options badge-personalise-option-nsfw"> <span class="on">On</span> <span class="off">Off</span> <span class="switch"></span>
          <input type="hidden" name="show_nsfw" />
          </span> </li>
      </ul>
      <div class="btn-container"> <a class="btn size-30 blue" href="#" id="jsid-personalise-btn-save">Save</a> <a class="link" href="#" id="jsid-personalise-btn-reset">Reset</a> </div>
    </section>
    <input type="hidden" name="customize_reset" value=""/>
    <input type="hidden" name="url" value="/"/>
  </form>
  <div id="sidebar-content">
    <section class="badge-block-ad block-ad">
      <div class="badge-gag-ads-container img-container" data-gag-ads="list-sidebar1-300x250-atf"></div>
    </section>
    <section class="block-subscribe badge-email-subscription" >
      <h2 class="sidebar-title">Nhận niềm vui mỗi ngày</h2>
      <form>
        <div class="field badge-toggle-hide-when-done">
          <input class="badge-email-subscription-input badge-evt" data-evt="Email-Subscription,Input-Clicked,top"
                type="email" placeholder="Email address">
          <a class="btn badge-email-subscription-btn badge-evt" href="javascript:void(0);"
                 data-evt="Email-Subscription,Input-Clicked,top">Subscribe</a> </div>
        <div class="message hide badge-toggle-hide-when-done">
          <p>Thanks for signing up!</p>
        </div>
      </form>
    </section>
    <section class="block-feature-cover">
      <h2 class="sidebar-title">Featured</h2>
      <ul id="jsid-featured-item-container"
            data-ads-position="7"
            data-ads-tag="list-featured-sidebar-300x250"
            data-list-key="hot">
      </ul>
      <div class="loading hide"> <a class="btn spin" href="#">Loading</a> </div>
    </section>
    <div id="jsid-featured-sidebar-tail">
      <section id="jsid-featured-sidebar-ad" class="badge-block-ad block-ad">
        <div class="badge-gag-ads-container img-container" data-gag-ads="list-sidebar2-300x250-sticky"></div>
      </section>
      <section class="block-subscribe badge-email-subscription" style="padding-bottom: 20px;">
        <h2 class="sidebar-title">Subscribe to 9GAG</h2>
        <form>
          <div class="field badge-toggle-hide-when-done">
            <input class="badge-email-subscription-input badge-evt" data-evt="Email-Subscription,Input-Clicked,bottom"
                type="email" placeholder="Email address">
            <a class="btn badge-email-subscription-btn badge-evt" href="javascript:void(0);"
                 data-evt="Email-Subscription,Input-Clicked,bottom">Subscribe</a> </div>
          <div class="message hide badge-toggle-hide-when-done">
            <p>Thanks for signing up!</p>
          </div>
        </form>
      </section>
      <section class="get-the-app">
        <h2 class="sidebar-title">Get the App</h2>
        <ul>
          <li><a class="app-store" href="http://9gag.com/iphone" target="_blank" onClick="GAG.GA.track('iPhone-App', 'Clicked-Download', 'SidNavBanner');">Download on App Store</a></li>
          <li><a class="google-play" href="http://9gag.com/android" target="_blank" onClick="GAG.GA.track('Android-App', 'Clicked-Download', 'SidNavBanner');">Get it on Google Play</a></li>
        </ul>
      </section>
      <section class="footer">
        <p class="static"> <a href="http://9gag.com/advertise">Advertise</a> &middot; <a href="http://9gag.com/contact">Contacts</a> &middot; <a href="http://9gag.com/privacy">Privacy</a> &middot; <a href="http://9gag.com/tos">Terms</a> </p>
        <p class="static">9GAG &copy; 2014</p>
        <a class="badge-scroll-to-top back-to-top" href="javascript: void(0);">Back to top</a> </section>
    </div>
  </div>
</section>
