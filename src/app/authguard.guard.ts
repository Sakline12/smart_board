import { HttpHandler, HttpRequest } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, CanActivate,Router, RouterStateSnapshot, UrlTree } from '@angular/router';
import { Observable } from 'rxjs';
import { map, take } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class AuthguardGuard implements CanActivate {
  constructor(private router:Router){

  }
  req:any;
  token:any;
  canActivate() {
    this.token = localStorage.getItem('token');
   
    if(this.token){
      return true;
    }else{
      this.router.navigate(['login']);
    }
    return true;
  }
  
  
}
