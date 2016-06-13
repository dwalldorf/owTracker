import{Component} from '@angular/core';

import {ItemCollection} from "../core/model/item.collection";
import {VerdictService} from "./service/verdict.service";
import {UserService} from "../user/service/user.service";
import {UserScore} from "./model/user.score";
import {AppLoadingService} from "../core/service/apploading.service";
import {AppConfig} from "../app.config";
import {Scoreboard} from "./model/scoreboard";

@Component({
    templateUrl: 'app/overwatch/views/scoreboard.html',
})
export class ScoreboardComponent {

    private LOADING_STATUS = AppConfig.ROUTE_NAME_SCOREBOARD;
    private LOADING_STATUS_HIGHER = this.LOADING_STATUS + ':higher';
    private LOADING_STATUS_LOWER = this.LOADING_STATUS + ':lower';

    private appLoadingService: AppLoadingService;

    private verdictService: VerdictService;

    private userService: UserService;

    private higherScoresFetched = false;
    private lowerScoresFetched = false;
    private userScoreFetched = false;

    periods = [
        {
            p: 30,
            name: 'monthly'
        },
        {
            p: 7,
            name: 'weekly'
        },
        {
            p: 1,
            name: 'daily'
        },
        {
            p: 0,
            name: 'all time'
        }
    ];
    selectedPeriod = 7;
    scoreboard = new Scoreboard();

    constructor(appLoadingService: AppLoadingService, verdictService: VerdictService, userService: UserService) {
        this.appLoadingService = appLoadingService;
        this.verdictService = verdictService;
        this.userService = userService;
    }

    //noinspection JSUnusedGlobalSymbols
    ngOnInit() {
        this.getScoreboard(this.selectedPeriod);
    }

    restFinished() {
        if (this.higherScoresFetched && this.lowerScoresFetched && this.userScoreFetched) {
            this.appLoadingService.finishedLoading(AppConfig.ROUTE_NAME_SCOREBOARD);
            return true;
        }
        return false;
    }

    noScoresPresent() {
        if (!this.restFinished()) {
            return false;
        }

        return (this.scoreboard.lower.totalItems == 0);
    }

    updatePeriod(period) {
        this.selectedPeriod = period;
        this.getScoreboard(this.selectedPeriod);
    }

    loadMoreHigher() {
        var offset = this.scoreboard.higher.totalItems;
        this.getHigherScores(this.selectedPeriod, offset);
    }

    loadMoreLower() {
        var offset = this.scoreboard.lower.totalItems;
        this.getLowerScores(this.selectedPeriod, offset);
    }

    private getScoreboard(period: number) {
        this.resetRestStatusFlags();
        this.appLoadingService.setLoading(this.LOADING_STATUS);

        this.getUserScore(period);
        this.getHigherScores(period);
        this.getLowerScores(period);
    }

    private getUserScore(period: number) {
        this.userService.getCurrentUser()
            .subscribe(user => {
                this.verdictService.getUserScores(user.id, period)
                    .subscribe(
                        score => {
                            this.scoreboard.self = score;
                            this.userScoreFetched = true;
                        },
                        () => this.userScoreFetched = true
                    );
            });
    }

    private getHigherScores(period: number, offset = 0) {
        this.appLoadingService.setLoading(this.LOADING_STATUS_HIGHER);
        this.userService.getCurrentUser()
            .subscribe(user => {
                this.verdictService.getHigherScores(user.id, period, offset)
                    .subscribe(scores => {
                        this.scoreboard.higher.addItems(scores.items);
                        this.scoreboard.higher.hasMore = scores.hasMore;

                        this.higherScoresFetched = true;
                        this.appLoadingService.finishedLoading(this.LOADING_STATUS_HIGHER);
                    });
            });
    }

    private getLowerScores(period: number, offset = 0) {
        this.appLoadingService.setLoading(this.LOADING_STATUS_LOWER);
        this.userService.getCurrentUser()
            .subscribe(user => {
                this.verdictService.getLowerScores(user.id, period, offset)
                    .subscribe(scores => {
                        this.scoreboard.lower.addItems(scores.items);
                        this.scoreboard.lower.hasMore = scores.hasMore;

                        this.lowerScoresFetched = true;
                        this.appLoadingService.finishedLoading(this.LOADING_STATUS_LOWER);
                    });
            });
    }

    private resetRestStatusFlags() {
        this.higherScoresFetched = false;
        this.lowerScoresFetched = false;
        this.userScoreFetched = false;
    }
}