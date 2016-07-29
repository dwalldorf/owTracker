import {Component} from '@angular/core';
import {RouteParams} from "@angular/router-deprecated";
import {DemoService} from "./service/demo.service";
import {Demo} from "./model/demo";

@Component({
    selector: 'demo-detail',
    templateUrl: 'app/demos/views/demo-detail.html',
})
export class DemoDetailComponent {

    private _demoService: DemoService;

    private _demoId: string;

    private restFinished: boolean;

    private demo: Demo;

    constructor(routeParams: RouteParams, demoService: DemoService) {
        this._demoService = demoService;
        this._demoId = routeParams.get('id');
    }

    ngOnInit() {
        this.loadDemo(this._demoId);
    }

    private loadDemo(id: string) {
        this.restFinished = false;
        this._demoService.getDemo(id).subscribe(
            demo => {
                this.demo = demo;
                this.restFinished = true;
            }
        );
    }
}