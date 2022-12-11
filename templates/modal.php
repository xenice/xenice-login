<?php
defined( 'ABSPATH' ) || exit;
?>
<div class='user-login'>
 <!-- Login-modal -->
  <div class="modal fade" id="login-modal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
            <ul class="nav justify-content-center">
                <li class="nav-item">
                  <span class="nav-link active"><?=__('Login', 'xenice-login')?></span>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="javascript:;" id="register-trigger"><?=__('Register', 'xenice-login')?></a>
                </li>
            </ul>
            <div class="sign-tips alert alert-danger"></div>
            <form >
                <div class="form-group">
                    <input id="username" type="text" class="form-control" name="username" placeholder="<?=__('Username or Email', 'xenice-login')?>">
                </div>
                <div class="form-group">
                    <input id="password" type="password" class="form-control" name="password" placeholder="<?=__('Password', 'xenice-login')?>">
                </div>
                <div class="form-group">
                    <button id="login" type="button" class="btn btn-custom"><?=__('Login', 'xenice-login')?></button>
                </div>
                <div style="font-size:12px;text-align:right">
                    <a href="<?=wp_login_url()?>?action=lostpassword" id="forget-password-trigger" class="forget-password"><?=__('Forget password?', 'xenice-login')?></a>
                </div>
            </form>
        </div>
   
      </div>
    </div>
</div>
<!-- #Login-modal -->
<!-- Register-modal -->
  <div class="modal fade" id="register-modal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
            <ul class="nav justify-content-center">
              <li class="nav-item">
                  <a class="nav-link" href="javascript:;" id="login-trigger"><?=__('Login', 'xenice-login')?></a>
              </li>
              <li class="nav-item">
                  <span class="nav-link active" ><?=__('Register', 'xenice-login')?></span>
              </li>
            </ul>
            <div class="sign-tips alert"></div>
            <form >
                <div class="form-group">
                    <input id="r_username" type="text" class="form-control" name="username" placeholder="<?=__('Username', 'xenice-login')?>">
                </div>
                <div class="form-group">
                    <input id="r_email" type="text" class="form-control" name="email" placeholder="<?=__('Email', 'xenice-login')?>">
                </div>
                <div class="form-group">
                    <input id="r_password" type="password" class="form-control" name="password" placeholder="<?=__('Password', 'xenice-login')?>">
                </div>
                <div class="form-group">
                    <input id="r_repassword" type="password" class="form-control" name="repassword" placeholder="<?=__('Confirm password', 'xenice-login')?>">
                </div>
                <div class="input-group form-group">
					<input id="r_captcha" type="text" class="form-control" id="captcha" name="captcha" placeholder="<?=__('Captcha', 'xenice-login')?>">
					<div class="input-group-append">
                        <span id="r_captcha_clk" class="input-group-text"><?=__('Get captcha', 'xenice-login')?></span>
                    </div>
				</div>
                <div class="form-group">
                    <button id="register" type="button" class="btn btn-custom"><?=__('Register', 'xenice-login')?></button>
                </div>
            </form>
        </div>
   
      </div>
    </div>
</div>
    <!-- #Register-modal -->
</div>
