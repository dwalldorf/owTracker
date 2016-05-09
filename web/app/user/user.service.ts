import { Injectable } from '@angular/core';
import { Http, Response, Headers } from '@angular/http';

import { User } from "./user";

@Injectable()
export class UserService {

    private people;

    private headers: Headers;

    private CURRENT_USER_URI = '/api/users/me';
    private LOGIN_URI = '/api/user/login';
    private USERS_URI = '/api/users';

    constructor(private http: Http) {
        this.headers = new Headers();
        this.headers.append('Content-Type', 'application/json');
        this.headers.append('Accept', 'application/json');
    }

    getMe() {
        // var promise = this.http.get(this.CURRENT_USER_URI);

        // return promise.then(function (res) {
        //     var user = res.data;
        //     console.log(user);
        //     return promise;
        // }, function () {
        //     return promise;
        // });
    }

    login(user) {
        return this.http.post(this.LOGIN_URI, JSON.stringify(user), { headers: this.headers });
    }

    register(user: User) {
        return this.http.post(this.USERS_URI, JSON.stringify(user), { headers: this.headers });
    }
}