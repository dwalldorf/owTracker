import{Component} from '@angular/core';

import {VerdictService} from "./service/verdict.service";
import {UserService} from "../user/service/user.service";
import {User} from "../user/model/user";

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

    currentUser = new User();

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
        this.getScoreboard(this.period.p);
    }

    private getScoreboard(period: number) {
        this.userService.getCurrentUser()
            .subscribe(user=> {
                    this.currentUser = user;
                    this.verdictService.getHigherScores(user.id, period)
                        .subscribe(scores => {
                            this.scoreboard.higher = scores;
                            this.higherScoresFetched = true;
                        });
                    this.verdictService.getLowerScores(user.id, period)
                        .subscribe(scores => {
                            this.scoreboard.lower = scores;
                            this.lowerScoresFetched = true;
                        });
                    this.verdictService.getUserScores(user.id, period)
                        .subscribe(
                            score => {
                                this.scoreboard.self = score;
                                this.userScoreFetched = true;
                            }
                        );
                }
            );
    }

    restFinished() {
        return (this.higherScoresFetched && this.lowerScoresFetched && this.userScoreFetched);
    }

    updatePeriod() {
        this.resetRestStatusFlags();
        this.getScoreboard(this.period.p);
    }

    private resetRestStatusFlags() {
        this.higherScoresFetched = false;
        this.lowerScoresFetched = false;
        this.userScoreFetched = false;
    }
}