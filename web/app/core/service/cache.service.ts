import {EventEmitter, Injectable} from '@angular/core';
import {CachedObject} from "../model/cached.object";

@Injectable()
export class CacheService {

    private storage = [];

    /**
     *
     * @param identifier
     * @param data to cache
     * @param ttl in seconds
     */
    cache(identifier: string, data, ttl: number = 10) {
        this.invalidate(identifier);

        var cache = new CachedObject();
        cache.identifier = identifier;
        cache.ttl = ttl;
        cache.timestamp = this.getTimestamp();
        cache.object = data;

        this.storage[ identifier ] = cache;
    }

    /**
     * Returns cached object if existent and ttl not reached, null otherwise.
     *
     * @param identifier
     * @returns {any}
     */
    get(identifier: string) {
        if (!this.storage.hasOwnProperty(identifier)) {
            return null;
        }

        var cache: CachedObject = this.storage[ identifier ];
        if (cache.timestamp + cache.ttl >= this.getTimestamp()) {
            return cache.object;
        }

        this.invalidate(identifier);
        return null;
    }

    invalidate(identifier: string) {
        delete this.storage[ identifier ];
    }

    emitCachedEvent(data, eventEmitter: EventEmitter<Object>) {
        setTimeout(function () {
            eventEmitter.emit(data);
        }, 20);
    };

    /**
     * timestamp in seconds
     * @returns {number}
     */
    private getTimestamp() {
        return Math.floor(Date.now() / 1000);
    }

}