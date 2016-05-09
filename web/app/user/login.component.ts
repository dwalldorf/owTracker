import { Component } from '@angular/core';
import { Router } from '@angular/router-deprecated';

import { UserService } from "./user.service";
import { User } from "./user";

@Component({
    templateUrl: 'app/user/views/login.html'
})

export class LoginComponent {

    private user: User;

    private res;

    constructor(private userService: UserService, private router: Router) {
        this.resetUser();
    }

    private resetUser() {
        this.user = new User();
    }

    login() {
        this.userService.login(this.user).subscribe(
            res => this.res = res,
            err => console.error(err),
            () => this.router.navigate([ 'Dashboard' ])
        );
    }

    goToRegistration() {
        this.resetUser();
        this.router.navigate([ 'Register' ])
    }

}