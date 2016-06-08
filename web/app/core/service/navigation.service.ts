import {Injectable} from '@angular/core';
import {Router} from '@angular/router-deprecated';
import {AppConfig} from "../../app.config";

@Injectable()
export class NavigationService {

    private _router: Router;

    constructor(router: Router) {
        this._router = router;
    }

    public navigate(link: string) {
        this._router.navigate([ link ]);
    }

    public isRouteActive(routeInQuestion) {
        if (routeInQuestion == null) {
            return false;
        }

        if (routeInQuestion == AppConfig.ROUTE_NAME_ADMIN) {
            var currentInstruction = this._router.currentInstruction;
            if (currentInstruction == null) {
                return false;
            }
            return currentInstruction.component.urlPath == 'admin';
        }

        try {
            return this._router.isRouteActive(this._router.generate([ routeInQuestion ]));
        } catch (ex) {
            return false;
        }
    }
}