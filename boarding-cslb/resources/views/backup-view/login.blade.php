@include('header')
    <?php $home_link = "https://onboarding.cslb.at/"; ?>
    <main class="site-main wrap-login" id="login-page">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="webapp-vertical-middle">
                        <form id="webapp-form-login" action="#" class="webapp-form">
                            <div class="row justify-content-center">
                                <div class="col-md-12 form-item">
                                    <img src="resources/images/webapp-logo.png" class="webapp-logo" height="84" width="126" />
                                </div>
                                <div class="col-md-12 form-item">
                                    <input type="text" id="username" name="username" placeholder="Benutzer" />
                                </div>
                                <div class="col-md-12 form-item">
                                    <input type="password" id="password" name="password" placeholder="Passwort" />
                                </div>
                                <div class="col-md-12 form-item login-button-main">
                                    <input type="hidden" name="ci_csrf_token" value="" />
                                    <button class="webapp-button" type="submit">ANMELDEN</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>

    </main>
@include('footer')
