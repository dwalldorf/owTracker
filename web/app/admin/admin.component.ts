import {Component} from '@angular/core';
import {RouteConfig, ROUTER_DIRECTIVES} from '@angular/router-deprecated'

import {AppConfig} from "../app.config";
import {AdminDashboardComponent} from "./admin-dashboard.component";
import {AdminFeedbackComponent} from "./admin-feedback.component";
import {AdminFeedbackService} from "./service/admin-feedback.service";

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
        },
    ]
)
@Component({
    templateUrl: 'app/admin/views/admin-base.html',
    directives: [ ROUTER_DIRECTIVES ],
    providers: [ AdminDashboardComponent, AdminFeedbackComponent, AdminFeedbackService ],
})
export class AdminComponent {

    ngOnint() {
        console.log('admin component init');
    }

}