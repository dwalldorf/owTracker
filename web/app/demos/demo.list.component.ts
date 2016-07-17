import {Component} from '@angular/core';
import {AppLoadingService} from "../core/service/apploading.service";
import {AppConfig} from "../app.config";
import {DemoService} from "./service/demo.service";
import {ItemCollection} from "../core/model/item.collection";
import {Demo} from "./model/demo";

@Component({
    templateUrl: 'app/demos/views/demos.html',
})
export class DemoListComponent {

    private LOADING_STATUS = AppConfig.ROUTE_NAME_DEMOS;

    private _appLoadingService: AppLoadingService;

    private _demoService: DemoService;

    private demos: ItemCollection<Demo>;

    private restFinished = false;

    private showList = true;

    private showDemoDetail = false;

    constructor(appLoadingService: AppLoadingService, demoService: DemoService) {
        this._appLoadingService = appLoadingService;
        this._demoService = demoService;
    }

    ngOnInit() {
        this._appLoadingService.setLoading(this.LOADING_STATUS);

        this._demoService.getDemos().subscribe(
            demos => {
                this.demos = demos;
                console.log(this.demos);

                this._appLoadingService.finishedLoading(this.LOADING_STATUS);
                this.restFinished = true;
            }
        );
    }

    showDetail(){
        
    }
}