import {Component} from '@angular/core';
import {AdminStatsService} from "./service/admin-stat.service";

@Component({
    templateUrl: 'app/admin/views/dashboard.html',
})
export class AdminDashboardComponent {

    private adminStatsService: AdminStatsService;

    restFinished = false;
    stats = [];

    constructor(adminStatsService: AdminStatsService) {
        this.adminStatsService = adminStatsService;
    }

    ngOnInit() {
        this.adminStatsService.getAdminStats()
            .subscribe(stats => this.setStats(stats));
    }

    private setStats(stats) {
        this.stats = stats;
        this.restFinished = true;
    }

}