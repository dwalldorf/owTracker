import {Injectable, EventEmitter} from '@angular/core';

import {User} from "../model/user";
import {HttpService} from "../../core/service/http.service";
import {CacheService} from "../../core/service/cache.service";
import {CacheIdentifiers} from "../../core/config/cache.identifiers";

@Injectable()
export class UserService {

    private CURRENT_USER_URI = '/api/users/me';
    private LOGIN_URI = '/api/user/login';
    private LOGOUT_URI = '/api/user/logout';
    private USERS_URI = '/api/users';

    private httpService: HttpService;

    private cacheService: CacheService;

    constructor(httpService: HttpService, cacheService: CacheService) {
        this.httpService = httpService;
        this.cacheService = cacheService;
    }

    /**
     * @returns {EventEmitter}
     */
    getCurrentUser() {
        var eventEmitter = new EventEmitter(),
            cachedUser   = this.cacheService.get(CacheIdentifiers.CACHE_ID_CURRENT_USER);

        if (cachedUser !== null) {
            this.cacheService.emitCachedEvent(cachedUser, eventEmitter);
            return eventEmitter;
        } else {
            eventEmitter = this.httpService.makeRequest(HttpService.METHOD_GET, this.CURRENT_USER_URI);
            eventEmitter.subscribe(user => this.cacheService.cache(CacheIdentifiers.CACHE_ID_CURRENT_USER, user, 600));
        }

        return eventEmitter;
    }

    /**
     * @returns {EventEmitter}
     */
    login(user) {
        return this.httpService.makeRequest(HttpService.METHOD_POST, this.LOGIN_URI, user);
    }

    /**
     * @returns {EventEmitter}
     */
    register(user: User) {
        return this.httpService.makeRequest(HttpService.METHOD_POST, this.USERS_URI, user);
    }

    /**
     * @returns {EventEmitter}
     */
    logout() {
        return this.httpService.makeRequest(HttpService.METHOD_POST, this.LOGOUT_URI, null);
    }

}