import {Component, EventEmitter} from '@angular/core';
import {Verdict} from "./model/verdict";
import {HttpService} from "../core/service/http.service";
import {VerdictService} from "./service/verdict.service";

declare var jQuery: any;
@Component({
    selector: 'verdict-dialog',
    templateUrl: 'app/overwatch/views/verdict-dialog.html'
})
export class VerdictDialogComponent {

    private httpService: HttpService;

    private verdictService: VerdictService;

    disableSubmit = true;
    verdict: Verdict;
    mapPool = [];

    constructor(verdictService: VerdictService, httpService: HttpService) {
        this.verdictService = verdictService;
        this.httpService = httpService;

        this.resetVerdict();
    }

    //noinspection JSUnusedGlobalSymbols
    ngOnInit() {
        this.verdictService
            .getMapPool()
            .subscribe(maps => this.setMapPool(maps));
    }

    submitVerdict() {
        this.disableSubmit = true;
        this.verdictService.submitVerdict(this.verdict)
            .subscribe(() => {
                this.resetVerdict();
                this.disableSubmit = false;
            });
    }

    showDialog() {
        jQuery('#verdict-dialog').modal('show');
    }

    private setMapPool(maps) {
        this.mapPool = maps;
        this.disableSubmit = false;
    }

    private resetVerdict() {
        this.verdict = new Verdict();
        this.verdict.overwatchDate = this.formatDate(new Date());
    }

    private formatDate(date) {
        var d     = new Date(date),
            month = '' + (d.getMonth() + 1),
            day   = '' + d.getDate(),
            year  = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [ year, month, day ].join('-');
    }

}