import { Component, OnInit } from '@angular/core';
import { ApiService } from '../Services/api.service';
import { articlemodel } from './article.model';

import { FormBuilder,FormGroup, Validators } from '@angular/forms';
import {NgbModal, ModalDismissReasons, NgbModalOptions} from '@ng-bootstrap/ng-bootstrap';


@Component({
  selector: 'app-articles',
  templateUrl: './articles.component.html',
  styleUrls: ['./articles.component.css']
})
export class ArticlesComponent implements OnInit {
  
  
  title = 'appBootstrap';
  
  closeResult: string = '';
  public ListArticles: any = [];
  constructor(private _ApiService: ApiService,private modalService: NgbModal,private formBuilder:FormBuilder,) { }
 

  ngOnInit(): void {
    this.getAllArticles();
  }
  public getAllArticles(){
    this._ApiService.allarticles().subscribe((res) => (this.ListArticles = res));
  
  }
  open(content:any) {
    this.modalService.open(content, {ariaLabelledBy: 'modal-basic-title'}).result.then((result) => {
      this.closeResult = `Closed with: ${result}`;
    }, (reason) => {
      this.closeResult = `Dismissed ${this.getDismissReason(reason)}`;
    });
  }
  
  private getDismissReason(reason: any): string {
    if (reason === ModalDismissReasons.ESC) {
      return 'by pressing ESC';
    } else if (reason === ModalDismissReasons.BACKDROP_CLICK) {
      return 'by clicking on a backdrop';
    } else {
      return  `with: ${reason}`;
    }
  }
  public AddArticle(data:any) {
    
   
    this._ApiService.createArticle(data).subscribe((result) => {
      
      window.location.reload();
    })
  } public likeArticle(article_id:number,user_id:number) {
    
   
    this._ApiService.like(article_id,user_id).subscribe((result) => {
      
      window.location.reload();
    })
  }
}
