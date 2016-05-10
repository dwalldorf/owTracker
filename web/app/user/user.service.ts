import {Injectable} from '@angular/core';
import {Http, Headers} from '@angular/http';

import {User} from "./user";
import {HttpService} from "../http.service";

@Injectable()
export class UserService {

    private people;

    private headers: Headers;

    private CURRENT_USER_URI = '/api/users/me';
    private LOGIN_URI = '/api/user/login';
    private LOGOUT_URI = '/api/user/logout';
    private USERS_URI = '/api/users';

    constructor(private http: Http, private httpService: HttpService) {
        this.headers = new Headers();
        this.headers.append('Content-Type', 'application/json');
        this.headers.append('Accept', 'application/json');
    }

    getMe() {
        return this.httpService.get(this.CURRENT_USER_URI);
    }

    login(user) {
        return this.http.post(this.LOGIN_URI, JSON.stringify(user), { headers: this.headers });
    }

    register(user: User) {
        return this.http.post(this.USERS_URI, JSON.stringify(user), { headers: this.headers });
    }

    logout() {
        return this.httpService.post(this.LOGOUT_URI, null);
    }

}