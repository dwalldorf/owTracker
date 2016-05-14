import {Component, enableProdMode} from '@angular/core';
import {
    Router,
    RouteConfig,
    ROUTER_DIRECTIVES
} from '@angular/router-deprecated'

import {AppConfig} from "./app.config";
import {HttpService} from "./core/service/http.service";
import {LoginComponent} from './user/login.component';
import {RegisterComponent} from './user/register.component';
import {DashboardComponent} from "./core/dashboard.component";
import {ScoreboardComponent} from "./overwatch/scoreboard.component";
import {VerdictBarComponent} from "./overwatch/verdict-bar.component";
import {UserService} from './user/service/user.service';
import {User} from "./user/model/user";
import {VerdictService} from "./overwatch/service/verdict.service";
import {CacheService} from "./core/service/cache.service";

enableProdMode();

@RouteConfig([
    {
        path: '/login',
        name: AppConfig.ROUTE_NAME_LOGIN,
        component: LoginComponent,
    },
    {
        path: '/register',
        name: AppConfig.ROUTE_NAME_REGISTER,
        component: RegisterComponent,
    },
    {
        path: '/',
        name: AppConfig.ROUTE_NAME_DASHBOARD,
        component: DashboardComponent
    },
    {
        path: 'scores',
        name: AppConfig.ROUTE_NAME_SCOREBOARD,
        component: ScoreboardComponent
    }
])

@Component({
    selector: 'owt-app',
    templateUrl: 'app/views/base.html',
    directives: [ ROUTER_DIRECTIVES, VerdictBarComponent ],
    providers: [ UserService, VerdictService, HttpService, CacheService ]
})
export class AppComponent {

    private userService: UserService;

    private router: Router;

    private currentUser: User;

    constructor(router: Router, userService: UserService) {
        this.router = router;
        this.userService = userService;
    }

    //noinspection JSUnusedGlobalSymbols
    ngOnInit() {
        this.userService.getCurrentUser().subscribe(
            user => this.currentUser = user,
            () => this.handleNotLoggedIn()
        );
    }

    handleNotLoggedIn() {
        this.router.navigate([ AppConfig.ROUTE_NAME_LOGIN ]);
    }

    logout() {
        this.userService.logout().subscribe();
        this.handleNotLoggedIn();
    }

}
