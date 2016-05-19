import {Component} from '@angular/core';
import {Router} from '@angular/router-deprecated';

import {AppConfig} from "../app.config";
import {UserService} from "./service/user.service";
import {User} from "./model/user";

@Component({
    templateUrl: 'app/user/views/login.html'
})
export class LoginComponent {

    private userService: UserService;

    private router: Router;

    private user: User;

    loginError = null;

    constructor(userService: UserService, router: Router) {
        this.userService = userService;
        this.router = router;

        this.resetUser();
    }

    //noinspection JSUnusedGlobalSymbols
    ngOnInit() {
        this.userService.getCurrentUser().subscribe(user => this.goToDashBoard());
    }

    private resetUser() {
        this.user = new User();
    }

    login() {
        this.userService.login(this.user)
            .subscribe(
                () => this.handleLogin(),
                () => this.handleLoginError()
            );
    }

    private handleLogin() {
        this.loginError = null;
        this.goToDashBoard()
    }

    private handleLoginError() {
        this.loginError = 'Login failed.'
    }

    goToRegistration() {
        this.resetUser();
        this.router.navigate([ AppConfig.ROUTE_NAME_REGISTER ])
    }

    goToDashBoard() {
        this.resetUser();
        this.router.navigate([ AppConfig.ROUTE_NAME_DASHBOARD ])
    }

}