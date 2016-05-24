export class ItemCollection {

    items: Object[];
    totalItems: number;
    hasMore: boolean;

    constructor() {
        this.items = [];
        this.totalItems = 0;
        this.hasMore = false;
    }

    public addItem(item: Object) {
        this.items.concat([ item ]);
        this.totalItems = this.items.length;
    }

    public addItems(items) {
        this.items = this.items.concat(items);
        this.totalItems = this.items.length;
    }

}