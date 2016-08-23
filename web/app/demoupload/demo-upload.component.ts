import {Component} from '@angular/core';
import {CORE_DIRECTIVES, FORM_DIRECTIVES, NgClass, NgStyle} from '@angular/common';
import {FILE_UPLOAD_DIRECTIVES, FileSelectDirective, FileUploader} from 'ng2-file-upload/ng2-file-upload';
import {DemoUploadService} from "./service/demo-upload.service";
import {FlashService} from "../core/service/flash.service";

declare var jQuery: any;

@Component({
    selector: 'demo-upload',
    templateUrl: 'app/demoupload/views/demo-upload.html',
    directives: [ FILE_UPLOAD_DIRECTIVES, NgClass, NgStyle, CORE_DIRECTIVES, FORM_DIRECTIVES, FileSelectDirective ],
})
export class DemoUploadComponent {

    private _flashService: FlashService;

    private _demoUploadService: DemoUploadService;

    public hasBaseDropZoneOver = false;

    private uploader = new FileUploader({ url: '/api/demo' });

    constructor(flashService: FlashService, demoUploadService: DemoUploadService) {
        this._flashService = flashService;
        this._demoUploadService = demoUploadService;
    }

    public fileOverBase(e: any): void {
        this.hasBaseDropZoneOver = e;
    }

    openUploadDialog() {
        this._flashService.showDemoUpload();
    }

}