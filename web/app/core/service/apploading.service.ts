import {EventEmitter, Injectable} from '@angular/core';

declare var Spinner: any;

@Injectable()
export class AppLoadingService {

    private loading = [];

    public loadingEventEmitter: EventEmitter<Boolean>;

    constructor() {
        this.loadingEventEmitter = new EventEmitter();
    }

    public setLoading(component: string) {
        this.loading[ component ] = true;
        this.fireLoadingStatusChanged();
    }

    public isLoading(component: string) {
        return component in this.loading;
    }

    public finishedLoading(component: string) {
        if (component in this.loading) {
            delete this.loading[ component ];
            this.fireLoadingStatusChanged();
        }
    }

    private fireLoadingStatusChanged() {
        this.loadingEventEmitter.emit(this.hasLoadingComponents());
    }

    private hasLoadingComponents() {
        for (var key in this.loading) {
            if (this.loading[ key ] == true) {
                return true;
            }
        }
        return false;
    }
}