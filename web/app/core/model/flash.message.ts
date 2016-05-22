export class FlashMessage {

    static SUCCESS = 'success';
    static ERROR = 'danger';

    public message: string;
    public layoutClass: string;
    public sticky: boolean;

    constructor(message: string, htmlClass: string) {
        this.message = message;
        this.layoutClass = htmlClass;
    }
}