import {Component} from '@angular/core';

import {VerdictService} from "../overwatch/service/verdict.service";

@Component({
    templateUrl: 'app/dashboard/views/dashboard.html'
})
export class DashboardComponent {

    private MAX_ITEMS_PER_PAGE = 10;

    private verdictService: VerdictService;

    userVerdicts = [];

    displayVerdicts = [];

    restFinished = false;

    numberOfPages = 0;

    currentPage = 0;

    constructor(verdictService: VerdictService) {
        this.verdictService = verdictService;
    }

    //noinspection JSUnusedGlobalSymbols
    ngOnInit() {
        this.fetchVerdicts();

        this.verdictService.verdictAddedEventEmitter.subscribe(verdict => {
            this.userVerdicts.unshift(verdict);
            this.setUserVerdicts(this.userVerdicts);
        })
    }

    fetchVerdicts(invalidateCache = false) {
        this.verdictService
            .getUserVerdicts()
            .subscribe(verdicts => this.setUserVerdicts(verdicts));
    }

    private setUserVerdicts(verdicts) {
        this.userVerdicts = verdicts;
        this.restFinished = true;

        var numberOfEntries = this.userVerdicts.length;
        if (numberOfEntries > 0) {
            this.numberOfPages = Math.ceil(numberOfEntries / this.MAX_ITEMS_PER_PAGE);
            this.paginate(0);
        }
    }

    paginate(page: number) {
        var start = page * this.MAX_ITEMS_PER_PAGE,
            end   = start + this.MAX_ITEMS_PER_PAGE;

        this.displayVerdicts = this.userVerdicts.slice(start, end);
        this.currentPage = page;
    }

}