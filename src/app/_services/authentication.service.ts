import { Injectable, ErrorHandler } from '@angular/core';
import { HttpClient, HttpHeaders, HttpErrorResponse } from '@angular/common/http';
import { BehaviorSubject, Observable, of } from 'rxjs';
import { map, catchError } from 'rxjs/operators';
// import 'rxjs/add/observable/of';
import { environment } from '../../environments/environment';
import { Cookie } from 'ng2-cookies';
import { ToastrService } from 'ngx-toastr';
import { Router } from '@angular/router';
// import { User } from '@app/_models';

@Injectable({ providedIn: 'root' })
export class AuthenticationService {

    isAuthincate: boolean = false;
    public currentUserDetails: BehaviorSubject<any> = new BehaviorSubject<any>(null);
    constructor(
        private http: HttpClient,
        private toastr: ToastrService,
        private router: Router
    ) {
        // this.currentUserDetails = new BehaviorSubject<any>(JSON.parse(localStorage.getItem('currentUser')));
        if (Cookie.check('.BBSAASLMS.Cookie'))
            this.currentUserDetails = new BehaviorSubject<any>(JSON.parse(Cookie.get('.BBSAASLMS.Cookie')));
    }

    public get currentUserValue(): any {
        return Cookie.check('.BBSAASLMS.Cookie') ? this.currentUserDetails.value : null;
    }

    public isAuthenticated(): boolean {
        return Cookie.check('.BBSAASLMS.Cookie');
    }

    login(params: any) {
        const obj = {
            username: params.username,
            password: params.password
        };

        return this.http.post<any>(environment.baseUrl + 'auth/login', obj).pipe(map(data => {
            if(data.status){
                let response = data.data;
                const user = {
                    id: response.id,
                    username: response.username,
                    contact_no: response.contact_no,
                    employee_code: response.employee_code,
                    full_name: response.name,
                    user_type: response.user_type,
                    access_token: response.token,
                    image: response.image,
                    created: response.updated_at,
                }
                let expireDate = new Date('2030-07-19');
                Cookie.set('.BBSAASLMS.Cookie', JSON.stringify(user), expireDate, '/', window.location.hostname, false);
                this.currentUserDetails.next(user);
                const res = {
                    data: user,
                    errors: null,
                    message: "",
                    status: true
                };
                return res;
            }else{
                const res = {
                    data: [],
                    errors: null,
                    message: data.message,
                    status: false
                };
                return res;
            }
        }),
        catchError(err => {
            return of(err);
        }));
    }

    logout(hostname: any) {
        return this.http.post<any>(environment.baseUrl + 'logout', {}).pipe(
            map(res => {
                if (res.success) {
                    this.isAuthincate = false;
                    Cookie.delete('.BBSAASLMS.Cookie', '/', hostname);
                    this.toastr.success(res.message, 'Success!', { timeOut: 2000 });
                    this.currentUserDetails.next(null);
                    this.router.navigate(['/login']);
                }
                return res;
            })
        );

    }

    registerSystemAdmin(url: any, params: any) {
        return this.http.post<any>(environment.apiUrl + url, params).pipe(
            map(res => {
                return res;
            })
        );
    }

    

}
