import{Component} from '@angular/core';

import {ItemCollection} from "../core/model/item.collection";
import {VerdictService} from "./service/verdict.service";
import {UserService} from "../user/service/user.service";

@Component({
    templateUrl: 'app/overwatch/views/scoreboard.html'
})
export class ScoreboardComponent {

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
    period = this.periods[ 0 ];
    scoreboard = {
        higher: <ItemCollection>{},
        self: [],
        lower: <ItemCollection>{},
    };

    constructor(verdictService: VerdictService, userService: UserService) {
        this.verdictService = verdictService;
        this.userService = userService;

        this.scoreboard.higher = new ItemCollection();
        this.scoreboard.lower = new ItemCollection();
    }

    //noinspection JSUnusedGlobalSymbols
    ngOnInit() {
        this.getUserScore(this.period.p);
        this.getHigherScores(this.period.p);
        this.getLowerScores(this.period.p);
    }

    restFinished() {
        return (this.higherScoresFetched && this.lowerScoresFetched && this.userScoreFetched);
    }

    updatePeriod() {
        this.resetRestStatusFlags();
        this.getUserScore(this.period.p);
    }

    loadMoreHigher() {
        var offset = this.scoreboard.higher.totalItems;
        this.getHigherScores(this.period.p, offset);
    }

    loadMoreLower() {
        var offset = this.scoreboard.lower.totalItems;
        this.getLowerScores(this.period.p, offset);
    }

    private getUserScore(period: number) {
        this.userService.getCurrentUser()
            .subscribe(user => {
                this.verdictService.getUserScores(user.id, period)
                    .subscribe(
                        score => {
                            this.scoreboard.self = score;
                            this.userScoreFetched = true;
                        }
                    );
            });
    }

    private getHigherScores(period: number, offset = 0) {
        this.userService.getCurrentUser()
            .subscribe(user => {
                this.verdictService.getHigherScores(user.id, period, offset)
                    .subscribe(scores => {
                        this.scoreboard.higher.addItems(scores.items);
                        this.scoreboard.higher.hasMore = scores.hasMore;

                        this.higherScoresFetched = true;
                    });
            });
    }

    private getLowerScores(period: number, offset = 0) {
        this.userService.getCurrentUser()
            .subscribe(user => {
                this.verdictService.getLowerScores(user.id, period, offset)
                    .subscribe(scores => {
                        this.scoreboard.lower.addItems(scores.items);
                        this.scoreboard.lower.hasMore = scores.hasMore;

                        this.lowerScoresFetched = true;
                    });
            });
    }

    private resetRestStatusFlags() {
        this.higherScoresFetched = false;
        this.lowerScoresFetched = false;
        this.userScoreFetched = false;
    }
}