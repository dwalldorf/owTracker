import {Component} from '@angular/core';
import {Router} from '@angular/router-deprecated';

import {AppConfig} from "../app.config";
import {UserService} from "./user.service";
import {User} from "./user";

@Component({
    templateUrl: 'app/user/views/login.html'
})

export class LoginComponent {

    private user: User;

    constructor(private userService: UserService, private router: Router) {
        this.resetUser();
    }

    private resetUser() {
        this.user = new User();
    }

    login() {
        this.userService.login(this.user).subscribe(
            null,
            err => this.handleLoginError(err),
            () => this.router.navigate([ AppConfig.ROUTE_NAME_DASHBOARD ])
        );
    }

    handleLoginError(err) {
        console.error(err);

        // TODO: implement
        console.log('implement me!');
    }

    goToRegistration() {
        this.resetUser();
        this.router.navigate([ AppConfig.ROUTE_NAME_REGISTER ])
    }

}