import {Component} from '@angular/core';
import {Router} from '@angular/router-deprecated';

import {AppConfig} from "../app.config";
import {UserService} from "./service/user.service";
import {User} from "./model/user";

@Component({
    templateUrl: 'app/user/views/register.html'
})

export class RegisterComponent {

    private user: User;

    constructor(private userService: UserService, private router: Router) {
        this.user = new User();
    }

    register() {
        this.userService.register(this.user).subscribe(
            null,
            err => this.handleRegisterError(err),
            () => this.goToLogin()
        );
    }

    handleRegisterError(err) {
        console.error(err);

        // TODO: implement
        console.log('implement me!');
    }

    goToLogin() {
        this.router.navigate([ AppConfig.ROUTE_NAME_LOGIN ])
    }

}