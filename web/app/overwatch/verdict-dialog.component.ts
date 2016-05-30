import {Component} from '@angular/core';
import {Verdict} from "./model/verdict";
import {HttpService} from "../core/service/http.service";
import {VerdictService} from "./service/verdict.service";
import {AppLoadingService} from "../core/service/apploading.service";

declare var jQuery: any;
@Component({
    selector: 'verdict-dialog',
    templateUrl: 'app/overwatch/views/verdict-dialog.html',
})
export class VerdictDialogComponent {

    private STATUS_ID = 'verdictDialog';

    private httpService: HttpService;

    private verdictService: VerdictService;

    private appLoadingService: AppLoadingService;

    restFinished = false;
    verdict: Verdict;
    mapPool = [];

    constructor(verdictService: VerdictService, httpService: HttpService, appLoadingService: AppLoadingService) {
        this.verdictService = verdictService;
        this.httpService = httpService;
        this.appLoadingService = appLoadingService;

        this.resetVerdict();
    }

    //noinspection JSUnusedGlobalSymbols
    ngOnInit() {
        this.appLoadingService.setLoading(this.STATUS_ID);
        this.verdictService
            .getMapPool()
            .subscribe(maps => this.setMapPool(maps));
    }

    submitVerdict() {
        this.restFinished = false;
        this.verdictService.submitVerdict(this.verdict)
            .subscribe(() => {
                this.restFinished = true;
                this.closeDialog();
            });
    }

    showDialog() {
        jQuery('#verdict-dialog').modal('show');
    }

    closeDialog() {
        jQuery('#verdict-dialog').modal('hide');
        this.resetVerdict();
    }

    private setMapPool(maps) {
        this.mapPool = maps;
        
        this.restFinished = true;
        this.appLoadingService.finishedLoading(this.STATUS_ID);
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