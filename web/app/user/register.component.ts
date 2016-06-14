import {Component} from '@angular/core';
import {Router} from '@angular/router-deprecated';

import {AppConfig} from "../app.config";
import {UserService} from "./service/user.service";
import {User} from "./model/user";

@Component({
    templateUrl: 'app/user/views/register.html'
})
export class RegisterComponent {

    private router: Router;
    private userService: UserService;

    private user: User;

    formErrors = [];

    constructor(userService: UserService, router: Router) {
        this.router = router;
        this.userService = userService;

        this.user = new User();
    }

    ngOnInit() {
        this.userService.getCurrentUser(true).subscribe(() => this.goToLogin());
    }

    register() {
        this.userService.register(this.user).subscribe(
            () => this.handleRegisterSuccess(),
            err => this.handleRegisterError(err.json())
        );
    }

    private goToLogin() {
        this.router.navigate([ AppConfig.ROUTE_NAME_LOGIN ]);
    }

    private handleRegisterSuccess() {
        this.formErrors = [];
        this.goToLogin();
    }

    private handleRegisterError(err) {
        this.formErrors = [];

        if (err.hasOwnProperty('errors')) {
            var errors = err.errors;
            for (var key in errors) {
                this.formErrors[ key ] = errors[ key ];
            }
        }
    }

}