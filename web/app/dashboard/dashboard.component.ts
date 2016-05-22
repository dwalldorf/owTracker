import {Component} from '@angular/core';

import {VerdictService} from "../overwatch/service/verdict.service";
import {UserService} from "../user/service/user.service";

@Component({
    templateUrl: 'app/dashboard/views/dashboard.html',
})
export class DashboardComponent {

    private MAX_ITEMS_PER_PAGE = 10;

    private verdictService: VerdictService;

    private userService: UserService;

    userVerdicts = [];

    displayVerdicts = [];

    restFinished = false;

    numberOfPages = 0;

    currentPage = 0;

    constructor(verdictService: VerdictService, userService: UserService) {
        this.verdictService = verdictService;
        this.userService = userService;
    }

    //noinspection JSUnusedGlobalSymbols
    ngOnInit() {
        this.fetchVerdicts();

        this.verdictService.verdictAddedEventEmitter.subscribe(verdict => {
            this.userVerdicts.unshift(verdict);
            this.setUserVerdicts(this.userVerdicts);
        })
    }

    fetchVerdicts() {
        this.userService.getCurrentUser().subscribe(user => {
            this.verdictService
                .getUserVerdicts(user.id)
                .subscribe(verdicts => this.setUserVerdicts(verdicts));
        });
    }

    private setUserVerdicts(verdictCollection) {
        this.userVerdicts = verdictCollection.items;
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