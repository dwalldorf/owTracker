import {Component} from '@angular/core';
import {ROUTER_DIRECTIVES} from '@angular/router-deprecated';
import {UserService} from "../user/service/user.service";
import {NavigationElement} from "./model/navigation.element";
import {AppConfig} from "../app.config";
import {NavigationService} from "./service/navigation.service";

@Component({
    'selector': 'navigation',
    templateUrl: 'app/core/views/navigation.html',
    directives: [ ROUTER_DIRECTIVES ],
})
export class NavigationComponent {

    private _navigationService: NavigationService;

    private _userService: UserService;

    navigationElements: [NavigationElement];

    constructor(navigationService: NavigationService, userService: UserService) {
        this._navigationService = navigationService;
        this._userService = userService;
    }

    ngOnInit() {
        this.navigationElements = [
            new NavigationElement('', 'Dashboard', '/dashboard', AppConfig.ROUTE_NAME_DASHBOARD, 'glyphicon glyphicon-home'),
            new NavigationElement('Scoreboard', 'Scoreboard', '/scores', AppConfig.ROUTE_NAME_SCOREBOARD),
            new NavigationElement('My demos', 'Demos', '/demos', AppConfig.ROUTE_NAME_DEMOS),
        ];

        this._userService.getCurrentUser()
            .subscribe(user => {
                if (user.userSettings.isAdmin) {
                    this.navigationElements.push(new NavigationElement('Admin', 'Admin', '/admin/dashboard', AppConfig.ROUTE_NAME_ADMIN));
                }
            });
    }

    navigate(link: string) {
        this._navigationService.navigate(link);
    }

    isActive(route) {
        return this._navigationService.isRouteActive(route);
    }
}