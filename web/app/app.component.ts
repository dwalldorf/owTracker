import {Component, enableProdMode} from '@angular/core';
import {Router, RouteConfig, ROUTER_DIRECTIVES} from '@angular/router-deprecated'

import {AppConfig} from "./app.config";
import {HttpService} from "./core/service/http.service";
import {LoginComponent} from './user/login.component';
import {RegisterComponent} from './user/register.component';
import {DashboardComponent} from "./dashboard/dashboard.component";
import {ScoreboardComponent} from "./overwatch/scoreboard.component";
import {UserService} from './user/service/user.service';
import {VerdictService} from "./overwatch/service/verdict.service";
import {CacheService} from "./core/service/cache.service";
import {FeedbackDialogComponent} from "./feedback/feedback-dialog.component";
import {FeedbackService} from "./feedback/service/feedback.service";
import {VerdictDialogComponent} from "./overwatch/verdict-dialog.component";
import {FlashService} from "./core/service/flash.service";
import {FlashComponent} from "./core/flash.component";
import {AdminComponent} from "./admin/admin.component";
import {AppLoadingComponent} from "./core/apploading.component";
import {AppLoadingService} from "./core/service/apploading.service";
import {AdminStatsService} from "./admin/service/admin-stat.service";
import {NavigationComponent} from "./core/navigation.component";
import {NavigationService} from "./core/service/navigation.service";
import {AdminFeedbackService} from "./admin/service/admin-feedback.service";
import {DemoUploadComponent} from "./demoupload/demo-upload.component";
import {DemoUploadService} from "./demoupload/service/demo-upload.service";
import {DemoService} from "./demos/service/demo.service";
import {DemoListComponent} from "./demos/demo.list.component";
import {DemoDetailComponent} from "./demos/demo.detail.component";

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
        path: '/demos',
        name: AppConfig.ROUTE_NAME_DEMOS,
        component: DemoListComponent,
    },
    {
        path: '/demo/:id',
        name: AppConfig.ROUTE_NAME_DEMO_DETAILS,
        component: DemoDetailComponent,
    },
    {
        path: '/admin/...',
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
    directives: [
        ROUTER_DIRECTIVES,
        AppLoadingComponent,
        FlashComponent,
        NavigationComponent,
        VerdictDialogComponent,
        FeedbackDialogComponent,
        DemoListComponent,
        DemoDetailComponent,
        DemoUploadComponent,
        AdminComponent,
    ],
    providers: [
        AppLoadingService,
        HttpService,
        CacheService,
        NavigationService,
        FlashService,

        UserService,
        VerdictService,
        FeedbackService,
        DemoService,
        DemoUploadService,

        AdminComponent,
        AdminFeedbackService,
        AdminStatsService
    ],
})
export class AppComponent {

    private _router: Router;

    private _appLoadingService: AppLoadingService;

    private _userService: UserService;

    private _navigationService: NavigationService;

    private _allowedRoutesWithoutLogin = [
        AppConfig.ROUTE_NAME_LOGIN,
        AppConfig.ROUTE_NAME_REGISTER,
    ];

    restFinished = false;

    showDemoUploadOverlay = false;

    constructor(router: Router, appLoadingService: AppLoadingService, navigationService: NavigationService, userService: UserService) {
        this._router = router;
        this._appLoadingService = appLoadingService;
        this._navigationService = navigationService;
        this._userService = userService;
    }

    ngOnInit() {
        this._appLoadingService.setLoading('app');
        this._userService.getCurrentUser().subscribe(
            () => this.handleLoggedIn(),
            () => this.handleNotLoggedIn()
        );
    }

    handleLoggedIn() {
        this._appLoadingService.finishedLoading('app');
        this.restFinished = true;
    }

    handleNotLoggedIn() {
        this._appLoadingService.finishedLoading('app');
        this.restFinished = true;

        var currentRouteAllowedWithoutLogin = false;
        for (var routeName of this._allowedRoutesWithoutLogin) {
            var route = this._router.generate([ routeName ]);

            if (this._router.isRouteActive(route)) {
                currentRouteAllowedWithoutLogin = true;
                break;
            }
        }

        if (!currentRouteAllowedWithoutLogin) {
            this._router.navigate([ AppConfig.ROUTE_NAME_LOGIN ]);
        }
    }

    isLoggedIn() {
        var currentUser = this._userService.currentUser;

        if (currentUser && currentUser.hasOwnProperty('id')) {
            return currentUser.id.length == 24;
        }
        return false;
    }

    logout() {
        this._userService.logout().subscribe(() => this.handleNotLoggedIn());
    }

    toggleShowDemoUpload() {
        this.showDemoUploadOverlay = !this.showDemoUploadOverlay;
    }

    displayAdminMenu() {
        return this._navigationService.isRouteActive(AppConfig.ROUTE_NAME_ADMIN);
    }

}
