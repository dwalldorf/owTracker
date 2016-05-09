import { Component } from '@angular/core';
import { Router } from '@angular/router-deprecated';


import { UserService } from "./user.service";
import { User } from "./user";

@Component({
    templateUrl: 'app/user/views/register.html'
})

export class RegisterComponent {

    private user: User;

    private res;

    constructor(private userService: UserService, private router: Router) {
        this.user = new User();
    }

    register() {
        this.userService.register(this.user).subscribe(
            res => this.res = res,
            err => console.error(err),
            () => this.router.navigate([ 'Login' ])
        );
    }

    goToLogin() {
        this.router.navigate([ 'Login' ])
    }

}