import {Component, enableProdMode} from '@angular/core';
import {
    Router,
    RouteConfig,
    ROUTER_DIRECTIVES
} from '@angular/router-deprecated'

import {AppConfig} from "./app.config";
import {LoginComponent} from './user/login.component';
import {RegisterComponent} from './user/register.component';
import {UserService} from './user/user.service';
import {DashboardComponent} from "./dashboard.component";
import {HttpService} from "./http.service";
import {User} from "./user/user";

enableProdMode();

@Component({
    selector: 'owt-app',
    templateUrl: 'app/views/base.html',
    directives: [ ROUTER_DIRECTIVES ],
    providers: [ UserService, HttpService ]
})

@RouteConfig([
    {
        path: 'login',
        name: AppConfig.ROUTE_NAME_LOGIN,
        component: LoginComponent,
    },
    {
        path: 'register',
        name: AppConfig.ROUTE_NAME_REGISTER,
        component: RegisterComponent,
    },
    {
        path: '/',
        name: AppConfig.ROUTE_NAME_DASHBOARD,
        component: DashboardComponent
    }
])

export class AppComponent {

    private userService: UserService;

    private router: Router;

    private currentUser: User;

    constructor(router: Router, userService: UserService) {
        this.router = router;
        this.userService = userService;
    }

    ngOnInit() {
        this.userService.getMe().subscribe(
            res => this.setCurrentUser(<User> res.json()),
            err => this.handleNotLoggedIn()
        );
    }

    setCurrentUser(user: User) {
        this.currentUser = <User> user;
    }

    handleNotLoggedIn() {
        this.router.navigate([ AppConfig.ROUTE_NAME_LOGIN ]);
    }

    logout() {
        this.userService.logout().subscribe();
        this.handleNotLoggedIn();
    }

}
