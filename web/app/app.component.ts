import {Component} from '@angular/core';

@Component({
    selector: 'owt',
    templateUrl: 'app/views/base_logged_out.html'
})
export class AppComponent {
}

export class Verdict {
    id: string;
    userId: string;
    overwatchDate: string;
    map: string;
    aimAssist: boolean;
    visionAssist: boolean;
    otherAssist: boolean;
    griefing: boolean;
}