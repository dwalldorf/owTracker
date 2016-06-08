export class ItemCollection<T> {

    items: T[];
    totalItems: number;
    hasMore: boolean;

    constructor() {
        this.items = [];
        this.totalItems = 0;
        this.hasMore = false;
    }

    public addItem(item: T) {
        this.items.unshift(item);
        this.totalItems = this.items.length;
    }

    public addItems(items: T[]) {
        this.items = this.items.concat(items);
        this.totalItems = this.items.length;
    }

    public setItems(items: T[]) {
        if (!items) {
            items = [];
        }

        this.items = items;
        this.totalItems = this.items.length;
    }
}