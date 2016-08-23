import {Component} from '@angular/core';
import {FlashService} from "../core/service/flash.service";
import {AppLoadingService} from "../core/service/apploading.service";
import {UserService} from "./service/user.service";
import {User} from "./model/user";
import {FollowSteamId} from "./model/followSteamId";
import {FlashMessage} from "../core/model/flash.message";

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
    }

    showDialog() {
        jQuery('#usersettings-dialog').modal('show');

        this._userService.getCurrentUser().subscribe(user => {
            this._appLoadingService.finishedLoading(this.STATUS_ID);
            this.user = user;

            if (this.user.userSettings.followSteamIds.length == 0) {
                this.user.userSettings.followSteamIds = [ new FollowSteamId() ]
            }
        });
    }

    addSteamId() {
        this.user.userSettings.followSteamIds.push(new FollowSteamId());
    }

    save() {
        this._appLoadingService.setLoading(this.STATUS_ID);

        var followSteamIds = [];
        for (var i = 0; i < this.user.userSettings.followSteamIds.length; i++) {
            if (this.user.userSettings.followSteamIds[ i ].id.length > 0) {
                followSteamIds.push(this.user.userSettings.followSteamIds[ i ]);
            }
        }
        this.user.userSettings.followSteamIds = followSteamIds;

        this._userService.updateSettings(this.user).subscribe(() => {
            this.resetDialog();
            this._appLoadingService.finishedLoading(this.STATUS_ID);
            this._flashService.addMessage(new FlashMessage('User settings updated', FlashMessage.SUCCESS));
        });
    }

    resetDialog() {
        jQuery('#usersettings-dialog').modal('hide');
    }

}