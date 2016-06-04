import {Component} from '@angular/core';
import {
    Router,
    RouteConfig,
    ROUTER_DIRECTIVES
} from '@angular/router-deprecated'

import {AppConfig} from "../app.config";
import {AdminDashboardComponent} from "./admin-dashboard.component";
import {AdminFeedbackComponent} from "./admin-feedback.component";
import {AdminFeedbackService} from "./service/admin-feedback.service";
import {UserService} from "../user/service/user.service";

@Component({
    templateUrl: 'app/admin/views/admin-base.html',
    directives: [ ROUTER_DIRECTIVES ],
    providers: [ AdminDashboardComponent, AdminFeedbackComponent, AdminFeedbackService ],
})
export class AdminComponent {

    constructor(router: Router, userService: UserService) {
        userService.getCurrentUser().subscribe(user => {
            if (!user.isAdmin) {
                router.navigate([ AppConfig.ROUTE_NAME_ADMIN_DASHBOARD ]);
            }
        });
    }
}