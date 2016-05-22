import {Component} from '@angular/core';
import {FlashService} from "./service/flash.service";
import {FlashMessage} from "./model/flash.message";

@Component({
    selector: 'flash-messages',
    templateUrl: 'app/core/views/flash.html',
})
export class FlashComponent {

    private flashService: FlashService;

    private messages = [];

    constructor(flashService: FlashService) {
        this.flashService = flashService;
    }

    ngOnInit() {
        this.flashService
            .flashEventEmitter
            .subscribe(message => this.showMessage(message));
    }

    private showMessage(message: FlashMessage) {
        this.messages.push(message);

        var self = this;
        setTimeout(function () {
            self.messages.pop();
        }, 5000);
    }
}