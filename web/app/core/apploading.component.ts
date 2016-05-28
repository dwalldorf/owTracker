import {Component} from '@angular/core';

declare var Spinner: any;
@Component({
    selector: 'app-loading',
    templateUrl: 'app/core/views/app-loading.html',
})
export class AppLoadingComponent {

    opts = {
        lines: 7 // The number of lines to draw
        , length: 14 // The length of each line
        , width: 14 // The line thickness
        , radius: 25 // The radius of the inner circle
        , scale: 1 // Scales overall size of the spinner
        , corners: 1 // Corner roundness (0..1)
        , color: '#000' // #rgb or #rrggbb or array of colors
        , opacity: 0.5 // Opacity of the lines
        , rotate: 0 // The rotation offset
        , direction: 1 // 1: clockwise, -1: counterclockwise
        , speed: 0.6 // Rounds per second
        , trail: 50 // Afterglow percentage
        , fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
        , zIndex: 2e9 // The z-index (defaults to 2000000000)
        , className: 'spinner' // The CSS class to assign to the spinner
        , top: '50%' // Top position relative to parent
        , left: '50%' // Left position relative to parent
        , shadow: false // Whether to render a shadow
        , hwaccel: false // Whether to use hardware acceleration
        , position: 'absolute' // Element positioning
    };

    ngOnInit() {
        var target = document.getElementById('app-loading');

        console.log('apploading cmp onInit');
        console.log(target);
        new Spinner(this.opts).spin(target);
    }

}