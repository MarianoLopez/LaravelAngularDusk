<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" th:xmlns="http://www.thymeleaf.org">
    @include('shared.header')
    <main>
        <div class="container">
            <div class="row">
                <div id="login-page">
                    <div class="col s6 z-depth-6 card-panel offset-s3">
                        <form class="col s12" name='loginForm' action="/doLogin" method='POST'>
                            <div class="row">
                                <div class="col s12 center">
                                    <img src="{{ asset('resources/images/Angular_Laravel.jpg') }}" alt="" class="responsive-img valign profile-image-login">
                                    <p class="center condensed light flow-text">Login Form</p>
                                    @if (session('error'))
                                        <div class="alert alert-success">
                                        <p class="center-align"><b>{{ session('error') }}</b></p>
                                        </div>
                                    @endif
                                  
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <i class="mdi-social-person-outline prefix"></i>
                                    <input placeholder="Username" id="username" type="text" class="validate" name="username"></input>
                                    <label class="active" for="username">Username</label>
                                </div>
                            </div>
                            <div class="row margin">
                                <div class="input-field col s12">
                                    <i class="mdi-action-lock-outline prefix"></i>
                                    <input placeholder="Password" id="password" type="password" name='password'/>
                                    <label class="active" for="password">Password</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input class="btn waves-effect waves-light col s12" id="submit" name="submit" type="submit" value="Login" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('shared.footer')
</html>