export class NavigationElement {

    public label: string;
    public title: string;
    public link: string;
    public route;
    public customClasses: string;

    constructor(label: string, title: string, link: string, route = null, customClasses: string = '') {
        this.label = label;
        this.title = title;
        this.link = link;
        this.route = route;
        this.customClasses = customClasses;
    }
}