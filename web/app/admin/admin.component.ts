import {Component} from '@angular/core';
import {
    Router,
    RouteConfig,
    ROUTER_DIRECTIVES
} from '@angular/router-deprecated'

import {AppConfig} from "../app.config";
import {AdminDashboardComponent} from "./admin-dashboard.component";
import {AdminFeedbackComponent} from "./feedback/admin-feedback.component";
import {AdminFeedbackService} from "./service/admin-feedback.service";
import {UserService} from "../user/service/user.service";
import {AdminStatsService} from "./service/admin-stat.service";

@RouteConfig([
    {
        path: 'dashboard',
        name: AppConfig.ROUTE_NAME_ADMIN_DASHBOARD,
        component: AdminDashboardComponent,
    },
    {
        path: 'feedback',
        name: AppConfig.ROUTE_NAME_ADMIN_FEEDBACK,
        component: AdminFeedbackComponent,
    }
])
@Component({
    templateUrl: 'app/admin/views/admin-base.html',
    directives: [ ROUTER_DIRECTIVES ],
    providers: [ AdminDashboardComponent, AdminFeedbackComponent, AdminStatsService, AdminFeedbackService ],
})
export class AdminComponent {

    private _router: Router;

    private _userService: UserService;

    constructor(router: Router, userService: UserService) {
        this._router = router;
        this._userService = userService;
    }

    ngOnInit() {
        this._userService.getCurrentUser();
    }
}