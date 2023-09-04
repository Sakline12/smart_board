import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { DataService } from '../service/data.service';
import { Router } from '@angular/router';
import { ToastrService } from 'ngx-toastr';
import { TokenService } from '../service/token.service';
import Swal from 'sweetalert2';
@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit{
  submitted = false;
  data:any;
  token:any;
  public form = {
    email: null,
    password: null,
  };

  public error = null;
  constructor(private formBuilder: FormBuilder, private dataService: DataService,
               private router:Router, private toastr: ToastrService, private Token: TokenService){}

  // loginForm(){
  //   this.form = this.formBuilder.group({

  //     email: ['', [Validators.required, Validators.email]],
  //         password: ['', [Validators.required]],
  //   })
  // }
  ngOnInit(): void {
    // this.loginForm();
  }
  // get f(){
  //   return this.form.controls;
  // }

  // submit(){
  //   this.submitted = true;
  //   if(this.form.invalid){
  //     return;
  //   }
  //   this.dataService.login(this.form.value).subscribe(res =>{
  //     this.data = res;
  //     console.log(res);
  //     if(this.data.status === 1){
  //       this.token = this.data.data[0].token;
  //       localStorage.setItem('token', this.token);
  //       this.router.navigate(['']);
  //       this.toastr.success(JSON.stringify(this.data.message), JSON.stringify(this.data.code),
  //       {
  //         timeOut: 2000,
  //         progressBar: true
  //       });
  //     }else if (this.data.status ===0){
  //       this.toastr.error(JSON.stringify(this.data.message), JSON.stringify(this.data.code),
  //       {
  //         timeOut: 0,
  //         progressBar: true
  //       });
  //     }
     
  //   });
  // }
  submit(){
    this.dataService.login(this.form).subscribe(
      (data: any) => {
        // console.log('before',data); // Move the console.log() inside the success callback
        this.handleResponse(data);
      },
      (error: any) => this.handleError(error)
    );
  }
  handleError(error: any) {
    this.error = error.error;
            Swal.fire(
              'Error',
              'Email or Password doesn not match',
              'error'
            );
  }

  handleResponse(data: any) {
    console.log('after',data);
    this.Token.handle(data?.token);
    this.router.navigateByUrl('/dashboard');
  }
}
