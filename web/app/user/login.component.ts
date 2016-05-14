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

    constructor(userService: UserService, router: Router) {
        this.userService = userService;
        this.router = router;

        this.resetUser();
    }

    //noinspection JSUnusedGlobalSymbols
    ngOnInit() {
        this.userService.getCurrentUser().subscribe(() => this.goToDashBoard());
    }

    private resetUser() {
        this.user = new User();
    }

    login() {
        this.userService.login(this.user).subscribe(() => this.goToDashBoard());
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

    goToDashBoard() {
        this.resetUser();
        this.router.navigate([ AppConfig.ROUTE_NAME_DASHBOARD ])
    }

}