import{Component} from '@angular/core';

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
        higher: [],
        self: [],
        lower: [],
    };

    constructor(verdictService: VerdictService, userService: UserService) {
        this.verdictService = verdictService;
        this.userService = userService;
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
        var offset = this.scoreboard.higher[ 'totalScores' ];
        this.getHigherScores(this.period.p, offset);
    }

    loadMoreLower() {
        var offset = this.scoreboard.lower[ 'totalScores' ];
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
                        if (!this.scoreboard.higher.hasOwnProperty('scores')) {
                            this.scoreboard.higher = scores;
                        } else {
                            this.scoreboard.higher[ 'scores' ] = this.scoreboard.higher[ 'scores' ].concat(scores.scores);
                            this.scoreboard.higher[ 'totalScores' ] = this.scoreboard.higher[ 'scores' ].length;
                            this.scoreboard.higher[ 'hasMore' ] = scores.hasMore;
                        }

                        this.higherScoresFetched = true;
                    });
            });
    }

    private getLowerScores(period: number, offset = 0) {
        this.userService.getCurrentUser()
            .subscribe(user => {
                this.verdictService.getLowerScores(user.id, period, offset)
                    .subscribe(scores => {
                        if (!this.scoreboard.lower.hasOwnProperty('scores')) {
                            this.scoreboard.lower = scores;
                        } else {
                            this.scoreboard.lower[ 'scores' ] = this.scoreboard.lower[ 'scores' ].concat(scores.scores);
                            this.scoreboard.lower[ 'totalScores' ] = this.scoreboard.lower[ 'scores' ].length;
                            this.scoreboard.lower[ 'hasMore' ] = scores.hasMore;
                        }

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