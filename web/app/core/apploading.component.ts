import {Component} from '@angular/core';
import {AppLoadingService} from "./service/apploading.service";

declare var jQuery: any;
@Component({
    selector: 'app-loading',
    templateUrl: 'app/core/views/app-loading.html',
})
export class AppLoadingComponent {

    private appLoadingService: AppLoadingService;

    isLoading = false;

    constructor(appLoadingService: AppLoadingService) {
        this.appLoadingService = appLoadingService;
    }

    ngOnInit() {
        this.appLoadingService.loadingEventEmitter
            .subscribe(loadingStatus => this.setLoadingStatus(loadingStatus));
    }

    private setLoadingStatus(loadingStatus: boolean) {
        this.isLoading = loadingStatus;
    }
}