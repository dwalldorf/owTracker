import {Component} from '@angular/core';
import {Verdict} from "./model/verdict";
import {HttpService} from "../core/service/http.service";
import {VerdictService} from "./service/verdict.service";

@Component({
    selector: 'verdict-bar',
    templateUrl: 'app/overwatch/views/verdict-bar.html'
})

export class VerdictBarComponent {

    private httpService: HttpService;

    private verdictService: VerdictService;

    restFinished = false;
    verdict = new Verdict();
    mapPool = [];

    constructor(verdictService: VerdictService, httpService: HttpService) {
        this.verdictService = verdictService;
        this.httpService = httpService;

        this.verdict = new Verdict();
    }

    //noinspection JSUnusedGlobalSymbols
    ngOnInit() {
        this.verdictService
            .getMapPool()
            .subscribe(maps => this.setMapPool(maps));
    }

    submitVerdict() {
        console.log(this.verdict);
        this.verdict = new Verdict();
    }

    private setMapPool(maps) {
        this.mapPool = maps;
        this.restFinished = true;
    }

}