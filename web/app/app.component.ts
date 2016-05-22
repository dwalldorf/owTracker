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
import {DashboardComponent} from "./dashboard/dashboard.component";
import {ScoreboardComponent} from "./overwatch/scoreboard.component";
import {UserService} from './user/service/user.service';
import {User} from "./user/model/user";
import {VerdictService} from "./overwatch/service/verdict.service";
import {CacheService} from "./core/service/cache.service";
import {FeedbackDialogComponent} from "./feedback/feedback-dialog.component";
import {FeedbackService} from "./feedback/service/feedback.service";
import {VerdictDialogComponent} from "./overwatch/verdict-dialog.component";
import {FlashService} from "./core/service/flash.service";
import {FlashComponent} from "./core/flash.component";
import {AdminFeedbackComponent} from "./admin/admin-feedback.component";
import {AdminComponent} from "./admin/admin.component";
import {AdminFeedbackService} from "./admin/service/admin-feedback.service";

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
        component: DashboardComponent,
    },
    {
        path: '/scores',
        name: AppConfig.ROUTE_NAME_SCOREBOARD,
        component: ScoreboardComponent,
    },
    {
        path: '/admin/...',
        name: AppConfig.ROUTE_NAME_ADMIN,
        component: AdminComponent,
    },
    {
        path: '/**',
        redirectTo: [ AppConfig.ROUTE_NAME_DASHBOARD ],
    },
])

@Component({
    selector: 'owt-app',
    templateUrl: 'app/views/base.html',
    directives: [ ROUTER_DIRECTIVES, FlashComponent, VerdictDialogComponent, FeedbackDialogComponent ],
    providers: [
        HttpService,
        CacheService,
        FlashService,

        UserService,
        VerdictService,
        FeedbackService,

        AdminComponent,
    ],
})
export class AppComponent {

    private userService: UserService;

    private router: Router;

    private allowedRoutesWithoutLogin = [
        AppConfig.ROUTE_NAME_LOGIN,
        AppConfig.ROUTE_NAME_REGISTER,
    ];

    currentUser: User;

    restFinished = false;
    isLoggedIn = false;

    constructor(router: Router, userService: UserService) {
        this.router = router;
        this.userService = userService;
    }

    //noinspection JSUnusedGlobalSymbols
    ngOnInit() {
        this.userService.getCurrentUser().subscribe(
            user => this.handleLoggedIn(user),
            () => this.handleNotLoggedIn()
        );
    }

    handleLoggedIn(user: User) {
        this.currentUser = user;

        this.restFinished = true;
        this.isLoggedIn = true;
    }

    handleNotLoggedIn() {
        this.isLoggedIn = false;
        this.restFinished = true;

        var currentRouteAllowedWithoutLogin = false;
        for (var routeName of this.allowedRoutesWithoutLogin) {
            var route = this.router.generate([ routeName ]);

            if (this.router.isRouteActive(route)) {
                currentRouteAllowedWithoutLogin = true;
                break;
            }
        }

        if (!currentRouteAllowedWithoutLogin) {
            this.router.navigate([ AppConfig.ROUTE_NAME_LOGIN ]);
        }
    }

    logout() {
        this.userService.logout().subscribe(() => this.handleNotLoggedIn());
    }

}
