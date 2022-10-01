import { Component, OnInit } from '@angular/core';
import { ApiService } from '../Services/api.service';
import { articlemodel } from './article.model';

import {  VERSION, ViewChild, ElementRef } from "@angular/core";
import { FormBuilder,FormGroup, Validators } from '@angular/forms';
import {NgbModal, ModalDismissReasons, NgbModalOptions} from '@ng-bootstrap/ng-bootstrap';
import * as _ from 'lodash';



@Component({
  selector: 'app-articles',
  templateUrl: './articles.component.html',
  styleUrls: ['./articles.component.css']
})
export class ArticlesComponent implements OnInit {
  name = "Angular " + VERSION.major;
  toggle = true;
  id:any;
  liked:any;
likes : any ;
  title = 'appBootstrap';
  
  closeResult: string = '';
  public ListArticles: any = [];
  currentUserName: any;
  currentUserId: any;
  constructor(private _ApiService: ApiService,private modalService: NgbModal,private formBuilder:FormBuilder,private myNameElem: ElementRef) { 
    
    this.currentUserName = localStorage.getItem('nom');
    this.currentUserId = localStorage.getItem('id');
  }
 

  ngOnInit(): void {
    this.getAllArticles();
  }

  enableDisableRule() {
    console.log('enableDisableRule')
    this.toggle = !this.toggle;
  }
  public getAllArticles(){
    this._ApiService.allarticles().subscribe((res) => (this.ListArticles = res));
  
  } 
  public likeExists(article_id:number){
    
    this._ApiService.likeExists(article_id,this.currentUserId).subscribe((res) => (this.liked = res));
   
    if(this.liked==1)
    return 1;
    else return 0;
  
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
    
   data.user_id=localStorage.getItem('id');
    this._ApiService.createArticle(data).subscribe((result) => {
      
      window.location.reload();
    })
  } 
  
  public likeArticle(article_id:number,user_id:number) {
    let idx = _.findIndex(this.ListArticles,{id:article_id});
    if(idx>-1){
      this._ApiService.likeExists(user_id,article_id).subscribe(data => {
if(data==1){
        
      this.ListArticles[idx]['likes']=this.ListArticles[idx]['likes']+1;
     } 
    else{
      
      this.ListArticles[idx]['likes']=this.ListArticles[idx]['likes']-1;
    }})
    }
   
    this._ApiService.like(article_id,user_id).subscribe((result) => {
      
   //   window.location.reload();
    })
  }
  isArticleLikedByUser(article:any) :boolean {
    
    return article['likers'].indexOf(this.currentUserId) >-1

  }


}
