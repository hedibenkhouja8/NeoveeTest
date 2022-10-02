import { Component, OnInit } from '@angular/core';

import { ApiService } from '../Services/api.service';
import { ActivatedRoute } from '@angular/router';

import { FormBuilder,FormGroup, Validators } from '@angular/forms';
import {NgbModal, ModalDismissReasons, NgbModalOptions} from '@ng-bootstrap/ng-bootstrap';
import { articlemodel } from '../articles/article.model';
@Component({
  selector: 'app-article-by-user',
  templateUrl: './article-by-user.component.html',
  styleUrls: ['./article-by-user.component.css']
})
export class ArticleByUserComponent implements OnInit {
id:any;

articlemodel: articlemodel = new articlemodel();
title = 'appBootstrap';

public formValue: FormGroup;
  
closeResult: string = '';
  public ListArticles: any = [];
  constructor(private _ApiService: ApiService, private route: ActivatedRoute,private modalService: NgbModal,private formBuilder:FormBuilder) { 
    this.formValue = this.formBuilder.group({
      titre: [Validators.required],
      contenu: [Validators.required]
    

    });
  }

  ngOnInit(): void {
    this.id=this.route.snapshot.params['id'];
    this.articlesbyuser();
  }
  
  public articlesbyuser(){
    this._ApiService.articlesbyuser(this.id).subscribe((res) => (this.ListArticles = res));
  
  }
 

  public deleteArticle(id : number){
    this._ApiService.delete(id).subscribe(res => {
     
    
      this.articlesbyuser();
  
  });
  }
  
  open(content:any,article:any) {
    this.articlemodel=article.id;
    
  this.formValue.controls['titre'].setValue(article.titre);
  this.formValue.controls['contenu'].setValue(article.contenu);
    
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
  UpdateArticle(data:any,id:number) {
    this._ApiService
      .update(id, data)
      .subscribe((result) => {
        console.warn(data);
      });
      window.location.reload();
  }
  
}
