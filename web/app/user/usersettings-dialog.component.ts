import {Component} from '@angular/core';
import {FlashService} from "../core/service/flash.service";
import {FlashMessage} from "../core/model/flash.message";
import {AppLoadingService} from "../core/service/apploading.service";
import {UserService} from "./service/user.service";
import {User} from "./model/user";

declare var jQuery: any;
@Component({
    selector: 'usersettings-dialog',
    templateUrl: 'app/user/views/usersettings-dialog.html',
})
export class UserSettingsDialogComponent {

    private STATUS_ID = 'userSettings';

    private _appLoadingService: AppLoadingService;
    private _flashService: FlashService;
    private _userService: UserService;

    private user: User;

    constructor(appLoadingService: AppLoadingService, flashService: FlashService, userService: UserService) {
        this._appLoadingService = appLoadingService;
        this._flashService = flashService;
        this._userService = userService;

        this.user = new User();
    }

    ngOnInit() {
        this._userService.getCurrentUser().subscribe(user => {
            this.user = user;
        });
    }

    submit() {
        this._appLoadingService.setLoading(this.STATUS_ID);
        // this.feedbackService.submitFeedback(this.feedback)
        //     .subscribe(() => {
        //         this.appLoadingService.finishedLoading(this.STATUS_ID);
        //         this.resetDialog();
        //         this.flashService.addMessage(new FlashMessage('Your feedback was submitted!', FlashMessage.SUCCESS));
        //     });
    }

    showDialog() {
        jQuery('#usersettings-dialog').modal('show');
    }

    save() {

    }

    resetDialog() {
        jQuery('#usersettings-dialog').modal('hide');
    }

}