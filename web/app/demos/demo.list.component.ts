import {Component} from '@angular/core';
import {AppLoadingService} from "../core/service/apploading.service";
import {AppConfig} from "../app.config";
import {DemoService} from "./service/demo.service";
import {ItemCollection} from "../core/model/item.collection";
import {Demo} from "./model/demo";
import {Router, RouteConfig, ROUTER_DIRECTIVES} from '@angular/router-deprecated';

@Component({
    templateUrl: 'app/demos/views/demo-list.html',
    directives: [ ROUTER_DIRECTIVES ],
})
export class DemoListComponent {

    private LOADING_STATUS = AppConfig.ROUTE_NAME_DEMOS;

    private _appLoadingService: AppLoadingService;

    private _router: Router;

    private _demoService: DemoService;

    private demos: ItemCollection<Demo>;

    private restFinished = false;

    constructor(appLoadingService: AppLoadingService, router: Router, demoService: DemoService) {
        this._appLoadingService = appLoadingService;
        this._router = router;
        this._demoService = demoService;
    }

    ngOnInit() {
        console.log('demo list init');
        this._appLoadingService.setLoading(this.LOADING_STATUS);

        this._demoService.getDemos().subscribe(
            demos => {
                this.demos = demos;

                this._appLoadingService.finishedLoading(this.LOADING_STATUS);
                this.restFinished = true;
            }
        );
    }

    showDetail(id: string) {
        this._router.navigate([ 'DemoDetails', { id: id } ])
    }

}