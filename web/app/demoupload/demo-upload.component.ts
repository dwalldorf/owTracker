import {Component} from '@angular/core';
import {DemoUploadService} from "./service/demo-upload.service";
import {FlashService} from "../core/service/flash.service";

declare var jQuery: any;

@Component({
    selector: 'demo-upload',
    templateUrl: 'app/demoupload/views/demo-upload.html',
})
export class DemoUploadComponent {

    private _flashService;

    private _demoUploadService;

    constructor(flashService: FlashService, demoUploadService: DemoUploadService) {
        this._flashService = flashService;
        this._demoUploadService = demoUploadService;
    }

    ngOnInit() {
        jQuery("#demo-upload").dropzone({
            url: "/api/demo",
            parallelUploads: 2,
            uploadMultiple: true,
            autoProcessQueue: true,
            previewTemplate: '\
            <div class="dz-preview dz-file-preview"> \
                <div class="dz-details"> \
                    <div class="dz-filename"><span data-dz-name></span></div> \
                    <div class="dz-size" data-dz-size></div> \
                </div> \
                \
                <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div> \
            </div>',
            previewsContainer: "#upload-progress"
            // acceptedFiles: ".dem",
        });
    }

}