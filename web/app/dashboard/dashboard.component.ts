import {Component} from '@angular/core';

import {VerdictService} from "../overwatch/service/verdict.service";
import {UserService} from "../user/service/user.service";
import {ItemCollection} from "../core/model/item.collection";

@Component({
    templateUrl: 'app/dashboard/views/dashboard.html',
})
export class DashboardComponent {

    private MAX_ITEMS_PER_PAGE = 20;

    private verdictService: VerdictService;

    private userService: UserService;

    userVerdicts = new ItemCollection();

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
            this.userVerdicts.addItem(verdict);
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
        this.userVerdicts.setItems(verdictCollection.items);
        this.restFinished = true;

        var numberOfEntries = this.userVerdicts.totalItems;
        if (numberOfEntries > 0) {
            this.numberOfPages = Math.ceil(numberOfEntries / this.MAX_ITEMS_PER_PAGE);
            this.paginate(0);
        }
    }

    paginate(page: number) {
        var start = page * this.MAX_ITEMS_PER_PAGE,
            end   = start + this.MAX_ITEMS_PER_PAGE;

        this.displayVerdicts = this.userVerdicts.items.slice(start, end);
        this.currentPage = page;
    }

}