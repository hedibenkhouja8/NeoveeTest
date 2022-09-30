import { Component, OnInit } from '@angular/core';

import { ApiService } from '../Services/api.service';

import { FormBuilder,FormGroup, Validators } from '@angular/forms';

import { Router } from '@angular/router';
import {NgbModal, ModalDismissReasons, NgbModalOptions} from '@ng-bootstrap/ng-bootstrap';
@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {

  constructor(private _ApiService: ApiService,private formBuilder:FormBuilder,public router:Router) { }

  ngOnInit(): void {
  }
  public login(data:any) {
    
   
    this._ApiService.login(data).subscribe((result) => {
      if(result.status == 201) {
       
        this.router.navigate(['/articles']);
        localStorage.setItem('id', result.id);
        
        localStorage.setItem('nom', result.nom);
      }
      console.warn(result);
    })
  } 
}
