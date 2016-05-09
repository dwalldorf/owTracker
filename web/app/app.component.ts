import { Component } from '@angular/core';
import {
    RouteConfig,
    ROUTER_DIRECTIVES
} from '@angular/router-deprecated'

import { LoginComponent } from './user/login.component';
import { RegisterComponent } from './user/register.component';
import { UserService } from './user/user.service';
import { DashboardComponent } from "./dashboard.component";

@Component({
    selector: 'owt-app',
    templateUrl: 'app/views/base.html',
    directives: [ ROUTER_DIRECTIVES ],
    providers: [ UserService ]
})

@RouteConfig([
    {
        path: 'login',
        name: 'Login',
        component: LoginComponent,
    },
    {
        path: 'register',
        name: 'Register',
        component: RegisterComponent,
    },
    {
        path: '/',
        name: 'Dashboard',
        component: DashboardComponent
    }
])


export class AppComponent {

    constructor(private userService: UserService) {
    }

    ngOnInit() {
        // console.log(this.userService.login());
    }

}
